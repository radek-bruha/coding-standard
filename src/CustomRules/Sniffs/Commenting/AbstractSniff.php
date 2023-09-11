<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomRules\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

abstract class AbstractSniff implements Sniff
{

    protected const TYPE_CLASS       = 'Class';
    protected const TYPE_INTERFACE   = 'Interface';
    protected const TYPE_TRAIT       = 'Trait';
    protected const TYPE_CONSTRUCTOR = 'Constructor';

    protected const CODE    = 'code';
    protected const CONTENT = 'content';

    private const PATTERN = '#\r\n|\r|\n#';
    private const REPLACE = [
        '{NAMESPACE}',
        '{NAME}',
        '{TYPE}',
    ];

    /**
     * @var string[]
     */
    public array $comments = [
        '{TYPE} {NAME}',
        '@package {NAMESPACE}',
    ];

    protected function getNamespaceName(File $file, int $position): string
    {
        $result     = 'Unknown';
        $tokens     = $file->getTokens();
        $namespaces = [];

        $position = $file->findPrevious(T_NAMESPACE, $position);

        if (is_int($position)) {
            $position = $file->findNext(T_STRING, $position);

            if (is_int($position)) {
                $closePosition = $file->findEndOfStatement($position);

                for (; $position < $closePosition; $position++) {
                    $namespaces[] = $tokens[$position][self::CONTENT];
                }

                $result = implode('', $namespaces);
            }
        }

        return $result;
    }

    /**
     * @return string[]
     */
    protected function getDocumentComment(File $file, int $position): array
    {
        $result        = [];
        $tokens        = $file->getTokens();
        $startPosition = $file->findPrevious(T_DOC_COMMENT_OPEN_TAG, $position);

        if (is_int($startPosition)) {
            $iterator      = 0;
            $closePosition = $file->findNext(T_DOC_COMMENT_CLOSE_TAG, $startPosition + 1);

            for (; $startPosition < $closePosition; $startPosition++) {
                $token                  = $tokens[$startPosition];
                $isWhiteSpace           = $token[self::CODE] === T_DOC_COMMENT_WHITESPACE;
                $isWhiteSpaceNewLine    = preg_match(self::PATTERN, $token[self::CONTENT]) === 1;
                $isStringOrTagCharacter = in_array($token[self::CODE], [T_DOC_COMMENT_STRING, T_DOC_COMMENT_TAG], TRUE);

                if ($isStringOrTagCharacter || $isWhiteSpace && !$isWhiteSpaceNewLine) {
                    $result[$iterator] = sprintf('%s%s', $result[$iterator] ?? '', $token[self::CONTENT]);
                }

                if ($isWhiteSpace && $isWhiteSpaceNewLine) {
                    $iterator++;
                }
            }
        }

        return array_filter(array_map('trim', $result), static fn(string $item): bool => strlen($item) > 0);
    }

    protected function processCommenting(File $file, int $position, string $type, ?string $customName = NULL): int
    {
        $position = $file->findNext(T_STRING, $position);

        if (is_int($position)) {
            $comments = $this->getDocumentComment($file, $position);

            foreach ($this->comments as $comment) {
                $comment = $this->replacePlaceholders($file, $position, $type, $comment, $customName);

                if (!in_array($comment, $comments, TRUE)) {
                    $file->addError(
                        sprintf("Usage of %s comment without '%s' is not allowed.", lcfirst($type), $comment),
                        $position,
                        'Comment',
                    );
                }
            }
        }

        return 0;
    }

    protected function replacePlaceholders(
        File $file,
        int $position,
        string $type,
        string $string,
        ?string $customName = NULL,
    ): string {
        return str_replace(
            self::REPLACE,
            [
                $this->getNamespaceName($file, $position),
                is_string($customName) ? $customName : $file->getTokens()[$position][self::CONTENT],
                $type,
            ],
            $string,
        );
    }

}

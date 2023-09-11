<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomRules\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;

final class ConstructorSniff extends AbstractSniff
{

    /**
     * @var string[]
     */
    public array $comments = ['{NAME} constructor'];

    public string $anonymousName = 'Anonymous';

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_FUNCTION];
    }

    public function process(File $file, mixed $position): int
    {
        $tokens = $file->getTokens();

        if ($tokens[$file->findNext(T_STRING, $position)][self::CONTENT] === '__construct') {
            $innerPosition = $file->findPrevious(T_ANON_CLASS, $position);

            if (is_int($innerPosition)) {
                $this->processCommenting($file, $position, self::TYPE_CONSTRUCTOR, $this->anonymousName);
            } else {
                $innerPosition = $file->findPrevious(T_CLASS, $position);

                if (is_int($innerPosition)) {
                    $innerPosition = $file->findNext(T_STRING, $innerPosition);

                    if (is_int($innerPosition)) {
                        $this->processCommenting(
                            $file,
                            $position,
                            self::TYPE_CONSTRUCTOR,
                            $tokens[$innerPosition][self::CONTENT],
                        );
                    }
                }
            }
        }

        return 0;
    }

}

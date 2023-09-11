<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomRules;

use SimpleXMLElement;

final class Analyzer
{

    public static function phpCodeSniffer(string $data): int
    {
        $timestamp = microtime(TRUE);
        $results   = [];
        $record    = FALSE;
        $total     = 0;
        $logs      = array_map(static fn(string $row): string => trim($row), explode(PHP_EOL, $data));

        foreach ($logs as $log) {
            if ($log === '*** START SNIFF PROCESSING REPORT ***') {
                $record = TRUE;

                continue;
            }

            if ($log === '*** END SNIFF PROCESSING REPORT ***') {
                $record = FALSE;

                continue;
            }

            if ($record) {
                if (preg_match('/(.+): (.+) sec/', $log, $matches) === 1) {
                    [
                        ,
                        $name,
                        $time,
                    ] = $matches;

                    $time   = (float) $time;
                    $total += $time;

                    $results[$name] = [
                        $name,
                        isset($results[$name]) ? $results[$name][1] + $time : $time,
                    ];
                }
            }
        }

        usort($results, static fn(array $one, array $two): int => $two[1] <=> $one[1]);

        echo sprintf(
            '%07.3fs (100.000%%): Analyzed %s rows of logs in %07.3fs with %07.3fMB RAM usage%s',
            $total,
            number_format(count($logs), 0, '.', ' '),
            microtime(TRUE) - $timestamp,
            memory_get_peak_usage(TRUE) / 1_024 ** 2,
            PHP_EOL,
        );

        foreach ($results as $result) {
            [
                $name,
                $time,
            ] = $result;

            echo sprintf('%07.3fs (%07.3f%%): %s%s', $time, $time / $total * 100, $name, PHP_EOL);
        }

        return 0;
    }

    public static function phpUnit(string $data): int
    {
        $timestamp = microtime(TRUE);
        $results   = [];
        $total     = 0;
        $logs      = (new SimpleXMLElement($data))->xpath('//testcase');

        foreach ($logs as $log) {
            $attributes = $log->attributes();

            if ($attributes === NULL) {
                continue;
            }

            $time   = (float) $attributes['time'];
            $total += $time;

            $results[] = [
                sprintf('%s::%s', $attributes['class'], $attributes['name']),
                $time,
            ];
        }

        usort($results, static fn(array $one, array $two): int => $two[1] <=> $one[1]);

        echo sprintf(
            '%07.3fs (100.000%%): Analyzed %s rows of logs in %07.3fs with %07.3fMB RAM usage%s',
            $total,
            number_format(count($logs), 0, '.', ' '),
            microtime(TRUE) - $timestamp,
            memory_get_peak_usage(TRUE) / 1_024 ** 2,
            PHP_EOL,
        );

        foreach ($results as $result) {
            [
                $name,
                $time,
            ] = $result;

            echo sprintf('%07.3fs (%07.3f%%): %s%s', $time, $time / $total * 100, $name, PHP_EOL);
        }

        return 0;
    }

    public static function phpUnitCoverage(int $minimum, string $path): int
    {
        $coverage = simplexml_load_file($path);

        if ($coverage === FALSE) {
            return 1;
        }

        $coverage->registerXPathNamespace('php', 'https://schema.phpunit.de/coverage/1.0');
        $coverage = $coverage->xpath('//php:project/php:directory/php:totals/php:lines');
        $coverage = is_array($coverage) ? (float) $coverage[0]['percent'] : 0;

        if ($coverage >= $minimum) {
            return 0;
        }

        echo sprintf(
            "%s\033[1;31mMinimum required code coverage is %s%%, but actual is %s%%!\033[0m%s",
            PHP_EOL,
            $minimum,
            $coverage,
            PHP_EOL,
        );

        return 1;
    }

}

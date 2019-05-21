<?php declare(strict_types=1);

namespace Bruha\CodingStandard\CustomRules;

/**
 * Class Analyzer
 *
 * @package Bruha\CodingStandard\CustomRules
 */
final class Analyzer
{

    /**
     * @param string $data
     *
     * @return int
     */
    public static function analyze(string $data): int
    {
        $timestamp = microtime(TRUE);
        $results   = [];
        $record    = FALSE;
        $total     = 0;
        $logs      = array_map(
            static function (string $row): string {
                return trim($row);
            },
            explode(PHP_EOL, $data)
        );

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
                        $g,
                        $name,
                        $time,
                    ] = $matches;

                    $g;
                    $time   = (float) $time;
                    $total += $time;

                    $results[$name] = [
                        $name,
                        isset($results[$name]) ? $results[$name][1] + $time : $time,
                    ];
                }
            }
        }

        usort(
            $results,
            static function (array $one, array $two): int {
                return $two[1] <=> $one[1];
            }
        );

        echo sprintf(
            '%07.3fs (100.000%%): Analyzed %s rows of logs in %07.3fs with %07.3fMB RAM usage%s',
            $total,
            number_format(count($logs), 0, '.', ' '),
            microtime(TRUE) - $timestamp,
            memory_get_peak_usage(TRUE) / 1024 ** 2,
            PHP_EOL
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

}
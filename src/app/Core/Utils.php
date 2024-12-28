<?php
namespace App\Core;

class Utils {
    /** @return list<string> */
    public static function walkDirectory(string $baseDir): array {
        $files = [];

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $baseDir,
                \FilesystemIterator::SKIP_DOTS
            )
        );

        foreach ($iterator as $file) {
            assert($file instanceof \SplFileInfo);
            if ($file->isFile()) {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }

    public static function dateSlugToDateTime(string $slug): ?\DateTimeImmutable {
        $parts = explode('/', $slug);

        if (count($parts) < 3) {
            return null;
        }

        $year = (int) $parts[0];
        $month = (int) $parts[1];
        $day = (int) $parts[2];

        $datetime = new \DateTime();
        $datetime->setTimezone(new \DateTimeZone("UTC"));
        $datetime->setTime(0, 0);
        $datetime->setDate($year, $month, $day);
        return \DateTimeImmutable::createFromMutable($datetime);
    }
}

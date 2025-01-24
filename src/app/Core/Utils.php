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

    public static function processAllAutolinks(string $content): string {
        $tags = ['h1', 'h2', 'h3'];

        foreach ($tags as $tag) {
            $content = Utils::processAutolinks($tag, $content);
        }

        return $content;
    }

    public static function processAllAutousernames(string $content): string {
        // https://regexlicensing.org/
        return preg_replace(
            "/\\/u\\/([a-zA-Z0-9_]+)(?!.*?<\\/title>)/",
            "<a class='user-link' href='/u/$1'>/u/$1</a>",
            $content
        );
    }

    public static function resetSession(): void {
        $_SESSION = [];
        session_destroy();
        if ((bool)ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            assert($params["path"] !== null);
            assert($params["domain"] !== null);
            assert($params["secure"] !== null);
            assert($params["httponly"] !== null);
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_start();
        session_regenerate_id(true);
    }

    private static function processAutolinks(
        string $tag,
        string $content
    ): string {
        $offset = 0;

        $newContent = '';

        while (true) {
            $begin = strpos($content, "<$tag", $offset);
            $end = strpos($content, "</$tag>", $offset);

            if ($begin === false || $end === false) {
                break;
            }

            $newContent .= substr($content, $offset, $begin - $offset);
            $newContent .= Utils::createAutolink(
                substr($content, $begin, $end - $begin)
            );
            $newContent .= $content[$end];

            $offset = $end + 1;
        }

        $newContent .= substr($content, $offset);
        return $newContent;
    }

    private static function createAutolink(string $unclosedTag): string {
        $contentBegin = strpos($unclosedTag, '>');
        assert(is_integer($contentBegin));
        $contentBegin = $contentBegin + 1;
        $tagPart = substr($unclosedTag, 0, $contentBegin - 1);
        $contentPart = substr($unclosedTag, $contentBegin);
        $id = preg_replace('/[^a-zA-Z0-9]/', '-', trim($contentPart));
        return "$tagPart><a class='id-link wrap' id='$id' href='#$id'>$contentPart</a>";
    }
}

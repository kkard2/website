<?php
namespace App\Core;

class ContentPage {
    private function __construct(
        private string $content
    ) {}

    public static function parse(string $filePath): ?ContentPage {
        $fileContent = file_get_contents($filePath);

        if ($fileContent === false) {
            return null;
        }

        $tags = ['h1', 'h2', 'h3'];

        foreach ($tags as $tag) {
            $fileContent = ContentPage::processAutolinks($tag, $fileContent);
        }

        return new ContentPage($fileContent);
    }

    public function getContent(): string {
        return $this->content;
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
            $newContent .= ContentPage::createAutolink(
                substr($content, $begin, $end - $begin)
            );
            $newContent .= $content[$end];

            $offset = $end + 1;
        }

        $newContent .= substr($content, $offset);
        return $newContent;
    }

    private static function createAutolink(string $unclosedTag): string {
        $contentBegin = strpos($unclosedTag, '>') + 1;
        $tagPart = substr($unclosedTag, 0, $contentBegin - 1);
        $contentPart = substr($unclosedTag, $contentBegin);
        $id = preg_replace('/[^a-zA-Z0-9]/', '-', trim($contentPart));
        return "$tagPart><a class='id-link' id='$id' href='#$id'>$contentPart</a>";
    }
}

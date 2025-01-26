<?php
namespace App\Models;

class ContentPageModel {
    private function __construct(
        private readonly string $content,
        private readonly ?\DateTimeImmutable $metaDateTime,
        public readonly ?string $title,
        public readonly string $slug,
    ) {}

    public static function fromFile(string $filePath, string $slug): ?ContentPageModel {
        $fileContent = file_get_contents($filePath);

        if ($fileContent === false) {
            return null;
        }

        preg_match_all('/<!--(.*?)-->/s', $fileContent, $matches);

        $metaDateTime = null;
        $title = $slug;
        foreach ($matches[1] as $comment) {
            $comment = trim($comment);
            if (str_starts_with($comment, '#datetime')) {
                $dateTimeStr = trim(substr($comment, strlen('#datetime')));
                $metaDateTime = new \DateTimeImmutable($dateTimeStr);
            }
            if (str_starts_with($comment, '#title')) {
                $title = trim(substr($comment, strlen('#title')));
            }
        }

        return new ContentPageModel($fileContent, $metaDateTime, $title, $slug);
    }

    public function getContent(): string {
        return $this->content;
    }

    public function getMetaDateTime(): ?\DateTimeImmutable {
        return $this->metaDateTime;
    }
}

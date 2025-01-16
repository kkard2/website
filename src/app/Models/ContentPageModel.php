<?php
namespace App\Models;

class ContentPageModel {
    private function __construct(
        private readonly string $content,
        private readonly ?\DateTimeImmutable $metaDateTime
    ) {}

    public static function fromFile(string $filePath): ?ContentPageModel {
        $fileContent = file_get_contents($filePath);

        if ($fileContent === false) {
            return null;
        }

        // TODO: parse metadata
        return new ContentPageModel($fileContent, null);
    }

    public function getContent(): string {
        return $this->content;
    }

    public function getMetaDateTime(): ?\DateTimeImmutable {
        return $this->metaDateTime;
    }
}

<?php
namespace App\Core;

class SoftwareViewEntry {
    public function __construct(
        public readonly \DateTimeImmutable $dateTime,
        public readonly \App\Models\ContentPageModel $contentPage
    ) {}
}

<?php
namespace App\Models;

class PostEntryModel {
    public function __construct(
        public readonly \DateTimeImmutable $dateTime,
        public readonly \App\Models\ContentPageModel $contentPage
    ) {}
}

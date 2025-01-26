<?php
namespace App\Models;

class PageCommentModel {
    public function __construct(
        public readonly string $id,
        public readonly string $content,
        public readonly string $postedAt,
        public readonly string $posterUsername,
        public readonly string $slug,
    ) {}
}

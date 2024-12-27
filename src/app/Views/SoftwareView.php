<?php
namespace App\Views;

use \App\Core\Utils;

class SoftwareView implements View {
    private function __construct(
        private string $test
    ) {}

    public static function create(): SoftwareView {
        $basePath = realpath('content/software/');

        if ($basePath === false) {
            throw new Exception("Cannot read content");
        }

        $asdf = "";
        foreach (Utils::walkDirectory($basePath) as $filePath) {
            $partialSlug = str_replace(
                '\\',
                '/',
                substr($filePath, strlen($basePath))
            );
            $asdf .= "$partialSlug<br>";
        }

        return new SoftwareView($asdf);
    }

    public function show(): void {
        echo $this->test;
    }
}

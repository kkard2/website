<?php
namespace App\Views;

use \App\Core\Utils;

class BlogView implements View {
    private function __construct(
        /** @var list<string> */
        private readonly array $entries,
    ) {}

    public static function create(): View {
        $basePath = realpath('content/blog/');

        if ($basePath === false) {
            throw new \Exception('Cannot read content');
        }

        $entries = [];

        foreach (Utils::walkDirectory($basePath) as $filePath) {
            $partialSlug = str_replace(
                '\\',
                '/',
                substr($filePath, strlen($basePath) + 1)
            );

            $dateTime = Utils::dateSlugToDateTime($partialSlug);
            if ($dateTime === null) {
                // TODO: log warning?
                continue;
            }

            $entries[] = $partialSlug;
        }

        usort($entries, function ($a, $b) {
            return $b <=> $a;
        });

        return new BlogView($entries);
    }

    public function show(): void {
?>
<h1>blog</h1>
i will post sometimes i promise
<ul>
<?php
        foreach ($this->entries as $entry) {
            $entry = "$entry";
            echo "<li><a href='/blog/$entry'>$entry</a></li>";
        }
?>
</ul>
<?php
    }
}

<?php
namespace App\Views;

use \App\Core\Utils;
use \App\Core\SoftwareViewEntry;

class SoftwareView implements View {
    private function __construct(
        /** @var list<SoftwareViewEntry> */
        private readonly array $entries,
    ) {}

    public static function create(): View {
        $basePath = realpath('content/software/');

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

            $content = \App\Models\ContentPageModel::fromFile($filePath);
            if ($content === null) {
                // TODO: log warning?
                continue;
            }

            $dateTime = $content->getMetaDateTime() ?? $dateTime;
            $entries[] = new SoftwareViewEntry($dateTime, $content);
        }

        usort($entries, function ($a, $b) {
            assert($a instanceof SoftwareViewEntry);
            assert($b instanceof SoftwareViewEntry);
            return $a->dateTime <=> $b->dateTime;
        });

        return new SoftwareView($entries);
    }

    public function show(): void {
    ?>
<h1>i hate software</h1>
<p>
this is a page where i collect annoying problems i encounter while using software.
</p>

<p>
also, check out <a href='/ophs'>/ophs</a> (other people hating software)
</p>
<?php
        $prevDateTime = null;

        foreach ($this->entries as $entry) {
            if ($entry->dateTime != $prevDateTime) {
                $prevDateTime = $entry->dateTime;
                echo "<h2>";
                echo $prevDateTime->format("Y-m-d");
                echo "</h2>";
            }
            echo $entry->contentPage->getContent();
        }
    }

    public function shouldDisplayComments(): bool { return false; }
}

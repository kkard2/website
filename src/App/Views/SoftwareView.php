<?php
namespace App\Views;

use \App\Core\Utils;
use \App\Models\PostEntryModel;

class SoftwareView implements View {
    private function __construct(
        /** @var list<PostEntryModel> */
        private readonly array $entries,
    ) {}

    public static function create(): View {
        $basePath = realpath('content/software/');

        if ($basePath === false) {
            throw new \Exception('cannot read content');
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

            $content = \App\Models\ContentPageModel::fromFile($filePath, "/software/$partialSlug");
            if ($content === null) {
                // TODO: log warning?
                continue;
            }

            $dateTime = $content->getMetaDateTime() ?? $dateTime;
            $entries[] = new PostEntryModel($dateTime, $content);
        }

        usort($entries, function ($a, $b) {
            assert($a instanceof PostEntryModel);
            assert($b instanceof PostEntryModel);
            return $b->dateTime <=> $a->dateTime;
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
            if ($prevDateTime === null || ($entry->dateTime->format("Y-m-d") != $prevDateTime->format("Y-m-d"))) {
                $prevDateTime = $entry->dateTime;
                echo "<h2>";
                echo $prevDateTime->format("Y-m-d");
                echo "</h2>";
            }
            echo $entry->contentPage->getContent();
            $slug = $entry->contentPage->slug;
            echo "<a href='$slug'>[comments]</a>";
        }
    }

    public function shouldDisplayComments(): bool { return false; }
}

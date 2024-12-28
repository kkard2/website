<?php
namespace App\Views;

use \App\Core\Utils;
use \App\Core\SoftwareViewEntry;

class SoftwareView implements View {
    /** @var list<SoftwareViewEntry> */
    private array $entries;

    public function __construct() {
        $basePath = realpath('content/software/');

        if ($basePath === false) {
            throw new \Exception('Cannot read content');
        }

        $this->entries = [];

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
            $this->entries[] = new SoftwareViewEntry($dateTime, $content);
        }

        usort($this->entries, function ($a, $b) {
            assert($a instanceof SoftwareViewEntry);
            assert($b instanceof SoftwareViewEntry);
            return $a->dateTime <=> $b->dateTime;
        });
    }

    public function show(): void {
    // todo what to do with preprocessing i am to eepy for that now
    ?>
<h1>i hate software</h1>

this is a page where i collect annoying problems i encounter while using software.

also, check out /ophs (other people hating software) 
<?php
    }
}

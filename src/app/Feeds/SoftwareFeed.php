<?php
namespace App\Feeds;

use \App\Core\Utils;
use \App\Models\PostEntryModel;

class SoftwareFeed {
    public function show(): void {
        header('Content-Type: application/xml');
        $indexTemplate = file_get_contents(realpath('content/software/index-template.xml'));

        if ($indexTemplate === false) {
            throw new \Exception('cannot read feed template');
        }

        $basePath = realpath('content/software/');

        if ($basePath === false) {
            throw new \Exception('cannot read content');
        }

        $entries = [];

        foreach (\App\Core\Utils::walkDirectory($basePath) as $filePath) {
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
            if ((int)$dateTime->format('Y') < 2025) {
                continue;
            }
            $entries[] = new PostEntryModel($dateTime, $content);
        }

        usort($entries, function ($a, $b) {
            assert($a instanceof PostEntryModel);
            assert($b instanceof PostEntryModel);
            return $b->dateTime <=> $a->dateTime;
        });

        $firstDateTime = $entries[0]->dateTime;

        echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<rss version="2.0">
    <channel>
        <title>kkard2/software</title>
        <link>https://kkard2.com/software</link>
        <description>i hate software</description>
        <language>en-us</language>

        <lastBuildDate><?= $firstDateTime->format('D, d M Y H:i:s O') ?></lastBuildDate>
<?php
        foreach ($entries as $entry) {
?>
        <item>
            <title><?= $entry->contentPage->title; ?></title>
            <link>https://kkard2.com<?= $entry->contentPage->slug; ?></link>
            <pubDate><?= $entry->dateTime->format('D, d M Y H:i:s O'); ?></pubDate>
            <guid>https://kkard2.com<?= $entry->contentPage->slug; ?></guid>
        </item>
<?php
        }
        echo $indexTemplate;
    }
}

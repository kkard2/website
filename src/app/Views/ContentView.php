<?php
namespace App\Views;

class ContentView {
    public function __construct(
        private string $slug,
        private string $inner
    ) {}

    public function show() {
?>
<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='utf-8'>
        <title><?= "kkard2$this->slug"; ?></title>
        <link rel='stylesheet' href='/style.css'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
    </head>
    <body>
        <header>
            <nav>
                <div class="menu">
                    <a href="/menu">/menu</a>
                    <div class="menu-content">
                        <a href="/">/</a>
                        <a href="/software">/software</a>
                        <a href="/blog">/blog</a>
                        <a href="/rss">/rss</a>
                        <a href="/people">/people</a>
                        <a href="/ophs">/ophs</a>
                    </div>
                </div>
            </nav>
        </header>
        <div>
            <?= $this->inner; ?>
        </div>
    </body>
</html>
<?php
    }
}

<?php
namespace App\Views;

class TemplateView implements View {
    public function __construct(
        private readonly string $slug,
        private readonly string $inner,
        private readonly ?\App\Core\Database $db,
        private readonly ?\App\Models\UserUsernameModel $currentUser,
        private readonly bool $showComments = true,
    ) {}

    public function show(): void {
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
                        <a href="/family">/family</a>
                    </div>
                    <div class="menu-user">
<?php
        if ($this->currentUser === null) {
            echo '<a href="/login">/login</a> <a href="/register">/register</a>';
        } else {
            echo '/u/' . $this->currentUser->username . ' <a href="/logout">[log out]</a>';
        }
?>
                    </div>
                </div>
            </nav>
        </header>
        <div>
<?php
        echo $this->inner;

        if ($this->db !== null && $this->showComments) {
            $this->showComments($this->db);
        }
?>
        </div>
    </body>
</html>
<?php
    }

    public function shouldDisplayComments(): bool {
        return $this->showComments;
    }

    private function showComments(\App\Core\Database $db): void {
        echo '<h1>comments</h1>';
        $comments = $db->getPageComments($this->slug);

        if ($this->currentUser !== null) {
?>
<form method='post'>

</form>
<?php
        }

        if (count($comments) == 0) {
            echo 'there are no comments';
        } else {
            foreach ($comments as $c) {
?>
            <div class='user-comment'>
                <span id='<?= "/c/$c->id"; ?>' class='user-comment-header'>
                    <?= "/c/$c->id "; ?>
                    <?= "/u/$c->posterUsername "; ?>
                    <?= is_null($c->replyToId) ? "" : "in reply to /c/$c->replyToId "; ?>
                    <!-- TODO: buttons -->
                </span>
                <div class='user-comment-content'>
                    <?= htmlspecialchars($c->content); ?>
                </div>
            </div>
<?php
            }
        }
    }
}

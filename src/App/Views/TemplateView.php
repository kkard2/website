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
                        <a href="/activity">/activity</a>
<?php
        if ($this->currentUser !== null && $this->currentUser->admin) {
            echo '<a href="/cms/software">/cms/software</a>';
        }
?>
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

        if ($this->currentUser !== null) {
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                $comment = isset($_POST['comment']) && is_string($_POST['comment'])
                    ? $_POST['comment']
                    : '';
                if ($comment === '') {
                    // this is not possible thru ui, just ignore
                } else {
                    // NOTE: if someone posted comment > 1000 chars this will
                    //       either throw or truncate, i'm fine with both
                    // NOTE: this does not allow xss, see Database::getPageComments
                    $commentId = $db->postComment($this->currentUser->id, $comment, $this->slug);
                    // prevents refresh resubmitting form
                    header("Location: $this->slug#c$commentId");
                }

            }
?>
<form method='post'>
    <div class='textarea-wrapper'>
        <textarea required maxlength='1000' rows='6' name='comment'></textarea><br>
    </div>
    <button type='submit' value='postcomment'>post</button>
</form><br>
<?php
        }

        $comments = $db->getPageComments($this->slug);

        if (count($comments) == 0) {
            echo 'there are no comments';
        } else {
            foreach ($comments as $c) {
?>
            <div class='user-comment'>
                <span id='<?= "c$c->id"; ?>' class='user-comment-header'>
                    <?=
                        "/c/$c->id by /u/$c->posterUsername @ $c->postedAt ";
                    ?>
<?php
                if ($this->currentUser !== null && $this->currentUser->admin) {
                    echo "<a href='/removecomment?id=$c->id'>[remove]</a>";
                }
?>
                </span>
                <div class='user-comment-content'>
                    <?= $c->content; ?>
                </div>
            </div>
<?php
            }
        }
    }
}

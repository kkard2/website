<?php
namespace App\Views;

class ActivityView implements View {
    public function __construct(
        private readonly \App\Core\Database $db,
        private readonly ?\App\Models\UserUsernameModel $currentUser,
    ) {}

    public function show(): void {
        $comments = $this->db->getAllComments();
        echo '<h1>comments</h1>';

        if (count($comments) == 0) {
            echo 'there are no comments';
        } else {
            foreach ($comments as $c) {
?>
            <div class='user-comment'>
                <span id='<?= "c$c->id"; ?>' class='user-comment-header'>
<?php
                echo "/c/$c->id by /u/$c->posterUsername in ";

                // https://regexlicensing.org/
                // i will regret this hack in the future
                if (str_starts_with($c->slug, '/u/')) {
                    echo $c->slug;
                } else {
                    echo "<a href='$c->slug'>$c->slug</a>";
                }

                echo " @ $c->postedAt ";
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

    public function shouldDisplayComments(): bool { return false; }
}

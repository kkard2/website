<?php
namespace App\Views;

class UserView implements View {
    public function __construct(
        private readonly \App\Core\Database $db,
        private readonly string $username,
        private readonly ?\App\Models\UserUsernameModel $currentUser,
    ) {}

    public function show(): void {
        $user = $this->db->getUser($this->username);

        if ($user === null) {
            throw new \App\Exceptions\NotFoundException("/u/$this->username/");
        }

        if ($user->hide) {
            echo '<del>';
        }

        $isOwner = $this->currentUser !== null && $user->id === $this->currentUser->id;
        $isAdmin = $this->currentUser !== null && $this->currentUser->admin;

        $children = $this->db->getChildren($user->id);

        if ($isOwner) {
            echo '<p><a href="/logoutall">[log out everywhere]</a> <a href="/changepassword">[change password]</a></p>';
        }

?>
<h1>/u/<?= $user->username; ?> <?= $isOwner ? ' (you)' : ''; ?></h1>
<?php
        echo $user->escapedBio() !== null
            ? $user->escapedBio()
            : '<span class="comment">no bio</span>';

        if ($isOwner) {
            echo '<br><br><a href="/editbio">[edit]</a>';
        }
?>
<h2>parent</h2>
<?php
        echo $user->parentUsername !== null
            ? "/u/$user->parentUsername"
            : '<span class="comment">no parent</span>';
?>
<h2>children</h2>
<?php
        if (count($children) === 0) {
            echo '<span class="comment">no children</span>';
        } else {
            echo '<ul>';
            foreach ($children as $child) {
                if (!$isOwner && !$isAdmin && $child->hide) {
                    continue;
                }
                echo '<li>';
                if ($isOwner) {
                    if ($child->hide) {
                        echo "<a href='/adopt?username=$child->username'>[adopt]</a>&nbsp;";
                    } else {
                        echo "<a href='/disown?username=$child->username'>[disown]</a>";
                    }
                } elseif ($isAdmin) {
                    echo "<a href='/adopt?username=$child->username'>[adopt]</a> ";
                    echo "<a href='/disown?username=$child->username'>[disown]</a>";
                }
                echo ' ';
                if ($child->hide) {
                    echo '<del>';
                }
                echo "/u/$child->username";
                if ($child->hide) {
                    echo '</del>';
                }
                echo '</li>';
            }
            echo '</ul>';
        }

        if ($isOwner || $isAdmin) {
            echo '<h2>parent key</h2>';
            if (isset($_GET['recreateparentkey'])) {
                $key = $this->db->createParentKey($user->id);
            }
            if (isset($_GET['showparentkey'])) {
                $key = $this->db->getParentKey($user->id);
                if ($key === null) {
                    $key = $this->db->createParentKey($user->id);
                }
                echo '<a href="?">[hide]</a> ';
                echo '<a href="?showparentkey&recreateparentkey">[recreate]</a><br>';
                echo "<span style='word-break: break-all;'>$key</span>";
            } else {
                echo '<a href="?showparentkey">[show]</a>';
            }
        }

        if ($user->hide) {
            echo '</del>';
        }
    }

    public function shouldDisplayComments(): bool { return true; }
}

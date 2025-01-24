<?php
namespace App\Views;

class FamilyView implements View {
    public function __construct(
        private readonly \App\Core\Database $db,
    ) {}

    public function show(): void {
?>
<h1>family</h1>
if you want an account on the site, you need to get the parent key from one of
these users:
<ul>
<?php
        foreach ($this->db->getAllUserUsernames() as $user) {
            echo "<li>/u/$user</li>";
        }
?>
</ul>
in the case of you performing a no no they may get banned alongside you
(i will decide this on case by case basis)
<?php
    }

    public function shouldDisplayComments(): bool { return false; }
}

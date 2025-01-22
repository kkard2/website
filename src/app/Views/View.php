<?php
namespace App\Views;

interface View {
    public function show(): void;
    public function shouldDisplayComments(): bool;
}

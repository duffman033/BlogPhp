<?php ob_start(); ?>

<?= $msg ?>

<?php
$title = "Erreur - Bastien Moreau";
$content = ob_get_clean();
require "template.php";
?>
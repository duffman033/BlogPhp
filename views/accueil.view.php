<?php
ob_start();
?>
    Coucou
<?php
$title = "Accueil - Bastien Moreau";
$content = ob_get_clean();
require "template.php";
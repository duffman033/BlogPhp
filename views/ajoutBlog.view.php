<?php ob_start() ?>
<form enctype="multipart/form-data" method="post" action="<?= URL ?>blogs/av" class="bg-light p-5 contact-form">
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Titre du Blog" id="title" name="title" required>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Chapô du blog" id="chapo" name="chapo" required>
    </div>
    <div class="form-group">
        <textarea type="text" class="form-control" cols="30" rows="7" placeholder="Contenu du blog" id="article" name="article" required></textarea>
    </div>
    <div class="form-group">
        <label for="image">Image :</label>
        <input type="file" class="form-control-file" id="image" name="image">
    </div>
    <div class="form-group">
        <input type="submit" value="Valider" class="btn btn-primary py-3 px-5">
    </div>
</form>
<?php
$title = "Ajout Blog - Bastien Moreau";
$content = ob_get_clean();
require "template.php";
?>

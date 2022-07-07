<?php ob_start() ?>
<form enctype="multipart/form-data" method="post" action="<?= URL ?>blogs/mv" class="bg-light p-5 contact-form">
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Titre du Blog" id="title" name="title" value="<?= $blog->getBlogTitle() ?>" required>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Chapô du blog" id="chapo" name="chapo" value="<?= $blog->getChapo() ?>" required>
    </div>
    <div class="form-group">
        <textarea type="text" class="form-control" cols="30" rows="7" placeholder="Contenu du blog" id="article" name="article" required><?= $blog->getArticle() ?></textarea>
    </div>
    <div class="form-group">
        <label for="image">Image :</label>
        <img src="<?= URL ?>public/images/<?= $blog->getImgUrl() ?>" class="img-fluid">
        <input type="file" class="form-control-file" id="image" name="image">
    </div>
    <div class="form-group">
        <input type="hidden" name="id" value="<?= $blog->getId(); ?>">
        <input type="submit" value="Valider" class="btn btn-primary py-3 px-5">
    </div>
</form>
<?php
$title = "Ajout Blog - Bastien Moreau";
$content = ob_get_clean();
require "template.php";
?>

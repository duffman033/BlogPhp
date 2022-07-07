<?php
ob_start();
for($i = 0; $i<count($blogs); $i++) :?>
    <div class="col-md-12">
        <div class="blog-entry ftco-animate d-md-flex">
            <a href="../index.php" class="img img-2" style="background-image: url(<?= URL ?>public/images/<?= $blogs[$i]->getImgUrl()?>);"></a>
            <div class="text text-2 pl-md-4">
                <h3 class="mb-2"><a href="../index.php"><?= $blogs[$i]->getBlogTitle() ?></a></h3>
                <div class="meta-wrap">
                    <p class="meta">
                        <span><i class="icon-calendar mr-2"></i><?= $blogs[$i]->getDateUpdate() ?></span>
                    </p>
                </div>
                <p class="mb-4"><?= $blogs[$i]->getChapo() ?></p>
                <p><a href="<?=URL ?>blogs/l/<?= $blogs[$i]->getId()?>" class="btn-custom">Voir plus <span class="ion-ios-arrow-forward"></span></a></p>
            </div>
        </div>
    </div>
<?php endfor ?>
<?php
$title = "Blogs Post - Bastien Moreau";
$content = ob_get_clean();
require "template.php";
?>
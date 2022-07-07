<?php
ob_start();?>
    <p><a href="<?= URL ?>blogs/a" class="reply">Ajouter un nouveau Blog</a></p>

    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">Titre</th>
                    <th scope="col">Chapo</th>
                    <th scope="col">Modifier</th>
                    <th scope="col">Supprimer</th>
                </tr>
                </thead>
                <tbody>
                <?php for($i = 0; $i<count($blogs); $i++) :?>
                <tr>
                    <td><?= $blogs[$i]->getBlogTitle() ?></td>
                    <td><?= $blogs[$i]->getChapo() ?></td>
                    <td><a href="<?= URL?>blogs/m/<?= $blogs[$i]->getId() ?>" class="reply">Modifier</a></td>
                    <td>
                        <form method="POST" action="<?= URL ?>blogs/s/<?= $blogs[$i]->getId(); ?>" onSubmit="return confirm('Voulez-vous vraiment Supprimer?');">
                            <button type="submit" class="btn btn-outline-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endfor ?>
                </tbody>
            </table>
        </div>
    </div>

<?php
$title = "Blogs Post - Bastien Moreau";
$content = ob_get_clean();
require "template.php";
?>
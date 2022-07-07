<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $title ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= URL ?>assets/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="<?= URL ?>assets/css/animate.css">

    <link rel="stylesheet" href="<?= URL ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= URL ?>assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?= URL ?>assets/css/magnific-popup.css">

    <link rel="stylesheet" href="<?= URL ?>assets/css/aos.css">

    <link rel="stylesheet" href="<?= URL ?>assets/css/ionicons.min.css">

    <link rel="stylesheet" href="<?= URL ?>assets/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="<?= URL ?>assets/css/jquery.timepicker.css">


    <link rel="stylesheet" href="<?= URL ?>assets/css/flaticon.css">
    <link rel="stylesheet" href="<?= URL ?>assets/css/icomoon.css">
    <link rel="stylesheet" href="<?= URL ?>assets/css/style.css">
</head>
<body>

<div id="colorlib-page">
    <a href="#" class="js-colorlib-nav-toggle colorlib-nav-toggle"><i></i></a>
    <aside id="colorlib-aside" role="complementary" class="js-fullheight">
        <nav id="colorlib-main-menu" role="navigation">
            <ul>
                <li class="colorlib-active"><a href="<?= URL ?>accueil">Accueil</a></li>
                <li><a href="<?= URL ?>blogs">Blog Posts</a></li>
                <li><a href="about.html">A propos</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="<?= URL ?>login">Connexion / Inscription</a></li>
                <li><a href="<?= URL ?>dashboard">Dashboard</a></li>
            </ul>
        </nav>

        <div class="colorlib-footer">
            <h1 id="colorlib-logo" class="mb-4"><a href="index.html" style="background-image: url(public/images/bg_1.jpg);">Bastien <span>Moreau</span></a></h1>
            <div class="mb-4">
                <h3>Inscrivez vous à la newsletter</h3>
                <form action="#" class="colorlib-subscribe-form">
                    <div class="form-group d-flex">
                        <div class="icon"><span class="icon-paper-plane"></span></div>
                        <input type="text" class="form-control" placeholder="Entrez votre adresse mail.">
                    </div>
                </form>
            </div>
            <p class="pfooter"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
        </div>
    </aside><!-- END COLORLIB-ASIDE -->
    <div id="colorlib-main">
        <section class="ftco-section ftco-no-pt ftco-no-pb">
            <div class="container">
                <div class="row d-flex">
                    <div class="col-xl-8 py-5 px-md-5">
                        <div class="row pt-md-4">

                            <?php if(!empty($_SESSION['alert'])) : ?>
                                <div class="fixed-top alert alert-<?= $_SESSION['alert']['type']?>" role="alert">
                                    <?= $_SESSION['alert']['msg']?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif ?>

                            <!-- CONTENT -->
                            <?= $content ?>
                            <!-- CONTENT -->

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div><!-- END COLORLIB-MAIN -->
</div><!-- END COLORLIB-PAGE -->

<!-- loader -->
<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


<script src="<?= URL ?>assets/js/jquery.min.js"></script>
<script src="<?= URL ?>assets/js/jquery-migrate-3.0.1.min.js"></script>
<script src="<?= URL ?>assets/js/popper.min.js"></script>
<script src="<?= URL ?>assets/js/bootstrap.min.js"></script>
<script src="<?= URL ?>assets/js/jquery.easing.1.3.js"></script>
<script src="<?= URL ?>assets/js/jquery.waypoints.min.js"></script>
<script src="<?= URL ?>assets/js/jquery.stellar.min.js"></script>
<script src="<?= URL ?>assets/js/owl.carousel.min.js"></script>
<script src="<?= URL ?>assets/js/jquery.magnific-popup.min.js"></script>
<script src="<?= URL ?>assets/js/aos.js"></script>
<script src="<?= URL ?>assets/js/jquery.animateNumber.min.js"></script>
<script src="<?= URL ?>assets/js/scrollax.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
<script src="<?= URL ?>assets/js/google-map.js"></script>
<script src="<?= URL ?>assets/js/main.js"></script>

</body>
</html>
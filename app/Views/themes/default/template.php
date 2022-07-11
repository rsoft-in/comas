<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $site_desc ?>">
    <meta name="keywords" content="<?= $site_keywords ?>">

    <link rel="stylesheet" href="<?= base_url() ?>/assets/themes/default.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title><?= $site_name .  (!empty($page_title) ? ' - ' . $page_title : '') ?></title>
    <script>
        var drawer = document.getElementsByClassName("navbar");

        function closeDrawer() {
            drawer[0].style.display = "none";
        }

        function openDrawer() {
            drawer[0].style.display = "block";
        }
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top bg-light">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <?php if ($site_show_logo_only && !empty($site_logo)) { ?>
                    <?= img(base_url() . '/writable/uploads/' . $site_logo, false, ['width' => '30', 'height' => '30', 'class' => 'd-inline-block align-text-top']) ?>
                <?php } ?>
                <?php if ($site_show_name_only) { ?>
                    <?= $site_name ?>
                <?php } ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php foreach ($site_links as $link) { ?>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="<?= base_url() . '/' . index_page() ?>/pages/page/<?= $link->page_url_slug ?>">
                                <?= (strtolower($link->page_title) == 'poetria' ? img(base_url() . '/assets/themes/poetria.png', false, ['style' => 'width: 18px;']) : '') ?>
                                <?= $link->page_title ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <?php $this->renderSection('content') ?>
    </div>
    <div class="container">
        <footer class="row row-cols-1 row-cols-md-3 g-4 py-3 mt-4 border-top bg-light">
            <div class="col">
                <div class="text-muted"><?= $site_name ?></div>
                <div class="text-muted"><small><?= $site_desc ?></small></div>
                <?php if (!empty($site_contact_email)) { ?>
                    <div class="text-muted">
                        <small><?= $site_contact_email ?></small>
                    </div>
                <?php } ?>
                <?php if (!empty($site_contact_phone)) { ?>
                    <div class="text-muted">
                        <small><?= $site_contact_phone ?></small>
                    </div>
                <?php } ?>
                <?php if (!empty($site_contact_mobile)) { ?>
                    <div class="text-muted">
                        <small><?= $site_contact_mobile ?></small>
                    </div>
                <?php } ?>
            </div>
            <div class="col text-muted text-center">
                <a href="/" class="text-muted text-decoration-none">
                    <?php if ($site_show_logo_only && !empty($site_logo)) { ?>
                        <?= img(base_url() . '/writable/uploads/' . $site_logo, false, ['width' => '30', 'height' => '30']) ?>
                    <?php } ?>
                </a>
            </div>
            <div class="col">
                <ul class="nav justify-content-end list-unstyled">
                    <?php if (!empty($site_social_fb_url)) { ?>
                        <li class="ms-3">
                            <?= anchor($site_social_fb_url, "<i class=\"bi bi-facebook\"></i>") ?>
                        </li>
                    <?php } ?>
                    <?php if (!empty($site_social_ig_url)) { ?>
                        <li class="ms-3">
                            <?= anchor($site_social_ig_url, "<i class=\"bi bi-instagram\"></i>", ['class' => 'social']) ?>
                        </li>
                    <?php } ?>
                    <?php if (!empty($site_social_tw_url)) { ?>
                        <li class="ms-3">
                            <?= anchor($site_social_tw_url, "<i class=\"bi bi-twitter\"></i>") ?>
                        </li>
                    <?php } ?>
                </ul>
                <div class="text-muted text-end mt-3">
                    <small>Maintained by <a href="https://rennovationsoftware.com">RennovationSoftware</a></small>
                </div>
            </div>
        </footer>
    </div>

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $site_desc ?>">
    <meta name="keywords" content="<?= $site_keywords ?>">

    <link rel="stylesheet" href="<?= base_url() ?>/assets/themes/default.css">
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
    <div class="header">
        <h1 class="logo">
            <?php if ($site_show_logo_only && !empty($site_logo)) { ?>
                <a href="<?= base_url() ?>"><?= img(base_url() . '/writable/uploads/' . $site_logo, false) ?></a>
            <?php } ?>
            <?php if ($site_show_name_only) { ?>
                <a href="<?= base_url() ?>"><?= $site_name ?></a>
            <?php } ?>
        </h1>
        <div class="navbar-toggle" onclick="openDrawer()"><i class="las la-bars"></i></div>
        <div class="navbar">
            <div class="close">
                <div class="title">Menu</div>
                <a class="drawer-close" onclick="closeDrawer();">&times;</a>
            </div>
            <?php foreach ($site_links as $link) { ?>
                <a class="nav-link" href="<?= base_url() . '/' . index_page() ?>/pages/page/<?= $link->page_url_slug ?>"><?= $link->page_title ?></a>
            <?php } ?>
        </div>
    </div>
    <div class="main">

        <?php $this->renderSection('content') ?>

    </div>
    <div class="footer">
        <div class="row">
            <div class="footer-col">
                <div class="section">
                    <a href="<?= base_url() ?>">
                        <i class="las la-home"></i> <?= $site_name ?></a>
                    <div class="mt-2"></div>
                    <?php if (!empty($site_contact_email)) { ?>
                        <div class="item">
                            <i class="las la-envelope"></i> <?= $site_contact_email ?>
                        </div>
                    <?php } ?>
                    <?php if (!empty($site_contact_phone)) { ?>
                        <div class="item">
                            <i class="las la-phone"></i> <?= $site_contact_phone ?>
                        </div>
                    <?php } ?>
                    <?php if (!empty($site_contact_mobile)) { ?>
                        <div class="item">
                            <i class="las la-mobile"></i> <?= $site_contact_mobile ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="footer-col">
                <div class="section">
                    <?php if ($site_show_categories) { ?>
                        <div class="list">
                            <?php foreach ($site_categories as $cat) { ?>
                                <div class="list-item">
                                    <?= anchor('pages/category/' . $cat->cg_id . '/1', $cat->cg_name) ?>
                                </div>
                            <?php } ?>
                            <div class="list-item">
                                <?= anchor('admin/login', 'Members') ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="footer-col">
                <div class="section">
                    <?php if ($site_show_social_links) { ?>
                        <?php if (!empty($site_social_fb_url)) { ?>
                            <div>
                                <?= anchor($site_social_fb_url, "<i class=\"lab la-facebook\"></i>", ['class' => 'social']) ?>
                            </div>
                        <?php } ?>
                        <?php if (!empty($site_social_ig_url)) { ?>
                            <div>
                                <?= anchor($site_social_ig_url, "<i class=\"lab la-instagram\"></i>", ['class' => 'social']) ?>
                            </div>
                        <?php } ?>
                        <?php if (!empty($site_social_tw_url)) { ?>
                            <div>
                                <?= anchor($site_social_tw_url, "<i class=\"lab la-twitter\"></i>", ['class' => 'social']) ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
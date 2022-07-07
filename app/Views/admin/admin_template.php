<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/default-template.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="<?php echo base_url() ?>/scripts/helper.js"></script>
    <script src="<?php echo base_url() ?>/scripts/default.js"></script>

    <title><?php echo SITE_NAME . ' ' . $page_title ?></title>

</head>

<body>
    <header class="navbar navbar-dark sticky-top bg-primary flex-md-nowrap p-2 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">
            <img src="<?php echo base_url() ?>/assets/comas-light.png" alt="" width="18" height="18" class="d-inline-block align-text-top me-2">
            <?php echo SITE_NAME ?>
        </a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-1">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="<?php echo base_url() ?>">
                                <i class="bi bi-house"></i>
                                Website
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($menu_id == 'dashboard' ? 'active' : '') ?>" aria-current="page" href="<?php echo base_url() . '/' . index_page() ?>/admin/dashboard">
                                <i class="bi bi-grid<?= ($menu_id == 'dashboard' ? '-fill' : '') ?>"></i>
                                Dashboard
                            </a>
                        </li>
                        <?php if ($_SESSION['user_level'] >= 1) { ?>
                            <li class="nav-item">
                                <a class="nav-link <?= ($menu_id == 'pages' ? 'active' : '') ?>" href="<?php echo base_url() . '/' . index_page() ?>/admin/pages">
                                    <i class="bi bi-file-earmark-richtext<?= ($menu_id == 'pages' ? '-fill' : '') ?>"></i>
                                    Pages
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= ($menu_id == 'posts' ? 'active' : '') ?>" href="<?php echo base_url() . '/' . index_page() ?>/admin/posts">
                                    <i class="bi bi-chat-right-text<?= ($menu_id == 'posts' ? '-fill' : '') ?>"></i>
                                    Posts
                                </a>
                            </li>
                        <?php } ?>
                        <?php if ($_SESSION['user_level'] >= 3) { ?>
                            <li class="nav-item">
                                <a class="nav-link <?= ($menu_id == 'users' ? 'active' : '') ?>" href="<?php echo base_url() . '/' . index_page() ?>/admin/users">
                                    <i class="bi bi-person<?= ($menu_id == 'users' ? '-fill' : '') ?>"></i>
                                    Users
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= ($menu_id == 'categories' ? 'active' : '') ?>" href="<?php echo base_url() . '/' . index_page() ?>/admin/categories">
                                    <i class="bi bi-collection<?= ($menu_id == 'categories' ? '-fill' : '') ?>"></i>
                                    Categories
                                </a>
                            </li>
                        <?php } ?>
                        <?php if ($_SESSION['user_level'] == 5) { ?>
                            <li class="nav-item">
                                <a class="nav-link <?= ($menu_id == 'settings' ? 'active' : '') ?>" href="<?php echo base_url() . '/' . index_page() ?>/admin/settings">
                                    <i class="bi bi-gear<?= ($menu_id == 'settings' ? '-fill' : '') ?>"></i>
                                    Settings
                                </a>
                            </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url() . '/' . index_page() ?>/admin/login/signout">
                                <i class="bi bi-box-arrow-left"></i>
                                Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?php echo $page_title ?></h1>
                </div>
                <div class="container">
                    <?php $this->renderSection('content') ?>
                </div>
            </main>
        </div>
    </div>
    <div class="notifier">
        <div class="alert alert-warning notify-msg" role="alert">
            Welcome
        </div>
    </div>
    <script>
        $(document).ready(function() {

        });
    </script>
</body>

</html>
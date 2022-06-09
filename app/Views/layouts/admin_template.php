<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/default-template.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <title><?php echo SITE_NAME . ' ' . $page_title ?></title>

</head>

<body>
    <nav class="navbar bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="<?php echo base_url() ?>/assets/comas.png" alt="" width="24" height="24" class="d-inline-block align-text-top">
                <?php echo SITE_NAME . ' ' . $page_title ?>
            </a>
        </div>
    </nav>
    <div class="container main">
        <?php $this->renderSection('content') ?>
    </div>

</body>

</html>
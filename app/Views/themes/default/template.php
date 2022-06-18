<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $site_desc ?>">

    <link rel="stylesheet" href="<?= base_url() ?>/assets/themes/default.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <title><?= $site_name ?></title>
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
        <h1 class="logo"><a href="<?= base_url() ?>"><?= $site_name ?></a></h1>
        <div class="navbar-toggle" onclick="openDrawer()"><i class="las la-bars"></i></div>
        <div class="navbar">
            <div class="mt-2 v-sm"></div>
            <a id="drawer-close" class="close" onclick="closeDrawer();">&times;</a>
            <?php foreach ($site_links as $link) { ?>
                <a href="<?= base_url() . '/' . index_page() ?>/pages/page/<?= $link->page_url_slug ?>"><?= $link->page_title ?></a>
            <?php } ?>
        </div>
    </div>
    <div class="main">

        <?php $this->renderSection('content') ?>

    </div>
    <div class="footer">
        <div class="row">
            <div class="column">
                <div class="section">
                    <a href="<?= base_url() ?>"><?= $site_name ?></a>
                </div>
            </div>
            <div class="column">
                <div class="section"></div>
            </div>
            <div class="column">
                <div class="section"></div>
            </div>
        </div>
    </div>
</body>

</html>
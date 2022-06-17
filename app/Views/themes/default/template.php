<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
            <a id="drawer-close" class="close" onclick="closeDrawer();">&times;</a>
            <a href="#">About Us</a>
            <a href="#">Contact</a>
        </div>
    </div>
    <div class="main">
        <div class="highlights">
            <?php $this->renderSection('content') ?>
        </div>
    </div>
</body>

</html>
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

    <title><?php echo SITE_NAME ?></title>

    <script>
        $(document).ready(function() {
            $('.form-control').keypress(function(event) {
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if (keycode == '13') {
                    signIn();
                }
            });
            $('#f_username').focus();
        });

        function signIn() {
            if ($('#f_username').val() == "" || $('#f_userpwd').val() == "") {
                return;
            }
            var postdata = {
                'user': $('#f_username').val(),
                'pwd': $('#f_userpwd').val(),
                'rem': $('#remember-me').is(":checked")
            }
            postdata = JSON.stringify(postdata);
            $.ajax({
                type: "POST",
                url: "<?= base_url() . '/' . index_page() ?>/admin/login/checkUser",
                data: "postdata=" + postdata,
                success: function(result) {
                    if (result === 'true')
                        location.href = "<?= base_url() . '/' . index_page() ?>/admin/dashboard";
                    else {
                        console.log(result);
                        showToast("Invalid login!");
                    }
                },
                error: function(XMLHttpRequest, status, error) {
                    alert(error);
                },
            });
        }
    </script>

</head>

<body class="text-center">

    <main class="form-signin w-100 m-auto">
        <div style="height: 100px;"></div>
        <form>
            <img class="mb-4" src="<?php echo base_url() ?>/assets/comas.png" alt="" width="50" height="50">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating">
                <input type="text" class="form-control" id="f_username" placeholder="Username" value="<?= $user[0] ?>">
                <label for="f_username">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="f_userpwd" placeholder="Password" value="<?= $user[1] ?>">
                <label for="f_userpwd">Password</label>
            </div>

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" id="remember-me"> Remember me
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="button" onclick="signIn()">Sign in</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2021–2022 <a href="https://rennovationsoftware.com">Rennovation Software</a></p>
        </form>
    </main>
    <div class="notifier">
        <div class="alert alert-warning notify-msg" role="alert">
            Welcome
        </div>
    </div>
</body>

</html>
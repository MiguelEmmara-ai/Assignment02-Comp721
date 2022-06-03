<!--Author: Muhamad Miguel Emmara-->
<!--Student ID: 18022146-->
<!--Email: ryf2144@autuni.ac.nz-->

<!--
    Description of File:
    Installation For The Script
-->

<?php
if (file_exists('includes/dbconf/settings.php') && file_exists('includes/backend/settings.php')) {
    header('location:index.php');
    die();
}

$msg = "";
$host = "";
$user = "";
$pswd = "";
$dbnm = "";

if (isset($_POST['submit'])) {
    $host = $_POST['host'];
    $user = $_POST['user'];
    $pswd = $_POST['pswd'];
    $dbnm = $_POST['dbnm'];

    $con = @mysqli_connect($host, $user, $pswd, $dbnm);
    if (mysqli_connect_error()) {
        $msg = mysqli_connect_error();
    } else {
        copy("includes/dbconf/settings.inc.config.php", "includes/dbconf/settings.php");
        $file1 = "includes/dbconf/settings.php";
        file_put_contents($file1, str_replace("db_host", $host, file_get_contents($file1)));
        file_put_contents($file1, str_replace("db_username", $user, file_get_contents($file1)));
        file_put_contents($file1, str_replace("db_password", $pswd, file_get_contents($file1)));
        file_put_contents($file1, str_replace("db_name", $dbnm, file_get_contents($file1)));

        copy("includes/dbconf/settings.inc.config.php", "includes/backend/settings.php");
        $file2 = "includes/backend/settings.php";
        file_put_contents($file2, str_replace("db_host", $host, file_get_contents($file2)));
        file_put_contents($file2, str_replace("db_username", $user, file_get_contents($file2)));
        file_put_contents($file2, str_replace("db_password", $pswd, file_get_contents($file2)));
        file_put_contents($file2, str_replace("db_name", $dbnm, file_get_contents($file2)));

        header('location:index.php');
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PHP Installer</title>
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        table {
            width: 30% !important;
            text-align: center;
            margin: auto;
            margin-top: 100px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        .frm {
            width: 70% !important;
            margin: auto;
            margin-top: 100px;
        }
    </style>
</head>

<body>

    <main role="main" class="container">

        <?php
        if ((isset($_GET['step'])) && $_GET['step'] == 2) {
        ?>

            <form class="frm" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Host" required name="host" value="<?php echo $host ?>">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Database User Name" required name="user" value="<?php echo $user ?>">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Database Password" name="pswd" value="<?php echo $pswd ?>">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Database Name" required name="dbnm" value="<?php echo $dbnm ?>">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                <span class="error"><?php echo $msg ?></span>
            </form>

        <?php
        } else {
        ?>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Configuration</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">PHP Version</th>
                        <td>
                            <?php
                            $is_error = "";
                            $php_version = phpversion();
                            if ($php_version > 5) {
                                echo "<span class='success'>" . $php_version . "</span>";
                            } else {
                                echo "<span class='error'>" . $php_version . "</span>";
                                $is_error = 'yes';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Curl Install</th>
                        <td>
                            <?php
                            $curl_version = function_exists('curl_version');
                            if ($curl_version) {
                                echo "<span class='success'>Yes</span>";
                            } else {
                                echo "<span class='error'>No</span>";
                                $is_error = 'yes';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Mail Function</th>
                        <td>
                            <?php
                            $mail = function_exists('mail');
                            if ($mail) {
                                echo "<span class='success'>Yes</span>";
                            } else {
                                echo "<span class='error'>No</span>";
                                $is_error = 'yes';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Session Working</th>
                        <td>
                            <?php
                            $_SESSION['IS_WORKING'] = 1;
                            if (!empty($_SESSION['IS_WORKING'])) {
                                echo "<span class='success'>Yes</span>";
                            } else {
                                echo "<span class='error'>No</span>";
                                $is_error = 'yes';
                            }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <?php
                            if ($is_error == '') {
                            ?>
                                <a href="?step=2"><button type="button" class="btn btn-success">Next</button></a>
                            <?php
                            } else {
                            ?><button type="button" class="btn btn-danger">Error</button><?php
                                                                    }
                                                                        ?>
                        </td>
                    </tr>
                </tbody>

            </table>
        <?php } ?>

    </main>

    <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
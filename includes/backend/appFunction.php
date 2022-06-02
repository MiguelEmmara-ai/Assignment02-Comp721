<?php

/*
|--------------------------------------------------------------------------
| Access Restriction
|--------------------------------------------------------------------------
|
| Here is the declaration that user or visitor
| can access the page
| all the (!defined('MY_CONSTANT')) meaning pages that CANNOT be access.
|
*/

if (!defined('MY_CONSTANT')) {
    // You can show a message
    die('Access not allowed!');
    exit; // This line is needed to stop script execution
}

/**
 * Check User Logged In
 * 
 * Check If User LoggedIn, if not then redirect him to login page
 *
 * @author     Muhamad Miguel Emmara - 180221456 <ryf2144@autuni.ac.nz>
 */
function checkUserLoggedIn()
{
    // Check if the user is logged in, if not then redirect him to login page
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {

        sweetAlertMsgReturn("Oh No...", "You Are Not Logged In, Please Log In First Buddy", "error", "OK", "login.php");

        exit();
    }
}

/**
 * Check User Logged In Redirect
 * 
 * Check if the user is already logged in, if yes then redirect him to admin page
 *
 * @author     Muhamad Miguel Emmara - 180221456 <ryf2144@autuni.ac.nz>
 */
function checkUserLoggedInRedirect()
{
    // Check if the user is already logged in, if yes then redirect him to admin page
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        header("location: admin.php");
        exit;
    } else {
        loginDrivers();
    }
}

/**
 * Logout Drivers
 *
 * @author     Muhamad Miguel Emmara - 180221456 <ryf2144@autuni.ac.nz>
 */
function logoutDrivers()
{
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        // If the user not logged, alert them

        sweetAlertMsgReturn("Oh No...", "You Are Not Logged In, Please Log In First Buddy", "error", "OK", "login.php");
    } else {
        // Unset all of the session variables
        $_SESSION = array();

        // Destroy the session.
        session_destroy();

        // If the user successfully  logged out, alert them
        sweetAlertMsgReturn("Bye", "Hope You Enjoy The Ride", "success", "OK", "login.php");
        exit;
    }
}

/**
 * sweetAlertMsg
 *
 * @param string   $title   The title of the popup, as HTML.
 * @param string   $text    A description for the popup. If text and html parameters are provided in the same time, html will be used.
 * @param string   $icon    The icon of the popup. SweetAlert2 comes with 5 built-in icon which will show a corresponding icon animation: warning, error, success, info, and question.
 * @param string   $btn    Button Text.
 *
 *
 * @author     Muhamad Miguel Emmara - 180221456 <ryf2144@autuni.ac.nz>
 */
function sweetAlertMsg($title, $text, $icon, $btn)
{
    echo '
    <script type="text/javascript">

    $(document).ready(function(){

        swal({
            html: true,
            title: "' . $title . '",
            text: "' . $text . '",
            icon: "' . $icon . '",
            button: "' . $btn . '",
        })
          });

    </script>
    ';
}

/**
 * sweetAlertMsgReturn
 *
 * @param string   $title   The title of the popup, as HTML.
 * @param string   $text    A description for the popup. If text and html parameters are provided in the same time, html will be used.
 * @param string   $icon    The icon of the popup. SweetAlert2 comes with 5 built-in icon which will show a corresponding icon animation: warning, error, success, info, and question.
 * @param string   $btn    Button Text.
 * @param string   $return  Window Location href
 *
 *
 * @author     Muhamad Miguel Emmara - 180221456 <ryf2144@autuni.ac.nz>
 */
function sweetAlertMsgReturn($title, $text, $icon, $btn, $return)
{
    echo '
    <script type="text/javascript">

    $(document).ready(function(){

        swal({
            html: true,
            title: "' . $title . '",
            text: "' . $text . '",
            icon: "' . $icon . '",
            button: "' . $btn . '",
        }).then(function() {
            window.location.href = "' . $return . '";
        })
          });

    </script>
    ';
}

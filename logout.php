<!--Author: Muhamad Miguel Emmara-->
<!--Student ID: 18022146-->
<!--Email: ryf2144@autuni.ac.nz-->

<!--
    Description of File:
    logout drivers
-->

<?php

/*
|--------------------------------------------------------------------------
| Access Restriction
|--------------------------------------------------------------------------
|
| Here is the declaration that user or visitor
| can access the page
| all the define('MY_CONSTANT', 1) meaning pages that can be access.
|
*/

define('MY_CONSTANT', 1);

/*
|--------------------------------------------------------------------------
| Initialize the session
|--------------------------------------------------------------------------
|
| creates a session or resumes the current one
| based on a session identifier passed via
| a GET or POST request, or passed via a cookie.
|
*/

session_start();

/*
|--------------------------------------------------------------------------
| Title Variable
|--------------------------------------------------------------------------
|
| Title variable used to
| make dynamic title depending
| on the page where user are on.
|
*/

$title = "Logging Out...";

/*
|--------------------------------------------------------------------------
| Require frontend/header
|--------------------------------------------------------------------------
|
| include file
| frontend/header
| for displaying the header
|
*/

require dirname(__FILE__) . "/includes/frontend/header.php";

/*
|--------------------------------------------------------------------------
| Require backend/appFunction
|--------------------------------------------------------------------------
|
| include file
| backend/appFunction
| We'll require it so we can access the methods inside
|
*/

require dirname(__FILE__) . "/includes/backend/appFunction.php";

/*
|--------------------------------------------------------------------------
| Require backend/SQLfunction
|--------------------------------------------------------------------------
|
| include file
| backend/SQLfunction
| We'll require it so we can access the methods inside
|
*/

require dirname(__FILE__) . "/includes/backend/SQLfunction.php";

/*
|--------------------------------------------------------------------------
| logoutDrivers()
|--------------------------------------------------------------------------
|
| Check If User LoggedIn,
| if true, we display error
| if not then logoutDrivers
|
*/

logoutDrivers();

?>
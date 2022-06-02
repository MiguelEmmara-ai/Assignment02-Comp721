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
| Require dbconf/settings.php
|--------------------------------------------------------------------------
|
| include file
| dbconf/settings.php
| for connect to database
|
*/

require dirname(__FILE__) . "/../dbconf/settings.php";

/*
|--------------------------------------------------------------------------
| Select Database
|--------------------------------------------------------------------------
|
| make query to select
| * FROM passengers WHERE status = 'Unassigned'
| then display it onto the table
|
*/

mysqli_select_db($conn, $dbnm);

$query = "SELECT * FROM passengers WHERE status = 'Unassigned'";

$result = mysqli_query($conn, $query);
?>

<table class="table table-striped table tablesorter" id="ipi-table">
    <thead class="thead-dark">
        <tr>
            <th class="text-center">Booking ref no</th>
            <th class="text-center">customer name</th>
            <th class="text-center">phone number</th>
            <th class="text-center filter-false sorter-false">unit number</th>
            <th class="text-center filter-false sorter-false">street number</th>
            <th class="text-center filter-false sorter-false">street name</th>
            <th class="text-center filter-false sorter-false">suburb</th>
            <th class="text-center filter-false sorter-false">destination suburb</th>
            <th class="text-center filter-false sorter-false">pickup date</th>
            <th class="text-center filter-false sorter-false">pickup time</th>
            <th class="text-center filter-false sorter-false">status</th>
            <th class="text-center filter-false sorter-false">Cars Need</th>
            <th class="text-center filter-false sorter-false">Assigned By</th>
            <th class="text-center filter-false sorter-false">actions</th>
        </tr>
    </thead>

    <?php while ($row = mysqli_fetch_assoc($result)) {?>

        <tbody class="text-center">
            <tr id="<?=$row["bookingRefNo"]?>">
                <td><?=$row["bookingRefNo"]?></td>
                <td><?=$row["customerName"]?></td>
                <td><?=$row["phoneNumber"]?></td>
                <td><?=$row["unitNumber"]?></td>
                <td><?=$row["streetNumber"]?></td>
                <td><?=$row["streetName"]?></td>
                <td><?=$row["suburb"]?></td>
                <td><?=$row["destinationSuburb"]?></td>
                <td><?=$row["pickUpDate"]?></td>
                <td><?=$row["pickUpTime"]?></td>
                <td><?=$row["status"]?></td>
                <td><img src="assets\img\cars\<?=$row["carsNeed"]?>.png" alt="<?=$row["carsNeed"]?>"><br><?=$row["carsNeed"]?></td>
                <td><?=$row["assignedBy"]?></td>

                <?php if ($row['status'] == "Assigned"): ?>
                    <td class="text-center align-middle" style="max-height: 60px;height: 60px;"><a class="btn btn-primary disabled" role="button" aria-disabled="true"><i class="far fa-paper-plane"></i>&nbsp;ASSIGN</a></td>
                <?php else: ?>
                    <td class="text-center align-middle" style="max-height: 60px;height: 60px;"><a class="btn btn-primary" role="button" onClick="updateAssignCab('<?=$row["bookingRefNo"]?>')"><i class="far fa-paper-plane"></i>&nbsp;ASSIGN</a></td>
                <?php endif;?>

            </tr>
        </tbody>

    <?php }?>

    <?php
// Frees up the memory, after using the result pointer
mysqli_free_result($result);

// Close Connection
mysqli_close($conn);?>
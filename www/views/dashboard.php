<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin</title>

    <?php include_once(__DIR__ . "/Layouts/Header.php"); ?>

</head>

<body>
    <div id="wrapper" class="vh-100" style="background-color: #fbfbfb;">

        <!-- Top Navigation -->
        <?php include_once(__DIR__ . "/Layouts/Nav.php"); ?>

        <!-- Title + Button -->
        <div class="container my-4">
            <div class="mb-3">
                <h2>Employee Manager</h2>
            </div>

            <div>
                <button type="button" name="btn_add_employee" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add</button>
            </div>
        </div>

        <!-- Data table -->
        <div class="container">
            <!-- Modal -->
            <?php
            include_once(__DIR__ . "/Cinema/Add.php");
            include_once(__DIR__ . "/Cinema/Remove.php");

            ?>
            <?php include_once(__DIR__ . "/Cinema/Table.php"); ?>
        </div>
    </div>
    <?php include_once(__DIR__ . "/Layouts/Footer.php"); ?>
    <?php include_once(__DIR__ . "/Cinema/Script.php"); ?>

</body>

</html>
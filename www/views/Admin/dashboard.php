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
        <!-- Data table -->
        <div class="container">
            <!-- Modal -->
            <?php
            include_once(__DIR__ . "/" . $_SESSION['path'] . "/Add.php");
            include_once(__DIR__ . "/" . $_SESSION['path'] . "/Remove.php");

            ?>
            <?php include_once(__DIR__ . "/" . $_SESSION['path'] . "/Table.php"); ?>
        </div>
    </div>
    <?php include_once(__DIR__ . "/Layouts/Footer.php"); ?>
    <?php include_once(__DIR__ . "/" . $_SESSION['path'] . "/Script.php"); ?>
</body>

</html>
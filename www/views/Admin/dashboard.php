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
        <div class="alert alert-success" id="msg-success" role="alert" style="display: none;">
            This is a success alert—check it out!
        </div>
        <div class="alert alert-danger" id="msg-failed" role="alert" style="display: none;">
            This is a danger alert—check it out!
        </div>
        <div class="container">
            <!-- Modal -->
            <?php
            include_once(__DIR__ . "/" . $path . "/Add.php");
            include_once(__DIR__ . "/" . $path . "/Remove.php");

            ?>
            <?php include_once(__DIR__ . "/" . $path . "/Table.php"); ?>
        </div>
    </div>
    <?php include_once(__DIR__ . "/Layouts/Footer.php"); ?>
    <?php include_once(__DIR__ . "/" . $path . "/Script.php"); ?>
</body>

</html>
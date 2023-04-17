<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>IIEX Cinema - Homepage</title>

    <?php include_once(__DIR__ . "/Layouts/Header.php"); ?>
    <?php include_once(__DIR__ . "/" . $path . "/Style.php"); ?>

</head>

<body cz-shortcut-listen="true">
    <div id="wrapper" style="background-color: #000218;">
        <!-- Top part -->
        <?php include_once(__DIR__ . "/Layouts/Nav.php"); ?>

        <!-- Content -->
        <?php include_once(__DIR__ . "/" . $path . "/Content.php"); ?>

        <?php include_once(__DIR__ . "/Layouts/Footer.php"); ?>
    </div>
    <?php include_once(__DIR__ . "/Layouts/Script.php"); ?>
    <?php include_once(__DIR__ . "/" . $path . "/Script.php"); ?>
</body>

</html>
<!-- Bootstrap 5.3 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

<!-- JQuery -->
<script language="JavaScript" type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>

<!-- JS -->
<script language="JavaScript" type="text/javascript" src="./script.js"></script>
<script>
    $(function() {
        console.log("run")
        $(<?php echo $_SESSION['path']?>).addClass("btn-dark")
    })
</script>
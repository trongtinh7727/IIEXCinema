    <!-- JQuery -->
    <script language="JavaScript" type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>

    <!-- Bootstrap 5.3 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <!-- Datatables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- Datatable Bootstrap -->
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <!-- JS -->
    <script language="JavaScript" type="text/javascript" src="./script.js"></script>
    <script>
        $(function() {
            console.log("run")
            $(<?php echo $path ?>).addClass("btn-dark")
        })
    </script>
    <!-- Log out modal -->
    <div class="modal fade align-content-center" id="signOutModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 360px;">
                <!-- Log out -->
                <div class="modal-body d-flex flex-column my-4">
                    <div id="log_out_modal_icon" class="m-auto align-middle">
                        <span class="align-middle">
                            <i class="fa-solid fa-door-open fa-2xl text-center w-100"></i>
                        </span>
                    </div>
                    <h1 class="modal-title fs-2 text-center my-2" id="addEmployeeModalLabel">Are you leaving?</h1>
                    <span class="text-center text-secondary my-2">Are you sure you want to sign out?</span>
                    <a href="./?admin/logout"><button type="button" class="btn btn-danger my-2 py-2 rounded-5">Yes, sign out</button></a>
                    <button type="button" class="btn btn-secondary my-2 py-2 rounded-5" data-bs-dismiss="modal">No,
                        I am staying</button>
                </div>
            </div>
        </div>
    </div>
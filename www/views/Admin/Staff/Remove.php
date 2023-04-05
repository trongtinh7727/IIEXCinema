<!-- Confirm Removal Modal -->
<div class="modal fade" id="confirm-removal-modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                <h4 class="modal-title">Xóa sinh viên</h4>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa sinh viên <strong id="student_name">My Tam</strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="delete-button" class="btn btn-danger" data-bs-dismiss="modal">Xóa</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Confirm Removel modal -->
<br>
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
                <button type="button" class="btn btn-danger my-2 py-2 rounded-5">Yes, sign out</button>
                <button type="button" class="btn btn-secondary my-2 py-2 rounded-5" data-bs-dismiss="modal">No,
                    I am staying</button>
            </div>
        </div>
    </div>
</div>
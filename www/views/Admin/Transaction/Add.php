<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addEmployeeModalLabel">Thêm Nhân Viên</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Tên đăng nhập :</label>
                    <input type="text" class="form-control" id="USERNAME" name="username">
                </div>
                <div class="mb-3">
                    <label for="firstname" class="form-label">Họ và tên lót :</label>
                    <input type="text" class="form-control" id="FNAME" name="firstname">
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Tên :</label>
                    <input type="text" class="form-control" id="LNAME" name="lastname">
                </div>
                <div class="mb-3">
                    <label for="sex" class="form-label">Giới tính :</label>
                    <select class="form-select" id="SEX" name="sex">
                        <option value="M">nam</option>
                        <option value="F">nữ</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="birthday" class="form-label">Ngày sinh :</label>
                    <input type="date" class="form-control" id="BIRTHDAY" name="birthday">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại :</label>
                    <input type="text" class="form-control" id="PHONE" name="phone">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Địa chỉ :</label>
                    <input type="text" class="form-control" id="ADDRESS" name="address">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="addStaff" type="button" class="btn btn-primary" data-bs-dismiss="modal">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
<input type="hiden" style="display: none;" name="" id="action" value="Add">
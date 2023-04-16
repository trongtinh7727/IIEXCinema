<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addModalLabel">Thêm Lịch chiếu phim</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form  method="POST">       
                 <div class="mb-3">
                    <label for="role" class="form-label">Chọn phim:</label>
                    <select id="movieBox" class="form-select" >
                        <!-- Movies -->
                    </select>
                </div>
                <div class="mb-3">
                    <label for="birthday" class="form-label">Thời gian bắt đầu :</label>
                    <input type="datetime-local" class="form-control" id="startTimne" name="birthday">
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
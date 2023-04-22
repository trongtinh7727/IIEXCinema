<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addCinemaModalLabel">Thêm</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
                <div class="modal-body">
                    <!-- Input -->
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="">Tên sản phẩm</span>
                        <input id="NAME" type="text" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="">Loại sản phẩm</span>
                        <select id="TYPE" class="form-select w-25" aria-label="Default select example">
                            <option value="-1">Chọn loại sản phẩm</option>
                            <option value="1">Đồ ăn</option>
                            <option value="2">Đồ uống</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="">Số lượng</span>
                        <input id="QUANTITY" type="text" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="">Ngày hết hạn</span>
                        <input id="Expiry_Date" type="date" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="add" type="button" class="btn btn-primary" data-bs-dismiss="modal">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
<input type="hidden" style="display: none;" name="" id="action" value="Add">
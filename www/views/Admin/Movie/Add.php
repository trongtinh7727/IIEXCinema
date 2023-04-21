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
                        <span class="input-group-text" id="">Tiêu đề</span>
                        <input id="TITLE" type="text" class="form-control" placeholder="Title of movie">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="">Tác giả</span>
                        <input id="DIRECTOR" type="text" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="">Diễn viên</span>
                        <input id="ACTORS" type="text" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="">Thể loại</span>
                        <input id="GENRE" type="text" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="">Nội dung</span>
                        <input id="STORY" type="text" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="">Thời lượng</span>
                        <input id="DURATION" type="text" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="">Ngày khởi chiếu</span>
                        <input id="OPENING_DAY" type="date" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="">Ngày kết thúc</span>
                        <input id="CLOSING_DAY" type="date" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="">Poster</span>
                        <input id="POSTER" type="file" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="">Trailer</span>
                        <input id="TRAILER" type="text" class="form-control">
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
<!-- Check which add or update action -->
<input type="hidden" style="display: none;" name="" id="action" value="Add">
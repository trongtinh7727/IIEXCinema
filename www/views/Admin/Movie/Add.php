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
                        <span class="input-group-text" id="">Title</span>
                        <input id="TITLE" type="text" class="form-control" placeholder="Title of movie" aria-label="ID">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="">GENRE</span>
                        <input id="GENRE" type="text" class="form-control" placeholder="GENRE" aria-label="ID">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="">DURATION</span>
                        <input id="DURATION" type="number" class="form-control" placeholder="GENRE" aria-label="ID">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="">RATING</span>
                        <input id="RATING" type="text" class="form-control" placeholder="RATING" aria-label="ID">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="">STORY</span>
                        <input id="STORY" type="text" class="form-control" placeholder="STORY" aria-label="ID">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="">POSTER</span>
                        <input id="POSTER" type="text" class="form-control" placeholder="POSTER" aria-label="ID">
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
<input type="hiden" style="display: none;" name="" id="action" value="Add">
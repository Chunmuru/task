<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#create">
                    Create
                </button>
                <a class="nav-link" href="/admin/request">Request</a>
            </div>
        </div>
        <a href="/logout" class="btn btn-danger">Logout</a>
    </div>
</nav>

<form action="/admin/insert" method="post">
    <div class="modal fade" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buat slot</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="nama" name="nama">
                            <option selected value="Pagi">Pagi</option>
                            <option value="Siang">Siang</option>
                            <option value="Malam">Malam</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="waktu" class="form-label">Waktu</label>
                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="waktu" name="waktu">
                            <option selected value="08.00 - 12.00">08.00 - 12.00</option>
                            <option value="12.00 - 16.00">12.00 - 16.00</option>
                            <option value="16.00 - 20.00">16.00 - 20.00</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" name="deskripsi" placeholder="Leave a comment here" id="floatingTextarea" required></textarea>
                            <label for="floatingTextarea">Deskripsi</label>
                        </div>
                    </div>
                    <div class="mb-3" style="display: flex;">
                        <label for="durasi" class="form-label">Durasi : </label>
                        <p> </p>
                        <input type="number" value="7" class="form-control" style="width: 60px;height: 30px;margin-left: 10px;margin-right: 10px;" id="durasi" name="durasi">
                        <p> </p>
                        <p>Hari</p>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <!-- <input type="text" class="form-control" id="harga" name="harga" value="10000" required> -->
                        <input class="form-control" id="harga" name="harga" type="number" value="10000" min="10000" step="500" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
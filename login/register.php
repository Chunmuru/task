<?= $this->extend('templateLogin/template');  ?>



<?= $this->section('content');  ?>

<form action="/login/proses" method="post">
    <div class="row">
        <div class="col-sm-5 border m-5">
            <h4 class="m-3">Registrasi</h4>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name='nama' autocomplete="off">
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" name='password' autocomplete="off">
                <label for="floatingPassword">Password</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" name='email' autocomplete="off">
                <label for="floatingInput">Email</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name='alamat' autocomplete="off">
                <label for="floatingInput">alamat</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name='umur' autocomplete="off">
                <label for="floatingInput">Umur</label>
            </div>
            <button type="submit" class="btn btn-outline-secondary mb-3 float-end">Submit</button>
        </div>
    </div>
</form>


<?= $this->endSection();  ?>
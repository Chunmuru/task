<?= $this->extend('templateLogin/template');  ?>


<?= $this->section('content');  ?>

<form action="/login/auth" method="post">

    <div class="row">
        <?php if (session()->getFlashData('pesan')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashData('pesan');  ?>
            </div>
        <?php endif; ?>
        <div class="col-sm-7 border m-5">
            <h4 class="m-3">Login</h4>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name='nama' autocomplete="off">
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" name='password' autocomplete="off">
                <label for="floatingPassword">Password</label>
            </div>
            <button type="submit" class="btn btn-outline-secondary mb-3 float-end">Submit</button>
            <a href="/register" class="mt-5 mb-2">Belum punya akun?</a>
        </div>
    </div>
</form>


<?= $this->endSection();  ?>
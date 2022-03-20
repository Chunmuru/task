<?= $this->extend('templateAdmin/template');  ?>



<?= $this->section('content');  ?>


<?php foreach ($req as $r) : ?>

    <div class="row">
        <?php

        $confirm = $r['confirm'] == 'konfirmasi';
        $confirm2 = $r['confirm'] == 'Aktif';
        $confirm3 = $r['confirm'];
        $gambar = $r['gambar'] == NULL;


        if ($confirm2) {
            $confirm3 = 'confirm';
        } else {
            $confirm3;
        }


        ?>
        <?php if ($gambar) : ?>
            <form action="/admin/proses" method="post">
                <input type="hidden" value="<?= $r['id'];  ?>" name="id">
                <input type="hidden" value="<?= $r['nilai'];  ?>" name="nilai">
                <input type="hidden" value="Aktif" name="confirm">
                <div class="col-sm-4 m-5">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">User : <?= $r['nama'];  ?></h5>
                            <p class="card-text">Paket : <?= $r['paket'];  ?></p>
                            <div class="container d-flex">
                                <button type="<?= $confirm ? 'submit' : 'button';  ?>" class=" btn <?= $confirm ? 'btn-warning' : 'btn-secondary';  ?>"><?= $confirm3;  ?></button>
            </form>
            <?php if ($confirm) : ?>
                <form action="/admin/tolak" method="post">
                    <input type="hidden" value="<?= $r['id'];  ?>" name="id">
                    <input type="hidden" value="<?= $r['gambar'];  ?>" name="gambar">
                    <input type="hidden" value="<?= $r['nilai'];  ?>" name="nilai">
                    <input type="hidden" value="Ditolak" name="confirm">
                    <button type="submit" class="btn btn-danger " style="position: relative;right: -30px;">Tolak</button>
                </form>
            <?php endif; ?>
    </div>
    </div>
    </div>
    </div>

<?php else : ?>
    <form action="/admin/gambar" method="post">
        <div class="col-sm-4 m-5">
            <div class="card" style="width: 18rem;">
                <input type="hidden" value="<?= $r['id'];  ?>" name="id">
                <input type="hidden" value="<?= $r['nilai'];  ?>" name="nilai">
                <input type="hidden" value="<?= $r['gambar'];  ?>" name="gambar">
                <input type="hidden" value="Aktif" name="confirm">
                <img src="/gambar/<?= $r['gambar'];  ?>" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">User : <?= $r['nama'];  ?></h5>
                    <p class="card-text">Paket : <?= $r['paket'];  ?></p>
                    <div class="container d-flex">
                        <button type="<?= $confirm ? 'submit' : 'button';  ?>" class=" btn <?= $confirm ? 'btn-warning' : 'btn-secondary';  ?>"><?= $confirm3;  ?></button>
    </form>
    <?php if ($confirm) : ?>
        <form action="/admin/tolak" method="post">
            <input type="hidden" value="<?= $r['id'];  ?>" name="id">
            <input type="hidden" value="<?= $r['nilai'];  ?>" name="nilai">
            <input type="hidden" value="<?= $r['gambar'];  ?>" name="gambar">
            <input type="hidden" value="Ditolak" name="confirm">
            <button type="button" class="btn btn-danger " style="position: relative;right: -30px;">Tolak</button>
        </form>
    <?php endif; ?>

<?php endif; ?>
<?php endforeach; ?>

<?= $this->endsection();  ?>
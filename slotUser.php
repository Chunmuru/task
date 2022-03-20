<?= $this->extend('template/template');  ?>




<?= $this->section('content');  ?>

<br><br><br>
<?php if ($validation->hasError('gambar')) : ?>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
    </svg>
    <div class="alert alert-danger  d-flex alert-dismissible fade show" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
            <use xlink:href="#exclamation-triangle-fill" />
        </svg>
        <div>
            <?= $validation->getError('gambar');  ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>






<?php if (session()->getFlashData('pesan')) : ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </svg>
        <strong>Perhatian</strong> <?= session()->getFlashData('pesan');  ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>


<h1 class="m-2">Slot anda : <?= $jumlah;  ?></h1>

<div class="row">
    <?php foreach ($slotUser as $s) : ?>
        <div class="col-sm-6">
            <?php
            $kata = 'expired';
            $kata2 = 'Butuh konfirmasi';
            $kata3 = 'Ditolak';
            $iya = $s['validasi'];
            $ini = $iya == $kata;
            $itu = $s['nama'];
            ?>
            <div class="card m-4 ">
                <div class="card-body <?= ($ini) ? 'alert-dark' : 'alert-success'; ?>">
                    <h5 class="card-title">Paket <?= $itu;  ?> </h5>

                    <?php

                    switch ($itu) {
                        case 'Pagi':
                            $iyalah = 'Pagi';
                            break;
                        case 'Siang':
                            $iyalah = 'Siang';
                            break;

                        default:
                            $iyalah = 'Malam';
                            break;
                    }

                    ?>
                    <p class="card-text">berlaku sampai tanggal <?= $s['waktu'];  ?></p>
                    <p class="card-text">Dibeli pada : <?= $s['created_at'];  ?></p>
                    <?php if ($iya == $kata) : ?>
                        <p class="card-text">Status : <b style="color:red;"><?= $iya;  ?></b></p>
                    <?php elseif ($iya == $kata3) : ?>
                        <p class="card-text">Status : <b style="color:black;"><?= $iya;  ?></b></p>
                    <?php elseif ($iya == $kata2) : ?>
                        <p class="card-text">Status : <b style="color:yellow;"><?= $iya;  ?></b></p>
                    <?php else : ?>
                        <p class="card-text">Status : <b style="color:greenyellow;"><?= $iya;  ?></b></p>
                    <?php endif; ?>
                    <!-- Button trigger modal -->
                    <?php if ($iya == $kata) : ?>
                        <button type="button" class="btn btn-danger">
                            <?= $iya;  ?>
                        </button>
                    <?php elseif ($iya == $kata3) : ?>
                        <button type="button" class="btn btn-dark">
                            <?= $iya;  ?>
                        </button>
                    <?php elseif ($iya == $kata2) : ?>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#konfirmasi">
                            <?= $iya;  ?>
                        </button>
                        <form action="/user/konfirmasi" method="post">
                            <input type="hidden" value="<?= $user['id'];  ?>" name="nilai">
                            <input type="hidden" name="paket" value="<?= $iyalah;  ?>">
                            <button type="submit" class="btn btn-outline-danger" style="position: absolute;right: 10px;bottom: 15px;">Kirim Nama paket dulu !!</button>
                        </form>
                    <?php else : ?>
                        <button type="button" class="btn btn-success">
                            <?= $iya;  ?>
                        </button>
                    <?php endif; ?>




                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <p id="text"></p>

    <!-- Modal -->
    <div class="modal fade" id="konfirmasi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Langsung Konfirmasi</p>
                    <hr>
                    <form action="/user/konfirmasi" method="post">
                        <input type="hidden" value="<?= $user['nama'];  ?>" name="nama">
                        <input type="hidden" value="<?= $user['id'];  ?>" name="nilai">
                        <button type="submit" class="btn btn-success">Confirm</button>
                    </form>
                    <hr>
                    <p>Pakai Gambar agar admin langsung konfirmasi</p>
                    <hr>
                    <form action="/user/konfirmasi" method="post" enctype="multipart/form-data">
                        <input type="hidden" value="<?= $user['nama'];  ?>" name="nama">
                        <input type="hidden" value="<?= $user['id'];  ?>" name="nilai">
                        <input type="file" name="gambar">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?= $this->endSection();  ?>
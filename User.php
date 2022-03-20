<?php

namespace App\Controllers;

use \App\Models\SlotModel;
use \App\Models\UserModel;
use \App\Models\UserSlotModel;
use \App\Models\UserSaldo;
use \App\Models\UserBayar;
use \App\Models\AdminModel;
use CodeIgniter\I18n\Time;

class User extends BaseController
{
    protected $slot = [];
    protected $UserModel = [];
    protected $UserSlotModel = [];
    protected $UserSaldo = [];
    protected $ini = [];
    protected $saldoUser = [];
    protected $bayar = [];
    protected $admin = [];




    //============================= Fungsi yang dijalankan pertama kali disini rata rata berisi instansiasi class ================================================================ 

    public function __construct()
    {
        $this->slot = new SlotModel();
        $this->UserModel = new UserModel();
        $this->UserSlotModel = new UserSlotModel();
        $this->UserSaldo = new UserSaldo();
        $this->bayar = new UserBayar();
        $this->ini = session()->get('user_id');
        $this->saldoUser = $this->UserSaldo->where('nilai', $this->ini)->find();
        $this->admin = new AdminModel();
    }

    //=============================================================================================================================================================================










    //============================= Halaman utama =============================================================================================== 

    public function index()
    {
        // dd($this->UserModel->where('id', $ini)->first());
        // $saldoUser = $this->UserSaldo->where('nilai', $this->ini)->find();
        // dd($this->UserSaldo->where('nilai', $this->ini)->find())

        $data =
            [
                'title' => 'Web Programming',
                'user'  => $this->UserModel->where('id', $this->ini)->first(),
                'saldo' => $this->saldoUser
            ];
        return view('user/index', $data);
    }

    //=============================================================================================================================================













    //============================= Halaman Slot ===================================================================================================

    public function slot()
    {
        $data =
            [
                'title' => 'Daftar slot',
                'slot'  => $this->slot->findAll(),
                'user'  => $this->UserModel->where('id', $this->ini)->first(),
                'saldo' => $this->saldoUser
            ];
        return view('user/slot', $data);
    }

    //===============================================================================================================================================













    //======================== fungsi edit profile ====================================================================================================

    public function edit()
    {
        // dd($this->request->getVar());

        $this->UserModel->save([
            'id' => $this->request->getVar('id'),
            'nama' => $this->request->getVar('nama'),
            'password' => $this->request->getVar('password'),
            'email' => $this->request->getVar('email'),
            'alamat' => $this->request->getVar('alamat'),
            'umur' => $this->request->getVar('umur'),
        ]);

        return redirect()->to('/user');
    }

    //=================================================================================================================================================











    //========================== Halaman Slot yang punya user =========================================================================================

    public function slotUser()
    {
        $User = $this->UserModel->where('id', $this->ini)->first();
        $Nilai = $User['id'];
        $slot = $this->UserSlotModel->where('nilai', $Nilai)->findAll();
        $jumlahSlot = $this->UserSlotModel->getUserSlot($Nilai);
        // dd($User['nilai']);
        // dd($this->UserSlotModel->where('nilai', $Nilai)->find());
        // dd($slot['nama']);
        // dd($this->UserSlotModel->getUserSlot($Nilai));

        $data =
            [
                'title' => 'Slot User',
                'user'  => $this->UserModel->where('id', $this->ini)->first(),
                'slotUser'  => $slot,
                'jumlah' => $jumlahSlot,
                'saldo' => $this->saldoUser,
                'validation' => \Config\Services::validation()

            ];
        return view('user/slotUser', $data);
    }

    //====================================================================================================================================================













    //================================== Fungsi buat beli slot ===========================================================================================

    public function beli()
    {
        // dd($this->request->getVar());
        $UserSaldo = $this->UserSaldo->where('nilai', $this->ini)->first();
        $UserId = $UserSaldo['id'];
        $harga = $this->request->getVar('harga');
        $harga = (int)$harga;
        $saldo = $UserSaldo['saldo'];
        $saldo = (int)$saldo;
        $hasil = $saldo - $harga;
        // dd($hasil);
        $UserModel = $this->UserModel->where('id', $this->ini)->first();
        $UserNilai = $UserModel['id'];
        $durasi = $this->request->getVar('durasi');

        $durasi = (int)$durasi;

        // dd($durasi);

        // dd($UserSaldo['id']);

        $Nama = $UserSaldo['nama'];

        $bayar = $this->bayar->first();

        // dd($Nama);



        $date2 = date('d') + $durasi;


        if ($date2 >= 10) {
            $date = date($date2 . '-m-Y');
        } else {
            $date = date(0 . $date2 . '-m-Y');
        }

        // dd($date);

        if ($saldo >= $harga) {

            $this->UserSaldo->save([
                'id' => $UserId,
                'nama' => $Nama,
                'saldo' => $hasil,
                'nilai' => $UserNilai
            ]);

            // dd($UserSaldo);

            $this->bayar->save([
                'nama' => $this->request->getVar('nama'),
                'user' => $Nama,
                'durasi' => $this->request->getVar('durasi'),
                'harga' => $harga,
                'saldo' => $saldo,
                'nilai' => $UserNilai,

            ]);

            $this->UserSlotModel->save([
                'nama' => $this->request->getVar('nama'),
                'durasi' => $this->request->getVar('durasi'),
                'nilai' => $UserNilai,
                'waktu' => $date,
                'validasi' => 'Butuh konfirmasi'

            ]);
            session()->setFlashdata('pesan', 'Pencet tombol kirim nama paket dulu !!');
            return redirect()->to('/user/slotUser');
        }
        // $kata = 'Gabisa';
        // dd($kata);
        session()->setFlashdata('pesan', 'Saldo anda tidak cukup');
        return redirect()->to('/user/slot');
    }

    //=====================================================================================================================================================================










    //================================ Fungsi buat Top Up user ============================================================================================================

    public function topUp()
    {
        // $this->UserSaldo->update_data();

        $ini = $this->request->getVar();
        $nilai1 = $this->request->getVar('nilai1');
        $nilai2 = $this->request->getVar('nilai2');
        $nilai3 = $this->request->getVar('nilai3');
        $nilai = $this->request->getVar('nilai');

        $nilai1 = (int)$nilai1;
        $nilai2 = (int)$nilai2;
        $nilai3 = (int)$nilai3;
        $nilai = (int)$nilai;

        $hasil = $nilai1 + $nilai2 + $nilai3 + $nilai;

        // dd($this->request->getVar('orang'));

        // dd($hasilBanget);


        $ini = $this->UserSaldo->where('nilai', $this->ini)->first();
        $data = $ini['saldo'];
        $dataId = $ini['id'];
        $data = (int)$data;

        $itu = $data + $hasil;

        // dd($ini);


        $this->UserSaldo->save([
            'id' => $dataId,
            'nama' => $this->request->getVar('nama'),
            'saldo' => $itu,
            'nilai' => $this->ini
        ]);

        return redirect()->to('/user');
    }

    //==========================================================================================================================================================================











    //==================== Halaman history / riwayat pembelian slot ============================================================================================================

    public function history()
    {

        $UserBayar = $this->bayar->where('nilai', $this->ini)->findAll();
        // dd($UserBayar);
        $data =
            [
                'title' => 'History',
                'saldo' => $this->saldoUser,
                'user'  => $this->UserModel->where('id', $this->ini)->first(),
                'history' => $UserBayar

            ];
        return view('user/history', $data);
    }

    //==========================================================================================================================================================================












    //==================== Fungsi untuk konfirmasi pembelian slot ==============================================================================================================


    public function konfirmasi()
    {
        // dd($this->request->getVar());

        $gambar = $this->request->getFile('gambar');
        // dd($gambar == true);

        // $ini = $gambar !== NULL;
        $nilai = $this->request->getVar('nilai');

        $admin = $this->admin->where('nilai', $nilai)->first();
        $id = $admin['id'];

        $paket = $this->request->getVar('paket');

        if ($paket) {
            $this->admin->save([
                'id' => $id,
                'paket' => $this->request->getVar('paket'),
            ]);
            session()->setFlashdata('pesan', 'Silahkan pencet tombol konfirmasi');
            return redirect()->to('/user/slotUser')->withInput();
        }


        // dd($gambar && $admin);


        // dd($id);
        // dd($admin && $gambar == true);

        if ($admin && $gambar == false) {
            $this->admin->save([
                'id' => $id,
                'nama' => $this->request->getVar('nama'),
                'nilai' => $nilai,
                'confirm' => 'konfirmasi'
            ]);
            session()->setFlashdata('pesan', 'Tunggu Konfirmasi admin, Harap jangan dispam agar request anda tidak tertimpa, admin menolak jika anda melanggar rule');
            return redirect()->to('/user/slotUser');
        } elseif ($admin && $gambar == true) {
            // dd(false);
            // In the controller
            if (!$this->validate([
                'gambar' => [
                    'rules' => 'uploaded[gambar]|mime_in[gambar,image/png,image/jpg,image/jpeg]|is_image[gambar]',
                    'errors' => [
                        'uploaded' => 'Gambar belum dipilih',
                        'is_image' => 'Yang anda upload bukan gambar',
                        'mime_in' => 'Yang anda upload bukan gambar'
                    ]
                ]
            ])) {
                return redirect()->to('/user/slotUser')->withInput();
            }
            // dd(true);
            $fileGambar = $this->request->getFile('gambar');
            $namaFile = $fileGambar->getRandomName();
            // dd($namaFile);
            $fileGambar->move('gambar', $namaFile);
            $this->admin->save([
                'id' => $id,
                'nama' => $this->request->getVar('nama'),
                'nilai' => $nilai,
                'gambar' => $namaFile,
                'confirm' => 'konfirmasi'
            ]);
            session()->setFlashdata('pesan', 'Tunggu Konfirmasi admin, Harap jangan dispam agar request anda tidak tertimpa, admin menolak jika anda melanggar rule');
            return redirect()->to('/user/slotUser');
        } elseif ($gambar == false) {
            // $kata = 'Tambah data';
            // dd($kata);
            $this->admin->save([
                'nama' => $this->request->getVar('nama'),
                'nilai' => $nilai,
                'confirm' => 'konfirmasi'
            ]);
            session()->setFlashdata('pesan', 'Tunggu Konfirmasi admin, Harap jangan dispam agar request anda tidak tertimpa, admin menolak jika anda melanggar rule');

            return redirect()->to('/user/slotUser');
        } else {
            // dd(false);
            if (!$this->validate([
                'gambar' => [
                    'rules' => 'uploaded[gambar]|mime_in[gambar,image/png,image/jpg,image/jpeg]|is_image[gambar]',
                    'errors' => [
                        'uploaded' => 'Gambar belum dipilih',
                        'is_image' => 'Yang anda upload bukan gambar',
                        'mime_in' => 'Yang anda upload bukan gambar'
                    ]
                ]
            ])) {
                return redirect()->to('/user/slotUser')->withInput();
            }
            // dd(true);
            $fileGambar = $this->request->getFile('gambar');
            $namaFile = $fileGambar->getRandomName();
            // dd($namaFile);
            $fileGambar->move('gambar', $namaFile);
            $this->admin->save([
                'id' => $id,
                'nama' => $this->request->getVar('nama'),
                'nilai' => $nilai,
                'gambar' => $namaFile,
                'confirm' => 'konfirmasi'
            ]);
            session()->setFlashdata('pesan', 'Tunggu Konfirmasi admin, Harap jangan dispam agar request anda tidak tertimpa, admin menolak jika anda melanggar rule');
            return redirect()->to('/user/slotUser');
        }
    }

    //===================================================================================================================================================================================

}








//========================= Nyoba nyoba buat fitur =========================================================================================================================================



 // public function coba()
    // {
    //     // $time = date();
    //     // $myTime = new Time('now');
    //     $date2 = date('d') + 10;
    //     if ($date2 >= 10) {
    //         $date = date($date2 . '-m-Y');
    //     } else {
    //         $date = date(0 . $date2 . '-m-Y');
    //     }
    //     $hapus = 20000;
    //     $ini = $this->bayar->where('id', 10)->where('waktu' <= $date)->delete();
    //     dd($date);
    // }

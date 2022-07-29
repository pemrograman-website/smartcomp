<?php

/** 
 * Form untuk mengisikan aksesoris yang akan dibeli
 * @var yii\web\View $this
 */

use yii\helpers\Url;
use kartik\helpers\Html;
use backend\models\JenisAksesoris;
use backend\models\MerkAksesoris;

?>
<div class="card">
    <h3 class="card-header text-center">
        Daftar Pembelian Aksesoris
    </h3>
    <div class="card-body">
        <div class="aksesoris-index">
            <div class="row">
                <div class="col-md-3"><label for="jenis">Jenis Aksesoris</label></div>
                <div class="col-md-3">
                    <div class="form-group">
                        <select class="form-control-sm" name="jenis" id="jenis" href="<?= Url::to(['/pembelian-aksesoris/list-aksesoris']); ?>" style="width: 100%">
                            <option value="0">Semua</option>
                            <?php
                            $jenisAksesoris = JenisAksesoris::list();
                            foreach ($jenisAksesoris as $key => $item) : ?>
                                <option value="<?= $key ?>"><?= $item ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3"><label class="float-right" for="merk">Merk Aksesoris</label></div>
                <div class="col-md-3">
                    <div class="form-group">
                        <select class="form-control-sm" name="merk" id="merk" href="<?= Url::to(['/pembelian-aksesoris/list-aksesoris']); ?>" style="width: 100%">
                            <option value="0">Semua</option>
                            <?php
                            $merkAksesoris = MerkAksesoris::list();

                            foreach ($merkAksesoris as $key => $item) : ?>
                                <option value="<?= $key ?>"><?= $item ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"><label for="namaBarang">Nama Barang</label></div>
            <div class="col-md-9" id="list-aksesoris">
                <div class="form-group">
                    <!-- Diisi id dan nama aksesoris berdasarkan pilihan jenis dan merk -->
                    <select class="form-control-sm" name="aksesoris" id="aksesoris" style="width: 100%">
                        <option value="0">Pilih aksesoris</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-md-3"><label for="jumlah">Jumlah (buah)</label></div>
            <div class="col-md-3">
                <div class="form-group"><input type="number" class="form-control" min=1 value=1 id="jumlah" name="jumlah" style="width: 100%"></div>
            </div>
            <div class="col-md-3"><label class="float-right" for="harga">Harga (Rp.)</label></div>
            <div class="col-md-3">
                <div class="form-group"><input type="text" class="form-control" value=0 id="harga" name="harga" style="width: 100%"></div>
            </div>
        </div>
        <div class="row  float-right">
            <div class="col-md-12">
                <?php
                echo Html::a('Tambah Aksesoris', Url::to(['/pembelian-aksesoris/tambah-aksesoris']), [
                    'class' => 'btn btn-success float-left ml-4 mt-2 mb-2 btn-tambah-aksesoris'
                ]);
                echo Html::a('Reset Aksesoris', Url::to(['/pembelian-aksesoris/reset-aksesoris']), [
                    'class' => 'btn btn-danger float-left ml-4 mt-2 mb-2 btn-reset-aksesoris'
                ])
                ?>
            </div>
        </div>
    </div>

    <div class="ml-4 mr-4">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Merk</th>
                    <th>Jumlah</th>
                    <th>Harga/bh</th>
                    <th>Sub-Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <!-- Ambil data tabel dari session pembelian -->
            <tbody id="daftar-pembelian">
                <?=
                $this->render('_daftar-pembelian', ['model' => $model]);
                ?>
            </tbody>
            <!-- Batas ambil data tabel dari session pembelian -->
        </table>
    </div>
</div>
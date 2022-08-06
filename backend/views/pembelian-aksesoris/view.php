<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PembelianAksesoris */
/* @var $daftarPembelian backend\models\PembelianAksesorisDetail */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pembelian Aksesoris', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pembelian-aksesoris-view">

    <h1>Transaksi No. <?= Html::encode($model->no_inv) ?></h1>

    <p>
        <?= Html::a('Void Transaksi', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
        <div class="col-md-6">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'no_inv',
                    'tanggal',
                    [
                        'attribute' => 'harga_total',
                        'format' => 'currency',
                    ],
                    'supplier_id',
                    'user_id',
                ],
            ]); ?></div>
        <div class="col-md-6">
            <h4>DAFTAR BARANG</h4>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Merk</th>
                        <th>Jumlah</th>
                        <th>Harga/bh</th>
                        <th>Sub-Total</th>
                </thead>
                <tbody>
                    <?php foreach ($daftarPembelian as $key => $item) : ?>
                        <tr style="vertical-align: middle">
                            <td><?= $item['barang'] ?></td>
                            <td><?= $item['merk'] ?></td>
                            <td><?= $item['qty'] ?></td>
                            <td><?= number_format($item['harga_beli']) ?></td>
                            <td><?= number_format($item['harga_beli'] * $item['qty']) ?></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


</div>
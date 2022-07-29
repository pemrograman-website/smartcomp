<?php

/** 
 * Membuat response ajax untuk menampilkan tabel aksesoris yang akan dibeli.
 * 
 * @var yii\web\View $this
 */

use yii\helpers\Url;
use yii\helpers\Html;

$jumlahItem = !empty($model) ? count($model) : 0;
$jumlahBarang = 0;
$totalHarga = 0;
if ($jumlahItem != 0) :
    foreach ($model as $key => $item) :
        $jumlahBarang += $item['jumlah'];
        $totalHarga += $item['sub-total']; ?>
        <tr style="vertical-align: middle">
            <td><?= $item['nama'] ?></td>
            <td><?= $item['merk'] ?></td>
            <td><?= $item['jumlah'] ?></td>
            <td><?= number_format($item['harga']) ?></td>
            <td><?= number_format($item['sub-total']) ?></td>
            <td>
                <?= Html::a('Hapus', '#', [
                    'class' => 'btn btn-outline-danger btn-xs btn-hapus-aksesoris',
                    'id' => 'btn-hapus-aksesoris',
                    'barang-id' => $item['id'],
                    'url' => Url::to(['/pembelian-aksesoris/hapus-aksesoris'])
                ])
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="3"></td>
        <td class="float-right" style="font-weight: bold;">Item Barang</td>
        <td colspan="2" style="font-weight: bold;"><?= $jumlahItem ?></td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td class="float-right" style="font-weight: bold;">Jumlah Barang</td>
        <td colspan="2" class="text-warning" style="font-weight: bold;"><?= $jumlahBarang ?></td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td class="float-right" style="font-weight: bold;">Total Harga</td>
        <td colspan="2" class="text-success" style="font-weight: bold;"><?= number_format($totalHarga) ?></td>
    </tr>
<?php else : ?>
    <tr>
        <td colspan="5" class="text-center text-muted font-italic">Silahkan tambahkan aksesoris yang ingin dibeli.</td>
    </tr>
<?php
endif;
?>
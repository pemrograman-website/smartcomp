<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PembelianAksesoris */

$this->title = 'Tambah Pembelian Aksesoris';
$this->params['breadcrumbs'][] = ['label' => 'Pembelian Aksesoris', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pembelian-aksesoris-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-6">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $this->render('_aksesoris', [
                'model' => $daftarPembelian,  //model diambil dari session
            ]) ?>
        </div>
    </div>

</div>
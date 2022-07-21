<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PembelianAksesoris */

$this->title = 'Create Pembelian Aksesoris';
$this->params['breadcrumbs'][] = ['label' => 'Pembelian Aksesoris', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pembelian-aksesoris-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

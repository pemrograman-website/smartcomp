<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MerkAksesoris */

$this->title = 'Tambah Merk Aksesoris';
$this->params['breadcrumbs'][] = ['label' => 'Merk Aksesoris', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="merk-aksesoris-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
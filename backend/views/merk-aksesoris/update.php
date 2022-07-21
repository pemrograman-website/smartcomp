<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MerkAksesoris */

$this->title = 'Update Merk Aksesoris: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Merk Aksesoris', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="merk-aksesoris-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

use backend\models\PembelianAksesoris;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PembelianAksesorisSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pembelian Aksesoris';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pembelian-aksesoris-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Tambah Pembelian Aksesoris', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'tanggal',
                'format' => ['date', 'php:d mm yy'],
            ],
            [
                'label' => 'Supplier',
                'attribute' => 'supplier.nama',
            ],
            'no_inv', //'user_id',
            'harga_total',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, PembelianAksesoris $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
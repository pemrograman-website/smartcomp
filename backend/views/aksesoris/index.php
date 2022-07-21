<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\Pjax;

use backend\models\Aksesoris;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AksesorisSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Aksesoris';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aksesoris-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Tambah Aksesoris', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'condensed' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'sku',
            'nama',
            'keterangan',
            'stock_on_hand',
            //'harga_jual',
            //'jenis_aksesoris_id',
            //'merk_aksesoris_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Aksesoris $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
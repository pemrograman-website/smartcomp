<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\Pjax;

// Models
use backend\models\JenisAksesoris;

use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\JenisAksesorisSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jenis Aksesoris';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jenis-aksesoris-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Tambah Jenis Aksesoris', ['create'], ['class' => 'btn btn-success']) ?>
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

            'nama',
            'disabled',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, JenisAksesoris $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
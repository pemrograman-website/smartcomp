<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;

use kartik\form\ActiveForm;
use kartik\date\DatePicker;
use backend\models\Supplier;
use kartik\widgets\Select2;

use backend\models\PembelianAksesoris;

/* @var $this yii\web\View */
/* @var $model backend\models\PembelianAksesoris */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="card">
    <h3 class="card-header text-center">
        Data Invoice
    </h3>
    <div class="card-body">
        <div class="pembelian-aksesoris-form">

            <?php $form = ActiveForm::begin(
                [
                    'id' => 'pembelian-aksesoris-form',
                ]

            ); ?>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'tanggal')->widget(DatePicker::class, [
                        'options' => ['placeholder' => 'Tanggal transaksi'],
                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd-mm-yyyy'
                        ],
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'supplier_id')->widget(Select2::class, [
                        'data' => Supplier::list(),
                        'options' => ['placeholder' => 'Pilih supplier'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?= $form->field($model, 'keterangan')->textArea(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>
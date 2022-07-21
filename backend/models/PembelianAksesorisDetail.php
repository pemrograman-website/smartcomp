<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pembelian_aksesoris_detail".
 *
 * @property int $pembelian_aksesoris_id
 * @property int $aksesoris_id
 * @property int|null $qty
 * @property float|null $harga_beli
 *
 * @property Aksesoris $aksesoris
 * @property PembelianAksesoris $pembelianAksesoris
 */
class PembelianAksesorisDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pembelian_aksesoris_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pembelian_aksesoris_id', 'aksesoris_id'], 'required'],
            [['pembelian_aksesoris_id', 'aksesoris_id', 'qty'], 'integer'],
            [['harga_beli'], 'number'],
            [['pembelian_aksesoris_id', 'aksesoris_id'], 'unique', 'targetAttribute' => ['pembelian_aksesoris_id', 'aksesoris_id']],
            [['aksesoris_id'], 'exist', 'skipOnError' => true, 'targetClass' => Aksesoris::className(), 'targetAttribute' => ['aksesoris_id' => 'id']],
            [['pembelian_aksesoris_id'], 'exist', 'skipOnError' => true, 'targetClass' => PembelianAksesoris::className(), 'targetAttribute' => ['pembelian_aksesoris_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pembelian_aksesoris_id' => 'Pembelian Aksesoris ID',
            'aksesoris_id' => 'Aksesoris ID',
            'qty' => 'Qty',
            'harga_beli' => 'Harga Beli',
        ];
    }

    /**
     * Gets query for [[Aksesoris]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAksesoris()
    {
        return $this->hasOne(Aksesoris::className(), ['id' => 'aksesoris_id']);
    }

    /**
     * Gets query for [[PembelianAksesoris]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPembelianAksesoris()
    {
        return $this->hasOne(PembelianAksesoris::className(), ['id' => 'pembelian_aksesoris_id']);
    }
}

<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "aksesoris".
 *
 * @property int $id
 * @property string|null $sku
 * @property string $nama
 * @property string|null $keterangan
 * @property int|null $stock_on_hand
 * @property float|null $harga_jual
 * @property int|null $jenis_aksesoris_id
 * @property int|null $merk_aksesoris_id
 *
 * @property JenisAksesoris $jenisAksesoris
 * @property MerkAksesoris $merkAksesoris
 */
class Aksesoris extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aksesoris';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['stock_on_hand', 'jenis_aksesoris_id', 'merk_aksesoris_id'], 'integer'],
            [['harga_jual'], 'number'],
            [['sku'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 45],
            [['keterangan'], 'string', 'max' => 255],
            [['jenis_aksesoris_id'], 'exist', 'skipOnError' => true, 'targetClass' => JenisAksesoris::className(), 'targetAttribute' => ['jenis_aksesoris_id' => 'id']],
            [['merk_aksesoris_id'], 'exist', 'skipOnError' => true, 'targetClass' => MerkAksesoris::className(), 'targetAttribute' => ['merk_aksesoris_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sku' => 'Sku',
            'nama' => 'Nama',
            'keterangan' => 'Keterangan',
            'stock_on_hand' => 'Stock On Hand',
            'harga_jual' => 'Harga Jual',
            'jenis_aksesoris_id' => 'Jenis Aksesoris ID',
            'merk_aksesoris_id' => 'Merk Aksesoris ID',
        ];
    }

    /**
     * Gets query for [[JenisAksesoris]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJenisAksesoris()
    {
        return $this->hasOne(JenisAksesoris::className(), ['id' => 'jenis_aksesoris_id']);
    }

    /**
     * Gets query for [[MerkAksesoris]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMerkAksesoris()
    {
        return $this->hasOne(MerkAksesoris::className(), ['id' => 'merk_aksesoris_id']);
    }
}

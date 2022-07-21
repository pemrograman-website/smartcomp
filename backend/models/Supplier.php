<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property int $id
 * @property string $nama
 * @property string|null $alamat
 * @property string|null $link
 * @property string|null $no_wa
 * @property int|null $disabled
 *
 * @property PembelianAksesoris[] $pembelianAksesoris
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['disabled'], 'integer'],
            [['nama'], 'string', 'max' => 45],
            [['alamat', 'link'], 'string', 'max' => 255],
            [['no_wa'], 'string', 'max' => 25],
            [['nama'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'link' => 'Link',
            'no_wa' => 'No Wa',
            'disabled' => 'Disabled',
        ];
    }

    /**
     * Gets query for [[PembelianAksesoris]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPembelianAksesoris()
    {
        return $this->hasMany(PembelianAksesoris::className(), ['supplier_id' => 'id']);
    }
}

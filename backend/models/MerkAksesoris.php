<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "merk_aksesoris".
 *
 * @property int $id
 * @property string $nama
 * @property int|null $disabled
 */
class MerkAksesoris extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'merk_aksesoris';
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
            'disabled' => 'Disabled',
        ];
    }
}

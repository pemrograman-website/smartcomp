<?php

namespace backend\models;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "jenis_aksesoris".
 *
 * @property int $id
 * @property string $nama
 * @property int|null $disabled
 */
class JenisAksesoris extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jenis_aksesoris';
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

    public static function list()
    {
        $query = new Query;

        $query->from('jenis_aksesoris');
        $query->orderBy(['nama' => SORT_ASC]);

        $list = $query->all();

        return ArrayHelper::map($list, 'id', 'nama');
    }
}

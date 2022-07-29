<?php

namespace backend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "pembelian_aksesoris".
 *
 * @property int $id
 * @property string|null $no_inv
 * @property string|null $tanggal
 * @property float|null $harga_total
 * @property int $supplier_id
 * @property int $user_id
 *
 * @property Supplier $supplier
 * @property User $user
 */
class PembelianAksesoris extends \yii\db\ActiveRecord
{

    const SESSION_KEY = 'beli-aksesoris';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pembelian_aksesoris';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal', 'supplier_id'], 'required'],
            [['keterangan', 'user_id', 'supplier_id'], 'safe'],
            [['harga_total'], 'number'],
            [['no_inv'], 'string', 'max' => 45],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['supplier_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no_inv' => 'No Inv',
            'tanggal' => 'Tanggal',
            'harga_total' => 'Harga Total',
            'supplier_id' => 'Supplier ID',
            'user_id' => 'User ID',
            'keterangan' => 'Keterangan',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->tanggal = date('Y-m-d', strtotime($this->tanggal));
            $this->user_id = \Yii::$app->user->id;

            return true;
        }

        return false;
    }

    /**
     * Gets query for [[Supplier]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}

<?php

namespace app\models;

use Yii;

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
            [['tanggal'], 'safe'],
            [['harga_total'], 'number'],
            [['supplier_id', 'user_id'], 'required'],
            [['supplier_id', 'user_id'], 'integer'],
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
        ];
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

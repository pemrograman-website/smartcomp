<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Aksesoris;

/**
 * AksesorisSearch represents the model behind the search form of `backend\models\Aksesoris`.
 */
class AksesorisSearch extends Aksesoris
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'stock_on_hand', 'jenis_aksesoris_id', 'merk_aksesoris_id'], 'integer'],
            [['sku', 'nama', 'keterangan'], 'safe'],
            [['harga_jual'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Aksesoris::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'stock_on_hand' => $this->stock_on_hand,
            'harga_jual' => $this->harga_jual,
            'jenis_aksesoris_id' => $this->jenis_aksesoris_id,
            'merk_aksesoris_id' => $this->merk_aksesoris_id,
        ]);

        $query->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}

<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PembelianAksesoris;

/**
 * PembelianAksesorisSearch represents the model behind the search form of `backend\models\PembelianAksesoris`.
 */
class PembelianAksesorisSearch extends PembelianAksesoris
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'supplier_id', 'user_id'], 'integer'],
            [['no_inv', 'tanggal'], 'safe'],
            [['harga_total'], 'number'],
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
        $query = PembelianAksesoris::find();

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
            'tanggal' => $this->tanggal,
            'harga_total' => $this->harga_total,
            'supplier_id' => $this->supplier_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'no_inv', $this->no_inv]);

        return $dataProvider;
    }
}

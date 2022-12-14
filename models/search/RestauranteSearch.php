<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Restaurante;

/**
 * RestauranteSearch represents the model behind the search form of `app\models\Restaurante`.
 */
class RestauranteSearch extends Restaurante
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'total_mesas', 'mensualidad', 'codigo_de_activacion', 'activado', 'usuario_id'], 'integer'],
            [['nit', 'nombre', 'telefono', 'celular', 'email', 'encargado', 'direccion', 'ciudad', 'fecha', 'hora', 'logo'], 'safe'],
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
        $query = Restaurante::find();

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
            'total_mesas' => $this->total_mesas,
            'mensualidad' => $this->mensualidad,
            'codigo_de_activacion' => $this->codigo_de_activacion,
            'activado' => $this->activado,
            'usuario_id' => $this->usuario_id,
            'fecha' => $this->fecha,
        ]);

        $query->andFilterWhere(['like', 'nit', $this->nit])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'celular', $this->celular])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'encargado', $this->encargado])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'ciudad', $this->ciudad])
            ->andFilterWhere(['like', 'hora', $this->hora])
            ->andFilterWhere(['like', 'logo', $this->logo]);

        return $dataProvider;
    }
}

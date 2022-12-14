<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pedido;
use app\models\Restaurante;
use Yii;

/**
 * PedidoSearch represents the model behind the search form of `app\models\Pedido`.
 */
class PedidoSearch extends Pedido
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'restaurante_id', 'cliente_id'], 'integer'],
            [['valor'], 'number'],
            [['estado'], 'safe'],
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
        $query = Pedido::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 25,
            ],
            
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (Yii::$app->user->identity!=null && Yii::$app->user->identity->tipo==1)
        {
            $usuario = Restaurante::findOne(['usuario_id' => Yii::$app->user->identity->id]);

            $query->where(['restaurante_id'=>$usuario->id])->orderBy(['id'=> SORT_DESC]);

        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'restaurante_id' => $this->restaurante_id,
            'cliente_id' => $this->cliente_id,
            'valor' => $this->valor,
        ]);

        $query->andFilterWhere(['like', 'estado', $this->estado]);
    
        return $dataProvider;
    }
}

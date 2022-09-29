<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Menu;
use app\models\Restaurante;
use Yii;

/**
 * MenuSearch represents the model behind the search form of `app\models\Menu`.
 */
class MenuSearch extends Menu
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'restaurante_id', 'precio'], 'integer'],
            [['grupo', 'nombre', 'descripcion', 'fecha', 'hora'], 'safe'],
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
        $query = Menu::find();

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
        if(Yii::$app->user->identity->tipo == '1'){
            $restaurante= Restaurante::findOne(['usuario_id' => Yii::$app->user->identity->id]);
            $query->andFilterWhere([
                'id' => $this->id,
                'restaurante_id' => $restaurante->id,
                'precio' => $this->precio,
                'fecha' => $this->fecha,
            ]);
        }else{
            $query->andFilterWhere([
                'id' => $this->id,
                'restaurante_id' => $this->restaurante_id,
                'precio' => $this->precio,
                'fecha' => $this->fecha,
            ]);   
        }


        $query->andFilterWhere(['like', 'grupo', $this->grupo])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'hora', $this->hora]);

        return $dataProvider;
    }
}

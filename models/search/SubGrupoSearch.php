<?php

namespace app\models\search;

use app\models\Restaurante;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SubGrupo;
use Yii;

/**
 * SubGrupoSearch represents the model behind the search form of `app\models\SubGrupo`.
 */
class SubGrupoSearch extends SubGrupo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'grupo_id', 'restaurante_id'], 'integer'],
            [['nombre'], 'safe'],
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
        $query = SubGrupo::find();

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
        if (Yii::$app->user->identity != null && Yii::$app->user->identity->tipo == 1) {
            $usuario = Restaurante::findOne(['usuario_id' => Yii::$app->user->identity->id]);
            $query->where(['restaurante_id' => [$usuario->id]])->orderBy(['id' => SORT_ASC]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'grupo_id' => $this->grupo_id,
            'restaurante_id' => $this->restaurante_id,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }
}

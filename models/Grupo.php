<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grupo".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property SubGrupo[] $subGrupos
 */
class Grupo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grupo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * Gets query for [[SubGrupos]].
     *
     * @return \yii\db\ActiveQuery|SubGrupoQuery
     */
    public function getSubGrupos()
    {
        return $this->hasMany(SubGrupo::class, ['grupo_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return GrupoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GrupoQuery(get_called_class());
    }
}

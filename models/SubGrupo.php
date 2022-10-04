<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sub_grupo".
 *
 * @property int $id
 * @property string $nombre
 * @property int $grupo_id
 * @property int $restaurante_id
 *
 * @property Grupo $grupo
 * @property Restaurante $restaurante
 */
class SubGrupo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sub_grupo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'grupo_id', 'restaurante_id'], 'required'],
            [['grupo_id', 'restaurante_id'], 'integer'],
            [['nombre'], 'string', 'max' => 250],
            [['grupo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grupo::class, 'targetAttribute' => ['grupo_id' => 'id']],
            [['restaurante_id'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurante::class, 'targetAttribute' => ['restaurante_id' => 'id']],
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
            'grupo_id' => 'Grupo ID',
            'restaurante_id' => 'Restaurante ID',
        ];
    }

    /**
     * Gets query for [[Grupo]].
     *
     * @return \yii\db\ActiveQuery|GrupoQuery
     */
    public function getGrupo()
    {
        return $this->hasOne(Grupo::class, ['id' => 'grupo_id']);
    }

    /**
     * Gets query for [[Restaurante]].
     *
     * @return \yii\db\ActiveQuery|RestauranteQuery
     */
    public function getRestaurante()
    {
        return $this->hasOne(Restaurante::class, ['id' => 'restaurante_id']);
    }

    /**
     * {@inheritdoc}
     * @return SubGrupoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubGrupoQuery(get_called_class());
    }
}

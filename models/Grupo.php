<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grupo".
 *
 * @property int $id
 * @property string $nombre
 * @property int|null $restaurante_id
 *
 * @property Menu[] $menus
 * @property Restaurante $restaurante
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
            [['restaurante_id'], 'integer'],
            [['nombre'], 'string', 'max' => 250],
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
            'restaurante_id' => 'Restaurante ID',
        ];
    }

    /**
     * Gets query for [[Menus]].
     *
     * @return \yii\db\ActiveQuery|MenuQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::class, ['grupo' => 'id']);
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

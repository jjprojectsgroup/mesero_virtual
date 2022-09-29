<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $grupo
 * @property int $restaurante_id
 * @property string $nombre
 * @property string $descripcion
 * @property int $precio
 * @property string $fecha
 * @property string $hora
 *
 * @property Restaurante $restaurante
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grupo', 'restaurante_id', 'nombre', 'descripcion', 'fecha', 'hora'], 'required'],
            [['restaurante_id', 'precio'], 'integer'],
            [['fecha'], 'safe'],
            [['grupo', 'nombre', 'descripcion', 'hora'], 'string', 'max' => 52],
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
            'grupo' => 'Grupo',
            'restaurante_id' => 'Restaurante ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'precio' => 'Precio',
            'fecha' => 'Fecha',
            'hora' => 'Hora',
        ];
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
     * @return MenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }
}

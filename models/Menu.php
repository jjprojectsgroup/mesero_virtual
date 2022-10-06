<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property int $grupo
 * @property int $restaurante_id
 * @property string $nombre
 * @property string $descripcion
 * @property int $precio
 * @property string $fecha
 * @property string $hora
 * @property string|null $stock
 * @property string|null $estado
 * @property int|null $sub_grupo
 *
 * @property Grupo $grupo0
 * @property PedidoItem[] $pedidoItems
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
            [['grupo', 'restaurante_id', 'precio', 'sub_grupo'], 'integer'],
            [['fecha'], 'safe'],
            [['nombre', 'descripcion', 'hora'], 'string', 'max' => 52],
            [['stock', 'estado'], 'string', 'max' => 250],
            [['grupo'], 'exist', 'skipOnError' => true, 'targetClass' => Grupo::class, 'targetAttribute' => ['grupo' => 'id']],
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
            'stock' => 'Stock',
            'estado' => 'Estado',
            'sub_grupo' => 'Sub Grupo',
        ];
    }

    /**
     * Gets query for [[Grupo0]].
     *
     * @return \yii\db\ActiveQuery|GrupoQuery
     */
    public function getGrupo0()
    {
        return $this->hasOne(Grupo::class, ['id' => 'grupo']);
    }

    /**
     * Gets query for [[PedidoItems]].
     *
     * @return \yii\db\ActiveQuery|PedidoItemQuery
     */
    public function getPedidoItems()
    {
        return $this->hasMany(PedidoItem::class, ['menu_id' => 'id']);
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

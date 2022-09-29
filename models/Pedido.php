<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pedido".
 *
 * @property int $id
 * @property int $restaurante_id
 * @property int|null $cliente_id
 * @property float $valor
 * @property string $estado
 *
 * @property Cliente $cliente
 * @property PedidoItem[] $pedidoItems
 * @property Restaurante $restaurante
 */
class Pedido extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pedido';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['restaurante_id', 'valor', 'estado'], 'required'],
            [['restaurante_id', 'cliente_id'], 'integer'],
            [['valor'], 'number'],
            [['estado'], 'string', 'max' => 250],
            [['restaurante_id'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurante::class, 'targetAttribute' => ['restaurante_id' => 'id']],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::class, 'targetAttribute' => ['cliente_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'restaurante_id' => 'Restaurante ID',
            'cliente_id' => 'Cliente ID',
            'valor' => 'Valor',
            'estado' => 'Estado',
        ];
    }

    /**
     * Gets query for [[Cliente]].
     *
     * @return \yii\db\ActiveQuery|ClienteQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Cliente::class, ['id' => 'cliente_id']);
    }

    /**
     * Gets query for [[PedidoItems]].
     *
     * @return \yii\db\ActiveQuery|PedidoItemQuery
     */
    public function getPedidoItems()
    {
        return $this->hasMany(PedidoItem::class, ['pedido_id' => 'id']);
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
     * @return PedidoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PedidoQuery(get_called_class());
    }
}

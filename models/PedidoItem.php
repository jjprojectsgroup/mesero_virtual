<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pedido_item".
 *
 * @property int $id
 * @property int $pedido_id
 * @property int $menu_id
 * @property int $cantidad
 * @property float $valor
 *
 * @property Menu $menu
 * @property Pedido $pedido
 */
class PedidoItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pedido_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pedido_id', 'menu_id', 'cantidad', 'valor'], 'required'],
            [['pedido_id', 'menu_id', 'cantidad'], 'integer'],
            [['valor'], 'number'],
            [['pedido_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pedido::class, 'targetAttribute' => ['pedido_id' => 'id']],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::class, 'targetAttribute' => ['menu_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pedido_id' => 'Pedido ID',
            'menu_id' => 'Menu ID',
            'cantidad' => 'Cantidad',
            'valor' => 'Valor',
        ];
    }

    /**
     * Gets query for [[Menu]].
     *
     * @return \yii\db\ActiveQuery|MenuQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::class, ['id' => 'menu_id']);
    }

    /**
     * Gets query for [[Pedido]].
     *
     * @return \yii\db\ActiveQuery|PedidoQuery
     */
    public function getPedido()
    {
        return $this->hasOne(Pedido::class, ['id' => 'pedido_id']);
    }

    /**
     * {@inheritdoc}
     * @return PedidoItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PedidoItemQuery(get_called_class());
    }
}

<?php

namespace app\models;

class Factura extends \yii\db\ActiveRecord
{

    public $pedido_id;
    public $menu_id;
    public $cantidad;
    public $valor;
    public $menu_array = array();
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
      /*  return array(
            array('pedido_id, menu_id, cantidad, valor', 'required'),
        );*/
        return [
          
            [['pedido_id', 'menu_id', 'cantidad', 'valor'], 'string', 'max' => 250],
        ];
    }

    public function attributeLabels()
    {
        return [
            'pedido_id' => 'ID de pedido',
            'menu_id' => 'ID de menu',
            'cantidad' => 'Cantidad',
            'valor' => 'Valor',
        ];
    }
}

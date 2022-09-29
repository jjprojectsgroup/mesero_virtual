<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PedidoItem]].
 *
 * @see PedidoItem
 */
class PedidoItemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PedidoItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PedidoItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

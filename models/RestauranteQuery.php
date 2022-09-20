<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Restaurante]].
 *
 * @see Restaurante
 */
class RestauranteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Restaurante[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Restaurante|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

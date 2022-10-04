<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SubGrupo]].
 *
 * @see SubGrupo
 */
class SubGrupoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SubGrupo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SubGrupo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

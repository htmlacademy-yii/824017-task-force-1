<?php

namespace frontend\models\cities;

/**
 * This is the ActiveQuery class for [[Cities]].
 *
 * @see Cities
 */
class CitiesQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Cities[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Cities|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

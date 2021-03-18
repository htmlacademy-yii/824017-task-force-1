<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[UsersOptionalSettings]].
 *
 * @see UsersOptionalSettings
 */
class UsersOptionalSettingsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UsersOptionalSettings[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UsersOptionalSettings|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

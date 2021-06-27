<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[UsersOptionalSettings]].
 *
 * @see UsersOptionalSettings
 */
class UsersOptionalSettingsQuery extends \yii\db\ActiveQuery
{
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

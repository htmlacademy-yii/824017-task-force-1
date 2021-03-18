<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[NotificationsHistory]].
 *
 * @see NotificationsHistory
 */
class NotificationsHistoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return NotificationsHistory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return NotificationsHistory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

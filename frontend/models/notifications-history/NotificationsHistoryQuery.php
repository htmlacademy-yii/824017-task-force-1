<?php

namespace frontend\models\notifications\history;

/**
 * This is the ActiveQuery class for [[NotificationsHistory]].
 *
 * @see NotificationsHistory
 */
class NotificationsHistoryQuery extends \yii\db\ActiveQuery
{
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

<?php

namespace frontend\models\chatMessages;

/**
 * This is the ActiveQuery class for [[ChatMessages]].
 *
 * @see ChatMessages
 */
class ChatMessagesQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return ChatMessages[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ChatMessages|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

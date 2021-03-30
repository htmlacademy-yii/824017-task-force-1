<?php

namespace frontend\models\chat\messages;

/**
 * This is the ActiveQuery class for [[ChatMessages]].
 *
 * @see ChatMessages
 */
class ChatMessagesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

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

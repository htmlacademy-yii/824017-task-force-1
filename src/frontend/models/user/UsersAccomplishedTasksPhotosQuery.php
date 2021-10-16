<?php

namespace frontend\models\user;

/**
 * This is the ActiveQuery class for [[UsersAccomplishedTasksPhotos]].
 *
 * @see UsersAccomplishedTasksPhotos
 */
class UsersAccomplishedTasksPhotosQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return UsersAccomplishedTasksPhotos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UsersAccomplishedTasksPhotos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

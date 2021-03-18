<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[UsersAccomplishedTasksPhotos]].
 *
 * @see UsersAccomplishedTasksPhotos
 */
class UsersAccomplishedTasksPhotosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

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

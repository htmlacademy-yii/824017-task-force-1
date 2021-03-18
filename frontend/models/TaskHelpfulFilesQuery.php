<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[TaskHelpfulFiles]].
 *
 * @see TaskHelpfulFiles
 */
class TaskHelpfulFilesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TaskHelpfulFiles[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TaskHelpfulFiles|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

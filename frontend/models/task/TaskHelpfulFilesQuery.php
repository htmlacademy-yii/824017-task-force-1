<?php

namespace frontend\models\task;

/**
 * This is the ActiveQuery class for [[TaskHelpfulFiles]].
 *
 * @see TaskHelpfulFiles
 */
class TaskHelpfulFilesQuery extends \yii\db\ActiveQuery
{
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

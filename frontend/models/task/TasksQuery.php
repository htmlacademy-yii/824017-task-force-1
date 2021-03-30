<?php

declare(strict_types = 1);

namespace frontend\models\task;

/**
 * This is the ActiveQuery class for [[Tasks]].
 *
 * @see Tasks
 */
class TasksQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Tasks[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Tasks|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function specializationsFilter(?array $targetSpecializations): self
    {
        return $this->andFilterWhere(['specialization_id' => $targetSpecializations]);
    }

    public function nameFilter(?string $name): self
    {
        return $this->andFilterWhere(['like', 'name', $name]);
    }

    public function period(string $period): self
    {
        return $this->andWhere([
                'between',
                'posting_date',
                strftime("%F %T", strtotime("-1 $period")),
                strftime("%F %T")
            ]);
    }

    public function withoutResponses(): self
    {
        return $this->andWhere(['responses.id' => null]);
    }

    public function withoutLocation(): self
    {
        return $this->andWhere(['latitude' => null]);
    }
}


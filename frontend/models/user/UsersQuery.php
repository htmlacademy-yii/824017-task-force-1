<?php

namespace frontend\models\user;

/**
 * This is the ActiveQuery class for [[Users]].
 *
 * @see Users
 */
class UsersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Users[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Users|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function specializationsFilter(?array $targetSpecializations): self
    {
        return $this->andFilterWhere(['specializations.id' => $targetSpecializations]);
    }

    public function nameFilter(?string $name): self
    {
        return $this->andFilterWhere(['like', 'users.name', $name]);
    }

    public function favoriteFilter(?string $min): self
    {
        return $this->andFilterWhere(['>', 'favorite_count', $min]);
    }

    public function withReviewsFilter(?string $min): self
    {
        return $this->andFilterHaving(['>', 'comments_count', $min]);
    }

    public function freeNow(): self
    {
        return $this->andWhere(['tasks.id' => null]);
    }
    
    public function online(): self
    {
        return $this->andWhere([
                'between',
                'last_activity',
                strftime("%F %T", strtotime("-30 min")),
                strftime("%F %T")
            ]);
    }
}

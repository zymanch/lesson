<?php

namespace models\base;
use ActiveGenerator\Criteria;
use models\UserQuery;

/**
 * This is the ActiveQuery class for [[models\User]].
 * @method UserQuery filterByUserId($value, $criteria = null)
 * @method UserQuery filterByUsername($value, $criteria = null)
 * @method UserQuery filterByDescription($value, $criteria = null)
  * @method UserQuery orderByUserId($order = Criteria::ASC)
  * @method UserQuery orderByUsername($order = Criteria::ASC)
  * @method UserQuery orderByDescription($order = Criteria::ASC)
  * @method UserQuery withLessons($params = [])
  * @method UserQuery joinWithLessons($params = null, $joinType = 'LEFT JOIN')
 */
class BaseUserQuery extends \yii\db\ActiveQuery
{


    use \ActiveGenerator\base\RichActiveMethods;

    /**
     * @inheritdoc
     * @return \models\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \models\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \models\UserQuery     */
    public static function model()
    {
        return new \models\UserQuery(\models\User::class);
    }
}

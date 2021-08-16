<?php

namespace models\base;
use ActiveGenerator\Criteria;
use models\YearQuery;

/**
 * This is the ActiveQuery class for [[models\Year]].
 * @method YearQuery filterByYearId($value, $criteria = null)
 * @method YearQuery filterByName($value, $criteria = null)
  * @method YearQuery orderByYearId($order = Criteria::ASC)
  * @method YearQuery orderByName($order = Criteria::ASC)
  * @method YearQuery withDays($params = [])
  * @method YearQuery joinWithDays($params = null, $joinType = 'LEFT JOIN')
  * @method YearQuery withLessons($params = [])
  * @method YearQuery joinWithLessons($params = null, $joinType = 'LEFT JOIN')
 */
class BaseYearQuery extends \yii\db\ActiveQuery
{


    use \ActiveGenerator\base\RichActiveMethods;

    /**
     * @inheritdoc
     * @return \models\Year[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \models\Year|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \models\YearQuery     */
    public static function model()
    {
        return new \models\YearQuery(\models\Year::class);
    }
}

<?php

namespace models\base;
use ActiveGenerator\Criteria;
use models\DayQuery;

/**
 * This is the ActiveQuery class for [[models\Day]].
 * @method DayQuery filterByDayId($value, $criteria = null)
 * @method DayQuery filterByYearId($value, $criteria = null)
 * @method DayQuery filterByDay($value, $criteria = null)
 * @method DayQuery filterByType($value, $criteria = null)
  * @method DayQuery orderByDayId($order = Criteria::ASC)
  * @method DayQuery orderByYearId($order = Criteria::ASC)
  * @method DayQuery orderByDay($order = Criteria::ASC)
  * @method DayQuery orderByType($order = Criteria::ASC)
  * @method DayQuery withYear($params = [])
  * @method DayQuery joinWithYear($params = null, $joinType = 'LEFT JOIN')
  * @method DayQuery withLessonDays($params = [])
  * @method DayQuery joinWithLessonDays($params = null, $joinType = 'LEFT JOIN')
 */
class BaseDayQuery extends \yii\db\ActiveQuery
{


    use \ActiveGenerator\base\RichActiveMethods;

    /**
     * @inheritdoc
     * @return \models\Day[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \models\Day|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \models\DayQuery     */
    public static function model()
    {
        return new \models\DayQuery(\models\Day::class);
    }
}

<?php

namespace models\base;
use ActiveGenerator\Criteria;
use models\LessonQuery;

/**
 * This is the ActiveQuery class for [[models\Lesson]].
 * @method LessonQuery filterByLessonId($value, $criteria = null)
 * @method LessonQuery filterByYearId($value, $criteria = null)
 * @method LessonQuery filterByLessonTypeId($value, $criteria = null)
 * @method LessonQuery filterByClassNumber($value, $criteria = null)
 * @method LessonQuery filterByUserId($value, $criteria = null)
 * @method LessonQuery filterByDaysOfWeek($value, $criteria = null)
  * @method LessonQuery orderByLessonId($order = Criteria::ASC)
  * @method LessonQuery orderByYearId($order = Criteria::ASC)
  * @method LessonQuery orderByLessonTypeId($order = Criteria::ASC)
  * @method LessonQuery orderByClassNumber($order = Criteria::ASC)
  * @method LessonQuery orderByUserId($order = Criteria::ASC)
  * @method LessonQuery orderByDaysOfWeek($order = Criteria::ASC)
  * @method LessonQuery withLessonType($params = [])
  * @method LessonQuery joinWithLessonType($params = null, $joinType = 'LEFT JOIN')
  * @method LessonQuery withUser($params = [])
  * @method LessonQuery joinWithUser($params = null, $joinType = 'LEFT JOIN')
  * @method LessonQuery withYear($params = [])
  * @method LessonQuery joinWithYear($params = null, $joinType = 'LEFT JOIN')
  * @method LessonQuery withLessonDays($params = [])
  * @method LessonQuery joinWithLessonDays($params = null, $joinType = 'LEFT JOIN')
  * @method LessonQuery withThemes($params = [])
  * @method LessonQuery joinWithThemes($params = null, $joinType = 'LEFT JOIN')
 */
class BaseLessonQuery extends \yii\db\ActiveQuery
{


    use \ActiveGenerator\base\RichActiveMethods;

    /**
     * @inheritdoc
     * @return \models\Lesson[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \models\Lesson|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \models\LessonQuery     */
    public static function model()
    {
        return new \models\LessonQuery(\models\Lesson::class);
    }
}

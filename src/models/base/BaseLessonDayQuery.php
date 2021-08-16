<?php

namespace models\base;
use ActiveGenerator\Criteria;
use models\LessonDayQuery;

/**
 * This is the ActiveQuery class for [[models\LessonDay]].
 * @method LessonDayQuery filterByLessonDay($value, $criteria = null)
 * @method LessonDayQuery filterByLessonId($value, $criteria = null)
 * @method LessonDayQuery filterByThemeId($value, $criteria = null)
 * @method LessonDayQuery filterByDayId($value, $criteria = null)
  * @method LessonDayQuery orderByLessonDay($order = Criteria::ASC)
  * @method LessonDayQuery orderByLessonId($order = Criteria::ASC)
  * @method LessonDayQuery orderByThemeId($order = Criteria::ASC)
  * @method LessonDayQuery orderByDayId($order = Criteria::ASC)
  * @method LessonDayQuery withDay($params = [])
  * @method LessonDayQuery joinWithDay($params = null, $joinType = 'LEFT JOIN')
  * @method LessonDayQuery withLesson($params = [])
  * @method LessonDayQuery joinWithLesson($params = null, $joinType = 'LEFT JOIN')
  * @method LessonDayQuery withTheme($params = [])
  * @method LessonDayQuery joinWithTheme($params = null, $joinType = 'LEFT JOIN')
 */
class BaseLessonDayQuery extends \yii\db\ActiveQuery
{


    use \ActiveGenerator\base\RichActiveMethods;

    /**
     * @inheritdoc
     * @return \models\LessonDay[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \models\LessonDay|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \models\LessonDayQuery     */
    public static function model()
    {
        return new \models\LessonDayQuery(\models\LessonDay::class);
    }
}

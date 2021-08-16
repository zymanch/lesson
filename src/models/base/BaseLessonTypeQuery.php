<?php

namespace models\base;
use ActiveGenerator\Criteria;
use models\LessonTypeQuery;

/**
 * This is the ActiveQuery class for [[models\LessonType]].
 * @method LessonTypeQuery filterByLessonTypeId($value, $criteria = null)
 * @method LessonTypeQuery filterByName($value, $criteria = null)
  * @method LessonTypeQuery orderByLessonTypeId($order = Criteria::ASC)
  * @method LessonTypeQuery orderByName($order = Criteria::ASC)
  * @method LessonTypeQuery withLessons($params = [])
  * @method LessonTypeQuery joinWithLessons($params = null, $joinType = 'LEFT JOIN')
 */
class BaseLessonTypeQuery extends \yii\db\ActiveQuery
{


    use \ActiveGenerator\base\RichActiveMethods;

    /**
     * @inheritdoc
     * @return \models\LessonType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \models\LessonType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \models\LessonTypeQuery     */
    public static function model()
    {
        return new \models\LessonTypeQuery(\models\LessonType::class);
    }
}

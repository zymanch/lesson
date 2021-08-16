<?php

namespace models\base;
use ActiveGenerator\Criteria;
use models\ThemeQuery;

/**
 * This is the ActiveQuery class for [[models\Theme]].
 * @method ThemeQuery filterByThemeId($value, $criteria = null)
 * @method ThemeQuery filterByLessonId($value, $criteria = null)
 * @method ThemeQuery filterByName($value, $criteria = null)
 * @method ThemeQuery filterByPosition($value, $criteria = null)
  * @method ThemeQuery orderByThemeId($order = Criteria::ASC)
  * @method ThemeQuery orderByLessonId($order = Criteria::ASC)
  * @method ThemeQuery orderByName($order = Criteria::ASC)
  * @method ThemeQuery orderByPosition($order = Criteria::ASC)
  * @method ThemeQuery withLessonDays($params = [])
  * @method ThemeQuery joinWithLessonDays($params = null, $joinType = 'LEFT JOIN')
  * @method ThemeQuery withLesson($params = [])
  * @method ThemeQuery joinWithLesson($params = null, $joinType = 'LEFT JOIN')
 */
class BaseThemeQuery extends \yii\db\ActiveQuery
{


    use \ActiveGenerator\base\RichActiveMethods;

    /**
     * @inheritdoc
     * @return \models\Theme[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \models\Theme|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \models\ThemeQuery     */
    public static function model()
    {
        return new \models\ThemeQuery(\models\Theme::class);
    }
}

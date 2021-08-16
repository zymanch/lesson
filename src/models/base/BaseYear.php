<?php

namespace models\base;



/**
 * This is the model class for table "lesson.year".
 *
 * @property integer $year_id
 * @property string $name
 *
 * @property \models\Day[] $days
 * @property \models\Lesson[] $lessons
 */
class BaseYear extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lesson.year';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[BaseYearPeer::NAME], 'required'],
            [[BaseYearPeer::NAME], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseYearPeer::YEAR_ID => 'Year ID',
            BaseYearPeer::NAME => 'Name',
        ];
    }
    /**
     * @return \models\DayQuery
     */
    public function getDays() {
        return $this->hasMany(\models\Day::className(), [BaseDayPeer::YEAR_ID => BaseYearPeer::YEAR_ID]);
    }
        /**
     * @return \models\LessonQuery
     */
    public function getLessons() {
        return $this->hasMany(\models\Lesson::className(), [BaseLessonPeer::YEAR_ID => BaseYearPeer::YEAR_ID]);
    }
    
    /**
     * @inheritdoc
     * @return \models\YearQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \models\YearQuery(get_called_class());
    }
}

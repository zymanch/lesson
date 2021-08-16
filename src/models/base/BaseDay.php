<?php

namespace models\base;



/**
 * This is the model class for table "lesson.day".
 *
 * @property integer $day_id
 * @property integer $year_id
 * @property string $day
 * @property string $type
 *
 * @property \models\Year $year
 * @property \models\LessonDay[] $lessonDays
 */
class BaseDay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lesson.day';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[BaseDayPeer::YEAR_ID], 'integer'],
            [[BaseDayPeer::DAY], 'safe'],
            [[BaseDayPeer::TYPE], 'string'],
            [[BaseDayPeer::YEAR_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseYear::className(), 'targetAttribute' => [BaseDayPeer::YEAR_ID => BaseYearPeer::YEAR_ID]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseDayPeer::DAY_ID => 'Day ID',
            BaseDayPeer::YEAR_ID => 'Year ID',
            BaseDayPeer::DAY => 'Day',
            BaseDayPeer::TYPE => 'Type',
        ];
    }
    /**
     * @return \models\YearQuery
     */
    public function getYear() {
        return $this->hasOne(\models\Year::className(), [BaseYearPeer::YEAR_ID => BaseDayPeer::YEAR_ID]);
    }
        /**
     * @return \models\LessonDayQuery
     */
    public function getLessonDays() {
        return $this->hasMany(\models\LessonDay::className(), [BaseLessonDayPeer::DAY_ID => BaseDayPeer::DAY_ID]);
    }
    
    /**
     * @inheritdoc
     * @return \models\DayQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \models\DayQuery(get_called_class());
    }
}

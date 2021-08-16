<?php

namespace models\base;



/**
 * This is the model class for table "lesson.lesson_day".
 *
 * @property integer $lesson_day
 * @property integer $lesson_id
 * @property integer $theme_id
 * @property integer $day_id
 *
 * @property \models\Day $day
 * @property \models\Lesson $lesson
 * @property \models\Theme $theme
 */
class BaseLessonDay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lesson.lesson_day';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[BaseLessonDayPeer::LESSON_ID, BaseLessonDayPeer::THEME_ID, BaseLessonDayPeer::DAY_ID], 'integer'],
            [[BaseLessonDayPeer::DAY_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseDay::className(), 'targetAttribute' => [BaseLessonDayPeer::DAY_ID => BaseDayPeer::DAY_ID]],
            [[BaseLessonDayPeer::LESSON_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseLesson::className(), 'targetAttribute' => [BaseLessonDayPeer::LESSON_ID => BaseLessonPeer::LESSON_ID]],
            [[BaseLessonDayPeer::THEME_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseTheme::className(), 'targetAttribute' => [BaseLessonDayPeer::THEME_ID => BaseThemePeer::THEME_ID]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseLessonDayPeer::LESSON_DAY => 'Lesson Day',
            BaseLessonDayPeer::LESSON_ID => 'Lesson ID',
            BaseLessonDayPeer::THEME_ID => 'Theme ID',
            BaseLessonDayPeer::DAY_ID => 'Day ID',
        ];
    }
    /**
     * @return \models\DayQuery
     */
    public function getDay() {
        return $this->hasOne(\models\Day::className(), [BaseDayPeer::DAY_ID => BaseLessonDayPeer::DAY_ID]);
    }
        /**
     * @return \models\LessonQuery
     */
    public function getLesson() {
        return $this->hasOne(\models\Lesson::className(), [BaseLessonPeer::LESSON_ID => BaseLessonDayPeer::LESSON_ID]);
    }
        /**
     * @return \models\ThemeQuery
     */
    public function getTheme() {
        return $this->hasOne(\models\Theme::className(), [BaseThemePeer::THEME_ID => BaseLessonDayPeer::THEME_ID]);
    }
    
    /**
     * @inheritdoc
     * @return \models\LessonDayQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \models\LessonDayQuery(get_called_class());
    }
}

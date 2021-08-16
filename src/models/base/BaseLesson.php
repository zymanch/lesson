<?php

namespace models\base;



/**
 * This is the model class for table "lesson.lesson".
 *
 * @property integer $lesson_id
 * @property integer $year_id
 * @property integer $lesson_type_id
 * @property integer $class_number
 * @property integer $user_id
 * @property string $days_of_week
 *
 * @property \models\LessonType $lessonType
 * @property \models\User $user
 * @property \models\Year $year
 * @property \models\LessonDay[] $lessonDays
 * @property \models\Theme[] $themes
 */
class BaseLesson extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lesson.lesson';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[BaseLessonPeer::YEAR_ID, BaseLessonPeer::LESSON_TYPE_ID, BaseLessonPeer::CLASS_NUMBER, BaseLessonPeer::USER_ID], 'integer'],
            [[BaseLessonPeer::DAYS_OF_WEEK], 'string', 'max' => 50],
            [[BaseLessonPeer::LESSON_TYPE_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseLessonType::className(), 'targetAttribute' => [BaseLessonPeer::LESSON_TYPE_ID => BaseLessonTypePeer::LESSON_TYPE_ID]],
            [[BaseLessonPeer::USER_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseUser::className(), 'targetAttribute' => [BaseLessonPeer::USER_ID => BaseUserPeer::USER_ID]],
            [[BaseLessonPeer::YEAR_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseYear::className(), 'targetAttribute' => [BaseLessonPeer::YEAR_ID => BaseYearPeer::YEAR_ID]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseLessonPeer::LESSON_ID => 'Lesson ID',
            BaseLessonPeer::YEAR_ID => 'Year ID',
            BaseLessonPeer::LESSON_TYPE_ID => 'Lesson Type ID',
            BaseLessonPeer::CLASS_NUMBER => 'Class Number',
            BaseLessonPeer::USER_ID => 'User ID',
            BaseLessonPeer::DAYS_OF_WEEK => 'Days Of Week',
        ];
    }
    /**
     * @return \models\LessonTypeQuery
     */
    public function getLessonType() {
        return $this->hasOne(\models\LessonType::className(), [BaseLessonTypePeer::LESSON_TYPE_ID => BaseLessonPeer::LESSON_TYPE_ID]);
    }
        /**
     * @return \models\UserQuery
     */
    public function getUser() {
        return $this->hasOne(\models\User::className(), [BaseUserPeer::USER_ID => BaseLessonPeer::USER_ID]);
    }
        /**
     * @return \models\YearQuery
     */
    public function getYear() {
        return $this->hasOne(\models\Year::className(), [BaseYearPeer::YEAR_ID => BaseLessonPeer::YEAR_ID]);
    }
        /**
     * @return \models\LessonDayQuery
     */
    public function getLessonDays() {
        return $this->hasMany(\models\LessonDay::className(), [BaseLessonDayPeer::LESSON_ID => BaseLessonPeer::LESSON_ID]);
    }
        /**
     * @return \models\ThemeQuery
     */
    public function getThemes() {
        return $this->hasMany(\models\Theme::className(), [BaseThemePeer::LESSON_ID => BaseLessonPeer::LESSON_ID]);
    }
    
    /**
     * @inheritdoc
     * @return \models\LessonQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \models\LessonQuery(get_called_class());
    }
}

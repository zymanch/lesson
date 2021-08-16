<?php

namespace models\base;



/**
 * This is the model class for table "lesson.lesson_type".
 *
 * @property integer $lesson_type_id
 * @property string $name
 *
 * @property \models\Lesson[] $lessons
 */
class BaseLessonType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lesson.lesson_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[BaseLessonTypePeer::NAME], 'required'],
            [[BaseLessonTypePeer::NAME], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseLessonTypePeer::LESSON_TYPE_ID => 'Lesson Type ID',
            BaseLessonTypePeer::NAME => 'Name',
        ];
    }
    /**
     * @return \models\LessonQuery
     */
    public function getLessons() {
        return $this->hasMany(\models\Lesson::className(), [BaseLessonPeer::LESSON_TYPE_ID => BaseLessonTypePeer::LESSON_TYPE_ID]);
    }
    
    /**
     * @inheritdoc
     * @return \models\LessonTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \models\LessonTypeQuery(get_called_class());
    }
}

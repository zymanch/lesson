<?php

namespace controllers;

use ActiveGenerator\Criteria;
use components\Controller;
use models\forms\SceneEditForm;
use models\Lesson;
use models\LessonQuery;
use models\Scene;
use models\SceneQuery;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Class StatController
 *
 * @package controllers
 */
class LessonController extends Controller
{

    const PROJECTION_TITLE = "This is a 3 year projection. You can expect to make even more after that period.";

    /**
     * @return array|string[]
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [

                    [
                        'actions' => [
                            'update',
                            'index',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    /**
     * @return array|\string[][]
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index', [
            'lessons' => $this->_getScenesQuery()->all()
        ]);
    }

    /**
     * @return LessonQuery
     */
    private function _getScenesQuery()
    {
        return LessonQuery::model()
            ->joinWithLessonType()
            ->filterByUserId($this->getUserId())
            ->orderByYearId(Criteria::DESC)
            ->orderByLessonTypeId()
            ->orderByLessonId();
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $lesson = $this->_getLesson($id);
        $days = $this->_getDays($lesson);

        if (!empty($_POST)) {
            $exitAfterSave = isset($_POST['save_exit']);
            $model->load(\Yii::$app->request->post());
            if ($model->validate()) {
                $model->save();
                Yii::$app->session->setFlash('success', 'Saved');
                return $exitAfterSave
                    ? $this->redirect('/stat/index')
                    : $this->redirect('/stat/update/' . $id);
            } else {
                $errors = $scene->getFirstErrors();
                $error = reset($errors);
                Yii::$app->session->setFlash('error', $error);
            }
        }
        return $this->render('update', [
            "model" => $lesson,
            "days" => $days,
        ]);
    }

    /**
     * @param $id
     * @return Lesson
     * @throws NotFoundHttpException
     */
    private function _getLesson($id)
    {
        $lesson = LessonQuery::model()
            ->filterByLessonId($id)
            ->one();
        if (!$lesson) {
            throw new NotFoundHttpException("Lesson not found");
        }
        return $lesson;
    }

    private function _getDays(Lesson $lesson)
    {
        $result = $lesson->year->days;
        $days = [];
        foreach ($lesson->lessonDays  as $day) {
            $days[] = $day->day_id;
        }
        $daysOfWeek = array_filter(explode(',', $lesson->days_of_week));
        foreach ($result as $index => $day) {
            $dayOfWeek = date('N', strtotime($day->day));
            if (!in_array($dayOfWeek, $daysOfWeek) && !in_array($day->day_id, $days)) {
                unset($result[$index]);
            }
        }
        return array_values($result);
    }

    private function _getDayTree(Lesson $lesson)
    {
        $result = [];
        foreach ($lesson->year->days as $day) {
            $result[$day->day_id] = [
                'day' => $day,
                ''
            ];
        }
    }

}

<?php

namespace commands;

use ActiveRecord\Criteria;
use components\service\SyncAccount;
use helper\Query;
use models\Content;
use models\ContentTypeQuery;
use models\Day;
use models\Director;
use models\DirectorQuery;
use models\FtpDirectory;
use models\Model;
use models\ModelQuery;
use models\User;
use models\UserHasFtpDirectory;
use models\UserQuery;
use models\Year;
use models\YearQuery;
use yii\console\Controller;
use yii\db\Exception;

class DayController extends Controller
{
    const HOLIDAYS = [
        1 => [1,2,3,4,5,6,7],
        2 => [23],
        3 => [8],
        5 => [1,9],
    ];

    public $year;

    public function options($actionID)
    {
        return ['year'];
    }


    public function actionGenerate()
    {
        $year = $this->_getYear();
        $period = $this->_getPeriod($year);
        $existsDays = $this->_getExistsDays($year);
        foreach ($period as $day) {
            $key = $day->format('Y-m-d');
            if (!isset($existsDays[$key])) {
                $model = new Day();
                $model->year_id = $year->year_id;
                $model->day = $key;
                $model->type = $this->_getDayType($day);
                $model->save(false);
            }
        }
    }

    private function _getYear()
    {
        $result = YearQuery::model()
            ->filterByYearId($this->year)
            ->one();
        if (!$result) {
            throw new \Exception('Year not found');
        }
        return $result;
    }

    /**
     * @param Year $year
     * @return \DatePeriod|\DateTime[]
     * @throws \Exception
     */
    private function _getPeriod(Year $year)
    {
        $interval = new \DateInterval('P1D');
        return new \DatePeriod($year->getFromDate(), $interval, $year->getToDate());
    }

    private function _getExistsDays(Year $year)
    {
        $result = [];
        foreach ($year->days as $day) {
            $result[$day->day] = $day;
        }
        return $result;
    }

    private function _getDayType(\DateTime $day)
    {
        if ((int)$day->format('N')>=6) {
            return Day::TYPE_WEEKEND;
        }
        foreach (self::HOLIDAYS as $month  => $days) {
            if ($month !== (int)$day->format('m')) {
                continue;
            }
            if (in_array((int)$day->format('d'), $days)) {
                return Day::TYPE_HOLIDAY;
            }
        }
        return Day::TYPE_STUDY;
    }
}

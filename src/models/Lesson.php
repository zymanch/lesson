<?php
namespace models;

use models\base;

class Lesson extends base\BaseLesson {

    /**
     * @return \models\ThemeQuery
     */
    public function getThemes() {
        return parent::getThemes()->orderByPosition();
    }
}
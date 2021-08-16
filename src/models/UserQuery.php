<?php

namespace models;

use ActiveRecord\Criteria;
use models\base;

class UserQuery extends base\BaseUserQuery
{
    public static function findOneByUserId($userId)
    {
        return static::model()->filterByUserId($userId)->limit(1)->one();
    }

    public function filterByJsonParamsIsNotNull()
    {
        return $this->filterByJsonParams(null, Criteria::ISNOTNULL);
    }
}
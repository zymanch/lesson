<?php

namespace models\forms;

use helper\Query;
use models\ContentPriceRateQuery;
use models\forms\base\Form;
use models\Scene;
use models\SceneQuery;
use yii\db\Exception;

class SceneEditForm extends Form
{
    const _1_TKT_IN_USD = 1.5;
    const MIN_PRICE_USD = 1;
    const MAX_PRICE_USD = 100;
    //price in usd
    public $scene_id;
    public $content_id;
    public $name;
    public $price;
    public $exclusive_rights_cost;
    
    public static function createFromScene(Scene $scene)
    {
        $model = new static;
        $model->scene_id = $scene->scene_id;
        $model->content_id = $scene->content_id;
        $model->name = $scene->name;
        $model->exclusive_rights_cost = $scene->exclusive_rights_cost;
        $priceTkt = $scene->getContentPriceRate()->one()->rate;
        $priceUsd = $priceTkt * self::_1_TKT_IN_USD;
        $model->price = round($priceUsd, 2);
        return $model;
    }
    
    public function rules()
    {
        return [
            [['scene_id', 'content_id', 'name', 'price'], 'required'],
            [['scene_id', 'content_id', 'price'], 'double'],
            [['name'], 'string', 'min' => 10, 'max' => 128],
            [['price'], 'double', 'min' => self::MIN_PRICE_USD, 'max' => self::MAX_PRICE_USD],
            [['exclusive_rights_cost'], 'integer'],
        ];
    }
    
    public function save()
    {
        Query::executeInTransaction(function () {
            
            $scene = SceneQuery::model()->filterBySceneId($this->scene_id)->one();
            $scene->name = $this->name;
            $scene->exclusive_rights_cost = $this->exclusive_rights_cost;
            
            if (!$scene->save(true, ['name', 'exclusive_rights_cost'])) {
                throw new Exception(json_encode($scene->getErrors()));
            }
            
            $contentPriceRate = ContentPriceRateQuery::model()->filterByContentId($this->content_id)->one();
            $priceUsd = $this->price;
            $priceTkt = $priceUsd / self::_1_TKT_IN_USD;
            $contentPriceRate->rate = round($priceTkt, 2);
            if (!$contentPriceRate->save(true, ['rate'])) {
                throw new Exception(json_encode($contentPriceRate->getErrors()));
            }
            
        });
    }
    
}
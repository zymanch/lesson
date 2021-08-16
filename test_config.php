<?php
/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 19.04.2018
 * Time: 16:02
 */
return array_merge(
    require(__DIR__ . '/static_config.php'),
    require(__DIR__ . '/config.local.php')
);
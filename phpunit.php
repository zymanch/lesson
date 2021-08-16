<?php
if (\DIRECTORY_SEPARATOR !== '\\') {
    die("!!! DO NOT RUN TESTS ON PRODUCTION !!!\n");
}
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/vendor/amorpro/soft-mocks/src/QA/SoftMockLoader.php');
require_once(__DIR__ . '/vendor/amorpro/soft-mocks/src/QA/SoftMocks.php');

$loader = new Qa\SoftMockLoader(__DIR__, [
    __DIR__ . '/vendor/guzzlehttp/psr7/src/Uri.php',
]);

$secure = __DIR__ . '/config.secure.json';
$secure = json_decode(file_get_contents($secure), 1);
if (!$secure) {
    print 'Secure config has wrong format';
    die();
}

require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/static_config.php'),
    require(__DIR__ . '/config.local.php')
);
unset($config['components']['errorHandler']);
unset($config['components']['user']);
unset($config['components']['session']);
unset($config['components']['request']);

Yii::setAlias('@web', __DIR__ . '/public');
Yii::setAlias('@backend', __DIR__ . '/src');
new yii\console\Application($config);

$_SERVER['argv'][] = 'run';
//$_SERVER['argv'][] = 'functional';
$_SERVER['argv'][] = '--fail-fast';

require(__DIR__ . '/vendor/codeception/codeception/codecept');

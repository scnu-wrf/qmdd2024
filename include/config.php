<?php
date_default_timezone_set('Asia/Shanghai');
$db_host ="localhost";
$db_port   = "3306";
$db_name   = "qmdd0";
$db_user   = "admin_root";
$db_pass   = "";//EC66F6E0913F43B837E9084216A5BD66";
$db_name   = "sports";
$db_user   = "root";
Yii::setPathOfAlias('rootpath', ROOT_PATH);
return array(
    'name' => '管理系统',
    'defaultController' => 'index',
    'preload' => array(
        'log'
    ),
    'import' => array(
        'rootpath.models.*',
        'application.components.*',
    ),
    'modules' => array(
// uncomment the following to enable the Gii tool
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123456',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
  'components' => array(
         'db' => array(
            'class' => 'system.db.CDbConnection',
            'connectionString' => 'mysql:host='.$db_host.';port='.$db_port.';dbname='.$db_name,
            'emulatePrepare' => true,
            'username' => $db_user,
            'password' => $db_pass,
            'charset' => 'utf8',
            'tablePrefix' => '',
            'enableParamLogging' => true,//增加这行
            ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'info,error, warning'
                ),
                array(
                    'class' => 'CWebLogRoute',
                    'levels' => 'trace'
                ),
            ),
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
        ),
        'theme' => 'classic',
    ),
    'language' => 'zh_cn',
    'params' => array(
        'uploadUrl' => 'https://file.gf41.net/FileUploader/fileUpload',
        'QcloudLiveSecretId' => 'AKIDy4nB14NWDTVmVzy0Y7duFVR9FVQSs5o3',
        'QcloudLiveSecretKey' => '23sEjJWVgGzQAWPR96ULKEeTgGOj2AK0',
        'QcloudLiveAppid' => '1252074806',
        'QcloudLiveBizid' => '2685',
        'QcloudLiveAntiKey' => '1ea8b22045d3f0aeb4597c64e5617ae7', // 防盗链key
        'QcloudLiveAuthKey' => '332dbcb1c3ffe9f1902830b9fae14873', // 鉴权key
        'QcloudLiveFcgi' => 'http://fcgi.video.qcloud.com/common_access',//直播码模式  操作类接口域名    ),
 //   'enableParamLogging' => true,//增加这行,测试使用
//'uploadUrl' => 'http://gfinter.net:8080/FileUploader/fileUpload',
),


);

?>
<?php

$config = require(ROOT_PATH . "/include/config.php");
$params = array_merge($config['params'], array('administrator' => array('admin'),));
$params['roleItem']=get_session('role_menu');
$params['roleItem'] = array(
       

	array(
        '素材管理',
        array(
			'gf_material_doc_index' => array('电子文档', 'gfMaterial/doc'),
            'gf_material_pic_index' => array('图片', 'gfMaterial/pic'),
            'gf_material_video_index' => array('视频', 'gfMaterial/video'),
            'gf_material_audio_index' => array('音频', 'gfMaterial/audio'),
			'gfBrow_index' => array('表情包', 'gfBrow/index'),
        ),
    ),

    array(
        '动态资讯',
        array(
            'ClubNews_index' => array('信息列表', 'ClubNews/index'),
        ),
    ),

    array(
        '应用管理',
        array(
            'QmddFuntionData_index' => array('功能自定义', 'qmddFuntionData/index'),
            'QmddFunction_index' => array('功能菜单管理', 'qmddFunction/index'),
			'gf_app_index' => array('GFAPP列表', 'gfapp/index'),
        ),
    ),
 
);
$main = array(
    'basePath' => ROOT_PATH . '/admin',
    'runtimePath' => ROOT_PATH . '/runtime/admin',
    'name' => '',
    'defaultController' => 'index',
    'components' => array(
        'db' => $config['components']['db'],
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
    ),
    'params' => $params,
);
return array_merge($config, $main);

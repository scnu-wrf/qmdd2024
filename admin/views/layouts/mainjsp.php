<!doctype html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="zh-cn"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="zh-cn"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="zh-cn"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="zh-cn"><!--<![endif]-->
<head>
<meta charset="utf-8">
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=Edge，chrome=1">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<?php $cs = Yii::app()->clientScript;
 $jsp=Yii::app()->request->baseUrl.'/static/admin/';
?>
<?php $cs->registerCssFile($jsp.'css/public.css');?>
<?php $cs->registerCssFile($jsp.'css/font.css');?>
<?php $cs->registerCssFile($jsp.'style.css');?>
<?php $cs->registerCoreScript('jquery');?>
<?php $cs->registerScriptFile($jsp.'js/jquery.nicescroll.js');?>
<?php $cs->registerCssFile($jsp.'js/jquery.fallr/jquery.fallr.css');?>
<?php $cs->registerScriptFile($jsp.'js/jquery.fallr/jquery.fallr.js');?>
<?php $cs->registerScriptFile($jsp.'js/ueditor/ueditor.config.js');?>
<?php $cs->registerScriptFile($jsp.'js/ueditor/ueditor.all.min.js');?>
<?php $cs->registerScriptFile($jsp.'js/ueditor/lang/zh-cn/zh-cn.js');?>
<?php $cs->registerScriptFile($jsp.'js/ueditor/ueditor.parse.min.js');?>
<?php $cs->registerCssFile($jsp.'js/jquery.datetimepicker.css');?>
<?php $cs->registerScriptFile($jsp.'js/jquery.datetimepicker.js');?>

<?php $cs->registerCssFile($jsp.'js/jquery.uploadifive/uploadifive.css');?>
<?php $cs->registerScriptFile($jsp.'js/jquery.uploadifive/jquery.uploadifive.min.js');?>
<?php $cs->registerScriptFile($jsp.'js/My97DatePicker/WdatePicker.js');?>
<?php $cs->registerCssFile($jsp.'js/artDialog/skins/default.css');?>
<?php $cs->registerScriptFile($jsp.'js/artDialog/jquery.artDialog.js');?>
<?php $cs->registerScriptFile($jsp.'js/artDialog/plugins/iframeTools.js');?>
<?php $cs->registerCssFile($jsp.'js/jquery.contextMenu/jquery.contextMenu.css');?>
<?php $cs->registerScriptFile($jsp.'js/jquery.contextMenu/jquery.ui.position.js');?>
<?php $cs->registerScriptFile($jsp.'js/jquery.contextMenu/jquery.contextMenu.js');?>
<?php $cs->registerScriptFile($jsp.'js/md5.js');?>
<?php $cs->registerScriptFile($jsp.'js/Base64.js');?>
<?php $cs->registerScriptFile($jsp.'js/base64_1.js');?>
<?php $cs->registerScriptFile($jsp.'js/public.js');?>
<?php $cs->registerScriptFile($jsp.'js/spark-md5.js');?>
<script charset="gb2312" src="<?php echo $jsp;?>js/PCASClass.js"></script>
<script>
var baseUrl = '<?php echo Yii::app()->request->baseUrl;?>';
var indexUrl = '<?php echo get_cookie('_currentUrl_');?>';
var uppicUrl = '<?php echo $this->createUrl('public/uppic');?>';
var upfileUrl = '<?php echo $this->createUrl('public/upfile');?>';
var submitType='tijiao'
</script>
</head>
<body>
<?php echo $content;?>
</body>
</html>
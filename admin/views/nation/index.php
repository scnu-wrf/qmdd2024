<?php 
   $title=array('','民族列表','添加,刷新');
   $schcmd='关键字=keywords';
   $coumnName='code,nation,country';
   $cmd='编辑:update,删除';//,题目:PisaExamsData/index::题目';//操作的命令
   $data=array(0,'id',$coumnName,'',$cmd);
   hsYii_indexShow($this,$model, $title,$schcmd,$data,$arclist,$pages); 
?>
<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl.'/static/admin/switch/css/default.css';?>">
    <link href="<?php echo Yii::app()->request->baseUrl.'/static/admin/switch/docs/css/bootstrap.min.css" rel="stylesheet';?>">
    <link href="<?php echo Yii::app()->request->baseUrl.'/static/admin/switch/docs/css/highlight.css" rel="stylesheet';?>">
    <link href="<?php echo Yii::app()->request->baseUrl.'/static/admin/switch/css/bootstrap3/bootstrap-switch.css" rel="stylesheet';?>">
    <link href="<?php echo Yii::app()->request->baseUrl.'/static/admin/switch/css/docs.min.css" rel="stylesheet';?>">
    <link href="<?php echo Yii::app()->request->baseUrl.'/static/admin/switch/docs/css/main.css" rel="stylesheet';?>">
 
</head>
<body>
    <div class="box">
        <div class="box-title c"><h1><i class="fa fa-table"></i>支付设置</h1></div><!--box-title end-->
        <div class="box-detail-tab">
            <?php
                $s2=indexof(get_cookie('_currentUrl_'),'1031');
             ?>       
            <nav>
                <ul class="c">
                    <?php $action=Yii::app()->controller->getAction()->id;?>
                    <li
                        <?php if ($s2>0){?>  class="current" <?php }?>
                        <?php if($action=='gfPay'){?> <?php }?>><a href="<?php echo $this->createUrl('gfPaySet/gfPay', array('client'=>1031));?>" >网页端</a></li>

                    <li
                        <?php if ($s2<0){?>  class="current" <?php }?>
                        <?php if($action=='gfPay'){?> <?php }?>><a href="<?php echo $this->createUrl('gfPaySet/gfPay', array('client'=>1030));?>" >移动端</a></li>

                </ul>
            </nav>
        </div><!--box-detail-tab end-->

        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th>支付方式</th>
                        <th>显示名称</th>
                        <th>开启</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i=1; 
                        $index = 1;
                        foreach($arclist as $v){ ?>
                        <tr height='40'>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->pay_name; ?></td>
                            <td>
                            <input id="dispName<?php echo $v->id;?>" class="input-text" type="text" value="<?php echo $v->pay_dispay_name;?>" onchange="getName(<?php echo $v->id;?>)"  style="width:90%;height:30px;" >
                            </td>
                            <td>
                            
                                <?php 
                                    if ($v->is_open_user==649){
                                        echo '<input class="switch" id="switch'.$v->id.'" type="checkbox" data-size="mini" value='.$v->id.' checked  onchange="getChange(\'switch'.$v->id.'\')" >';}
                                    else{
                                        echo '<input class="switch" id="switch'.$v->id.'" type="checkbox" data-size="mini" value='.$v->id.'  onchange="getChange(\'switch'.$v->id.'\')" >';
                                        }
                                ?>
                              
                            </td>

                        </tr>
                     <?php $i++; $index++;} ?>
                </tbody>
            </table>

        </div><!--  box-table end  -->
    </div><!--  box end -->


    <script src="<?php echo Yii::app()->request->baseUrl.'/static/admin/switch/docs/js/jquery.min.js';?>"></script>
    <script src="<?php echo Yii::app()->request->baseUrl.'/static/admin/switch/docs/js/bootstrap.min.js';?>"></script>
    <script src="<?php echo Yii::app()->request->baseUrl.'/static/admin/switch/docs/js/highlight.js';?>"></script>
    <script src="<?php echo Yii::app()->request->baseUrl.'/static/admin/switch/js/bootstrap-switch.js';?>"></script>
    <script src="<?php echo Yii::app()->request->baseUrl.'/static/admin/switch/docs/js/main.js';?>"></script>


    <script type="text/javascript">

        $("nav li").click(function(){
        //      // alert('81');
              $(this).addClass("current").siblings().removeClass("current");
         })

        function getChange(a){
            var state;
            var $aa = $("#"+a);
            var id=$aa.val();
            // var state=$aa.bootstrapSwitch('state');

            if ($aa.bootstrapSwitch('state'))
              {
                state=649;
              }
            else
              {
                state=648;
              }

            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('changeSwitch');?>',
                data: {id:id, state:state},
                dataType:'json',
                success:function(data){
                    var dialog = art.dialog({ time: 1,title: '设置更改',width:'20em', height:100,padding: 0,cancel: false, content: data.msg });
                   
                }
            });
        }

        function getName(id){

            var $nn = $("#dispName"+id);
            var dispName=$nn.val();
            var defaultValue=document.getElementById("dispName"+id).defaultValue;

            if($.trim(dispName)==""){
                $nn.val(defaultValue).trigger('blur');
              }
            else{
                $.ajax({
                    type:'POST',
                    url:'<?php echo $this->createUrl('changeName');?>',
                    data: {id:id, dispName:dispName},
                    dataType:'json',
                    success:function(data){
                        var dialog = art.dialog({ time: 1,title: '设置更改',width:'20em', height:100,padding: 0,cancel: false, content: data.msg });                       
                    }
                });
            }


        }


    </script>
</body>
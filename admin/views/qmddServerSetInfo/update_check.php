<style>
    table{
        border-collapse:collapse;
    }
    /*模拟对角线*/
    .out{
        border-top:60px #D6D3D6 solid;/*上边框宽度等于表格第一行行高*/
        width:0px;/*让容器宽度为0*/
        height:0px;/*让容器高度为0*/
        border-left:110px #BDBABD solid;/*左边框宽度等于表格第一行第一格宽度*/
        position:relative;/*让里面的两个子容器绝对定位*/
        padding:0!important;
    }

    table span{
        font-style:normal;
        display:block;
        position:absolute;
        top:-52px;
        left:-60px;
        width:70px;
    }

    em{
        font-style:normal;
        display:block;
        position:absolute;
        top:-25px;
        left:-95px;
        width:70px;
    }

</style>
<?php

if (empty($_REQUEST['type'])){
    $type=$model->f_typeid;
} else{
    $type=$_REQUEST['type'];
    $model->f_typeid=$type;    
}
if (empty($_REQUEST['typename'])){
    $typename=$model->f_typename;   
} else{
    $typename=$_REQUEST['typename'];   
}
?>
<?php
$txt='';
if(!isset($_REQUEST['list'])){
        $_REQUEST['list']='index';
}
$flag=$_REQUEST['list'];
if($flag=='search'){
    $txt='服务查询》';
} elseif ($flag=='pass') {
    $txt='服务审核》';
} elseif ($flag=='check') {
    $txt='服务审核》待审核》';
} elseif ($flag=='index') {
    $txt='服务发布》';
} elseif ($flag=='list') {
    $txt='已发布列表》';
} elseif ($flag=='fail') {
    $txt='审核未通过列表》';
}
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约》服务管理》<?php echo $txt; ?><a class="nav-a">详情</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
<?php $id=(!empty($model->id)) ? $model->id : 0; ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <?php echo $form->labelEx($model, 'f_typeid'); ?>：<?php echo $typename; ?>
                <table class="table-title">
                    <tr>
                        <td>基本信息</td>
                    </tr>
                </table>
                <table>                    
                    <tr><?php echo $form->hiddenField($model, 'f_typeid'); ?>
                        <td width="15%"><?php echo $form->labelEx($model, 'set_code'); ?></td>
                        <td width="35%"><?php echo $model->set_code; ?></td>
                        <td width="15%"><?php echo $form->labelEx($model, 'if_user_state'); ?></td>
                        <td width="35%">
                            <?php echo $form->radioButtonList($model, 'if_user_state', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check','disabled'=>'true', 'template' => '<span class="check">{input}{label}</span>')); ?>
                            <?php echo $form->error($model, 'if_user_state', $htmlOptions = array()); ?>
                        </td>
                    </tr>  
                    <tr>
                        <td><?php echo $form->labelEx($model, 'set_name'); ?></td>
                        <td colspan="3"><?php echo $model->set_name; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'server_start'); ?></td>
                        <td><?php echo $model->server_start; ?>至<?php echo $model->server_end; ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'star_time'); ?></td>
                        <td><?php echo $model->star_time; ?>至<?php echo $model->end_time; ?></td>
                    </tr>                               
                </table>

 <table class="mt15 table-title">
    <tr><td>服务信息</td></tr>
 </table>
 <script>
 var oldnum=0;
 var s_no=0;
 </script>
 <?php echo $form->hiddenField($model, 'product', array('class' => 'input-text')); ?>
 <div><!--服务资源-->
 <table>
    <tr>
        <td width="15%">序号</td>
        <td width="20%">资源编号/名称</td>
        <td width="10%">服务类别</td>
        <td width="10%">资源等级</td>
        <td width="10%">服务项目</td>
        <td width="10%">备注</td>
        <td width="10%">所属场馆</td>
        <td width="15%">操作</td>
     </tr>
</table>               
<table id="product">
 <?php $index = 1; ?>
<?php if(!empty($model->set_list)) foreach ($model->set_list as $v) { ?>
 <tr data-server="<?php echo $v->server_sourcer_id;?>">
   <td width="15%" style="text-align:center;"><?php echo $index ?></td>
   <td width="20%" title="<?php echo $v->s_name; ?>"><input type="hidden" name="product[<?php echo $v->id;?>][id]" value="<?php echo $v->id;?>" /><?php echo $v->s_code; ?>-<?php echo $v->s_name; ?>
<input type="hidden" name="product[<?php echo $v->id;?>][server_sourcer_id]" value="<?php echo $v->server_sourcer_id;?>" /></td>
   <td width="10%"><?php if(!empty($v->s_usertype)) echo $v->s_usertype->f_uname;?></td>
   <td width="10%"><?php echo $v->s_levelname;?></td>
 <?php if(!empty($v->project_ids)) $project=ProjectList::model()->findAll('id in('.$v->project_ids.')'); ?>
   <td width="10%"><?php if(!empty($project))foreach($project as $p)   echo $p->project_name; ?></td>
   <td width="10%"><?php if(!empty($v->sitetype)) echo $v->sitetype->F_NAME;?><?php if(!empty($v->s_gfname)) echo $v->s_gfname;?></td>
   <td width="10%"><?php if(!empty($v->site)) echo $v->site->site_name;?></td>
   <td width="15%"><a class="btn" href="javascript:;" onclick="fnMemberprice(<?php echo $v->id;?>);" title="可约服务明细">价格明细</a></td>
   </tr>
 <script>
 var oldnum=<?php echo $v->id;?>;
 var s_no=<?php echo $index;?>;
 </script>
<?php $index++; } ?>                     
               </table>
</div>
        <div class="mt15" style="overflow:auto;">
<?php echo $form->hiddenField($model, 'setdata', array('class' => 'input-text'));
$cnum=count($server_time); ?>
        <table id="setdata" style='table-layout:auto;white-space: nowrap;'>
            <tr class="table-title">
                <td colspan="<?php echo $cnum+1; ?>">时间及价格设置</td>
            </tr>
            <tr>
                <td class="out" style="width:15%!important;"><div><span>服务时段</span><em>服务资源</em></div></td>
            <?php if(!empty($server_time)) foreach ($server_time as $t) { ?>
                <td width="80"><?php echo $t->start_time; ?><br><?php echo $t->end_time; ?></td>
            <?php }?>
            </tr>
    <?php if(!empty($model->set_list)) foreach ($model->set_list as $s) { ?>
            <tr id="item_<?php echo $s->server_sourcer_id; ?>">
                <td><?php echo $s->s_name; ?></td>
                <input type="hidden" name="setdata[<?php echo $s->id; ?>][list_id]" value="<?php echo $s->id; ?>">
                <input type="hidden" name="setdata[<?php echo $s->id; ?>][server_sourcer_id]" value="<?php echo $s->server_sourcer_id; ?>">
            <?php if(!empty($server_time)) foreach ($server_time as $t) { ?>
            <?php $price='';
            $set_data=QmddServerSetData::model()->find('(info_id='.$id.' and list_id='.$s->id.' and s_timename="'.$t->timename.'") order by id DESC');
            if(!empty($set_data)) $price=$set_data->sale_price; ?>
                <td><?php echo $price; ?></td>
            <?php }?>
            </tr>
<?php } ?>
        </table>
        </div>
        <table class="mt15 table-title">
            <tr>
                <td>操作信息</td>
            </tr>
        </table>
        <table>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'f_check'); ?></td>
                <td><?php echo $model->f_check_name; ?></td>
            </tr>
            <tr>
                <td width='15%'><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                <td>
                    <?php echo ($model->f_check==371 && $flag=='check') ? $form->textArea($model, 'reasons_failure', array('class' => 'input-text' ,'value'=>'')) : $model->reasons_failure; ?>
                    <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
                </td>
            </tr>
<?php if($flag!='pass'){ ?>
                <tr>
                    <td>可执行操作</td>
                    <td>
                        <?php echo show_shenhe_box(array('tongguo'=>'审核通过','tuihui'=>'退回修改','butongguo'=>'审核未通过'));?>
                    <?php if($flag=='index' && $model->f_check!=373){ ?>
                        <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">撤销申请</button>
                    <?php } elseif ($flag=='list') { ?>
                        <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
                    <?php } ?>
<?php if($flag=='list' || $flag=='fail' || ($model->f_check==373 && $flag=='index')){ ?>
                        <!-- <a class="btn" href="<?php //echo $this->createUrl('fnDelete', array('id'=>$model->id));?>">删除</a> -->
                        <a class="btn" href="javascript:;" onclick="clickDelete('<?php echo $model->id; ?>')">删除</a>
<?php } ?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
<?php } ?>
        </table>           
    </div><!--box-detail-tab-item end-->
</div><!--box-detail-bd end-->
            
<?php $this->endWidget(); ?>
  </div><!--box-detail end-->
</div><!--box end-->
<script>
// 特殊价格设置
var fnSpecial=function(){
    $.dialog.open('<?php echo $this->createUrl("special",array('id'=>$model->id));?>',{
        id:'teshujia',
        lock:true,
        opacity:0.3,
        title:'特殊价格设置',
        width:'100%',
        height:'95%',
        close: function () {}
    });
};
var club_id=<?php echo get_session('club_id');?>;
var $start_time=$('#<?php echo get_class($model);?>_star_time');
var $end_time=$('#<?php echo get_class($model);?>_end_time');
$start_time.on('click', function(){
WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
$end_time.on('click', function(){
WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss '});});
 var fnSetDate=function(op){
        WdatePicker({dateFmt:'yyyy-MM-dd',realDateFmt:'yyyy-MM-dd',onpicked:function(dp){
            //console.log('123');
            var current_line=$(op).parent().parent().find('input');
            var server_start=current_line.eq(0).val();
            var server_end = current_line.eq(1).val();
			var date_star=new Date(server_start);
			var date_end=new Date(server_end);
			if(date_star.getTime()>date_end.getTime()){
				we.msg('minus', '服务开始日期不能大于结束日期');
				$(op).val('');
				return false;
			}
			var times=date_end.getTime()-date_star.getTime();
			var days=parseInt(times / (1000 * 60 * 60 * 24));
			if(days>14){
				we.msg('minus', '可发布服务时间不能超过15天');
				$(op).val('');
				return false;
			}
		}
		});
    };
    //添加服务资源
    $QmddServerSetInfo_product = $('#QmddServerSetInfo_product');
    $product = $('#product');
    $setdata = $('#setdata');
    var num=oldnum+1;
     $('#product_select_btn').on('click', function(){
        var type = $('#QmddServerSetInfo_f_typeid').val();
        var html_str='';
        var html_d='';
        if (club_id=='') {
            we.msg('minus','抱歉，系统没有获取到单位信息');
            return false;
        }
        if (type=='') {
            we.msg('minus','请先选择服务类型');
            return false;
        }
        
        $.dialog.data('product_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/server_sourcer");?>&club_id='+club_id+'&type='+type,{
            id:'fuwuziyuan',
            lock:true,
            opacity:0.3,
            title:'选择服务资源',
            width:'80%',
            height:'80%',
            close: function () {
                if($.dialog.data('id')==-1){
                    var boxnum=$.dialog.data('products');
                    for(var j=0;j<boxnum.length;j++) {
                        if($('#item_'+boxnum[j].dataset.id).length==0){
                        s_no++;
                        html_str = html_str + '<tr data-server="'+boxnum[j].dataset.id+'">'+
                        '<td width="10%" style="text-align: center;">'+s_no+'</td>'+
                        '<td width="30%">'+boxnum[j].dataset.code+'-'+boxnum[j].dataset.name+
                        '<input type="hidden" name="product['+num+'][id]" value="null" />'+
                        '<input type="hidden" name="product['+num+'][server_sourcer_id]" value="'+boxnum[j].dataset.id+'" /></td>'+
                        '<td width="15%">'+boxnum[j].dataset.type+'</td>'+
                        '<td width="10%">'+boxnum[j].dataset.level+'</td>'+
                        '<td width="15%">'+boxnum[j].dataset.project+'</td>'+
                        '<td width="20%"><a class="btn" href="javascript:;" onclick="fnDeleteProduct(this);" title="删除">'
                        +'<i class="fa fa-trash-o"></i></a></td></tr>';
                        html_d = html_d + '<tr id="item_'+boxnum[j].dataset.id+'">'+
                        '<td>'+boxnum[j].dataset.name+'</td>'+
                        +'<input type="hidden" name="setdata['+num+'][list_id]">'+
                        '<input type="hidden" name="setdata['+num+'][server_sourcer_id]" value="'+boxnum[j].dataset.id+'">';
                        <?php if(!empty($server_time)) foreach ($server_time as $t) {?>
                            html_d = html_d + '<td><input class="input-text" type="text" name="setdata['+num+'][<?php echo $t->timename; ?>]" value="'+boxnum[j].dataset.price+'" style="width:40px;"></td>';
                        <?php } ?>
                        html_d = html_d + '</tr>';
                        num++;
                        }
                        
                    }
                    $product.append(html_str);
                    $setdata.append(html_d);
                    
                    //fnUpdateProduct();
                }
            }
        });
    });
    

// 查看服务时间价格
var fnMemberprice=function(detail_id){
	price_id=$('#QmddServerSetInfo_salesperson_profit_id');
    $.dialog.open('<?php echo $this->createUrl("memberprice");?>&detail_id='+detail_id,{
        id:'huiyuanjia',
        lock:true,
        opacity:0.3,
        title:'服务价格明细',
        width:'100%',
        height:'100%',
        close: function () {}
    });
};
    var fnDeleteProduct=function(op){
    var sourcer_id=$(op).parent().parent().attr('data-server');
    $(op).parent().parent().remove();
    $('#item_'+sourcer_id).remove();
    };

    function clickDelete(id){
        var url = '<?php echo $this->createUrl('fnDelete'); ?>&id='+id;
        var fnDelete = function() {
            $.ajax({
                type: 'get',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 1) {
                        we.success(data.msg, data.redirect);
                    } else {
                        we.error(d.msg, d.redirect);
                    }
                }
            });
        };
        $.fallr('show', {
            buttons: {
                button1: {text: '删除', danger: true, onclick: fnDelete},
                button2: {text: '取消'}
            },
            content: '确定删除？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });
    }
</script> 

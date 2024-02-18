
<div class="box">
    <span style="float:right;padding-right:15px;">
        <a class="btn" href="javascript:;" onclick="we.reload();">刷新</a>
    </span>
    <div class="box-title c">
    	<h1>
			<?php 
				if($_REQUEST['club_type']==8){
					echo '当前界面：社区单位》社区单位管理》社区单位注销';
				}else if($_REQUEST['club_type']==189){
					echo '当前界面：战略伙伴》战略伙伴管理》战略伙伴注销';
				}elseif($_REQUEST['club_type']==380){
					echo '当前界面：供应商》供应商管理》供应商注销';
				}elseif($_REQUEST['club_type']==1086){
					echo '当前界面：会员 》管理机构 》单位注销';
				}elseif($_REQUEST['club_type']==9){
					echo '当前界面：会员 》得闲体育 》单位注销';
				}
			?>
       </h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" onclick="add_member()"><i class="fa fa-plus"></i>注销</a>
            <?php echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="club_type" value="<?php echo Yii::app()->request->getParam('club_type');?>">
                <label style="margin-right:10px;">
                    <span>操作时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $startDate;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $endDate;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入管理账号/服务平台名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check">
                            <input id="j-checkall" class="input-check" type="checkbox">
                        </th>
                        <th>序号</th>
                        <?php if($_REQUEST['club_type']==380){?>
                            <th>商家类型</th>
                        <?php }?>
                        <th><?php echo $model->getAttributeLabel('club_code');?></th>
                        <?php if($_REQUEST['club_type']==380){?>
                            <th>公司名称</th>
                            <th>供应商类型</th>
                        <?php }?>
                        <th><?=$_REQUEST['club_type']==380?"商家名称":"服务平台名称"?></th>
                        <?php if($_REQUEST['club_type']==8){?>
                            <th><?php echo $model->getAttributeLabel('individual_enterprise');?></th>
                        <?php }elseif($_REQUEST['club_type']==189){?>
                            <th>战略伙伴类别</th>
                        <?php }?>
                        <?php if($_REQUEST['club_type']!=380){?>
                            <th>入驻项目数量</th>
                        <?php }?>
                        <th><?php echo $model->getAttributeLabel('lock_reason');?></th>
                        <th><?php echo $model->getAttributeLabel('lock_date');?></th>
                        <th><?php echo $model->getAttributeLabel('reasons_adminid');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php 
$index = 1;
foreach($arclist as $v){ 
?>
                    <tr>
                        <td class="check check-item">
                            <input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>">
                        </td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <?php if($_REQUEST['club_type']==380){?>
                            <td><?php echo $v->partnership_name; ?></td>
                        <?php }?>
                        <td><?php echo $v->club_code; ?></td>
                        <?php if($_REQUEST['club_type']==380){?>
                            <td><?php echo $v->company; ?></td>
                            <td><?php echo $v->company_type; ?></td>
                        <?php }?>
                        <td><?php echo $v->club_name; ?></td>
                        <?php if($_REQUEST['club_type']==8){?>
                            <td><?php echo $v->individual_enterprise_name; ?></td>
                        <?php }elseif($_REQUEST['club_type']==189){?>
                            <td><?php echo $v->partnership_name; ?></td>
                        <?php }?>
                        <?php if($_REQUEST['club_type']!=380){?>
                            <td>
                                <?php 
                                    $p_count=ClubProject::model()->count('if_del=509 and club_id='.$v->id.' and auth_state=461 and free_state_Id=1202');
                                    echo $p_count;  
                                ?>
                            </td>
                        <?php }?>
                        <td><?php echo $v->lock_reason; ?></td>
                        <td><?php echo $v->lock_date; ?></td>
                        <td><?php echo (!is_null($v->lockAdmin)?$v->lockAdmin->admin_gfaccount:'').'/'.$v->lock_adminname; ?></td>
                        <td>
                            <?php 
                                $up='update';
                                if($_REQUEST['club_type']==8){
                                    $up=$this->createUrl('clubListSqdw/update_data', array('id'=>$v->id));
                                }elseif($_REQUEST['club_type']==189){
                                    $up=$this->createUrl('clubListZlhb/update_data', array('id'=>$v->id));
                                }elseif($_REQUEST['club_type']==380){
                                    $up=$this->createUrl('clubListGys/update_data', array('id'=>$v->id,'action'=>'index_can'));
                                }elseif($_REQUEST['club_type']==1086){
                                    $up=$this->createUrl('clubListGljg/update', array('id'=>$v->id,'action'=>'index_can'));
                                }elseif($_REQUEST['club_type']==9){
                                    $up=$this->createUrl('update', array('id'=>$v->id));
                                }
                                echo show_command('详情',$up); 
                            ?>
                            <?php echo show_command('删除','\''.$v->id.'\''); ?>
                        </td>
                    </tr>
<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        
        <div class="box-page c"><?php $this->page($pages);?></div>
        
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
$(function(){
    var $lock_date_start=$('#start_date');
    var $lock_date_end=$('#end_date');
    $lock_date_start.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
    });
    $lock_date_end.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
    });
});
</script>
<script>
    var screen = document.documentElement.clientWidth;
    var sc = screen-300;
    var add_html = 
        '<div id="add_format" style="width:'+sc+'px;">'+
            '<form id="add_form" name="add_form">'+
                '<table id="table_tag" style="width:100%;border: solid 1px #d9d9d9;">'+
                    '<thead>'+
                        '<tr class="table-title">'+
                            '<td colspan="8" style="padding: 5px;">单位选择&nbsp;&nbsp;<input type="button" class="btn btn-blue" onclick="add_tag();" value="选择"></td>'+
                        '</tr>'+
                    '</thead>'+
                '</table>'+
            '</form>'+
        '</div>';


	// 选择单位
    var if_data=0;
    function add_tag(){
        $.dialog.data('club_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/club");?>&club_type='+<?php echo $_REQUEST['club_type']?>,{
        id:'danwei',
		lock:true,
        opacity:0.3,
		width:'500px',
		height:'100%',
        title:'选择具体内容',		
        close: function () {
            if($.dialog.data('club_id')>0){       
                var content = 
                '<tr style="text-align:center;">'+
                    '<td style="width:100px;border:solid 1px #d9d9d9;">单位管理账号</td>';
					if(<?=$_REQUEST['club_type']?>!=380){
                    content+='<td style="width:100px;border:solid 1px #d9d9d9;">单位类型</td>';
					}
                    content+='<td style="width:100px;border:solid 1px #d9d9d9;"><?=$_REQUEST['club_type']==380?"商家名称":"服务平台名称"?></td>'+
                    '<td style="width:100px;border:solid 1px #d9d9d9;">注销原因</td>'+
                '</tr>'+
                '<tr style="text-align:center;" class="add_len">'+
                    '<input id="deal_id" name="deal_id" type="hidden" value="'+$.dialog.data('club_id')+'">'+
                    '<td style="border:solid 1px #d9d9d9;padding:5px;"><input style="border:0;text-align:center;" readonly="readonly" id="deal_code" name="deal_code" type="text" value="'+$.dialog.data('club_code')+'"></td>';
					if(<?=$_REQUEST['club_type']?>!=380){
                    	content+='<td style="border:solid 1px #d9d9d9;padding:5px;"><input style="border:0;text-align:center;" readonly="readonly" id="partnership_type" name="partnership_type" type="text" value="'+$.dialog.data('club_typename')+'"></td>';
					}
                    content+='<td style="border:solid 1px #d9d9d9;padding:5px;"><input style="border:0;text-align:center;" readonly="readonly" id="deal_name" name="deal_name" type="text" value="'+$.dialog.data('club_title')+'"></td>'+
                    '<td style="border:solid 1px #d9d9d9;padding:5px;">'+
                        '<input id="user_state" name="user_state" type="hidden" value="649">'+
                        '<textarea class="input-text" id="lock_reason" name="lock_reason"></textarea>'+
                    '</td>'+
                '</tr>';
                $("#table_tag tbody").remove();
                $("#table_tag").append(content);
                if_data=1;
            }
         }
       });
    }
    function add_member(){
        if_data=0;
        var title='';
        if(<?php echo $_REQUEST['club_type']?>==189){
            title='战略伙伴';
        }else if(<?php echo $_REQUEST['club_type']?>==8){
            title='社区单位';
        }
        $.dialog({
            id:'tianjia',
            lock:true,
            opacity:0.3,
            // height: '60%',
            // width:'80%',
            title:title+'注销',
            content:add_html,
            button:[
                {
                    name:'保存',
                    callback:function(){
                        return fn_add_tr();
                    },
                    focus:true
                },
                {
                    name:'取消',
                    callback:function(){
                        return true;
                    }
                }
            ]
        });
        $('.aui_main').css('height','auto');
    }

    function fn_add_tr(){
        if(if_data==0){
            return false;
        }
        var form=$('#add_form').serialize();
        we.loading('show');
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('updata_club',array());?>',
            data: form,
            dataType: 'json',
            success: function(data) {
                if(data.status==1){
                    we.loading('hide');
                    $.dialog.list['tianjia'].close();
                    we.success(data.msg, data.redirect);
                }else{
                    we.loading('hide');
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }
</script>

<div class="box" div style="font-size: 9px">
    <a class="btn" href="javascript:;" onclick="we.reload();" style="vertical-align: middle;float: right; margin-right: 10px;"><i class="fa fa-refresh"></i>刷新</a>
	<div class="box-title c"><h1>当前界面：项目》单位项目管理》项目冻结/解冻</h1></div>
    <div class="box-content">
        <div class="box-detail-tab mt15">
            <ul class="c">
                <li class="current" >冻结</li>
                <li><a href="<?=$this->createUrl('index_thawy')?>">解冻</a></li>
            </ul>
        </div>
    	<div class="box-header">
            <?php echo '<span class="exam"><p>今日冻结：<span style="color:red;font-weight: bold;">'.$count1.'</span></p></span>&nbsp;'; ?>
            <?php echo '<span class="exam"><p>今日解冻：<span style="color:red;font-weight: bold;">'.$count2.'</span></p></span>&nbsp;'; ?>
            <a class="btn" onclick="add_member()">冻结账号</a>
            <!-- <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a> -->
        </div><!--box-header end -->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>冻结/解冻日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>账号状态：</span>
                    <?php echo downList($state,'f_id','F_NAME','state'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" placeholder="请输入编码 / 帐号 / 姓名" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="text-align:center;">序号</th>
                        <th>操作内容</th>
                        <th><?php echo $model->getAttributeLabel('p_code');?></th>
                        <th><?php echo $model->getAttributeLabel('club_name');?></th>
                        <th><?php echo $model->getAttributeLabel('club_type');?></th>
                        <th><?php echo $model->getAttributeLabel('project_id');?></th>
                        <th><?php echo $model->getAttributeLabel('lock_reason');?></th>
                        <th><?php echo $model->getAttributeLabel('state');?></th>
                        <th><?php echo $model->getAttributeLabel('lock_date_start');?></th>
                        <th><?php echo $model->getAttributeLabel('lock_date_end');?></th>
                        <th>解冻方式</th>
                        <th>操作时间</th>
                        <th>操作人</th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1;foreach($arclist as $v){ ?>
                    <tr>
                        <td style="text-align:center;"><span class="num num-1"><?php echo $index; ?></span></td>
                        <td>
                            <?php 
                                if(is_null($v->remedy_btn)){
                                    echo '冻结';
                                }else{
                                    echo '解冻';
                                }
                            ?>
                        </td>
                        <td><?php echo $v->cpd->p_code; ?></td>
                        <td><?php echo $v->cpd->club_name; ?></td>
                        <td><?php echo $v->cpd->club_type_name; ?></td>
                        <td><?php echo $v->cpd->project_name; ?></td>
                        <td><?php echo $v->lock_reason; ?></td>
                        <td><?php echo $v->state_name; ?></td>
                        <td><?php echo empty($v->lock_date_start)?'':date('Y-m-d H:i:s',strtotime($v->lock_date_start));?></td>
                        <td><?php echo empty($v->lock_date_end)?'':date('Y-m-d H:i:s',strtotime($v->lock_date_end));?></td>
                        <td>
                            <?php 
                                if(is_null($v->remedy_btn)){
                                    echo '';
                                }elseif($v->remedy_btn==1){
                                    echo '常规解冻';
                                }elseif($v->remedy_btn==0){
                                    echo '立即解冻';
                                }
                            ?>
                        </td>
                        <td><?php echo $v->add_time; ?></td>
                        <td><?php echo $v->process_account.'/'.$v->process_nick; ?></td>
                    </tr>
                <?php $index++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

var $start_date=$('#start_date');
var $end_date=$('#end_date');
$start_date.on('click', function(){
    WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
});
$end_date.on('click', function(){
    WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
});

var add_html = 
    '<div id="add_format" style="width:1095px;">'+
        '<form id="add_form" name="add_form">'+
            '<table id="table_tag" style="width:100%;border: solid 1px #d9d9d9;">'+
                '<thead>'+
                    '<tr class="table-title">'+
                        '<td colspan="8" style="padding: 5px;">账号选择&nbsp;&nbsp;<input type="button" class="btn btn-blue" onclick="add_tag();" value="选择"></td>'+
                    '</tr>'+
                '</thead>'+
            '</table>'+
        '</form>'+
    '</div>';

var if_data=0;
function add_tag(){
    $.dialog.data('id', 0);
    $.dialog.open('<?php echo $this->createUrl("select/clubProject");?>',{
    id:'gfzhanghao',
    lock:true,opacity:0.3,
    width:'500px',
    // height:'60%',
    title:'选择冻结单位项目',		
    close: function () {
        if($.dialog.data('id')>0){
            var e=$.parseJSON($.dialog.data('data'));
            var content = 
            '<tr style="text-align:center;">'+
                '<td style="width:60px;border:solid 1px #d9d9d9;">单位账号</td>'+
                '<td style="width:100px;border:solid 1px #d9d9d9;">服务平台名称</td>'+
                '<td style="width:100px;border:solid 1px #d9d9d9;">项目</td>'+
                '<td style="width:100px;border:solid 1px #d9d9d9;">项目等级</td>'+
                '<td style="width:100px;border:solid 1px #d9d9d9;">冻结处理</td>'+
                '<td style="width:100px;border:solid 1px #d9d9d9;">冻结原因</td>'+
            '</tr>'+
            '<tr style="text-align:center;" class="add_len">'+
                '<input id="club_project_id" name="club_project_id" type="hidden" value="'+e.id+'">'+
                '<td style="border:solid 1px #d9d9d9;padding:5px;">'+e.p_code+'</td>'+
                '<td style="border:solid 1px #d9d9d9;padding:5px;">'+e.club_name+'</td>'+
                '<td style="border:solid 1px #d9d9d9;padding:5px;">'+e.project_name+'</td>'+
                '<td style="border:solid 1px #d9d9d9;padding:5px;">'+e.level_name+'</td>'+
                '<td style="border:solid 1px #d9d9d9;padding:5px;">'+
                    '<select id="project_state" name="project_state" >'+
                        '<option value>请选择</option>'+
                        '<?php $base_code=BaseCode::model()->getReturn('1282,1283,507'); if(!empty($base_code))foreach($base_code as $ba){?>'+
                            '<option value="<?php echo $ba->f_id; ?>"><?php 
                            echo $ba->F_NAME; 
                            ?></option>'+
                        '<?php }?>'+
                    '</select>'+
                '</td>'+
                '<td style="border:solid 1px #d9d9d9;padding:5px;">'+
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
    $.dialog({
        id:'tianjia',
        lock:true,
        opacity:0.3,
        height: '60%',
        width:'80%',
        title:'选择冻结单位项目',
        content:add_html,
        button:[
            {
                name:'确定冻结',
                callback:function(){
                    if($("#project_state").val()==''){
                        we.msg('minus', '请选择冻结处理');
                        return false;
                    }
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
        url: '<?php echo $this->createUrl('addForm',array());?>',
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
<div class="box" div style="font-size: 9px">
    <a class="btn" href="javascript:;" onclick="we.reload();" style="vertical-align: middle;float: right; margin-right: 10px;"><i class="fa fa-refresh"></i>刷新</a>
	<div class="box-title c"><h1>当前界面：服务者》服务者管理》服务者冻结/解冻</h1></div>
    <div class="box-content">
        <div class="box-detail-tab mt15">
            <ul class="c">
                <li class="current" >冻结</li>
                <li><a href="<?=$this->createUrl('index_thawy')?>">解冻</a></li>
            </ul>
        </div>
    	<div class="box-header">
            <a class="btn" onclick="add_member()">冻结账号</a>
            <!-- <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a> -->
        </div><!--box-header end -->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>账号状态：</span>
                    <?php echo downList($if_del,'f_id','F_NAME','if_del'); ?>
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
                        <th><?php echo $model->getAttributeLabel('gf_code');?></th>
                        <th><?php echo $model->getAttributeLabel('gfaccount');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_name');?></th>
                        <th><?php echo $model->getAttributeLabel('project_name');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_type');?></th>
                        <th><?php echo $model->getAttributeLabel('if_del');?></th>
                        <th><?php echo $model->getAttributeLabel('lock_reason');?></th>
                        <th>解冻方式</th>
                        <th><?php echo $model->getAttributeLabel('lock_date_start');?></th>
                        <th><?php echo $model->getAttributeLabel('lock_date_end');?></th>
                        <th>操作时间</th>
                        <th>操作人</th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1;foreach($arclist as $v){ ?>
                    <tr>
                        <td style="text-align:center;"><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php echo CHtml::link($v->gf_code, array('update', 'id'=>$v->id)); ?></td>
                        <td><?php echo CHtml::link($v->gfaccount, array('update', 'id'=>$v->id)); ?></td>
                        <td><?php echo $v->qualification_name; ?></td>
                        <td><?php echo $v->project_name; ?></td>
                        <td><?php echo $v->qualification_type; ?></td>
                        <td><?php echo $v->acc_status->F_NAME; ?></td>
                        <td><?php echo $v->lock_reason; ?></td>
                        <td>
                            <?php 
                                if($v->if_del==506&&!empty($v->lock_date_end)&&$v->expiry_date_start==$v->lock_date_end){
                                    echo '常规解冻';
                                }elseif($v->if_del==506&&!empty($v->lock_date_end)&&$v->expiry_date_start!=$v->lock_date_end){
                                    echo '立即解冻';
                                }else{
                                    echo '';
                                }
                            ?>
                        </td>
                        <td><?php echo date('Y-m-d H:i:s',strtotime($v->lock_date_start));?></td>
                        <td><?php echo date('Y-m-d H:i:s',strtotime($v->lock_date_end));?></td>
                        <td><?php echo date('Y-m-d',strtotime($v->lock_time)); ?></td>
                        <td><?php echo $v->process_nick; ?></td>
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
    $.dialog.data('gfid', 0);
    $.dialog.open('<?php echo $this->createUrl("select/qualification");?>&free_state_Id=1202&is_pay=464',{
    id:'gfzhanghao',
    lock:true,opacity:0.3,
    width:'500px',
    // height:'60%',
    title:'选择冻结账号',		
    close: function () {
        if($.dialog.data('gfid')>0){
            var e=$.parseJSON($.dialog.data('data'));
            var content = 
            '<tr style="text-align:center;">'+
                '<td style="width:60px;border:solid 1px #d9d9d9;">服务者编码</td>'+
                '<td style="width:100px;border:solid 1px #d9d9d9;">GF账号</td>'+
                '<td style="width:100px;border:solid 1px #d9d9d9;">姓名</td>'+
                '<td style="width:100px;border:solid 1px #d9d9d9;">项目</td>'+
                '<td style="width:100px;border:solid 1px #d9d9d9;">服务者类型</td>'+
                '<td style="width:100px;border:solid 1px #d9d9d9;">冻结处理</td>'+
                '<td style="width:100px;border:solid 1px #d9d9d9;">冻结原因</td>'+
            '</tr>'+
            '<tr style="text-align:center;" class="add_len">'+
                '<input id="qualification_id" name="qualification_id" type="hidden" value="'+e.id+'">'+
                '<td style="border:solid 1px #d9d9d9;padding:5px;">'+e.gf_code+'</td>'+
                '<td style="border:solid 1px #d9d9d9;padding:5px;">'+e.gfaccount+'</td>'+
                '<td style="border:solid 1px #d9d9d9;padding:5px;">'+e.qualification_name+'</td>'+
                '<td style="border:solid 1px #d9d9d9;padding:5px;">'+e.project_name+'</td>'+
                '<td style="border:solid 1px #d9d9d9;padding:5px;">'+e.qualification_type+'</td>'+
                '<td style="border:solid 1px #d9d9d9;padding:5px;">'+
                    '<select id="if_del" name="if_del" >'+
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
        title:'添加冻结账号',
        content:add_html,
        button:[
            {
                name:'确定冻结',
                callback:function(){
                    if($("#if_del").val()==''){
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
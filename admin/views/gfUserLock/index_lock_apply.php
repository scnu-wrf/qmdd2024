
<div class="box">
    <div class="box-title c">
        <h1>
            <span>当前界面：系统》账号管理》申请冻结</span>
        </h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div>
    <div class="box-content">
        <div class="box-header">
            <a class="btn" onclick="add_member()">冻结会员</a>
            <!-- <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a> -->
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <!--<span>关键字：</span>-->
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="账号/昵称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list" style="text-align:left;">
                <thead>
                    <tr>
                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th >序号</th>
                        <!--<th >GF_ID</th>-->
                        <th ><?php echo $model->getAttributeLabel('GF_ACCOUNT');?></th>
                        <th ><?php echo $model->getAttributeLabel('GF_NAME');?></th>
                        <th ><?php echo $model->getAttributeLabel('user_state');?></th>
                        <th ><?php echo $model->getAttributeLabel('lock_reason');?></th>
                        <!-- <th >解冻方式</th> -->
                        <th>冻结处理</th>
                        <th>冻结状态</th>
                        <th>申请时间</th>
                        <th><?php echo $model->getAttributeLabel('admin_gfname'); ?></th>
                        <th>操作</th>

                        <!--<th ><?php //echo $model->getAttributeLabel('admin_gfid');?></th>
                        <th ><?php //echo $model->getAttributeLabel('uDate');?></th>-->
                      <!--<th >操作</th>-->
                    </tr>
                </thead>
                <tbody>
<?php
$index = 1;
//print_r($arclist);
foreach($arclist as $v){

?>
                    <tr>
                    <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->GF_ID); ?>"></td>
                        <td ><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <!--<td ><?php //echo $v->GF_ID; ?></td>-->
                        <td ><?php echo $v->GF_ACCOUNT; ?></td>
                        <td ><?php echo $v->GF_NAME; ?></td>
                        <td ><?php echo $v->user_state_name; ?></td>
                        <td ><?php echo $v->lock_reason; ?></td>
                        <!-- <td > -->
                            <?php
                                // if(is_null($v->remedy_btn)){
                                //     echo '';
                                // }elseif($v->remedy_btn==1){
                                //     echo '常规解冻';
                                // }elseif($v->remedy_btn==0){
                                //     echo '立即解冻';
                                // }
                            ?>
                        <!-- </td> -->
                        <td>冻结处理</td>
                        <td>冻结状态</td>
                        <td><?php echo $v->uDate; ?></td>
                        <td ><?php if(!empty($v->admin_gfid)) echo $v->admin_gfid.'/'.$v->admin_gfname; ?></td>
                        <td>
                            <?php
                                echo show_command('详情',$this->createUrl('update', array('id'=>$v->ID)));
                                if($model->user_state == 371) {
                                    echo '<a class="btn">撤销</a>';
                                }
                                echo show_command('删除','\''.$v->ID.'\'');
                            ?>
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
    var $lock_date_start=$('#lock_date_start,#start_date');
    var $lock_date_end=$('#lock_date_end,#end_date');
    $lock_date_start.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
    });
    $lock_date_end.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
    });
});
</script>
<script>

     // 每页全选
    $('#j-checkall').on('click', function(){
        var $this = $(this);
        var $temp1 = $('.check-item .input-check');
        var $temp2 = $('.box-table .list tbody tr');
        if($this.is(':checked')){
            $temp1.each(function(){
                this.checked = true;
            });
            $temp2.addClass('selected');
        }else{
            $temp1.each(function(){
                this.checked = false;
            });
            $temp2.removeClass('selected');
        }
    });

    var screen = document.documentElement.clientWidth;
   // var sc = screen-100;
    var add_html =
        '<div id="add_format" style="width:500px;">'+
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
        $.dialog.data('GF_ID', 0);
        $.dialog.open('<?php echo $this->createUrl("select/gfuser");?>',{
        id:'gfzhanghao',
        lock:true,opacity:0.3,
        width:'500px',
        // height:'60%',
        title:'选择冻结账号',
        close: function () {
            if($.dialog.data('GF_ID')>0){
                var content =
                '<tr style="text-align:center;">'+
                    '<td style="width:60px;border:solid 1px #d9d9d9;">账号</td>'+
                    '<td style="width:100px;border:solid 1px #d9d9d9;">昵称</td>'+
                    '<td style="width:100px;border:solid 1px #d9d9d9;">用户状态</td>'+
                    '<td style="width:100px;border:solid 1px #d9d9d9;">冻结原因</td>'+
                    // '<td style="width:100px;border:solid 1px #d9d9d9;">冻结开始时间</td>'+
                    // '<td style="width:100px;border:solid 1px #d9d9d9;">冻结结束时间</td>'+
                '</tr>'+
                '<tr style="text-align:center;" class="add_len">'+
                    '<input id="gf_id" name="gf_id" type="hidden" value="'+$.dialog.data('GF_ID')+'">'+
                    '<td style="border:solid 1px #d9d9d9;padding:5px;">'+$.dialog.data('GF_ACCOUNT')+'</td>'+
                    '<td style="border:solid 1px #d9d9d9;padding:5px;">'+$.dialog.data('GF_NAME')+'</td>'+
                    '<td style="border:solid 1px #d9d9d9;padding:5px;">'+
                        '<select id="user_state" name="user_state" >'+
                            // '<option value>请选择</option>'+
                            '<?php $base_code=BaseCode::model()->getReturn('1282,1283,507'); if(!empty($base_code))foreach($base_code as $ba){?>'+
                                '<option value="<?php echo $ba->f_id; ?>"';if(<?php echo $ba->f_id ?>==$.dialog.data('user_state')){content+='selected="selected"';};content+='><?php


                                //if($ba->f_id==506){ //不显示"正常"状态的数据

                                //}else{
                                echo $ba->F_NAME;
                                //}





                                ?></option>'+
                            '<?php }?>'+
                        '</select>'+
                    '</td>'+
                    '<td style="border:solid 1px #d9d9d9;padding:5px;">'+
                        '<textarea class="input-text" id="lock_reason" name="lock_reason"></textarea>'+
                    '</td>'+
                    // '<td style="border:solid 1px #d9d9d9;padding:5px;">'+$.dialog.data('lock_date_start')+'</td>'+
                    // '<td style="border:solid 1px #d9d9d9;padding:5px;">'+$.dialog.data('lock_date_end')+'</td>'+
                '</tr>';
                $("#table_tag tbody").remove();
                $("#table_tag").append(content);
                if_data=1;
            }
         }
       });
    }
    // onchange="myFunction(this,this.options[this.options.selectedIndex].value)"
    // var date1 = new Date(),
    // time1=date1.getFullYear()+"-"+(date1.getMonth()+1)+"-"+date1.getDate();//time1表示当前时间
    // function myFunction(e,n){
    //     if(n==1282){
    //         console.log(fun_date(7))
    //         $(e).parent().next().html(time1);
    //         $(e).parent().next().next().html(fun_date(7));
    //     }else if(n==1283){
    //         $(e).parent().next().html(time1);
    //         $(e).parent().next().next().html(fun_date(30));
    //     }else if(n==507){
    //         $(e).parent().next().html(time1);
    //         $(e).parent().next().next().html('9999-09-09');
    //     }else{
    //         $(e).parent().next().html('0000-00-00');
    //         $(e).parent().next().next().html('0000-00-00');
    //     }
    // }
    // function fun_date(day){
    //     var date2 = new Date(date1);
    //     date2.setDate(date1.getDate()+day);
    //     var time2 = date2.getFullYear()+"-"+
    //     (date2.getMonth()+1)+"-"+date2.getDate();
    //     return time2;
    // }
    function add_member(){
        if_data=0;
        $.dialog({
            id:'tianjia',
            lock:true,
            opacity:0.3,
            height: '60%',
            // width:'80%',
            title:'冻结会员',
            content:add_html,
            button:[
                {
                    name:'提交审核',

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

    function click_li() {
        window.location.href="<?php echo $this->createUrl('gfUser1/index_thaw',array()); ?>";
    }
</script>
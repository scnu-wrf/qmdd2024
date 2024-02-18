
<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播》直播预约》<a class="nav-a">直播预约列表</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end--> 
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>直播名称：</span>
                    <input style="width:200px;" class="input-text" type="text" name="live_title" value="<?php echo Yii::app()->request->getParam('live_title');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>节目名称：</span>
                    <input style="width:200px;" class="input-text" type="text" name="programs_title" value="<?php echo Yii::app()->request->getParam('programs_title');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="节目单号 / 直播编号" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-search" style="position: relative;border-top: solid 1px #d9d9d9;padding: 15px 0;">
            <a id="j-sele" class="btn" href="javascript:;" onclick="" style="margin-left:10px;" value="1">全选</a>
            <input id="info_id" type="hidden">
            <a class="btn" href="javascript:;" onclick="send('.check-item input:checked')" >发送通知</a>
           
        </div><!--box-search2 end-->
        <div class="box-table">
        	<table class="list">
                	<tr class="table-title">
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                    	<th style='text-align:center;'>序号</th>
                        <th><?php echo $model->getAttributeLabel('gfid');?></th>
                        <th>直播名称</th>
                        <th>节目单号</th>
                        <th>节目单名称</th>
                        <th>直播时间</th>
                        <th>直播开始倒计时</th>
                        <th><?php echo $model->getAttributeLabel('remind_state');?></th>
                        <th>操作</th>
                    </tr>
                    <?php $index = 1;
					 if(is_array($arclist)) foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                    	<td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php if(!empty($v->user)) echo $v->user->GF_ACCOUNT.'/'.$v->user->ZSXM;; ?></td>
                        <td><?php if(!empty($v->programs)) if(!empty($v->programs->video_live)) echo $v->programs->video_live->title; ?></td>
                        <td><?php if(!empty($v->programs)) echo $v->programs->program_code; ?></td>
                        <td><?php if(!empty($v->programs)) echo $v->programs->title; ?></td>
                        <td><?php if(!empty($v->programs)){ echo $v->programs->program_time.'<br>'.$v->programs->program_end_time;} ?></td>
                        <td><?php if(!empty($v->programs) && !empty($v->programs->program_time)){
                        $time1 = strtotime(date("Y-m-d H:i:s"));
                        //$now_m=date("Y-m-d H:i:s",strtotime("+7 day",strtotime($v->uDate)));
                        $time2 = strtotime($v->programs->program_time);
                        $all=$time2-$time1;
                        $days=floor($all/86400);
                        $all1=$all-($days*86400);
                        $hours=floor($all1/3600);
                        $all2=$all1-($hours*3600);
                        $minus=floor($all2/60);
                        $sec=$all2%60;
                         echo ($time2>$time1) ? $days.'天'.$hours.'时'.$minus.'分'.$sec.'秒' : '正在直播';} ?></td>
                        <td><?php if(!empty($v->base_code)) echo $v->base_code->F_NAME; ?></td>
                        <td>
                            <a class="btn" href="javascript:;" onclick="fnSending(<?php echo $v->id;?>);" title="发送通知">通知</a>
                        </td>
                    </tr>
                   <?php $index++; } ?>
                </table>
                 
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
function send(op){
       var str = '';
       var arr=[];
       $(op).each(function() {
            arr.push($(this).val());
        });
       str=we.implode(',', arr);
        if(str.length<1){
            we.msg('minus','请选中要通知的用户');
            return false;
        }
        //console.log(str);
        fnSending(str);
        
}
// 发送通知
var fnSending=function(send_id){
    var html='<div style="width:500px;">'+
    '<table class="box-detail-table showinfo">'+
        '<tr>'+
            '<td width="15%">通知类型</td>'+
            '<td><select id="dialog_type"><?php if(is_array($remind_type)) foreach($remind_type as $v){?><option value="<?php echo $v->f_id;?>"><?php echo $v->F_NAME;?></option><?php }?></select></td>'+
        '</tr>'+
        '<tr>'+
            '<td width="15%">通知内容</td>'+
            '<td><textarea id="dialog_content" class="input-text"></textarea></td>'+
        '</tr>'+
    '</table>'+
    '</div>';
    $.dialog({
        id:'tongzhi',
        lock:true,
        opacity:0.3,
        title:'发送通知',
        content:html,
        button:[
            {
                name:'发送通知',
                callback:function(){
                    we.loading('show');
                    $.ajax({
                        type: 'post',
                        url: '<?php echo $this->createUrl('gfidsending');?>',
                        data: {id:send_id, msg:$('#dialog_content').val(), type:$('#dialog_type').val()},
                        dataType: 'json',
                        success: function(data) {
                            if(data.status==1){
                                $.dialog.list['tongzhi'].close();
                                we.success(data.msg, data.redirect);
                            }else{
                                we.loading('hide');
                                we.msg('minus', data.msg);
                            }
                        }
                    });
                    return false;
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
};
// 总页全选
    $("#j-sele").on('click', function(){
        var $temp1 = $('.list .input-check');
        var $temp2 = $('.box-table .list tbody tr');
        var $this = $(this);
        mArr=[];
        if($this.attr("value")=='1'){
            value=0;
            $this.attr("value",value).text('取消全选');
            $temp1.each(function(){
                this.checked = true;
            });
            $temp2.addClass('selected');
            $.each(arr_index,function(k,info){
                mArr.push(info.id);
            })
        }else{
            value=1;
            $this.attr("value",value).text('全选');
            $temp1.each(function(){
                this.checked = false;
            });
            $temp2.removeClass('selected');
            mArr=[];
        }
    });
//单页全选
$(function() {
var $this, $temp1 = $('.check-item .input-check'), $temp2 = $('.box-table .list tbody tr');
    $('#j-checkall').on('click', function() {
        $this = $(this);
        if ($this.is(':checked')) {
            $temp1.each(function() {
                if(this.disabled!=true){
                    this.checked = true;
                }
            });
            $temp2.addClass('selected');
        } else {
            $temp1.each(function() {
                this.checked = false;
            });
            $temp2.removeClass('selected');
        }
    });

    $temp1.each(function() {
        $this = $(this);
        if ($this.is(':checked')) {
            $this.parent().parent().addClass('selected');
        } else {
            $this.parent().parent().removeClass('selected');
        }
    });

    $temp1.on('click', function() {
        $this = $(this);
        if ($this.is(':checked')) {
            $this.parent().parent().addClass('selected');
        } else {
            $this.parent().parent().removeClass('selected');
        }
    });


});

    

</script>

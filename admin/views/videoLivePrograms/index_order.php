
<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播》直播预约》<a class="nav-a">直播群发通知</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end--> 
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="节目单号 / 节目名称 / 直播名称" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                	<tr class="table-title">
                    	<th style='text-align: center;'>序号</th>
                        <th>直播编号</th>
                        <th><?php echo $model->getAttributeLabel('live_id');?></th>
                        <th><?php echo $model->getAttributeLabel('title');?></th>
                        <th><?php echo $model->getAttributeLabel('program_time');?></th>
                        <td>预约人</td>
                        <td>状态</td>
                        <th>操作</th>
                    </tr>
                    <?php $index = 1;
					 if(is_array($arclist)) foreach($arclist as $v){ ?>
                    <tr>
                    	<td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php if(!empty($v->video_live)) echo $v->video_live->code; ?></td>
                        <td><?php if(!empty($v->video_live)) echo $v->video_live->title; ?></td>
                        <td><?php echo $v->title; ?></td>
                        <td><?php echo $v->program_time; ?><br><?php echo $v->program_end_time; ?></td>
            <?php $num=PersonalCollection::model()->count('news_type=863 and news_id='.$v->id); ?>
                        <td><?php echo $num; ?></td>
            <?php $num2=LiveMessage::model()->count('m_type=315 and r_gfid=0 and live_program_id='.$v->id); ?>
                        <td><?php echo ($num2>0) ? '已通知' : '待通知'; ?></td>
                        <td>
                            <a class="btn" href="javascript:;" onclick="fnSending(<?php echo $v->id;?>);" title="发送通知">通知</a>
                            <a class="btn" href="javascript:;" onclick="fnLog(<?php echo $v->id;?>);" title="查看预约会员">查看预约会员</a>
                        </td>
                    </tr>
                   <?php $index++; } ?>
                </table>
                 
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    // 查看预约会员
var fnLog=function(detail_id){
    $.dialog.open('<?php echo $this->createUrl("orderlog");?>&detail_id='+detail_id,{
        id:'yuyvehuiyuan',
        lock:true,
        opacity:0.3,
        title:'查看预约会员',
        width:'95%',
        height:'95%',
        close: function () {}
    });
};
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
                        url: '<?php echo $this->createUrl('sending');?>&id='+send_id,
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
</script>

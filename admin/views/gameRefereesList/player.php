<?php
    check_request('game_id',0);
    check_request('project_id',0);
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：》赛事/排名 》赛事成员 》赛事裁判报名</h1>
        <span style="float:right;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create'),'添加'); ?>
        </div>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>赛事名称：</span>
                    <?php echo downList($game_id,'id','game_title','game_id','id="game_id" onchange="changeGameid(this);"'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>项目名称：</span>
                    <select name="project_id" id="project_id">
                        <option value="">请选择</option>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>申请日期：</span>
                    <input style="width:200px;" type="text" class="input-text" name="star_time" id="star_time" value="<?php echo $star_time; ?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
                <span style="margin-left:20px;">
                    <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
                </span>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style='text-align: center;' class="list-id">序号</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('project_id');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('referee_gfaccount');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('real_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('agree_state');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('send_date1');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td style="text-align: center;" class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style="text-align: center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style="text-align: center;"><?php echo $v->game_name; ?></td>
                        <td style="text-align: center;"><?php echo $v->project_name; ?></td>
                        <td style="text-align: center;"><?php echo $v->referee_gfaccount; ?></td>
                        <td style="text-align: center;"><?php echo $v->real_name; ?></td>
                        <td style="text-align: center;"><?php echo $v->agree_state_name; ?></td>
                        <td style="text-align: center;"><?php echo $v->send_date; ?></td>
                        <td style="text-align: center;">
                            <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'game_id'=>$v->game_id,'data_id'=>$v->sign_game_data_id))); ?>
                            <?php echo show_command('删除','\''.$v->id.'\''); ?>
                        </td>
                    </tr>
                    <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content || gamesign-lt end-->
</div><!--box end-->
<script>
    $(function(){
        var $star_time=$('#star_time');
        // var $end_time=$('#end_time');
        $star_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
        // $end_time.on('click', function(){
        //     WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});
        // });
    });

    var deleteUrl = '<?php echo $this->createUrl('delete',array('id'=>'ID')); ?>';
    changeGameid($('#game_id'));
    function changeGameid(obj){
        var obj = $(obj).val();
        var s_html = '<option value>请选择</option>';
        if(obj > 0){
            var pr = '<?php echo $_REQUEST['project_id']; ?>';
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('data_id'); ?>&game_id='+obj,
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    for(var i=0;i<data[1].length;i++){
                        s_html += '<option value="'+data[1][i]['project_id']+'" '+((data[1][i]['project_id']==pr) ? 'selected>' : '>')+data[1][i]['project_name']+'</option>';
                    }
                    $('#project_id').html(s_html);
                }
            });
        }
        else{
            $('#project_id').html(s_html);
        }
    }
</script>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名 》积分管理 》龙虎置换排名积分确认 <?= !empty($_REQUEST['state'])?'》待确认':'';?></h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;&nbsp;
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header" >
            <?php if(empty($_REQUEST['state'])){?>
                    <span class="exam" onclick="on_exam();"><p>待确认：(<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span>)</p></span>
            <?php }else{ ?>
                <a class="btn btn-blue" href="javascript:;" onclick="checkval('.check-item input:checked');">确认积分</a>
            <?php } ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="state" id="state" value="<?php echo Yii::app()->request->getParam('state');?>">
                
                <label style="margin-right:10px;">
                    <span>确认日期：</span>
                    <input style="width:100px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                    <span>-</span>
                    <input style="width:100px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                </label>
                <label>
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入GF账号/姓名">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input type="checkbox" id="j-checkall" class="input-check"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('GF_ACCOUNT') ?></th>
                        <th><?php echo $model->getAttributeLabel('ZSXM') ?></th>
                        <th><?php echo $model->getAttributeLabel('project_id') ?></th>
                        <th><?php echo $model->getAttributeLabel('get_type') ?></th>
                        <th><?php echo $model->getAttributeLabel('get_score_game_reson') ?></th>
                        <th>排名积分</th>
                        <th><?php echo $model->getAttributeLabel('state') ?></th>
                        <?php if(empty($_REQUEST['state'])){?>
                            <th><?php echo $model->getAttributeLabel('audit_time') ?></th>
                        <?php } ?>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo $index; ?></td>
                        <td><?php echo $v->gfUser->GF_ACCOUNT; ?></td>
                        <td><?php echo $v->gfUser->ZSXM; ?></td>
                        <td><?php if(!is_null($v->projectList))echo $v->projectList->project_name; ?></td>
                        <td><?php if(!is_null($v->getType))echo $v->getType->F_NAME; ?></td>
                        <td><?php echo $v->get_score_game_reson; ?></td>
                        <td><?php echo $v->get_score; ?></td>
                        <td><?php echo $v->state==371?'待确认':'已确认'; ?></td>
                        <?php if(empty($_REQUEST['state'])){?>
                            <td><?php echo $v->audit_time; ?></td>
                        <?php } ?>
                        <td>
                            <?php echo show_command('审核',$this->createUrl('update_verify', array('id'=>$v->id))); ?>
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
    
    function on_exam(){
        var exam = $('.exam p span').text();
        if(exam>0){ 
            $('#state').val(371);
            $('.box-search select').html('<option value>请选择</option>');
            $('.box-search .input-text').val('');
            document.getElementById('submit_button').click();
        }
    }

    var $start_time=$('#start_date');
    var $end_time=$('#end_date');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
         WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    
    // 每页全选
    $('#j-checkall').on('click', function(){
        $temp1 = $('.check-item .input-check');
        $temp2 = $('.box-table .list tbody tr');
        $this = $(this);
        if($this.is(':checked')){
            $temp1.each(function(){
                this.checked = true;
            });
            $temp2.addClass('selected');
        }
        else{
            $temp1.each(function(){
                this.checked = false;
            });
            $temp2.removeClass('selected');
        }
    });

    // 获取所有选中多选框的值
    checkval = function(op,num){
        // console.log(op)
        if(num=='one'){
            var str = op;
        }else{
            var str = '';
            $(op).each(function() {
                str += $(this).val() + ',';
            });
        }
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        if(str.length<1){
            we.msg('minus','请先选中要确认的数据');
            return false;
        }
        var an = function(){
            confirmed(str);
        }
        $.fallr('show', {
            buttons: {
                button1: {text: '确定', danger: true, onclick: an},
                button2: {text: '取消'}
            },
            content: '是否确认？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });
    };

    // 确认操作
    function confirmed(id){
        console.log(id)
        we.loading('show');
        $.ajax({
            type:'post',
            url:'<?php echo $this->createUrl('confirmed'); ?>&id='+id,
            // data:{id:id},
            dataType:'json',
            success: function(data){
                we.loading('hide');
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                }else{
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }
</script>
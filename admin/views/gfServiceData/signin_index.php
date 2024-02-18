<?php
    check_request('sign_on',1);
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约 》服务签到 》签到管理<?php if($_REQUEST['sign_on']>1) echo ($_REQUEST['sign_on']==2) ? ' 》待签到' : ' 》未签到'; ?></h1>
        <span class="back">
            <?php if($_REQUEST['sign_on']>1) {?>
                <a class="btn" href="<?php echo $this->createUrl('signin_index',array('keywords'=>$keywords,'servic_time_star'=>$startDate,'servic_time_end'=>$endDate)); ?>">返回上一层</a>
            <?php }?>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <?php if($_REQUEST['sign_on']==1) {?>
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('signin_index',array('keywords'=>$keywords,'servic_time_star'=>$startDate,'servic_time_end'=>$endDate,'sign_on'=>2)); ?>">待签到：<?php echo $count1; ?></a>
            <a class="btn" href="<?php echo $this->createUrl('signin_index',array('keywords'=>$keywords,'servic_time_star'=>$startDate,'servic_time_end'=>$endDate,'sign_on'=>3)); ?>">未签到：<?php echo $count2; ?></a>
            <a class="btn" href="<?php echo $this->createUrl('qmddServiceAuthorization/index_move',array('back_url'=>base64_encode(json_encode(array('keywords'=>$keywords,'servic_time_star'=>$startDate,'servic_time_end'=>$endDate))))); ?>">动动约签到授权</a>
        </div>
    <?php }?>
    <div /*class="box-content"*/ >
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="sign_on" value="<?php echo $_REQUEST['sign_on'];?>">
                <label style="margin-right:10px;">
                    <span><?php echo ($_REQUEST['sign_on']==1) ? '签到' : '服务'; ?>日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="servic_time_star" name="servic_time_star" value="<?php echo $startDate;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="servic_time_end" name="servic_time_end" value="<?php echo $endDate;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>服务类别：</span>
                    <?php echo downList($t_stypeid,'id','f_uname','t_stypeid'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>项目：</span>
                    <?php echo downList($project_id,'id','project_name','project_id'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="服务流水号/订单号/预订人/联系电话">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <?php if($_REQUEST['sign_on']>1) {?>
            <div class="box-header">
                <label for="j-checkall" style="margin-right:20px;">
                    <span class="btn"><input id="j-checkall" class="input-check" type="checkbox">全选</span>
                </label>
                <?php if($_REQUEST['sign_on']==2) {?>
                    <!-- <a class="btn btn-blue" href="javascript:;" onclick="sending_notice(we.checkval('.check-item input:checked'));" style="vertical-align: middle;margin-right:10px;">一键发送通知</a> -->
                    <a class="btn btn-blue" href="javascript:;" onclick="save_Sourcer(we.checkval('.check-item input:checked'),1);" style="vertical-align: middle;margin-right:10px;">一键签到</a>
                <?php }else{?>
                    <a class="btn btn-blue" href="javascript:;" onclick="save_Sourcer(we.checkval('.check-item input:checked'),3);" style="vertical-align: middle;margin-right:10px;">一键补签</a>
                    <a class="btn btn-blue" href="javascript:;" onclick="save_invalid(we.checkval('.check-item input:checked'));" style="vertical-align: middle;margin-right:10px;">一键失效</a>
                <?php }?>
            </div>
        <?php }?>
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <?php if($_REQUEST['sign_on']==2) {?>
                            <th class="check"></th>
                        <?php }?>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('t_stypename');?></th>
                        <th><?php echo $model->getAttributeLabel('server_name_frontEnd');?></th>
                        <th><?php echo $model->getAttributeLabel('order_num1').'/'.$model->getAttributeLabel('order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('project_name');?></th>
                        <th><?php echo $model->getAttributeLabel('service_resources');?></th>
                        <th><?php echo $model->getAttributeLabel('service_data_name');?></th>
                        <!-- <th><?php //echo $model->getAttributeLabel('data_name');?></th> -->
                        <th><?php echo $model->getAttributeLabel('gf_name');?></th>
                        <th><?php echo $model->getAttributeLabel('contact_phone');?></th>
                        <?php if($_REQUEST['sign_on']==1) {?>
                        <th><?php echo $model->getAttributeLabel('sign_come');?></th>
                        <?php }?>
                        <th><?php echo $model->getAttributeLabel('sign_code');?></th>
                        <th><?php echo ($_REQUEST['sign_on']==1) ? $model->getAttributeLabel('is_invalid') : '操作';?></th>
                        <?php if($_REQUEST['sign_on']==1) {?>
                            <th><?php echo $model->getAttributeLabel('adminid2'); ?></th>
                        <?php }?>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <?php if($_REQUEST['sign_on']==2) {?>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo $v->id; ?>"></td>
                        <?php }?>
                        <td><?php echo $index ?></td>
                        <td><?php echo $v->t_stypename; ?></td>
                        <td><?php echo $v->service_name; ?></td>
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php echo $v->project_name; ?></td>
                        <td><?php echo $v->service_name; ?></td>
                        <td><?php echo substr($v->servic_time_star,0,10).' '.substr($v->servic_time_star,11,-3).'-'.substr($v->servic_time_end,11,-3);?></td>
                        <!-- <td><?php //echo $v->data_name; ?></td> -->
                        <td><?php echo $v->gf_account.' / '.$v->gf_name; ?></td>
                        <td><?php echo $v->contact_phone; ?></td>
                        <?php if($_REQUEST['sign_on']==1) {?>
                        <td>
                            <?php 
                                if($v->sign_come==null){
                                    if(strtotime($v->servic_time_star)<time()){
                                        echo '未签到';
                                    }
                                }else{
                                    $left = substr($v->sign_come,0,10);
                                    $right = substr($v->sign_come,11);
                                    echo $left.'<br>'.$right;
                                } 
                            ?>
                        </td>
                        <?php }?>
                        <td><?php echo $v->sign_code; ?></td>
                        <td>
                            <?php
                                if($_REQUEST['sign_on']==1){
                                    if($v->is_invalid==1){
                                        if($v->sign_come!=null || $v->sign_come>'0000-00-00 00:00:01') echo '已签到';
                                    }
                                    elseif($v->is_invalid==2) echo '失效';
                                    else echo '补签';
                                }
                                elseif($_REQUEST['sign_on']==2){
                                    // echo '<a class="btn" onClick="sending_notice('.$v->id.');" href="javascript:;">发送通知</a>';
                                    // echo '&nbsp;';
                                    echo '<a class="btn" onClick="save_Sourcer('.$v->id.',1);" href="javascript:;">签到</a>';
                                }
                                else{
                                    echo '<a class="btn" onClick="save_Sourcer('.$v->id.',3);" href="javascript:;">补签</a>';
                                    echo '&nbsp;';
                                    echo '<a class="btn" onClick="save_invalid('.$v->id.');" href="javascript:;">失效</a>';
                                }
                            ?>
                        </td>
                        <?php if($_REQUEST['sign_on']==1) {?>
                            <td><?php if(!empty($v->admin_list)) echo $v->admin_list->admin_gfaccount; if(!empty($v->admin_name)) echo '/'.$v->admin_name; ?></td>
                        <?php }?>
                    </tr>
                <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>
<script>
    $(function(){
        var $servic_time_star=$('#servic_time_star');
        var $servic_time_end=$('#servic_time_end');
        $servic_time_star.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
        $servic_time_end.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
    });

    // 每页全选
    $('#j-checkall').on('click', function() {
        $temp1 = $('.check-item .input-check');
        $temp2 = $('.box-table .list tbody tr');
        $this = $(this);
        if($this.is(':checked')) {
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

    // 签到服务
    function save_Sourcer(id,val){
        if(id==''){
            we.msg('minus','请选择要签到的数据');
            return false;
        }
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('save_Sourcer');?>&id='+id+'&is_invalid='+val,
            dataType: 'json',
            success: function(data) {
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                }
                else{
                    we.msg('minus', data.msg);
                }
            },
            error: function(request){
                console.log(request);
            }
        });
        return false;
    }

    // 发送通知
    function sending_notice(id){
        if(id==''){
            we.msg('minus','请选择要通知的人');
            return false;
        }
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('sending_notice'); ?>&id='+id,
            dataType: 'json',
            success: function(data){
                if(data==1){
                    we.msg('check','发送成功');
                }
            },
            error: function(request){
                we.msg('minus','操作失败');
                console.log(request);
            }
        })
    }

    // 失效操作
    function save_invalid(id){
        if(id==''){
            we.msg('minus','请选择要操作的数据');
            return false;
        }
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('save_invalid'); ?>&id='+id,
            dataType: 'json',
            success: function(data){
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                }
                else{
                    we.msg('minus', data.msg);
                }
            },
            error: function(request){
                we.msg('minus','操作失败');
                console.log(request);
            }
        })
    }
</script>
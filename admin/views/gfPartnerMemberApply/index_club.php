<?php// var_dump($_REQUEST);?>
<div class="box">
    <div class="box-title c">
        <h1><?php if($_REQUEST['index']=='1'){?>当前界面：首页 》单位入会管理 》入会单位列表<?php }elseif($_REQUEST['index']=='2'){?>当前界面：首页 》单位入会管理 》取消/审核未通过<?php }elseif($_REQUEST['index']=='3'){?>当前界面：首页》单位入会管理》入会待审核<?php }elseif($_REQUEST['index']=='4'){?>当前界面：首页 》单位入会管理 》退会列表<?php }?></h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <?php if($_REQUEST['index']==1){?>
            <div class="box-header">
                <?php echo $_REQUEST['index']==1?show_command('添加',$this->createUrl('create_club',array('type'=>$_REQUEST['type'])),'添加'):''; ?>
            </div><!--box-header end-->
        <?php }?>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="index" id="index" value="<?php echo Yii::app()->request->getParam('index');?>">
                <input type="hidden" name="state" id="state" value="<?php echo Yii::app()->request->getParam('state');?>">
                <input type="hidden" name="type" value="<?php echo Yii::app()->request->getParam('type');?>">
				<!-- <label style="margin-right:20px;">
                    <span>会员类型：</span>
                    <?php //echo downList($type,'f_id','F_NAME','type'); ?>
                </label> -->
				<label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php echo downList($project_list,'id','project_name','project_id'); ?>
                </label>
                <?php if($_REQUEST['index']==1){?>
                    <label style="margin-right:10px;">
                        <span>入会时间：</span>
                        <input style="width:120px;" class="input-text" type="text" id="effective_start_time" name="effective_start_time" value="<?php echo Yii::app()->request->getParam('effective_start_time');?>">
                        <span>-</span>
                        <input style="width:120px;" class="input-text" type="text" id="effective_end_time" name="effective_end_time" value="<?php echo Yii::app()->request->getParam('effective_end_time');?>">
                    </label>
                <?php }?>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入编号/单位">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
                <!-- <button class="btn btn-blue" type="button" onclick="javascript:excel();" >导出</button> -->
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <?php if($_REQUEST['index']==1){?>
                            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('partner_id');?></th>
                            <th>单位类型</th>
                            <th>加入项目</th>
                            <th><?php echo $model->getAttributeLabel('code');?></th>
                            <th><?php echo $model->getAttributeLabel('entry_validity');?></th>
                            <th>联系人</th>
                            <th>联系电话</th>
                            <th><?php echo $model->getAttributeLabel('auth_state');?></th>
                            <th>操作</th>
                        <?php }elseif($_REQUEST['index']==2){?>
                            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('partner_id');?></th>
                            <th>单位类型</th>
                            <th>加入项目</th>
                            <th>联系人</th>
                            <th>联系电话</th>
                            <th><?php echo $model->getAttributeLabel('state');?></th>
                            <th>操作时间</th>
                            <th>操作</th>
                        <?php }elseif($_REQUEST['index']==3){?>
                            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('partner_id');?></th>
                            <th>单位类型</th>
                            <th>加入项目</th>
                            <th>联系人</th>
                            <th>联系电话</th>
                            <th>入会方式</th>
                            <th><?php echo $model->getAttributeLabel('auth_state');?></th>
                            <th>申请日期</th>
                            <th>操作</th>
                        <?php }elseif($_REQUEST['index']==4){?>
                            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('partner_id');?></th>
                            <th>单位类型</th>
                            <th>加入项目</th>
                            <th><?php echo $model->getAttributeLabel('code');?></th>
                            <th>联系人</th>
                            <th>联系电话</th>
                            <th><?php echo $model->getAttributeLabel('auth_state');?></th>
                            <th><?php echo $model->getAttributeLabel('apply_relieve_time');?></th>
                            <th><?php echo $model->getAttributeLabel('relieve_time');?></th>
                            <th>操作</th>
                        <?php }?>
                    </tr>
                </thead>
                <tbody>
<?php 
    $index = 1;
    foreach($arclist as $v){ 
?>
                    <tr>
                        <?php if($_REQUEST['index']==1){?>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->partner_name; ?></td>
                            <td><?php echo $v->partner_club->club_type_name; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php echo $v->code; ?></td>
                            <td><?php echo date('Y-m-d H:i:s',strtotime($v->entry_validity));?></td>
                            <td><?php echo $v->zsxm; ?></td>
                            <td><?php echo $v->apply_phone; ?></td>
                            <td><?php echo $v->auth_state_name; ?></td>
                            <td>
                                <?php echo show_command('修改',$this->createUrl('update_club', array('id'=>$v->id,'type'=>$v->type))); ?>
                                <?php if($v->state==372&&$v->auth_state==931){?>
                                    <a class="btn" href="javascript:;" onclick="unuse('<?php echo $v->id;?>', unuseUrl);" title="退会">退会</a>
                                <?php }elseif($v->state==372&&$v->auth_state==1485){?>
                                    <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $v->id;?>', cancelUrl2);" title="撤销">撤销</a>
                                <?php }?>
                            </td>
                        <?php }elseif($_REQUEST['index']==2){?>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->partner_name; ?></td>
                            <td><?php echo $v->partner_club->club_type_name; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php echo $v->zsxm; ?></td>
                            <td><?php echo $v->apply_phone; ?></td>
                            <td>  
                                <?php 
                                    if($v->state==374){
                                        echo $v->state_name; 
                                    }else{
                                        echo $v->invite_initiator==210?'拒绝申请':'拒绝邀请'; 
                                    }
                                ?>    
                            </td>
                            <td><?php echo date('Y-m-d H:i:s',strtotime($v->update));?></td>
                            <td>
                                <?php echo show_command('修改',$this->createUrl('update_club', array('id'=>$v->id,'type'=>$v->type))); ?>
                            </td>
                        <?php }elseif($_REQUEST['index']==3){?>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->partner_name; ?></td>
                            <td><?php echo $v->partner_club->club_type_name; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php echo $v->zsxm; ?></td>
                            <td><?php echo $v->apply_phone; ?></td>
                            <td><?php echo $v->invite_initiator==502?'邀请入会':'申请入会'; ?></td>
                            <td><?php echo $v->auth_state_name; ?></td>
                            <td><?php echo date('Y-m-d H:i:s',strtotime($v->apply_time));?></td>
                            <td>
                                <?php echo show_command('修改',$this->createUrl('update_club', array('id'=>$v->id,'type'=>$v->type))); ?>
                                <?php if($v->auth_state==929){ ?>
                                    <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $v->id;?>', cancelUrl);" title="撤销">撤销</a>
                                <?php } ?>
                            </td>
                        <?php }elseif($_REQUEST['index']==4){?>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->partner_name; ?></td>
                            <td><?php echo $v->partner_club->club_type_name; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php echo $v->code; ?></td>
                            <td><?php echo $v->zsxm; ?></td>
                            <td><?php echo $v->apply_phone; ?></td>
                            <td><?php echo $v->auth_state_name; ?></td>
                            <td><?php echo $v->apply_relieve_time;?></td>
                            <td><?php echo $v->relieve_time;?></td>
                            <td>
                                <?php echo show_command('修改',$this->createUrl('update_club', array('id'=>$v->id,'type'=>$v->type))); ?>
                                <?php if($v->state==372&&$v->auth_state==1485){?>
                                    <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $v->id;?>', cancelUrl2);" title="撤销">撤销</a>
                                <?php }?>
                            </td>
                        <?php }?>
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
    var unuseUrl = '<?php echo $this->createUrl('unuse', array('id'=>'ID','new'=>'auth_state','del'=>1485));?>';
    var cancelUrl = '<?php echo $this->createUrl('cancel', array('id'=>'ID','new'=>'state','del'=>374));?>';
    var cancelUrl2 = '<?php echo $this->createUrl('cancel', array('id'=>'ID','new'=>'auth_state','del'=>931));?>';
    var unuse = function(id, url) {
        we.overlay('show');
        if (id == '' || id == undefined) {
            we.msg('error', '请选择要申请退出的单位', function() {
                we.loading('hide');
            });
            return false;
        }
        var fnUnuse = function() {
            url = url.replace(/ID/, id);
            console.log(url)
            $.ajax({
                type: 'get',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 1) {
                        we.msg('check', data.msg, function() {
                            we.loading('hide');
                            we.reload();
                        });
                    } else {
                        we.msg('error', data.msg, function() {
                            we.loading('hide');
                        });
                    }
                }
            });
        };
        $.fallr('show', {
            buttons: {
                button1: {text: '申请退出', danger: true, onclick: fnUnuse},
                button2: {text: '取消'}
            },
            content: '确定申请退出？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });
    };

    $(function(){
        var $effective_start_time=$('#effective_start_time');
        var $effective_end_time=$('#effective_end_time');
        $effective_start_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
        $effective_end_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
    });

    function on_exam(){
        var exam = $('.exam p span').text();
        if(exam>0){ 
            $('#state').val(371);
            $('#index').val('');
            $('.box-search select').html('<option value>请选择</option>');
            $('.box-search .input-text').val('');
            document.getElementById('submit_button').click();
        }
    }

    function excel(){
        $("#is_excel").val(1);
        $("#submit_button").click();
        $("#is_excel").val(0);
    }
</script>
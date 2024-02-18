
<div class="box">
    <div class="box-title c">
        <h1>
            当前界面：系统 》体育豆 》
            <?php 
                if($_REQUEST['index']==1){
                    echo '体育豆赠送管理';
                }elseif($_REQUEST['index']==2){
                    echo '体育豆赠送待审核';
                }elseif($_REQUEST['index']==3){
                    echo '体育豆赠送审核';
                }elseif($_REQUEST['index']==4){
                    echo '体育豆赠送审核 》待审核';
                }elseif($_REQUEST['index']==5){
                    echo '体育豆赠送列表';
                }elseif($_REQUEST['index']==6){
                    echo '赠送审核未通过列表';
                }
            ?>
        </h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <?php if($_REQUEST['index']==1){?>
            <div class="box-header">
                <?php echo show_command('添加',$this->createUrl('create',['index'=>1]),'添加'); ?>
                <?php echo show_command('批删除','','删除'); ?>
            </div><!--box-header end-->
        <?php }elseif($_REQUEST['index']==3){ ?>
            <div class="box-header">
                <span class="exam" onclick="on_exam();"><p>待审核：(<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span>)</p></span>
            </div><!--box-header end-->
        <?php } ?>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="index" id="index" value="<?php echo Yii::app()->request->getParam('index');?>">
                <input type="hidden" name="state" id="state" value="<?php echo Yii::app()->request->getParam('state');?>">
                <?php if($_REQUEST['index']==3||$_REQUEST['index']==5){?>
                    <label style="margin-right:10px;">
                        <span><?= $_REQUEST['index']==5?'日期：':'审核日期：'?></span>
                        <input style="width:80px;" class="input-text" type="text" placeholder="" id="start_date" name="start_date" value="<?php echo $start_date; ?>">
                        <span>-</span>
                        <input style="width:80px;" class="input-text" type="text" placeholder="" id="end_date" name="end_date" value="<?php echo $end_date; ?>">
                    </label>
                <?php }?>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入方案编号/名称/审批人" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <thead>
                <table class="list">
                    <tr>
                        <?php if($_REQUEST['index']==1){ ?>
                            <th class="check"><input type="checkbox" id="j-checkall" class="input-check"></th>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('code');?></th>
                            <th><?php echo $model->getAttributeLabel('name');?></th>
                            <th><?php echo $model->getAttributeLabel('f_username');?></th>
                            <th>赠送会员</th>
                            <th>赠送体育豆总数</th>
                            <th><?php echo $model->getAttributeLabel('remark');?></th>
                            <th><?php echo $model->getAttributeLabel('state_name');?></th>
                            <th><?php echo $model->getAttributeLabel('uDate');?></th>
                            <th>操作</th>
                        <?php }elseif($_REQUEST['index']==2){?>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('code');?></th>
                            <th><?php echo $model->getAttributeLabel('name');?></th>
                            <th><?php echo $model->getAttributeLabel('f_username');?></th>
                            <th>赠送会员</th>
                            <th>赠送体育豆总数</th>
                            <th><?php echo $model->getAttributeLabel('remark');?></th>
                            <th><?php echo $model->getAttributeLabel('add_time');?></th>
                            <th>操作</th>
                        <?php }elseif($_REQUEST['index']==3){?>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('code');?></th>
                            <th><?php echo $model->getAttributeLabel('name');?></th>
                            <th><?php echo $model->getAttributeLabel('f_username');?></th>
                            <th>赠送会员</th>
                            <th>赠送体育豆总数</th>
                            <th><?php echo $model->getAttributeLabel('remark');?></th>
                            <th><?php echo $model->getAttributeLabel('state_name');?></th>
                            <th><?php echo $model->getAttributeLabel('f_userid');?></th>
                            <th><?php echo $model->getAttributeLabel('check_time');?></th>
                            <th>操作</th>
                        <?php }elseif($_REQUEST['index']==4){?>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('code');?></th>
                            <th><?php echo $model->getAttributeLabel('name');?></th>
                            <th><?php echo $model->getAttributeLabel('f_username');?></th>
                            <th>赠送会员</th>
                            <th>赠送体育豆总数</th>
                            <th><?php echo $model->getAttributeLabel('remark');?></th>
                            <th><?php echo $model->getAttributeLabel('state_name');?></th>
                            <th><?php echo $model->getAttributeLabel('f_userid');?></th>
                            <th><?php echo $model->getAttributeLabel('check_time');?></th>
                            <th>操作</th>
                        <?php }elseif($_REQUEST['index']==5){?>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('code');?></th>
                            <th><?php echo $model->getAttributeLabel('name');?></th>
                            <th><?php echo $model->getAttributeLabel('f_username');?></th>
                            <th>赠送会员</th>
                            <th>赠送体育豆总数</th>
                            <th><?php echo $model->getAttributeLabel('remark');?></th>
                            <th><?php echo $model->getAttributeLabel('f_userid');?></th>
                            <th><?php echo $model->getAttributeLabel('uDate');?></th>
                            <th>操作</th>
                        <?php }elseif($_REQUEST['index']==6){?>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('code');?></th>
                            <th><?php echo $model->getAttributeLabel('name');?></th>
                            <th><?php echo $model->getAttributeLabel('f_username');?></th>
                            <th>赠送会员</th>
                            <th>赠送体育豆总数</th>
                            <th><?php echo $model->getAttributeLabel('remark');?></th>
                            <th><?php echo $model->getAttributeLabel('check_time');?></th>
                            <th>操作</th>
                        <?php } ?>
                    </tr>
                    <?php 
                        $index = 1; foreach($arclist as $v){ 
                        $memberAll = BeansHistory::model()->findAll('send_info_id='.$v->id);
                        $tx='';
                        foreach($memberAll as $h){
                            $tx.=$h->got_beans_code.'/'.$h->got_beans_name.',';
                        }
                        $tx=rtrim($tx, ',');
                        $memberCount = BeansHistory::model()->count('send_info_id='.$v->id);
                    ?>
                        <tr>
                            <?php if($_REQUEST['index']==1){ ?>
                                <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                                <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                                <td><?php echo $v->code; ?></td>
                                <td><?php echo $v->name; ?></td>
                                <td><?php echo $v->f_username; ?></td>
                                <td style="width:200px;" title="<?= $tx;?>"><?php echo '<span style="display:inline-block;width: 200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">'.$tx.'</span>'; ?></td>
                                <td><?php echo $memberCount; ?></td>
                                <td><?php echo $v->remark; ?></td>
                                <td><?php echo $v->state_name; ?></td>
                                <td><?php echo $v->uDate; ?></td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'index'=>1))); ?>
                                    <?php echo show_command('删除','\''.$v->id.'\''); ?>
                                </td>
                            <?php }elseif($_REQUEST['index']==2){?>
                                <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                                <td><?php echo $v->code; ?></td>
                                <td><?php echo $v->name; ?></td>
                                <td><?php echo $v->f_username; ?></td>
                                <td style="width:200px;" title="<?= $tx;?>"><?php echo '<span style="display:inline-block;width: 200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">'.$tx.'</span>'; ?></td>
                                <td><?php echo $memberCount; ?></td>
                                <td><?php echo $v->remark; ?></td>
                                <td><?php echo $v->add_time; ?></td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'index'=>2))); ?>
                                </td>
                            <?php }elseif($_REQUEST['index']==3){?>
                                <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                                <td><?php echo $v->code; ?></td>
                                <td><?php echo $v->name; ?></td>
                                <td><?php echo $v->f_username; ?></td>
                                <td style="width:200px;" title="<?= $tx;?>"><?php echo '<span style="display:inline-block;width: 200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">'.$tx.'</span>'; ?></td>
                                <td><?php echo $memberCount; ?></td>
                                <td><?php echo $v->remark; ?></td>
                                <td><?php echo $v->state_name; ?></td>
                                <td><?php echo $v->f_username; ?></td>
                                <td><?php echo $v->check_time; ?></td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'index'=>3))); ?>
                                </td>
                            <?php }elseif($_REQUEST['index']==4){?>
                                <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                                <td><?php echo $v->code; ?></td>
                                <td><?php echo $v->name; ?></td>
                                <td><?php echo $v->f_username; ?></td>
                                <td style="width:200px;" title="<?= $tx;?>"><?php echo '<span style="display:inline-block;width: 200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">'.$tx.'</span>'; ?></td>
                                <td><?php echo $memberCount; ?></td>
                                <td><?php echo $v->remark; ?></td>
                                <td><?php echo $v->state_name; ?></td>
                                <td><?php echo $v->f_username; ?></td>
                                <td><?php echo $v->check_time; ?></td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'index'=>4))); ?>
                                </td>
                            <?php }elseif($_REQUEST['index']==5){?>
                                <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                                <td><?php echo $v->code; ?></td>
                                <td><?php echo $v->name; ?></td>
                                <td><?php echo $v->f_username; ?></td>
                                <td style="width:200px;" title="<?= $tx;?>"><?php echo '<span style="display:inline-block;width: 200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">'.$tx.'</span>'; ?></td>
                                <td><?php echo $memberCount; ?></td>
                                <td><?php echo $v->remark; ?></td>
                                <td><?php echo $v->f_username; ?></td>
                                <td><?php echo $v->uDate; ?></td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'index'=>5))); ?>
                                </td>
                            <?php }elseif($_REQUEST['index']==6){?>
                                <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                                <td><?php echo $v->code; ?></td>
                                <td><?php echo $v->name; ?></td>
                                <td><?php echo $v->f_username; ?></td>
                                <td style="width:200px;" title="<?= $tx;?>"><?php echo '<span style="display:inline-block;width: 200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">'.$tx.'</span>'; ?></td>
                                <td><?php echo $memberCount; ?></td>
                                <td><?php echo $v->remark; ?></td>
                                <td><?php echo $v->check_time; ?></td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'index'=>6))); ?>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php $index++; } ?>
                </table>
            </thead>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID')); ?>';

    function on_exam(){
        var exam = $('.exam p span').text();
        if(exam>0){ 
            $('#index').val(4);
            $('.box-search select').html('<option value>请选择</option>');
            $('.box-search .input-text').val('');
            document.getElementById('click_submit').click();
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
</script>

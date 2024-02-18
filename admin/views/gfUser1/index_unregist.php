<?php //var_dump($_REQUEST);?>
<div class="box">
    <div class="box-title c">
        <h1>
            <span>
                <?php
                    if($_REQUEST['passed']==136){
                        echo '当前界面：会员》实名管理》未实名账号列表';
                    }elseif($_REQUEST['passed']==373){
                        echo '当前界面：会员》实名管理》实名未通过列表';
                    }
                ?>
            </span>
        </h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <!-- <div class="box-detail-tab" style="margin-top:10px;">
            <ul class="c">
                <li class="<?//=Yii::app()->request->getParam('passed')==136?'current':'';?>" style="margin-right: 10px;"><a href="<?php //echo $this->createUrl('index_unregist',array('passed'=>136));?>">未实名列表</a></li>
                <li class="<?//=Yii::app()->request->getParam('passed')==373?'current':'';?>"><a href="<?php //echo $this->createUrl('index_unregist',array('passed'=>373));?>">实名审核未通过</a></li>
            </ul>
        </div>box-detail-tab end -->
        <div class="box-header">
            <?php ($_REQUEST['passed'] == 136) ? $txt = '注销' : $txt = '删除'; ?>
            <a style="display:inline-block;" id="j-delete" class="btn" href="javascript:;" onclick="we.operate(we.checkval('.check-item input:checked'), deleteUrl, '是否确认<?= $txt; ?>？');" ><i class="fa fa-trash-o"></i><?php echo ($_REQUEST['passed'] == 136) ? '账号注销' : '删除'; ?></a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="passed" value="<?php echo Yii::app()->request->getParam('passed');?>">
                <label style="margin-right:10px;">
                    <span><?php echo $_REQUEST['passed']==136?'注册时间：':'审核时间：';?></span>
                    <input style="width:100px;" class="input-text" type="text" id="time_start" name="time_start" value="<?php echo $time_start;?>">
                    <span>-</span>
                    <input style="width:100px;" class="input-text" type="text" id="time_end" name="time_end" value="<?php echo $time_end;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入账号/昵称">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th width="3%">序号</th>
                        <th width="10.7%"><?php echo $model->getAttributeLabel('GF_ACCOUNT');?></th>
                        <th width="10.7%"><?php echo $model->getAttributeLabel('GF_NAME');?></th>
                        <?php if($_REQUEST['passed']==136){?>
                            <th width="10.7%"><?php echo $model->getAttributeLabel('security_phone');?></th>
                            <th width="10.7%"><?php echo $model->getAttributeLabel('passed');?></th>
                            <th width="10.7%"><?php echo $model->getAttributeLabel('logon_way');?></th>
                            <th width="10.7%"><?php echo $model->getAttributeLabel('REGTIME');?></th>
                            <th width="10.7%">有效期限</th>
                            <th width="10.7%"><?php echo $model->getAttributeLabel('user_state'); ?></th>
                        <?php }elseif($_REQUEST['passed']==373){?>
                            <th ><?php echo $model->getAttributeLabel('ZSXM');?></th>
                            <th ><?php echo $model->getAttributeLabel('native');?></th>
                            <th ><?php echo $model->getAttributeLabel('security_phone');?></th>
                            <th ><?php echo $model->getAttributeLabel('id_card_type');?></th>
                            <th>审核日期</th>
                            <th>实名状态</th>
                            <th>有效期限</th>
                            <th><?php echo $model->getAttributeLabel('admin_gfname');?></th>
                        <?php }?>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->GF_ID); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->GF_ACCOUNT; ?></td>
                        <td><?php echo $v->GF_NAME; ?></td>
                        <?php if($_REQUEST['passed']==136){?>
                            <td><?php echo $v->security_phone; ?></td>
                            <td><?php echo $v->passed_name; ?></td>
                            <td><?php echo $v->logon_way_name; ?></td>
                            <td><?php echo substr($v->REGTIME,0,10).'<br>'.substr($v->REGTIME,11); ?></td>
                            <td>
                                <?php
                                    $left = substr($v->valid_date,0,10);
                                    $right = substr($v->valid_date,11);
                                    echo $left.' '.$right.'<br>'.$v->end_valid_date;
                                ?>
                            </td>
                            <td><?php echo $v->user_state_name; ?></td>
                        <?php }elseif($_REQUEST['passed']==373){?>
                            <td><?php echo $v->ZSXM; ?></td>
                            <td><?php echo $v->native; ?></td>
                            <td><?php echo $v->security_phone; ?></td>
                            <td><?php echo $v->id_card_type_name; ?></td>
                            <td><?php if(!empty($v->examine_time))echo substr($v->examine_time,0,10).'<br>'.substr($v->REGTIME,11); ?></td>
                            <td><?php echo $v->passed_name; ?></td>
                            <td>
                                <?php
                                    $left = substr($v->valid_date,0,10);
                                    $right = substr($v->valid_date,11);
                                    echo $left.' '.$right.'<br>'.$v->end_valid_date;
                                ?>
                            </td>
                            <td><?php echo $v->admin_gfname; ?></td>
                        <?php }?>
                        <td>
                            <?php echo $_REQUEST['passed']==136?show_command('详情',$this->createUrl('update', array('id'=>$v->GF_ID))):show_command('详情',$this->createUrl('update_exam', array('id'=>$v->GF_ID))); ?>
                            <?php if($_REQUEST['passed']==136){?>
                                <a class="btn" href="javascript:;" onclick="we.operate('<?= $v->GF_ID; ?>', deleteUrl, '是否确认注销？');" title="注销">注销</a>
                            <?php }elseif($_REQUEST['passed']==373){?>
                                <?php echo show_command('删除','\''.$v->GF_ID.'\''); ?>
                            <?php }?>
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
    var deleteUrl = '<?php echo $this->createUrl('cancel', array('id'=>'ID','al'=>($_REQUEST['passed'] == 136) ? '注销成功' : '删除成功'));?>';

    $(function(){
        var $time_start=$('#time_start');
        var $time_end=$('#time_end');
        $time_start.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
        $time_end.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
    });

    var ids=[];
    // 每页全选
    $('#j-checkall').on('click', function(){
        $temp1 = $('.check-item .input-check');
        $temp2 = $('.box-table .list tbody tr');
        $this = $(this);
        if($this.is(':checked')){
            $temp1.each(function(){
                ids.push($(this).val());
                this.checked = true;
            });
            $temp2.addClass('selected');
            ids=uniqueArray(ids);
        }else{
            $temp1.each(function(){
                this.checked = false;
                removeByValue(ids,$(this).val());
            });
            $temp2.removeClass('selected');
        }
    });
    // 单选
    $('.check-item .input-check').on('click', function() {
        $this = $(this);
        if ($this.is(':checked')) {
            $this.parent().parent().addClass('selected');
            ids.push($this.val());
        } else {
            $this.parent().parent().removeClass('selected');
            removeByValue(ids,$this.val());
        }
    });
    //移除数组中的固定元素
    function removeByValue(arr, val) {
        for(var i=0; i<arr.length; i++) {
            if(arr[i] == val) {
                arr.splice(i, 1);
                break;
            }
        }
    }
    //删除数组重复元素
    function uniqueArray(arr){
        var tmp = new Array();
        for(var i in arr){
            if(tmp.indexOf(arr[i])==-1){
                tmp.push(arr[i]);
            }
        }
        return tmp;
    }
</script>
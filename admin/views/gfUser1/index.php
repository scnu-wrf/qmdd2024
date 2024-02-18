<?php
// var_dump($_REQUEST);
    if(!isset($_REQUEST['country'])){
        $_REQUEST['country'] = '';
    }
    // if(!isset($_REQUEST['province'])){
    //     $_REQUEST['province'] = '';
    // }
?>
<div class="box">
    <div class="box-title c">
        <h1>
            <span>
              当前界面：会员 》会员管理 》注册会员列表
            </span>
        </h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();">
            <i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create',array('passed'=>136)),'注册账号'); ?>
            <?php echo show_command('添加',$this->createUrl('create',array('passed'=>372)),'注册实名'); ?>
            <?php echo show_command('添加','javascript:;','账号实名','id="zsxm"'); ?>
            <?php // echo show_command('添加', $this->createUrl('create', array('passed' => 372, 'action' => 'realname')), '账号实名'); ?>
            <a style="margin-left: 45px; color: #000000;">今日注册：<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span></a>
            <!-- <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a> -->
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" id="to_day" name="to_day" value="">
       
                <label style="margin-right:10px;">
                    <span>注册时间：</span>
                    <input style="width:100px;" class="input-text" type="text" id="realname_time" name="realname_time" value="<?php echo empty(Yii::app()->request->getParam('realname_time'))?date('Y-m-d'):Yii::app()->request->getParam('realname_time');?>">
                    <span>-</span>
                    <input style="width:100px;" class="input-text" type="text" id="realname_entertime" name="realname_entertime" value="<?php echo empty(Yii::app()->request->getParam('realname_entertime'))?date('Y-m-d'):Yii::app()->request->getParam('realname_entertime');?>">
                </label>
                <label style="margin-right:20px;">
                    <span>注册方式：</span>
                    <?php echo downList($logon_way,'f_id','F_NAME','logon_way'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>账号状态：</span>
                    <?php echo downList($user_state,'f_id','F_NAME','user_state'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="账号/昵称/手机号">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th width="3%">序号</th>
                        <th width="8.8%"><?php echo $model->getAttributeLabel('GF_ACCOUNT');?></th>
                        <th width="8.8%"><?php echo $model->getAttributeLabel('GF_NAME');?></th>
                        <th width="8.8%"><?php echo $model->getAttributeLabel('security_phone');?></th>
                        <th width="8.8%"><?php echo $model->getAttributeLabel('user_state');?></th>
                        <th width="8.8%"><?php echo $model->getAttributeLabel('passed');?></th>
                        <!-- <th ><?php //echo $model->getAttributeLabel('ZSXM');?></th> -->
                        <th width="8.8%"><?php echo $model->getAttributeLabel('REGTIME');?></th>
                        <th width="8.8%">有效期限</th>
                        <th width="8.8%"><?php echo $model->getAttributeLabel('logon_way');?></th>
                        <th width="8.8%"><?php echo $model->getAttributeLabel('gf_reg_address');?></th>
                        <th width="8.8%"><?php echo $model->getAttributeLabel('gf_reg_client');?></th>
                        <th width="8.8%">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td ><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td ><?php echo $v->GF_ACCOUNT; ?></td>
                        <td ><?php echo $v->GF_NAME; ?></td>
                        <td ><?php echo $v->security_phone; ?></td>
                        <td ><?php echo $v->user_state_name; ?></td>
                        <td ><?php echo $v->passed_name; ?></td>
                        <!-- <td ><?php // echo $v->ZSXM; ?></td> -->
                        <td ><?php echo substr($v->REGTIME,0,10); ?></td>
                        <td>
                            <?php
                                $left = substr($v->valid_date,0,10);
                                $right = substr($v->valid_date,11);
                                echo $left.' '.$right.'<br>'.$v->end_valid_date;
                            ?>
                        </td>
                        <td ><?php echo $v->logon_way_name; ?></td>
                        <td ><?php echo $v->gf_reg_address; ?></td>
                        <td >
                            <?php
                                if($v->gf_reg_client==1){
                                    echo 'PC';
                                }elseif($v->gf_reg_client==2){
                                    echo 'MAC';
                                }elseif($v->gf_reg_client==3){
                                    echo '苹果';
                                }elseif($v->gf_reg_client==4){
                                    echo 'IPAD';
                                }elseif($v->gf_reg_client==5){
                                    echo '安卓';
                                }elseif($v->gf_reg_client==6){
                                    echo 'APAD';
                                }elseif($v->gf_reg_client==7){
                                    echo '网页';
                                }elseif($v->gf_reg_client==8){
                                    echo '其他';
                                }
                            ?>
                        </td>
                        <td >
                            <?php echo show_command('详情',$this->createUrl('update', array('id'=>$v->GF_ID))); ?>
                            <!-- <?php //echo show_command('删除','\''.$v->GF_ID.'\''); ?> -->
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
        var $realname_time=$('#realname_time');
        var $realname_entertime=$('#realname_entertime');
        $realname_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
        $realname_entertime.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
    });


    $("#zsxm").on("click",function(){
        $.dialog.data('GF_ID', 0);
            $.dialog.open('<?php echo $this->createUrl("select/gfuser");?>&passed=0',{
            id:'zhanghao',
            lock:true,opacity:0.3,
            width:'500px',
            // height:'60%',
            title:'选择未登记账号',
            close: function () {
                if($.dialog.data('GF_ID')>0){
                    window.location.href="<?php echo $this->createUrl('update_c'); ?>&passed=372&id="+$.dialog.data('GF_ID');
                }
            }
        })
    })
</script>


<?php //var_dump($_REQUEST);?>
<div class="box">
    <div class="box-title c">
        <h1>
            <span>当前界面：服务者 》服务者管理 》入驻审核</span>
            <script>var webstate = <?php echo $_REQUEST['state']; ?></script>
        </h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-detail-tab" style="margin-top: 15px; border: 0px;">
            <ul class="c">
                <li id="waitting_for_exam" style="width:150px;"><a href="javascript:;" onclick="on_exam(0);">待审核：<span style="color:red;font-weight: bold;"><?php echo $num; ?></span></a></li>
                <li id="exam_list" style="width:150px;"><a href="javascript:;" onclick="on_exam(1);">审核记录</a></li>
            </ul>
        </div><!--box-detail-tab end-->

        <!-- <div class="box-header"> -->
            <?php // if(empty($_REQUEST['state'])){?>
                <!-- <span class="exam" onclick="on_exam();"><p>待审核：<span style="color:red;font-weight: bold;"></span></p></span> -->
            <?php // }else{?>
                <!-- <a class="btn btn-blue" href="javascript:;" onclick="checkSubmit(372)">审核通过</a> -->
                <!-- <a class="btn btn-blue" href="javascript:;" onclick="checkSubmit(373)">审核不通过</a> -->
            <?php // }?>
        <!-- </div> -->

        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                  <input type="hidden" name="state" id="state" value="<?php echo Yii::app()->request->getParam('state'); ?>">
                <!-- <label style="margin-right:20px;">
                    <span>性别：</span>
                    <?php //echo downList($sex,'f_id','F_NAME','qualification_sex'); ?>
                </label>
				<label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php //echo downList($project_list,'id','project_name','project'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>类型：</span>
                    <?php //echo downList($qualification_type_id,'f_id','F_NAME','qualification_type_id'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>资质等级：</span>
                    <?php //echo downList($identity,'f_id','F_NAME','identity'); ?>
                </label> -->
                <label style="margin-right:10px;">
                    <span><?php echo empty($_REQUEST['state'])?'审核':'申请'?>时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $startDate;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $endDate;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input type="text" style="width:200px" class="input-text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="请输入账号/姓名">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div>
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <?php if($_REQUEST['state'] == 0) { ?>
                            <th width="3%">序号</th>
                            <th width="12%"><?php echo $model->getAttributeLabel('qualification_gfaccount') ?></th>
                            <th width="12%"><?php echo $model->getAttributeLabel('qualification_name') ?></th>
                            <th width="12%"><?php echo $model->getAttributeLabel('qualification_project_name') ?></th>
                            <th width="12%"><?php echo $model->getAttributeLabel('qualification_type_id') ?></th>
                            <th width="12%">入驻来源</th>
                            <th width="12%">入驻状态</th>
                            <th width="12%">申请时间</th>
                            <th width="12%">操作</th>
                        <?php }else if($_REQUEST['state'] == 1) { ?>
                            <th class="check" ><input type="checkbox" id="j-checkall" class="input-check"></th>
                            <th width="3%">序号</th>
                            <th width="10.7%"><?php echo $model->getAttributeLabel('qualification_gfaccount') ?></th>
                            <th width="10.7%"><?php echo $model->getAttributeLabel('qualification_name') ?></th>
                            <th width="10.7%"><?php echo $model->getAttributeLabel('qualification_project_name') ?></th>
                            <th width="10.7%"><?php echo $model->getAttributeLabel('qualification_type_id') ?></th>
                            <th width="10.7%"><?php echo $model->getAttributeLabel('logon_way') ?></th>
                            <th width="10.7%">审核状态</th>
                            <th width="10.7%"><?php echo $model->getAttributeLabel('uDate') ?></th>
                            <th width="10.7%">审核员</th>
                            <th width="10.7%">操作</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v) {?>
                        <tr>
                            <?php if($_REQUEST['state'] == 1){?>
                                <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <?php }?>
                            <td><span class="num num-1"><?php echo $index; ?></span></td>
                            <td><?php echo $v->qualification_gfaccount; ?></td>
                            <td><?php echo $v->qualification_name; ?></td>
                            <td><?php echo $v->qualification_project_name; ?></td>
                            <td><?php echo $v->qualification_type; ?></td>
                            <td><?php echo $v->logon_way_name; ?></td>
                            <td><?php echo $v->check_state_name; ?></td>
                            <td><?php if($v->uDate!='0000-00-00 00:00:00')echo $v->uDate; ?></td>
                            <?php if($_REQUEST['state'] == 1) { ?>
                                <td><?php echo $v->process_preson_account.'/'.$v->process_preson_nick; ?></td>
                            <?php } ?>
                            <td>
                                <?php echo show_command(($_REQUEST['state'] == 0) ? '审核' : '详情', $this->createUrl('update_examine', array('id'=>$v->id))); ?>
                            </td>
                        </tr>
                    <?php $index++; }?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div>
<script>
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

    // 切换待审核与审核记录
    function on_exam(state){
        if(state == 0) {
            $('#state').val(0);
            $('#start_date').val('');
            $('#end_date').val('');
            $('#keywords').val('');
            document.getElementById('click_submit').click();
        }else if(state == 1) {
            $('#state').val(1);
            $('#keywords').val('');
            document.getElementById('click_submit').click();
        }
    }
    // 页面加载完成时添加导航栏选中
    $(window).load(function() {
        if(webstate == 0) {
            document.getElementById('exam_list').className='';
            document.getElementById('waitting_for_exam').style.backgroundColor='#FDE9D9';
            document.getElementById('waitting_for_exam').className='current';
        }else if(webstate == 1) {
            document.getElementById('waitting_for_exam').className='';
            document.getElementById('exam_list').style.backgroundColor='#FDE9D9';
            document.getElementById('exam_list').className='current';
        }
    });

    // 每页全选
    $('#j-checkall').on('click', function(){
        var $temp1 = $('.check-item .input-check');
        var $temp2 = $('.box-table .list tbody tr');
        var $this = $(this);
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
    // 单选
    $('.check-item .input-check').on('click', function() {
        var $this = $(this);
        if ($this.is(':checked')) {
            $this.parent().parent().addClass('selected');
        } else {
            $this.parent().parent().removeClass('selected');
        }
    });
    function checkSubmit(state){
        var str = '';
        $(".check-item input:checked").each(function(){
                str += $(this).val() + ',';
        })
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        if(str.length<1){
            we.msg('minus','请选中要审核的数据');
            return false;
        }
        we.loading('show');
        $.ajax({
            type:'post',
            url:'<?php echo $this->createUrl("check"); ?>&id='+str+'&state='+state,
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
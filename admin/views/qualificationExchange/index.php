<div class="box">
    <div class="box-title c">
        <h1>
            <span><?php echo empty($_REQUEST['state'])?'当前界面：会员 》龙虎会员管理 》资质置换龙虎积分':'当前界面：会员》龙虎会员管理》资质置换龙虎积分》待审核'?></span>
        </h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <?php if(empty($_REQUEST['state'])){?>
        <div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create'),'添加'); ?>
            <span class="exam" onclick="on_exam();"><p>待审核：<span style="color:red;font-weight: bold;"><?php echo $num; ?></span></p></span>
        </div><!--box-header end-->
        <?php }?>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="state" id="state" value="<?php echo Yii::app()->request->getParam('state'); ?>">
                <?php if(empty($_REQUEST['state'])){?>
                    <label style="margin-right:10px;">
                        <span>审核时间：</span>
                        <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $startDate;?>">
                        <span>-</span>
                        <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $endDate;?>">
                    </label>
                <?php }?>
				<label style="margin-right:20px;">
                    <span>项目：</span>
                    <select name="project">
                        <option value="">请选择</option>
                        <?php foreach($project_id as $v){?>
                        <option value="<?php echo $v->id;?>"<?php if(Yii::app()->request->getParam('project_id')!=null && Yii::app()->request->getParam('project_id')==$v->id){?> selected<?php }?>><?php echo $v->project_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="请输入账号/姓名" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th>GF账号</th>
                        <th>姓名</th>
						<th><?php echo $model->getAttributeLabel('get_score_project_id');?></th>
                        <th>持有资质</th>
						<th><?php echo $model->getAttributeLabel('qua_id');?></th>
                        <th><?php echo $model->getAttributeLabel('get_score');?></th> 
                        <th><?php echo $model->getAttributeLabel('state');?></th> 
                        <?php if(empty($_REQUEST['state'])){?>
						    <th><?php echo $model->getAttributeLabel('state_time');?></th>
                        <?php }else{?>
						    <th><?php echo $model->getAttributeLabel('uDate');?></th>
                        <?php }?>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $basepath=BasePath::model()->getPath(130);?>
<?php 
$index = 1;
foreach($arclist as $v){ 
?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>					
						<td><?php if($v->gf_user_name!=null){echo $v->gf_user_name->GF_ACCOUNT;} ?></td>
						<td><?php if($v->gf_user_name!=null){echo $v->gf_user_name->ZSXM;} ?></td>
						<td><?php if($v->project_list!=null){echo $v->project_list->project_name;} ?></td>
						<td>
                            <?php 
                                if($v->base_code_qua!=null){$ce=ServicerCertificate::model()->find('id='.$v->base_code_qua->fater_id);}else{$ce='';}
                                if(!empty($ce))echo $ce->f_name;
                            ?>
                        </td>
						<td><?php echo $v->person_name; ?></td>
                        <td><?php echo $v->get_score; ?></td>  
						<td><?php echo $v->state_name; ?></td>    
                        <?php if(empty($_REQUEST['state'])){?>
                            <td><?php echo $v->state_time; ?></td>
                        <?php }else{?>
                            <td><?php echo $v->uDate; ?></td>
                        <?php }?>               
                        <td>
                            <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id))); ?>

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
        // if(exam>0){
            $('#state').val(371);
            $('.box-search select').html('<option value>请选择</option>');
            $('.box-search .input-text').val('');
            document.getElementById('click_submit').click();
        // }
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

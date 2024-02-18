<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播 》直播管理 》<a class="nav-a">虚拟体育币上架</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加方案</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="pricing" value="<?php echo Yii::app()->request->getParam('pricing');?>">
                <label style="margin-right:10px;">
                    	<span>上下线日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="star_time" name="star_time" value="<?php echo Yii::app()->request->getParam('star_time');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_time" name="end_time" value="<?php echo Yii::app()->request->getParam('end_time');?>">
                </label>
                <!-- <label style="margin-right:10px;">
                    <span>审核状态：</span>
                    <?php //echo downList($base_code,'f_id','F_NAME','state'); ?>
                </label> -->
                <!-- <label style="margin-right:10px;">
                    <span>上下线状态：</span>
                    <select id="userstate" name="userstate">
                        <option value="">请选择</option>
                        <option value="649"<?php //if(Yii::app()->request->getParam('userstate')!==null && Yii::app()->request->getParam('userstate')!==''  && Yii::app()->request->getParam('userstate')==649){?> selected<?php //}?>>上线</option>
                        <option value="648"<?php //if(Yii::app()->request->getParam('userstate')!==null && Yii::app()->request->getParam('userstate')!==''  && Yii::app()->request->getParam('userstate')==648){?> selected<?php //}?>>下线</option>
                    </select>
                </label> -->
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text"  placeholder="请输入方案编码/标题" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                <tr class="table-title">
                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                    <th style="text-align:center"><?php echo $model->getAttributeLabel('code');?></th>
                    <th style="text-align:center"><?php echo $model->getAttributeLabel('name');?></th>
                    <th style="text-align:center"><?php echo $model->getAttributeLabel('is_user');?></th>
                    <th style="text-align:center"><?php echo $model->getAttributeLabel('star_time');?></th>
                    <th style="text-align:center"><?php echo $model->getAttributeLabel('end_time');?></th>
                    <th style="text-align:center">操作</th>
                </tr>
                <?php 
                    if(is_array($arclist)) foreach($arclist as $v){ ?>
                <tr>
                    <td class="check check-item"><?php //if($v->f_check<>371 && $v->f_check<>372){?><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"><?php //} ?></td>
                    <td><?php echo $v->code; ?></td>
                    <td><?php echo $v->name; ?></td>
                    <td><?php if(!empty($v->is_user)) echo $v->base_is_user->F_NAME; ?></td>
                    <td><?php echo $v->star_time; ?></td>
                    <td><?php echo $v->end_time; ?></td>
                    <td>
                        <?php echo show_command('修改',$this->createUrl('update',array('id'=>$v->id))); ?>
                        <?php echo show_command('删除','\''.$v->id.'\'') ?>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
    $(function(){
        var $star_time=$('#star_time');
        var $end_time=$('#end_time');
        $star_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
        $end_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
    });
</script>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>签到管理</h1></div><!--box-title end-->     
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>服务类型：</span>
                    <select name="order_type">
                        <option value="">请选择</option>
                        <?php foreach($order_type as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('order_type')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>服务名称：</span>
                    <select name="server_sourcer">
                        <option value="">请选择</option>
                        <?php foreach($server_sourcer as $v){?>
                        <option value="<?php echo $v->id;?>"<?php if(Yii::app()->request->getParam('server_sourcer')==$v->id){?> selected<?php }?>><?php echo $v->s_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>服务项目：</span>
                    <select name="project_id">
                        <option value="">请选择</option>
                        <?php foreach($project_id as $v){?>
                        <option value="<?php echo $v->id;?>"<?php if(Yii::app()->request->getParam('project_id')==$v->id){?> selected<?php }?>><?php echo $v->project_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入GF帐号 / 姓名" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th class="list-id">序号</th>
                        <th><?php echo $model->getAttributeLabel('type');?></th>
                        <th><?php echo $model->getAttributeLabel('service_name');?></th>
                        <th><?php echo $model->getAttributeLabel('service_data_name');?></th>
                        <th><?php echo $model->getAttributeLabel('sign_time');?></th>
                        <th>签到率</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->type_name; ?></td>
                        <td><?php echo $v->service_name; ?></td>
                        <td><?php echo $v->service_data_name; ?></a></td>
                        <td><?php echo $v->sign_time; ?></td>
                        <td><?php echo $v->sign_type; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    // $(function(){
    //     var $start_time=$('#start_date');
    //     var $end_time=$('#end_date');
    //     $start_time.on('click', function(){
    //         var end_input=$dp.$('end_date')
    //         WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'end_date\')}'});
    //     });
    //     $end_time.on('click', function(){
    //         WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'start_date\')}'});
    //     });
    // });
</script>
<div class="box"></div>
    <div class="box-title c">
        <h1>当前界面：动动约 》服务退订 》退订审核》<a class="nav-a">待审核</a></h1>
        <span class="back"><a href="javascript:;" class="btn" onclick="we.reload();">刷新</a></span>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('returnGoods/index_service_pass');?>');"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div>
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                <label style="margin-right:10px;">
                    <span>日期：</span>
                    <input style="width:80px;" type="text" class="input-text time" name="star" value="<?php echo $star; ?>">
                    <span>-</span>
                    <input style="width:80px;" type="text" class="input-text time" name="end" value="<?php echo $end; ?>">
                </label>
                <label style="margin-right:10px;">
                    <span>服务类别：</span>
                    <?php echo downList($t_typeid,'id','f_uname','t_typeid'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>服务项目：</span>
                    <?php echo downList($project_id,'id','project_name','project_id'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:120px;" type="text" class="input-text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="请输入账号 / 名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div>
        <div class="box-table">
            <table class="list">
                <thead>
                    <th style="text-align:center; width:25px;">序号</th>
                    <th width="10%"><?php echo $model->getAttributeLabel('refunds_num'); ?></th>
                    <th><?php echo $model->getAttributeLabel('gf_service_order_num'); ?></th>
                    <th><?php echo $model->getAttributeLabel('service_type'); ?></th>
                    <th><?php echo $model->getAttributeLabel('service_title'); ?></th>
                    <th width="10%"><?php echo $model->getAttributeLabel('service_time'); ?></th>
                    <th><?php echo $model->getAttributeLabel('service_money'); ?></th>
                    <th style="width:70px;"><?php echo $model->getAttributeLabel('service_order_date'); ?></th>
                    <th><?php echo $model->getAttributeLabel('service_return_reason'); ?></th>
                    <th width="10%"><?php echo $model->getAttributeLabel('service_return_cond'); ?></th>
                    <th><?php echo $model->getAttributeLabel('service_total_money'); ?></th>
                    <th><?php echo $model->getAttributeLabel('return_float_Percentage'); ?></th>
                    <th><?php echo $model->getAttributeLabel('ret_money'); ?></th>
                    <th>服务单位</th>
                    <th><?php echo $model->getAttributeLabel('order_gfid'); ?></th>
                    <th>操作</th>
                </thead>
                <tbody>
<?php $index = 1;foreach($arclist as $v) {?>
<?php if(!empty($v->orderdata)) $list = GfServiceData::model()->find('id='.$v->orderdata->gf_service_id); ?>
                        <tr>
                            <td style="text-align:center;"><?php echo $index; ?></td>
                            <td><?php echo $v->order_num; ?></td>
                            <td><?php if(!empty($list)) echo $list->order_num; ?></td>
                            <td><?php if(!empty($list)) echo $list->t_stypename; ?></td>
                            <td><?php if(!empty($v->orderdata)) echo $v->orderdata->service_name; ?></td>
                            <td><?php if(!empty($v->orderdata)) echo $v->orderdata->service_data_name; ?></td>
                            <td><?php echo $v->sale_money; ?></td>
                            <td><?php echo $v->order_date; ?></td>
                            <td><?php echo $v->return_reason; ?></td>
                            <td><?php if(!empty($v->reasonid)) echo $v->reasonid->return_start_time.'小时<距服务时间≤'.$v->reasonid->return_time.'小时'; ?>
                            </td>
                            <td><?php if(!empty($v->buy_orderdata)) echo $v->buy_orderdata->buy_amount; ?></td>
                            <td><?php if(!empty($v->buy_orderdata)) echo $v->buy_orderdata->buy_amount*($v->return_float_Percentage/100); ?></td>
                            <td><?php echo $v->ret_money; ?></td>
                            <td><?php if(!empty($v->club_list)) echo $v->club_list->club_name; ?></td>
                            <td><?php if(!empty($v->orderinfo)) echo $v->orderinfo->order_gfaccount; ?>(<?php echo $v->gf_name; ?>)</td>
                            <td><a class="btn" href="<?php echo $this->createUrl('update_service_check', array('id'=>$v->id,'list'=>'check'));?>" title="详情">审核</a></td>
                        </tr>
                    <?php $index++; }?>
                </tbody>
            </table>
        </div>
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div>
</div>
<script>
    $(function(){
        $('.time').on('click',function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        })
    })
</script>
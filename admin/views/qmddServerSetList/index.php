<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>服务统计表</h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="请输入资源编号/资源名称/上架编号" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;' width="10%"><?php echo $model->getAttributeLabel('s_code');?></th>
                        <th style='text-align: center;' width="15%"><?php echo $model->getAttributeLabel('s_name');?></th>
                        <th style='text-align: center;' width="10%"><?php echo $model->getAttributeLabel('t_typeid');?></th>
                        <th style='text-align: center;' width="10%"><?php echo $model->getAttributeLabel('project_ids');?></th>
                        <th style='text-align: center;' width="6%"><?php echo $model->getAttributeLabel('available_quantity');?></th>
                        <th style='text-align: center;' width="10%">浮动交易金额</th>
                        <th style='text-align: center;' width="10%">实际交易金额</th>
                        <th style='text-align: center;' width="10%"><?php echo $model->getAttributeLabel('club_id');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1;
if (is_array($arclist)) foreach($arclist as $v){ ?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->s_code; ?></td>
                        <td><?php echo $v->s_name; ?></td>
                        <td><?php if(!empty($v->s_type)) echo $v->s_type->t_name; ?>-<?php if(!empty($v->s_usertype)) echo $v->s_usertype->f_uname; ?></td>
                        <td><?php if ($v->project_ids != '') {
				$project = ProjectList::model()->findAll('id in (' . $v->project_ids . ')');
			} ?>
            <?php if(!empty($project )) foreach ($project as $p) {
				echo $p->project_name.' ';
			}
			?>
            			</td>
                        <td><?php echo $v->available_quantity; ?></td>
                        <td><?php $r_amount=0;
		$r_mdata = GfServiceData::model()->findAll('qmdd_server_set_list_id='.$v->id.' and order_state=1170 and cancelled<>0');
		if(!empty($r_mdata)) foreach($r_mdata as $r){
			$r_amount=$r_amount+$r->ret_amount;
		} ?><?php echo $r_amount; ?></td>
                        <td><?php $b_amount=0;
		$b_mdata = GfServiceData::model()->findAll('qmdd_server_set_list_id='.$v->id.' and order_state=1172');
		if(!empty($b_mdata)) foreach($b_mdata as $b){
			$b_amount=$b_amount+($b->buy_price*$b->buy_count);
		} ?><?php echo $b_amount; ?></td>
                        <td><?php echo $v->club_name; ?></td>
                        <td>
                            <a class="btn" href="javascript:;" onclick="fnLog(<?php echo $v->id;?>);" title="销售明细">销售明细</a>
                            <!--a class="btn" href="javascript:;" onclick="fnUpdate(<php echo $v->id;?>);"><i class="fa fa-refresh"></i>刷新</a-->
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
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

//刷新库存
function fnUpdate(detail_id){
		$.ajax({
			type: 'post',
			url: '<?php echo $this->createUrl('quantity');?>&detail_id='+detail_id,
			data: {detail_id:detail_id},
			dataType: 'json',
			success: function(data) {
				if(data!=''){
					we.msg('minus', '刷新成功');
					we.reload();
				  }else{
					we.msg('minus', '刷新失败');
				}
			}
		}); 

}
// 查看库存记录
var fnLog=function(detail_id){
    $.dialog.open('<?php echo $this->createUrl("log");?>&detail_id='+detail_id,{
        id:'mingxi',
        lock:true,
        opacity:0.3,
        title:'销售明细',
        width:'95%',
        height:'95%',
        close: function () {}
    });
};
</script>
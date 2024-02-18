
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》商品发布》商品发布审核》<a class="nav-a">待审核</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>申请日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="编号/货号/型号/名称" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                    <tr class="table-title">
                        <th style="text-align:center; width:25px;">序号</th>
                        <th><?php echo $model->getAttributeLabel('supplier_code');?></th>
                        <th><?php echo $model->getAttributeLabel('name');?></th>
                        <th><?php echo $model->getAttributeLabel('json_attr');?></th>
                        <th><?php echo $model->getAttributeLabel('type');?></th>
                        <th><?php echo $model->getAttributeLabel('supplier_id');?></th>
                        <th><?php echo $model->getAttributeLabel('display');?></th>
                        <th style="width:70px;"><?php echo $model->getAttributeLabel('add_time');?></th>
                        <th>操作</th>
                    </tr>
<?php $index = 1;
foreach($arclist as $v){ ?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->supplier_code; ?></td>
                        <td><?php echo $v->name; ?></td>
                        <td><?php echo $v->json_attr; ?></td>
                        <td>
                        <?php if(!empty($v->type)){ 
                            $ptype=explode(',', $v->type);
                            if(!empty($ptype)) foreach($ptype as $t){
                                $types = MallProductsTypeSname::model()->find('tn_code="'.$t.'"');
                                if(!empty($types)) echo $types->sn_name.' ';   
                        }} ?>
                        </td>
                        <td><?php if(!empty($v->club_list)) echo $v->club_list->club_name; ?></td>
                        <td><?php echo $v->display_name; ?></td>
                    
                        <td><?php echo $v->add_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_check', array('id'=>$v->id));?>" title="详情">审核</a>
                        </td>
                    </tr>
<?php $index++; } ?>
                </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var $star_time=$('#start');
    var $end_time=$('#end');
    $star_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
</script>

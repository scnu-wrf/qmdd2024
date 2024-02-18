<div class="box">
    <div class="box-content">
        <div class="box-title c">
            <h1>当前界面：商城》毛利管理》<a class="nav-a">商品毛利设置</a></h1>
            <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
        </div><!--box-title c end-->
        <div class="box-content">
            <div class="box-header">
                <?php echo show_command('添加',$this->createUrl('create'),'添加'); ?>
                <?php echo show_command('批删除','','删除'); ?>
            </div><!--box-header end-->
            <div class="box-search">
                <form action="<?php echo Yii::app()->request->url;?>" method="get">
                    <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                    <label style="margin-right:10px;">
                        <span>关键字：</span>
                        <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入方案编号/方案名称">
                    </label>
                    <button class="btn btn-blue" type="submit">查询</button>
                </form>
            </div><!--box-search end-->
            <div class="box-table">
                <table class="list">
                    <thead>
                        <tr>
                            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                            <th style="text-align:center;width:25px;">序号</th>
                            <th><?php echo $model->getAttributeLabel('f_code');?></th>
                            <th><?php echo $model->getAttributeLabel('f_name');?></th>
                            <th>适用销售时间</th>
                            <th>适用商品</th>
                            <th><?php echo $model->getAttributeLabel('add_date');?></th>
                            <th><?php echo $model->getAttributeLabel('f_username');?></th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
<?php $index = 1;
foreach($arclist as $v){ ?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->f_code; ?></td>
                            <td><?php echo $v->f_name; ?></td>
                            <td><?php echo $v->star_time; ?><br><?php echo $v->end_time; ?></td>
                            <td>
                    <?php $prodata=MallProfitProduct::model()->findAll('info_id='.$v->id);
                    $prodata_num=count($prodata);
                    $prodata_text='';
                    if($prodata_num>3){
                        for($i=0;$i<3;$i++){
                        $prodata_text.=$prodata[$i]['product_code'].','.$prodata[$i]['product_name'].','.$prodata[$i]['json_attr'].';<br>';
                        }
                        $prodata_text.='...';
                    } else {
                        for($i=0;$i<$prodata_num;$i++){
                        $prodata_text.=$prodata[$i]['product_code'].','.$prodata[$i]['product_name'].','.$prodata[$i]['json_attr'].';<br>';
                        }
                    }
                            echo $prodata_text; ?></td>
                            <td><?php echo $v->add_date; ?></td>
                            <td><?php echo $v->f_username; ?></td>
                            <td>
                                <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                                <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                        <?php $index++; } ?>
                    </tbody>
                </table>
            </div><!--box-table end-->
            <div class="box-page c"><?php $this->page($pages); ?></div>
        </div>
    </div><!--box-content-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>
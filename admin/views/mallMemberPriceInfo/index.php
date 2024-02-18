<div class="box">
    <div class="box-content">
        <div class="box-title c">
            <h1>当前界面：商城》定价/分配方案》<a class="nav-a">定价方案</a></h1>
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
                        <input style="width:250px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入方案编码 / 方案名称">
                    </label>
                    <button class="btn btn-blue" type="submit">查询</button>
                </form>
            </div><!--box-search end-->
            <div class="box-table">
                <table class="list">
                    <thead>
                        <tr>
                            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                            <th style='text-align:center; width:25px;'>序号</th>
                            <th width="10%"><?php echo $model->getAttributeLabel('f_code');?></th>
                            <th width="10%"><?php echo $model->getAttributeLabel('f_name');?></th>
                            <th><?php echo $model->getAttributeLabel('s_sale');?></th>
                            <th><?php echo $model->getAttributeLabel('s_club');?></th>
                            <th><?php echo $model->getAttributeLabel('s_sec');?></th>
                            <th><?php echo $model->getAttributeLabel('s_time');?></th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $index = 1;
                            foreach($arclist as $v){
                        ?>
                        <tr>
                            <td style='text-align: center;' class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->f_code; ?></td>
                            <td><?php echo $v->f_name; ?></td>
                            <td>
                    <?php $sale=MallMemberPriceData::model()->findAll('infoid='.$v->id.' and sale_typeid=3');
                    $sale_num=count($sale);
                    $sale_text='';
                    if($sale_num>3){
                        for($i=0;$i<3;$i++){
                        $sale_text.=$sale[$i]['sale_levelnamea'].' '.$sale[$i]['sale_pricea'].'% '.$sale[$i]['sale_beana'].'% '.$sale[$i]['sale_counta'].'<br>';
                        }
                        $sale_text.='...';
                    } else {
                        for($i=0;$i<$sale_num;$i++){
                        $sale_text.=$sale[$i]['sale_levelnamea'].' '.$sale[$i]['sale_pricea'].'% '.$sale[$i]['sale_beana'].'% '.$sale[$i]['sale_counta'].'<br>';
                        }
                    }
                            echo $sale_text; ?></td>
                            <td>
                    <?php $clubd=MallMemberPriceData::model()->findAll('infoid='.$v->id.' and sale_typeid=4');
                    $clubd_num=count($clubd);
                    $clubd_text='';
                    if($clubd_num>3){
                        for($i=0;$i<3;$i++){
                        $clubd_text.=$clubd[$i]['sale_levelnamea'].' '.$clubd[$i]['sale_pricea'].'% '.$clubd[$i]['sale_beana'].'% '.$clubd[$i]['sale_counta'].'<br>';
                        }
                        $clubd_text.='...';
                    } else {
                        for($i=0;$i<$clubd_num;$i++){
                        $clubd_text.=$clubd[$i]['sale_levelnamea'].' '.$clubd[$i]['sale_pricea'].'% '.$clubd[$i]['sale_beana'].'% '.$clubd[$i]['sale_counta'].'<br>';
                        }
                    }
                            echo $clubd_text; ?></td>
                            <td>
                    <?php $sec=MallMemberPriceData::model()->findAll('infoid='.$v->id.' and sale_typeid=5');
                    $sec_num=count($sec);
                    $sec_text='';
                    if($sec_num>3){
                        for($i=0;$i<3;$i++){
                        $sec_text.=$sec[$i]['sale_levelnamea'].' '.$sec[$i]['sale_pricea'].'% '.$sec[$i]['sale_beana'].'% '.$sec[$i]['sale_counta'].'<br>';
                        }
                        $sec_text.='...';
                    } else {
                        for($i=0;$i<$sec_num;$i++){
                        $sec_text.=$sec[$i]['sale_levelnamea'].' '.$sec[$i]['sale_pricea'].'% '.$sec[$i]['sale_beana'].'% '.$sec[$i]['sale_counta'].'<br>';
                        }
                    }
                            echo $sec_text; ?></td>
                            <td>
                    <?php $stime=MallMemberPriceData::model()->findAll('infoid='.$v->id.' and sale_typeid=6');
                    $stime_num=count($stime);
                    $stime_text='';
                    if($stime_num>3){
                        for($i=0;$i<3;$i++){
                        $stime_text.=$stime[$i]['sale_levelnamea'].' '.$stime[$i]['sale_pricea'].'% '.$stime[$i]['sale_beana'].'% '.$stime[$i]['sale_counta'].'<br>';
                        }
                        $stime_text.='...';
                    } else {
                        for($i=0;$i<$stime_num;$i++){
                        $stime_text.=$stime[$i]['sale_levelnamea'].' '.$stime[$i]['sale_pricea'].'% '.$stime[$i]['sale_beana'].'% '.$stime[$i]['sale_counta'].'<br>';
                        }
                    }
                            echo $stime_text; ?></td>
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
<div class="box">
    <div class="box-title c">
        <h1>当前界面：系统 》积分/体育豆 》积分兑换活动</h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header"> 
            <?php echo show_command('添加',$this->createUrl('create_tyd'),'添加'); ?>
            <?php echo show_command('批删除','','删除'); ?>
        </div>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
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
                        <th>兑换类型</th>
                        <th>兑换内容</th>
                        <th>积分兑换比例</th>
                        <th>限兑数量</th>
                        <th>起止时间</th>
                        <th>是否开放</th>
                        <th>已兑数量</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php
$index = 1;
 foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->baseCode->F_NAME; ?></td>
                        <td><?php echo $v->item_type_name; ?></td>
                        <td><?php echo $v->credit.':'.$v->beans; ?></td>
                        <td><?php echo $v->beans_num; ?></td>
                        <td><?php echo $v->beans_date_start.'<br>'.$v->beans_date_end; ?></td>
                        <td><?php echo $v->ifuse->F_NAME; ?></td>
                        <td><?php echo $v->consume_beans_num; ?></td>
                        <td>
                            <?php echo show_command('修改',$this->createUrl('update_tyd', array('id'=>$v->id))); ?>
                            <?php echo show_command('删除','\''.$v->id.'\''); ?>
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
</script>
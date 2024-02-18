<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>供应商入驻经营类目列表</h1></div><!--box-title end-->     
    <div class="box-content">
        <div class="box-header">
            <?php if(empty($_GET['fater_id'])){?>
                <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a>
            <?php }else{?>
                <a class="btn" href="<?php echo $this->createUrl('create', array('faterId'=>$_GET['fater_id']));?>"><i class="fa fa-plus"></i>添加</a>
                <span class="back" style="float:right"><a href="javascript:;" class="btn" onclick="getBack();"><i class="fa fa-reply"></i>返回</a></span>
            <?php }?>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入关键字" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="text-align: center;" class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="text-align: center;" class="list-id">序号</th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('ct_code');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('ct_mark');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('ct_name');?></th>
                        <th style="text-align: center;">操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td style="text-align: center;" class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style="text-align: center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style="text-align: center;"><?php echo $v->ct_code; ?></td>
                        <td style="text-align: center;"><?php echo $v->ct_mark; ?></td>
                        <td style="text-align: center;"><?php echo $v->ct_name; ?></a></td>
                        <td style="text-align: center;">
                            <a class="btn" href="<?php echo $this->createUrl('index', array('fater_id'=>$v->id));?>" title="二级类型">下级类目</a>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
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
    var deleteUrl = '<?php echo $this->createUrl('delete',array('id'=>'ID')); ?>';
    function getBack(){
        history.go(-1);
    }
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
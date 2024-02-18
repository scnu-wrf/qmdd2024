<?php
    if(!isset( $_REQUEST['pid'])){
        $_REQUEST['pid']=1;
    }
    $project=ProjectList::model()->findAll();
    foreach($arclist as $h){
        $game_project=GameListData::model()->findAll('project_id='.$h->id.' ');
        if(!empty($game_project))foreach($game_project as $k){
            $count=count($k->project_id);
        }
    }
?>
<script>
    var p_project=<?php echo $count; ?>
</script>
<div class="box">
    <span style="float:right;padding-right:15px;">
        <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
    </span>
    <div class="box-title c"><h1>当前界面：项目》平台项目管理》平台项目列表</div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create',array('pid'=>$_REQUEST['pid']));?>"><i class="fa fa-plus"></i>添加</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入国际编码或项目名称">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
                <button class="btn btn-blue" type="button" onclick="javascript:excel();">导出</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th class="list-id">序号</th>
                        <th><?php echo $model->getAttributeLabel('CODE');?></th>
                        <th>项目名称(一级)</th>
                        <th>项目名称(二级)</th>
                        <th><?php echo $model->getAttributeLabel('project_e_name');?></th>
                        <th><?php echo $model->getAttributeLabel('IF_VISIBLE');?></th>
                        <th><?php echo $model->getAttributeLabel('IF_DEFAULT');?></th>
                        <th><?php echo $model->getAttributeLabel('uDate');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php
    $index = 1;
    foreach($arclist as $v){
?>
                    <tr id="poj_<?php echo $v->id;?>">
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->CODE; ?></td>
                        <td><?php echo $v->project_type==1?$v->project_name:''; ?></td>
                        <td><?php echo $v->project_type==2?$v->project_name:''; ?></td>
                        <td><?php echo $v->project_e_name; ?></td>
                        <td><?php echo $v->if_visible_name; ?></td>
                        <td><?php echo $v->if_default_name; ?></td>
                        <td><?php echo $v->uDate; ?></a></td>
                        <td style='text-align: center;width:15%;'>
                            <!-- <a class="btn" href="<?php //echo $this->createUrl('index',array('pid'=>$v->project_type+1,'CODE' => $v->CODE));?>" title="下级项目">子项目</a> -->
                            <?php if($v->project_type==1){?>
                                <a class="btn" href="<?php echo $this->createUrl('create',array('pid'=>$v->project_type+1,'fater_id'=>$v->id));?>">添加二级</a>
                            <?php } ?>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <?php
                                $game_project1=GameListData::model()->findAll('project_id='.$v->id);
                                $game_project2=GameListData::model()->findAll('game_name_id='.$v->id);
                                ?>
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
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
    function d_error(){
        we.msg('minus','项目正在使用，请先处理');
    }
    function excel(){
        $("#is_excel").val(1);
        $("#submit_button").click();
        $("#is_excel").val(0);
    }
</script>
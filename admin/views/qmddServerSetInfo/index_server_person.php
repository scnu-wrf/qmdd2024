<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约》动动约管理》<a class="nav-a">服务上下架</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-detail-tab" style="margin-top: 15px;">
            <ul class="c">
                <li style="width:150px;"><a href='javascript:alert("功能调整中");'>场地</a></li>
                <li class="current" style="width:150px;"><a href="<?=$this->createUrl('index_server_person')?>">服务者</a></li>
                <li style="width:150px;"><a href='javascript:alert("暂未开放");'>约赛</a></li>
                <li style="width:150px;"><a href='javascript:alert("暂未开放");'>约练</a></li>
            </ul>
        </div>
        <div class="box-header">
            <a class="btn" style="text-align: center; width: 80px; background-color: #ff8e24;" href="<?php echo $this->createUrl(''); ?>">上架管理</a>
            <a class="btn" style="text-align: center; width: 80px; margin-left: -5px;" href="<?php echo $this->createUrl(''); ?>">待审核&nbsp;<span class="red"><?php // echo $state_count; ?></span></a>
            <a class="btn" style="text-align: center; width: 80px; margin-left: -5px;" href="<?php echo $this->createUrl(''); ?>">已上架&nbsp;<span class="red"><?php // echo $state_count; ?></span></a>
            <a class="btn" style="text-align: center; width: 80px; margin-left: -5px;" href="<?php echo $this->createUrl(''); ?>">已下架</a>
            <?php // foreach($server_type as $v){
                // $name = $v->t_name;
                // if($v->id==1) $name = '场地';
                // echo show_command('添加',$this->createUrl('create',array('type'=>$v->id,'typename'=>$name)),'发布'.$name).' ';
            // }?>
            <?php // echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <!-- <label style="margin-right:10px;">
                    <span>服务类型：</span>
                    <?php // echo downList($server_type,'id','t_name','server_type'); ?>
                </label> -->
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <!-- <input style="width:200px;" class="input-text"  placeholder="请输入发布编号/标题" type="text" name="keywords" value="<?php // echo Yii::app()->request->getParam('keywords');?>"> -->
                    <input style="width:200px;" class="input-text"  placeholder="场馆/服务者名称" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <tr>
                    <td width="15%">服务项目</td>
                    <td>
                        <?php // echo $form->checkBoxList($model, 'project_id', Chtml::listData($project, 'id', 'project_name'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                    </td>
                </tr>
                <tr>
                    <td>类别</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>无可售数据</td>
                </tr>
            </table><br>
            <table class="list">
                    <tr class="table-title">
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style='text-align: center; width:25px;'>序号</th>
                        <th width="15%"><?php echo $model->getAttributeLabel('set_code');?></th>
                        <th width="15%"><?php echo $model->getAttributeLabel('set_name');?></th>
                        <th><?php echo $model->getAttributeLabel('f_typeid');?></th>
                        <th>服务资源</th>
                        <th>服务项目</th>
                        <th><?php echo $model->getAttributeLabel('server_start');?></th>
                        <th><?php echo $model->getAttributeLabel('if_user_state');?></th>
                        <th><?php echo $model->getAttributeLabel('f_check');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
<?php $index = 1;
if(is_array($arclist)) foreach($arclist as $v){ ?>
<?php
$pro='';
$sitelist=QmddServerSetList::model()->findAll('(info_id='.$v->id.') group by project_ids');
if(!empty($sitelist)) foreach ($sitelist as $p) $pro.=$p->project_ids.',';
$arrp=explode(',',$pro);
$arrp = array_unique(array_filter($arrp));
$projectname='';
if(!empty($arrp))foreach($arrp as $g){
    $pn=ProjectList::model()->find('id='.$g);
    $projectname.=$pn->project_name.';';
}
?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->set_code; ?></td>
                        <td><?php echo $v->set_name; ?></td>
                        <td><?php if(!empty($v->servertype)) echo $v->servertype->t_name; ?></td>
                        <td><?php if(!empty($v->set_list)) foreach ($v->set_list as $l) echo $l->s_name.';'; ?></td>
                        <td><?php echo $projectname; ?></td>
                        <td><?php echo $v->server_start; ?><br><?php echo $v->server_end; ?></td>
                        <td><?php echo $v->user_state_name; ?></td>
                        <td><?php echo $v->f_check_name; ?></td>
                        <td>
                            <?php if($v->f_check==721 || $v->f_check==1538){ ?>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑">编辑</a>
                        <?php } else{ ?>
                            <a class="btn" href="<?php echo $this->createUrl('update_check', array('id'=>$v->id,'list'=>'index'));?>" title="详情">详情</a>
                        <?php } ?>
                        <?php if($v->f_check==371){ ?>
                            <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $v->id;?>', cancel);" title="撤销提交">撤销</a>
                        <?php } else{ ?>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除">删除</a>
                        <?php } ?>
                        </td>
                    </tr>
<?php } ?>
                </table>

        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
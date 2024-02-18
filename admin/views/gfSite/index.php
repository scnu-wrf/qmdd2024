<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约》资源登记》<a class="nav-a">场馆登记</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-detail-tab" style="margin-top: 15px;">
            <ul class="c">
                <li class="current" style="width:150px;"><a href="<?=$this->createUrl('index')?>">登记中</a></li>
                <li style="width:150px;"><a href="<?=$this->createUrl('index_list')?>">已登记</a></li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" placeholder="编号 / 名称" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
                <?php echo show_command('添加',$this->createUrl('create'),'添加'); ?>
                <?php echo show_command('批删除','','删除'); ?>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style='text-align: center; width:25px;'>序号</th>
                        <th width="10%"><?php echo $model->getAttributeLabel('site_code');?></th>
                        <th width="10%"><?php echo $model->getAttributeLabel('site_name');?></th>
                        <th><?php echo $model->getAttributeLabel('site_level');?></th>
                        <th><?php echo $model->getAttributeLabel('site_envir');?></th>
                        <th><?php echo $model->getAttributeLabel('project_list');?></th>
                        <th>场馆权属</th>
                        <th><?php echo $model->getAttributeLabel('area_province');?></th>
                        <th><?php echo $model->getAttributeLabel('site_state');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1;
    foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check<?php if($v->site_state!=371){ ?> check-item<?php } ?>"><input class="input-check" type="checkbox"<?php if($v->site_state==371){ ?> disabled<?php } ?> value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->site_code; ?></td>
                        <td><?php echo $v->site_name; ?></td>
                        <td><?php echo $v->site_level_name; ?></td>
                        <td><?php if(!empty($v->site_envir)) $envir=BaseCode::model()->findAll('f_id in('.$v->site_envir.')');
                         if(!empty($envir)) foreach ($envir as $e) echo $e->F_NAME.' '; ?></td>
                        <td><?php if(!empty($v->project_list)){
                            $project=ProjectList::model()->findAll('id in('.$v->project_list.')');
                            $tx='';
                            if(count($project)>=2){
                                $tx=$project[0]['project_name'].' '.$project[1]['project_name'].'...';
                            } elseif (count($project)==1) {
                                $tx=$project[0]['project_name'];
                            }
                            echo $tx;
                        }  ?></td>
                        <td><?php if(!empty($v->origin)) echo $v->origin->F_NAME; ?></td>
                        <td><?php echo $v->area_province; ?><?php echo $v->area_city; ?><?php echo $v->area_district; ?></td>
                        <td><?php echo $v->site_state_name; ?></td>
                        <td>
                            <?php if($v->site_state==721 || $v->site_state==1538){ ?>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑">编辑</a>
                        <?php } else{ ?>
                            <a class="btn" href="<?php echo $this->createUrl('update_check', array('id'=>$v->id,'list'=>'index'));?>" title="详情">详情</a>
                        <?php } ?>
                        <?php if($v->site_state==371){ ?>
                            <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $v->id;?>', cancel);" title="撤销提交">撤销</a>
                        <?php } else{ ?>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除">删除</a>
                        <?php } ?>
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
    var cancel = '<?php echo $this->createUrl('cancelSubmit', array('id'=>'ID'));?>';
</script>
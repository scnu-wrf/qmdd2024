<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约》资源登记》<a class="nav-a">场馆登记</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" placeholder="场馆编号 / 场馆名称" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
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
                        <th style='text-align: center; width:25px;'>序号</th>
                        <th><?php echo $model->getAttributeLabel('site_code');?></th>
                        <th><?php echo $model->getAttributeLabel('site_name');?></th>
                        <th><?php echo $model->getAttributeLabel('contact_phone');?></th>
                        <th><?php echo $model->getAttributeLabel('site_address');?></th>
                        <th><?php echo $model->getAttributeLabel('site_level_name');?></th>
                        <th><?php echo $model->getAttributeLabel('site_state_name');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1;
    foreach($arclist as $v){ ?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->site_code; ?></td>
                        <td><?php echo $v->site_name; ?></td>
                        <td><?php echo $v->contact_phone; ?></td>
                        <td><?php echo $v->site_address; ?></td>
                        <td><?php echo $v->site_level_name; ?></td>
                        <td><?php echo $v->site_state_name; ?></td>
                        <td>
                        <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑">编辑</a>
                        <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除">删除</a>
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
    var deleteUrl = '<?php echo $this->createUrl('delete1', array('id'=>'ID'));?>'; 
    var cancel = '<?php echo $this->createUrl('cancelSubmit', array('id'=>'ID'));?>';
</script>
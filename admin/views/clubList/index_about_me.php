<div class="box">
    <div class="box-title c"><h1>当前界面：首页 》关于我们 》各单位关于我们查询</h1>
    <span style="float:right;padding-right:15px;">
        <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
    </span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th style="width:300px">发布单位</th>
                        <th><?php echo $model->getAttributeLabel('about_me_time');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $basepath=BasePath::model()->getPath(123);?>
                    <?php $index = 1;foreach($arclist as $v){ ?>
                    <tr> 	      
                        <td><span class="num num-1"><?php echo $index; ?></td>
                        <td><?php echo $v->club_name;?></td>
                        <td><?php echo $v->about_me_time;?></td>
                        <td>
                            <?php echo show_command('修改',$this->createUrl('about_me', array('id'=>$v->id,'is_use'=>'yes'))); ?>
                        </td>
					<?php $index++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
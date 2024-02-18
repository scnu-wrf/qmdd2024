
<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约》服务管理》服务发布审核》<a class="nav-a">待审核</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('qmddServerSetInfo/index_pass');?>');"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                     <span>关键字：</span>
                    <input style="width:200px;" class="input-text"  placeholder="请输入发布编号/标题" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>    
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                	<tr class="table-title">
                        <th style='text-align: center; width:25px;'>序号</th>
                        <th width="15%"><?php echo $model->getAttributeLabel('set_code');?></th>
                        <th width="15%"><?php echo $model->getAttributeLabel('set_name');?></th>
                        <th><?php echo $model->getAttributeLabel('f_typeid');?></th>
                        <th>服务资源</th>
                        <th>服务项目</th>
                        <th><?php echo $model->getAttributeLabel('server_start');?></th>
                        <th>服务价格</th>
                        <th><?php echo $model->getAttributeLabel('if_user_state');?></th>
                        <th><?php echo $model->getAttributeLabel('f_check');?></th>
                        <th>操作</th>
                    </tr>
<?php $index = 1;
if(is_array($arclist)) foreach($arclist as $v){ ?>
<?php $listdata1=QmddServerSetData::model()->find('info_id='.$v->id.' order by sale_price ASC'); ?>
<?php $listdata2=QmddServerSetData::model()->find('info_id='.$v->id.' order by sale_price DESC'); ?>
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
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->set_code; ?></td>
                        <td><?php echo $v->set_name; ?></td>
                        <td><?php if(!empty($v->servertype)) echo $v->servertype->t_name; ?></td>
                        <td><?php if(!empty($v->set_list)) foreach ($v->set_list as $l) echo $l->s_name.';'; ?></td>
                        <td><?php echo $projectname; ?></td>
                        <td><?php echo $v->server_start; ?><br><?php echo $v->server_end; ?></td>
                        <td><?php if(!empty($listdata1)) echo $listdata1->sale_price; ?>-
                            <?php if(!empty($listdata2)) echo $listdata2->sale_price; ?></td>
                        <td><?php echo $v->user_state_name; ?></td>
                        <td><?php echo $v->f_check_name; ?></td>
                        <td>
                        	<a class="btn" href="<?php echo $this->createUrl('update_check', array('id'=>$v->id,'list'=>'check'));?>" title="详情">审核</a>
                        </td>
                    </tr>
<?php } ?>
                </table>
                 
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>

$(function(){
	var $star=$('#star');
    var $end=$('#end');
	$star.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
});

</script>

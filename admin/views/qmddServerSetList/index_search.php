<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约》服务查询》<a class="nav-a">各单位已发布服务查询</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>审核日期：</span>
                    <input style="width:80px;" class="input-text" type="text" id="star" name="star" value="<?php echo $star;?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="请输入资源编号/资源名称/发布编号" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style='text-align: center;'>序号</th>
                        <th width="15%">发布编号</th>
                        <th><?php echo $model->getAttributeLabel('t_typeid');?></th>
                        <th><?php echo $model->getAttributeLabel('s_name');?></th>
                        <th><?php echo $model->getAttributeLabel('project_ids');?></th>
                        <th><?php echo $model->getAttributeLabel('server_start');?></th>
                        <th>服务价格</th>
                        <th><?php echo $model->getAttributeLabel('add_time');?></th>
                        <th><?php echo $model->getAttributeLabel('club_id');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1;
if (is_array($arclist)) foreach($arclist as $v){ ?>
<?php $listdata1=QmddServerSetData::model()->find('list_id='.$v->id.' order by sale_price ASC'); ?>
<?php $listdata2=QmddServerSetData::model()->find('list_id='.$v->id.' order by sale_price DESC'); ?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php if(!empty($v->info)) echo $v->info->set_code; ?></td>
                        <td><?php if(!empty($v->s_type)) echo $v->s_type->t_name; ?>-<?php if(!empty($v->s_usertype)) echo $v->s_usertype->f_uname; ?></td>
                        <td><?php echo $v->s_name; ?></td>
                        <td><?php if ($v->project_ids != '') {
				$project = ProjectList::model()->findAll('id in (' . $v->project_ids . ')');
			} ?>
            <?php if(!empty($project )) foreach ($project as $p) {
				echo $p->project_name.' ';
			}
			?>
            			</td>
                        <td><?php echo $v->server_start; ?><br><?php echo $v->server_end; ?></td>
                        <td><?php if(!empty($listdata1)) echo $listdata1->sale_price; ?>-
                            <?php if(!empty($listdata2)) echo $listdata2->sale_price; ?></td>
                        <td><?php if(!empty($v->info)) echo $v->info->reasons_time; ?></td>
                        <td><?php echo $v->club_name; ?></td>
                        <td><a class="btn" href="<?php echo $this->createUrl('qmddServerSetInfo/update_check', array('id'=>$v->info_id,'list'=>'search'));?>" title="详情">详情</a>&nbsp;<a class="btn" href="javascript:;" onclick="fnMemberprice(<?php echo $v->id;?>);" title="可约服务明细">价格明细</a></td>
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

// 查看服务时间价格
var fnMemberprice=function(detail_id){
    $.dialog.open('<?php echo $this->createUrl("qmddServerSetInfo/memberprice");?>&detail_id='+detail_id,{
        id:'huiyuanjia',
        lock:true,
        opacity:0.3,
        title:'服务时间价格表',
        width:'100%',
        height:'100%',
        close: function () {}
    });
};

</script>
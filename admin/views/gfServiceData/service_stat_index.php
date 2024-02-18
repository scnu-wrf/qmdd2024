<?php 
    $myDate=$nowDate;
?>
<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>已售服务查询</h1><br><br>
        <small>可按月查询各服务类别的详细预定及服务情况</small>
    </div>
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="news_type" value="<?php echo Yii::app()->request->getParam('news_type');?>">
                <!-- <label style="margin-right:10px">
                    <span>关键字：</span>
                    <input type="text" style="width:200px;" class="input-text" name="keywords" value="<?php //echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入功能名称">
                </label> -->
                <label style="margin-right:20px;">
                    <span>服务项目：</span>
                    <select name="project_id">
                        <option value="">请选择</option>
                        <?php foreach($project_id as $v){?>
                        <option value="<?php echo $v->id;?>"<?php if(Yii::app()->request->getParam('project_id')==$v->id){?> selected<?php }?>><?php echo $v->project_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>服务类别：</span>
                    <select id="server_type" name="server_type">
                        <option value="">请选择</option>
                        <?php foreach($server_type_list as $v){?>
                        <option value="<?php echo $v->id;?>"<?php if(Yii::app()->request->getParam('server_type')==$v->id){?> selected<?php }?>><?php echo $v->f_uname;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>查询月份：</span>
                    <input style="width:120px;" class="input-text" type="text" id="s_date" name="s_date" value="<?php echo $myDate;?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-header end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="text-align: center;">序号</th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('project_name');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('t_stypename');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('data_name');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('service_name');?></th>
                        <th style="text-align: center;">未服务数量</th>
                        <th style="text-align: center;">已服务数量</th>
                        <th style="text-align: center;">操作</th>
                    </tr>
                </thead>
                <tbody>
<?php 
$index = 1;
foreach($arclist as $v){
?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style="text-align: center"><?php echo $v->project_name; ?></td>
                        <td style="text-align: center"><?php echo $v->t_stypename; ?></td>
                        <td style="text-align: center"><?php echo $v->service_name; ?></td>
                        <td style="text-align: center"><?php if(!empty($v->service_name)&&!empty($v->sName))echo $v->sName->server_name; ?></td>
                        <td style="text-align: center"><?php echo $v->count1; ?></td>
                        <td style="text-align: center"><?php echo $v->count2; ?></td>
                        <td style='text-align: center;'>
                            <a class="btn" href="<?php echo $this->createUrl('service_stat_update', array('id'=>$v->service_id,'projectId'=>$v->project_id,'typeId'=>$v->t_stypeid,'date'=>$myDate));?>" title="编辑"><i class="fa fa-edit"></i></a>
                        </td>
                    </tr>
<?php $index++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>
<script>
    $(function(){
        var $star_time=$('#s_date');
        $star_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM'});
        });
    });
</script>
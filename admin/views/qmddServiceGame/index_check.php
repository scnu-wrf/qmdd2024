
<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-home"></i>当前界面：动动约>服务资源审核><a class="nav-a">赛事服务资源审核</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search" style=" border:none;">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="news_type" value="<?php echo Yii::app()->request->getParam('news_type');?>">
                <table width="100%">   
                	<tr>
                    	<td width="100">登记时间：</td>
                        <td>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                		</td>
                    	<td width="100">服务区域：</td>
                        <td>
                    <select name="province"></select><select name="city"></select><select name="area"></select>
                    <script>new PCAS("province","city","area","<?php echo Yii::app()->request->getParam('province');?>","<?php echo Yii::app()->request->getParam('city');?>","<?php echo Yii::app()->request->getParam('site_address');?>");</script>
                		</td>
                </tr>
                <tr>
                	<td><label>按项目：</label></td>
                    <td>
                    <label><?php echo downList($project_list,'id','project_name','project'); ?></label>
                	</td>
                    <td><label>关键字：</label></td>
                    <td><label><input type="text" style="width:200px;" class="input-text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入资源编码 / 资源名称"></label>
                <button class="btn btn-blue" type="submit">查询</button>
                	</td>
                </tr>
            </table>
            </form>
        </div><!--box-header end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check">序号</th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('service_code');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('title');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('server_name');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('project_id');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('imgUrl');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('club_name');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('state_name');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('uDate');?></th>
                        <th style="text-align: center;">操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $basepath=BasePath::model()->getPath(175);?>
<?php 
$index = 1;
foreach($arclist as $v){
?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style="text-align: center"><?php echo $v->service_code; ?></td>
                        <td style="text-align: center"><?php echo $v->title; ?></td>
                        <td style="text-align: center"><?php echo $v->server_name; ?></td>
                        <td style="text-align: center"><?php echo $v->project_name; ?></td>
                        <td style="text-align: center"><a href="<?php echo $basepath->F_WWWPATH.$v->imgUrl; ?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v->imgUrl; ?>" style="max-height:50px; max-width:50px;"></a></td>
                        <td style="text-align: center"><?php echo $v->club_name; ?></td>
                        <td style="text-align: center"><?php echo $v->state_name; ?></td>
                        <td style="text-align: center"><?php echo $v->uDate; ?></td>
                        <td style='text-align: center;'>
                            <a class="btn" href="<?php echo $this->createUrl('update_check', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
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

    $(function(){
        var $start_time=$('#start_date');
        var $end_time=$('#end_date');
        $start_time.on('click', function(){
            var end_input=$dp.$('end_date')
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'end_date\')}'});
        });
        $end_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'start_date\')}'});
        });
    });
</script>
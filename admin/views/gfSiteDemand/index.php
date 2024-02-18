<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>场地需求</h1></div><!--box-title end-->      
    <div class="box-content">
        <div class="box-header">
            <!--<a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a>-->
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>按环境：</span>
                    <select name="site_envir">
                        <option value="">请选择</option>
                        <?php  foreach($site_envir as $v){?>
                        <option value="<?php  echo   $v->f_id;?>"<?php if(Yii::app()->request->getParam('site_envir')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>所属类型：</span>
                    <select name="site_belong">
                        <option value="">请选择</option>
                        <?php  foreach($site_belong as $v){?>
                        <option value="<?php  echo   $v->f_id;?>"<?php if(Yii::app()->request->getParam('site_belong')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>按星级：</span>
                    <select name="site_level">
                        <option value="">请选择</option>
                        <?php  foreach($site_level as $v){?>
                        <option value="<?php  echo   $v->f_id;?>"<?php if(Yii::app()->request->getParam('site_level')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>按状态：</span>
                    <select name="site_state">
                        <option value="">请选择</option>
                        <?php  foreach($site_state as $v){?>
                        <option value="<?php  echo   $v->f_id;?>"<?php if(Yii::app()->request->getParam('site_state')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>服务地区：</span>
                    <select name="province"></select><select name="city"></select><select name="area"></select>
                    <script>new PCAS("province","city","area","<?php echo Yii::app()->request->getParam('province');?>","<?php echo Yii::app()->request->getParam('city');?>","<?php echo Yii::app()->request->getParam('site_address');?>");</script>
                </label>
                <br>
                <label style="margin-right:10px;">
                    <span>有效期时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入场地名称或产权所属人">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th class="list-id">序号</th>
                        <th><?php echo $model->getAttributeLabel('site_code');?></th>
                        <th><?php echo $model->getAttributeLabel('site_pic');?></th>
                        <th><?php echo $model->getAttributeLabel('site_name');?></th>
                        <th><?php echo $model->getAttributeLabel('site_address');?></th>
                        <th><?php echo $model->getAttributeLabel('belong_name');?></th>
                        <th><?php echo $model->getAttributeLabel('user_club_name');?></th>
                        <th><?php echo $model->getAttributeLabel('site_level');?></th>
                        <th><?php echo $model->getAttributeLabel('site_state');?></th>
                        <th><?php echo $model->getAttributeLabel('register_time');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $basepath=BasePath::model()->getPath(170);?>
				<?php
                $index = 1;
                 foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td> 
                        <td><?php echo $v->site_code; ?></td>
                        <td><a href="<?php echo $basepath->F_WWWPATH.$v->site_pic; ?>" target="_blank"><div style="width:50px; height:50px;overflow:hidden;"><img src="<?php echo $basepath->F_WWWPATH.$v->site_pic; ?>" width="50"></div></a></td>
                        <td><?php echo $v->site_name; ?></a></td>
                        <td><?php echo $v->site_address; ?></td>
                        <td><?php echo $v->belong_name; ?></td>
                        <td><?php echo $v->user_club_name; ?></td>
                        <td><?php echo $v->site_level_name; ?></td>
                        <td><?php echo $v->site_state_name; ?></td>
                        <td><?php echo $v->register_time; ?></td>
                        <td>
                             <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                        </td>
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
</script>
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
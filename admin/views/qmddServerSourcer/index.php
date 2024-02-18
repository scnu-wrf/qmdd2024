<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-home"></i>当前界面：动动约>服务发布管理><a class="nav-a">可售服务资源</a></h1>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <!--a class="btn" href="<php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a-->
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>编号/名称：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <label style="margin-right:20px;">
                    <span>服务类型：</span>
                    <select name="type">
                        <option value="">请选择</option>
                        <?php  foreach($type as $v){?>
                        <option value="<?php  echo $v->id;?>"<?php if(Yii::app()->request->getParam('type')==$v->id){?> selected<?php }?>><?php echo $v->t_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>服务地区：</span>
                    <select name="province"></select><select name="city"></select><select name="area"></select>
                    <script>new PCAS("province","city","area","<?php echo Yii::app()->request->getParam('province');?>","<?php echo Yii::app()->request->getParam('city');?>","<?php echo Yii::app()->request->getParam('area');?>");</script>
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('s_code');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('project_ids');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('t_typeid');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('s_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('server_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('club_id');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('add_time');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                 foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php echo $v->s_code; ?></td>
                        <td>
                            <?php if(!empty($v->project_ids)){ 
							$project = ProjectList::model()->findAll('id in('.$v->project_ids.')');						
								foreach($project as $p){	
									echo $p->project_name.' ';
                                    } 	
								} ?>
                        </td>
                        <td><?php if(!empty($v->s_type)) echo $v->s_type->t_name; ?></td>
                        <td><?php echo $v->s_name; ?></td>
                        <td><?php echo $v->server_name; ?></td>
                        <td><?php echo $v->club_name; ?></td>
                        <td><?php echo $v->add_time; ?></td>
                        <td>
                            <!--a class="btn" href="<php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a-->
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                <?php } ?>
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
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>服务器列表</h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>服务器代码：</span>
                    <select id="server_code" name="server_code">
                        <option value="">请选择</option>
                        <?php foreach($gf_server as $v){?>
                        <option value="<?php echo $v->id;?>"<?php if(Yii::app()->request->getParam('server_code')!==null && Yii::app()->request->getParam('server_code')!==''  && Yii::app()->request->getParam('server_code')==$v->id){?> selected<?php }?>><?php echo $v->adv_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:10px;">
//                  <span>发布单位：</span>
//                  <input id="club" style="width:200px;" class="input-text" type="text" name="club" value="<?php echo Yii::app()->request->getParam('club');?>">
//               </label>
                <label style="margin-right:20px;">
                    <span>服务器管理员ID</span>
                    <select id="server_adminid" name="server_adminid">
                        <option value="">请选择</option>
                        <?php foreach($base_code as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('server_adminid')!==null && Yii::app()->request->getParam('server_adminid')!==''  && Yii::app()->request->getParam('server_adminid')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>服务器类型</span>
                    <select id="server_type" name="server_type">
                        <option value="">请选择</option>
                        <option value="1"<?php if(Yii::app()->request->getParam('server_type')!==null && Yii::app()->request->getParam('server_type')!==''  && Yii::app()->request->getParam('server_type')==1){?> selected<?php }?>>上线</option>
                        <option value="0"<?php if(Yii::app()->request->getParam('server_type')!==null && Yii::app()->request->getParam('server_type')!==''  && Yii::app()->request->getParam('server_type')==0){?> selected<?php }?>>下线</option>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>服务器类型名称</span>
                    <select id="server_type_name" name="server_type_name">
                        <option value="">请选择</option>
                        <?php foreach($base_code as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('server_type_name')!==null && Yii::app()->request->getParam('server_type_name')!==''  && Yii::app()->request->getParam('server_type_name')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                                <label style="margin-right:20px;">
                    <span>服务器项目</span>
                    <select id="server_item" name="server_item">
                        <option value="">请选择</option>
                        <?php foreach($base_code as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('server_item')!==null && Yii::app()->request->getParam('server_item')!==''  && Yii::app()->request->getParam('server_item')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>             
                   <label style="margin-right:20px;">
                    <span>服务器项目名称</span>
                    <select id="server_item_name" name="server_item_name">
                        <option value="">请选择</option>
                        <?php foreach($base_code as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('server_item_name')!==null && Yii::app()->request->getParam('server_item_name')!==''  && Yii::app()->request->getParam('server_item_name')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>              
                  <label style="margin-right:20px;">
                    <span>服务器名称</span>
                    <select id="server_name" name="server_name">
                        <option value="">请选择</option>
                        <?php foreach($base_code as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('server_name')!==null && Yii::app()->request->getParam('server_name')!==''  && Yii::app()->request->getParam('server_name')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>              
                  <label style="margin-right:20px;">
                    <span>服务器ip地址</span>
                    <select id="server_ip_address" name="server_ip_address">
                        <option value="">请选择</option>
                        <?php foreach($base_code as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('server_ip_address')!==null && Yii::app()->request->getParam('server_ip_address')!==''  && Yii::app()->request->getParam('server_ip_address')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>                <label style="margin-right:20px;">
                    <span>服务器区域</span>
                    <select id="server_area" name="server_area">
                        <option value="">请选择</option>
                        <?php foreach($base_code as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('server_area')!==null && Yii::app()->request->getParam('server_area')!==''  && Yii::app()->request->getParam('server_area')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>              
                  <label style="margin-right:20px;">
                    <span>经度</span>
                    <select id="longitude" name="longitude">
                        <option value="">请选择</option>
                        <?php foreach($base_code as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('longitude')!==null && Yii::app()->request->getParam('longitude')!==''  && Yii::app()->request->getParam('longitude')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>               
                 <label style="margin-right:20px;">
                    <span>纬度</span>
                    <select id="latitude" name="latitude">
                        <option value="">请选择</option>
                        <?php foreach($base_code as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('latitude')!==null && Yii::app()->request->getParam('latitude')!==''  && Yii::app()->request->getParam('latitude')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>                
                <label style="margin-right:20px;">
                    <span>if用户</span>
                    <select id="if_user" name="if_user">
                        <option value="">请选择</option>
                        <?php foreach($base_code as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('if_user')!==null && Yii::app()->request->getParam('if_user')!==''  && Yii::app()->request->getParam('if_user')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                 <label style="margin-right:20px;">
                    <span>if删除</span>
                    <select id="if_del" name="if_del">
                        <option value="">请选择</option>
                        <?php foreach($base_code as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('if_del')!==null && Yii::app()->request->getParam('if_del')!==''  && Yii::app()->request->getParam('if_del')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                 <label style="margin-right:20px;">
                    <span>加入时间</span>
                    <select id="add_time" name="add_time">
                        <option value="">请选择</option>
                        <?php foreach($base_code as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('add_time')!==null && Yii::app()->request->getParam('add_time')!==''  && Yii::app()->request->getParam('add_time')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>

                <br>
                <label style="margin-right:10px;">
                    <span>上线日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>排序：</span>
                    <select id="sorttype" name="sorttype">
                        <option value="">请选择</option>
                        <option value="online"<?php if(Yii::app()->request->getParam('sorttype')=='online'){?>selected<?php }?>>上线先后</option>
                    </select>
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('server_code');?></th>
                        <th><?php echo $model->getAttributeLabel('server_adminid');?></th>
                        <th><?php echo $model->getAttributeLabel('server_type');?></th>
                        <th><?php echo $model->getAttributeLabel('server_type_name');?></th>
                        <th><?php echo $model->getAttributeLabel('server_item');?></th>
                        <th><?php echo $model->getAttributeLabel('server_item_name');?></th>
                        <th><?php echo $model->getAttributeLabel('server_name');?></th>
                        <th><?php echo $model->getAttributeLabel('server_ip_address');?></th>
                        <th><?php echo $model->getAttributeLabel('server_area');?></th>
                        <th><?php echo $model->getAttributeLabel('longitude');?></th>
                        <th><?php echo $model->getAttributeLabel('latitude');?></th>
                        <th><?php //echo $model->getAttributeLabel('if_user');?></th>
                        <th><?php echo $model->getAttributeLabel('if_del');?></th>
                        <th><?php echo $model->getAttributeLabel('add_time');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $basepath=BasePath::model()->getPath(116);?>
                    <?php $base_code_arr=array(); foreach($base_code as $v){ $base_code_arr[$v->f_id]=$v->F_NAME;}?>
                    <?php if(Yii::app()->request->getParam('type')>0 && Yii::app()->request->getParam('sorttype')=='online'){ $adver_name=AdverName::model()->getOne(Yii::app()->request->getParam('type')); $dispay_num=$adver_name->dispay_num;}?>
					<?php 
                    $i=1; 
                    $index = 1;
                    foreach($arclist as $v){ ?>
                    <tr class="<?php if(Yii::app()->request->getParam('type')>0 && Yii::app()->request->getParam('sorttype')=='online'){ if(($dispay_num=='' || $i<=$dispay_num) && $v->select_id==1){ ?>showed<?php }}?>">
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><a href="<?php //echo $basepath->F_WWWPATH.$v->advertisement_pic; ?>" target="_blank"><img width="50" src="<?php //echo $basepath->F_WWWPATH.$v->advertisement_pic; ?>"></a></td>
                        <td><?php echo $v->ADVER_TITLE; ?><?php if(Yii::app()->request->getParam('type')>0 && Yii::app()->request->getParam('sorttype')=='online'){ if(($dispay_num=='' || $i<=$dispay_num) && $v->select_id==1){ ?><span style="color:#f00;">(正在展示)</span><?php }}?></td>
                        <td><?php echo $v->server_code; ?></td>
                        <td><?php echo $v->server_adminid; ?></td>
                        <td><?php echo $v->server_type; ?></td>
                        <td><?php echo $v->server_type_name; ?></td>
                        <td><?php echo $v->server_item; ?></td>
                        <td><?php echo $v->server_item_name; ?></td>
                        <td><?php echo $v->server_name; ?></td>
                        <td><?php echo $v->server_ip_address; ?></td>
                        <td><?php echo $v->server_area; ?></td>
                        <td><?php echo $v->longitude; ?></td>
                        <td><?php echo $v->latitude; ?></td>
                        <td><?php //echo $v->if_user; ?></td>
                        <td><?php echo $v->if_del; ?></td>
                        <td><?php echo $v->add_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
<?php $i++; $index++;} ?>
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


<?php
    check_request('userstate',0);
    // $session = Yii::app()->session;
    // echo json_encode($session);
?>
<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-home"></i>当前界面：商城>商家上下架管理><a class="nav-a">上架方案商品冻结销售</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="pricing" value="<?php echo Yii::app()->request->getParam('pricing');?>">
                <table width="100%">   
                	<tr>
                    	<td width="100">供应商：</td>
                        <td>
                            <input style="width:200px;" class="input-text"  placeholder="请输入供应商" type="text" name="supplier" value="<?php echo Yii::app()->request->getParam('supplier');?>">
                		</td>
                    	<td width="100">上下线日期：</td>
                        <td>
                            <input style="width:120px;" class="input-text" type="text" id="star_time" name="star_time" value="<?php echo Yii::app()->request->getParam('star_time');?>">
                            <span>-</span>
                            <input style="width:120px;" class="input-text" type="text" id="end_time" name="end_time" value="<?php echo Yii::app()->request->getParam('end_time');?>">
                            </label>
                		</td>
                    </tr>
                    <tr>
                        <td><label>审核状态：</label></td>
                        <td>
                            <label><?php echo downList($base_code,'f_id','F_NAME','state'); ?></label>
                            &nbsp;&nbsp;<label><span style="margin-right:20px;">上下线状态：</span>
                            <select id="userstate" name="userstate">
                                <option value="">请选择</option>
                                <option value="649"<?php if($_REQUEST['userstate']==649){?> selected<?php }?>>上线</option>
                                <option value="648"<?php if($_REQUEST['userstate']==648){?> selected<?php }?>>下线</option>
                            </select></label>
                        </td>
                        <td><label>关键字：</label></td>
                        <td>
                            <label>
                                <input style="width:200px;" class="input-text"  placeholder="请输入方案编码/标题" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                            </label>
                            <button class="btn btn-blue" type="submit">查询</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                <tr class="table-title">
                    <th style="text-align:center;width:4%;">序号</th>
                    <th style="text-align:center;width:10%;"><?php echo $model->getAttributeLabel('event_code');?></th>
                    <th style="text-align:center;width:10%;"><?php echo $model->getAttributeLabel('event_title');?></th>
                    <th style="text-align:center"><?php echo $model->getAttributeLabel('supplier_id');?></th>
                    <th style="text-align:center"><?php echo $model->getAttributeLabel('if_user_state');?></th>
                    <th style="text-align:center"><?php echo $model->getAttributeLabel('f_check');?></th>
                    <th style="text-align:center;"><?php echo $model->getAttributeLabel('frozen_id');?></th>
                    <th style="text-align:center;"><?php echo $model->getAttributeLabel('frozen_time');?></th>
                    <th style="text-align:center">操作</th>
                </tr>
                <?php $index=1; if(is_array($arclist)) foreach($arclist as $v){ ?>
                <tr>
                    <td style="text-align:center"><span class="sum sum-1"><?php echo $index; ?></span></td>
                    <td><?php echo $v->event_code; ?></td>
                    <td><?php echo $v->event_title; ?></td>
                    <td><?php echo $v->supplier_name; ?></td>
                    <td><?php if($v->if_user_state!=null){ $if_user_state=array(648=>'下线', 649=>'上线'); echo $if_user_state[$v->if_user_state]; } ?></td>
                    <td><?php if($v->f_check!=null){ echo $v->base_code->F_NAME; } ?></td>
                    <td><?php if(!empty($v->frozen_id)) echo $v->admin_frozen_id->admin_gfnick; ?></td>
                    <td><?php echo $v->frozen_time; ?></td>
                    <td><?php echo show_command('修改',$this->createUrl('update_supplier_check',array('id'=>$v->id,'frozen'=>'1'))); ?></td>
                </tr>
                <?php $index++; } ?>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    $(function(){
        var $star_time=$('#star_time');
        var $end_time=$('#end_time');
        $star_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm'});
        });
        $end_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm'});
        });
    });
</script>
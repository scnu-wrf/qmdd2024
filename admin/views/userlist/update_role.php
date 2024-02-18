<?php
    //新增角色
?>

<style>.box-detail-tab li{ width:150px; }.item_center table td{text-align:center;}</style>
<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i><?= '当前界面:会员 》会员管理 》注册会员列表 》';?></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->
	<?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
   <div class="box-detail">
        <!-- <div class="box-detail-tab" style="margin-top:10px;">
            <ul class="c">
                <li class="<?//=$_REQUEST['passed']==136?'current':'';?>"><a href="<?php //echo $this->createUrl('create',array('passed'=>136));?>">普通注册</a></li>
                <li class="<?//=$_REQUEST['passed']==2?'current':'';?>"><a href="<?php //echo $this->createUrl('create',array('passed'=>2));?>">实名注册</a></li>
            </ul>
        </div> -->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">

                <table width="100%" class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">会员信息</td>
                    </tr>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($user, 'security_phone'); ?></td>
                        <td><?php echo $user->security_phone; ?></td>
                    </tr>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($user, 'id_card_type'); ?></td>
                        <td><?php echo $user->id_card_type; ?></td>
                    </tr>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($user, 'id_card'); ?></td>
                        <td><?php echo $user->id_card; ?></td>
                    </tr>
                </table>

                <table width="100%" class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">请选择</td>
                    </tr>

                    <tr>
                        <td width="15%"><?php echo '角色类型'; ?></td>
                        <td width="85%" id="df_gf_name">
                            <?php echo $form->dropDownList($role, 'roleCode', Chtml::listData(QmddRoleNew::model()->getUserRole(), 'f_id', 'f_rname'), array('prompt' => '请选择')); ?>
                            <?php  echo $form->error($role, 'roleCode', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td width="15%"><?php echo '标识码'; ?></td>
                        <td>
                            <?php echo $form->textField($role, 'code', array('class' => 'input-text')); ?>
                            <?php echo $form->error($role, 'code', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <div id="reloadRN"><!-- change realname -->
                <table width="100%" style="table-layout:auto; margin-top:10px;">
                    <tr>
                    <td  width="15%">操作</td>
                    <td>
                        <?php echo show_shenhe_box(array('baocun'=>'确认'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                    </tr>
                </table>
                </div><!-- change realname end -->
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
   
</script>
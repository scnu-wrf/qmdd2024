<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>商品毛利方案详情</h1><span class="back"><a href="javascript:;" class="btn" onclick="we.back();"><i class="fa fa-reply">返回</i></a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <div class="box-detail-bd">
                <table class="table-title">
                    <tr>
                        <td colspan="4">基本信息</td>
                    </tr> 
                </table>
                <table>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'f_code'); ?></td>
                        <td width="35%">
                            <?php echo $form->textField($model, 'f_code', array('class'=>'input-text')); ?>
                            <?php echo $form->error($model, 'f_code', $htmlOptions = array()); ?>
                        </td>
                        <td width="15%"><?php echo $form->labelEx($model, 'f_name'); ?></td>
                        <td width="35%">
                            <?php echo $form->textField($model, 'f_name', array('class'=>'input-text')); ?>
                            <?php echo $form->error($model, 'f_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>销售方式</td>
                        <td colspan="3">
                            <?php echo $form->checkBoxList($model, 's_sale', array(3=>'普通销售'),
                              $htmlOptions = array('separator' => '', 'class' => 'input-check','onchange'=>'CheckedType(this,"#s_sale");', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?>
                            <?php echo $form->checkBoxList($model, 's_time', array(6=>'限时抢购'),
                              $htmlOptions = array('separator' => '', 'class' => 'input-check','onchange'=>'CheckedType(this,"#s_time");', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?>  
                            <?php echo $form->checkBoxList($model, 's_club', array(4=>'单位导购'),
                              $htmlOptions = array('separator' => '', 'class' => 'input-check','onchange'=>'CheckedType(this,"#s_club");', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?>  
                            <?php echo $form->checkBoxList($model, 's_sec', array(5=>'二次上架'),
                              $htmlOptions = array('separator' => '', 'class' => 'input-check','onchange'=>'CheckedType(this,"#s_sec");', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?>  
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'f_content'); ?></td>
                        <td colspan="3"><?php echo $form->textField($model, 'f_content', array('class'=>'input-text')); ?></td>
                    </tr>
                </table>
<?php
$a_num=0;
$b_num=0;
$c_num=0;
$id=(!empty($model->id)) ? $model->id : 0;
?>
<!--普通销售-->
            <div class="mt15" id="s_sale">
                <table>
                    <tr class="table-title">
                        <td>普通销售</td>
                    </tr>
                    <tr>
                        <td>销售对象：<span class="red">非单位学员</span></td>
                    </tr>
                </table>
                <?php echo $form->hiddenField($model, 'member'); ?>
                <table>
                    <tr>
                        <td width="12%">管理单位分配</td>
                <?php if(!empty($sharclub)) foreach ($sharclub as $cf) { ?>
                        <td><?php echo $cf->card_name; ?></td>
                <?php }?>
                    </tr>
                    <tr>
                        <td>占总毛利比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_centa='';
                        $s_sale_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=0 and sale_typeid=3 and sale_show_id=1129 and sale_level='.$ms->id);
                        if(!empty($s_sale_data)) $sale_centa=$s_sale_data->sale_centa;
                         ?>
                         <td>
                            <input type="hidden" name="member[<?php echo $a_num; ?>][sale_level]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="member[<?php echo $a_num; ?>][sale_levelname]" value="<?php echo $ms->card_name; ?>">
                            <input type="hidden" name="member[<?php echo $a_num; ?>][is_member]" value="0">
                            <input type="hidden" name="member[<?php echo $a_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="member[<?php echo $a_num; ?>][sale_show_id]" value="1129">
                            <input class="input-text" type="text" name="member[<?php echo $a_num; ?>][sale_centa]" value="<?php echo $sale_centa; ?>" style="width:60%;"></td>
                    <?php $a_num++; } ?>
                    </tr>
                    <tr>
                        <td>分成比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_centb='';
                        $s_sale_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=0 and sale_typeid=3 and sale_show_id=1129 and sale_level='.$ms->id);
                        if(!empty($s_sale_data)) $sale_centb=$s_sale_data->sale_centb;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="member[<?php echo $b_num; ?>][sale_centb]" value="<?php echo $sale_centb; ?>" style="width:60%;"></td>
                    <?php $b_num++; } ?>
                    </tr>
                    <tr>
                        <td>实占总毛利比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_total='';
                        $s_sale_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=0 and sale_typeid=3 and sale_show_id=1129 and sale_level='.$ms->id);
                        if(!empty($s_sale_data)) $sale_total=$s_sale_data->sale_total;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="member[<?php echo $c_num; ?>][sale_total]" value="<?php echo $sale_total; ?>" style="width:60%;"></td>
                    <?php $c_num++; } ?>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td>销售对象：<span class="red">单位学员</span></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="12%">管理单位分配</td>
                <?php if(!empty($sharclub)) foreach ($sharclub as $cf) { ?>
                        <td><?php echo $cf->card_name; ?></td>
                <?php }?>
                    </tr>
                    <tr>
                        <td>占总毛利比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_centa='';
                        $s_sale_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=3 and sale_show_id=1129 and sale_level='.$ms->id);
                        if(!empty($s_sale_data)) $sale_centa=$s_sale_data->sale_centa;
                         ?>
                         <td>
                            <input type="hidden" name="member[<?php echo $a_num; ?>][sale_level]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="member[<?php echo $a_num; ?>][sale_levelname]" value="<?php echo $ms->card_name; ?>">
                            <input type="hidden" name="member[<?php echo $a_num; ?>][is_member]" value="1">
                            <input type="hidden" name="member[<?php echo $a_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="member[<?php echo $a_num; ?>][sale_show_id]" value="1129">
                            <input class="input-text" type="text" name="member[<?php echo $a_num; ?>][sale_centa]" value="<?php echo $sale_centa; ?>" style="width:60%;"></td>
                    <?php $a_num++; } ?>
                    </tr>
                    <tr>
                        <td>分成比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_centb='';
                        $s_sale_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=3 and sale_show_id=1129 and sale_level='.$ms->id);
                        if(!empty($s_sale_data)) $sale_centb=$s_sale_data->sale_centb;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="member[<?php echo $b_num; ?>][sale_centb]" value="<?php echo $sale_centb; ?>" style="width:60%;"></td>
                    <?php $b_num++; } ?>
                    </tr>
                    <tr>
                        <td>实占总毛利比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_total='';
                        $s_sale_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=3 and sale_show_id=1129 and sale_level='.$ms->id);
                        if(!empty($s_sale_data)) $sale_total=$s_sale_data->sale_total;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="member[<?php echo $c_num; ?>][sale_total]" value="<?php echo $sale_total; ?>" style="width:60%;"></td>
                    <?php $c_num++; } ?>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="12%">社区单位(免费)</td>
                <?php if(!empty($clublevel_free)) foreach ($clublevel_free as $cf) { ?>
                        <td><?php echo $cf->card_name; ?></td>
                <?php }?>
                    </tr>
                    <tr>
                        <td>占总毛利比例(%)</td>
                        <?php foreach ($clublevel_free as $ms){
                        $sale_centa='';
                        $s_sale_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=3 and sale_show_id=1129 and sale_level='.$ms->id);
                        if(!empty($s_sale_data)) $sale_centa=$s_sale_data->sale_centa;
                         ?>
                         <td>
                            <input type="hidden" name="member[<?php echo $a_num; ?>][sale_level]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="member[<?php echo $a_num; ?>][sale_levelname]" value="<?php echo $ms->card_name; ?>">
                            <input type="hidden" name="member[<?php echo $a_num; ?>][is_member]" value="1">
                            <input type="hidden" name="member[<?php echo $a_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="member[<?php echo $a_num; ?>][sale_show_id]" value="1129">
                            <input class="input-text" type="text" name="member[<?php echo $a_num; ?>][sale_centa]" value="<?php echo $sale_centa; ?>" style="width:60%;"></td>
                    <?php $a_num++; } ?>
                    </tr>
                    <tr>
                        <td>分成比例(%)</td>
                        <?php foreach ($clublevel_free as $ms){
                        $sale_centb='';
                        $s_sale_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=3 and sale_show_id=1129 and sale_level='.$ms->id);
                        if(!empty($s_sale_data)) $sale_centb=$s_sale_data->sale_centb;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="member[<?php echo $b_num; ?>][sale_centb]" value="<?php echo $sale_centb; ?>" style="width:60%;"></td>
                    <?php $b_num++; } ?>
                    </tr>
                    <tr>
                        <td>实占总毛利比例(%)</td>
                        <?php foreach ($clublevel_free as $ms){
                        $sale_total='';
                        $s_sale_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=3 and sale_show_id=1129 and sale_level='.$ms->id);
                        if(!empty($s_sale_data)) $sale_total=$s_sale_data->sale_total;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="member[<?php echo $c_num; ?>][sale_total]" value="<?php echo $sale_total; ?>" style="width:60%;"></td>
                    <?php $c_num++; } ?>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="12%">社区单位(有偿)</td>
                <?php if(!empty($clublevel_pay)) foreach ($clublevel_free as $cf) { ?>
                        <td><?php echo $cf->card_name; ?></td>
                <?php }?>
                    </tr>
                    <tr>
                        <td>占总毛利比例(%)</td>
                        <?php foreach ($clublevel_pay as $ms){
                        $sale_centa='';
                        $s_sale_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=3 and sale_show_id=1129 and sale_level='.$ms->id);
                        if(!empty($s_sale_data)) $sale_centa=$s_sale_data->sale_centa;
                         ?>
                         <td>
                            <input type="hidden" name="member[<?php echo $a_num; ?>][sale_level]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="member[<?php echo $a_num; ?>][sale_levelname]" value="<?php echo $ms->card_name; ?>">
                            <input type="hidden" name="member[<?php echo $a_num; ?>][is_member]" value="1">
                            <input type="hidden" name="member[<?php echo $a_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="member[<?php echo $a_num; ?>][sale_show_id]" value="1129">
                            <input class="input-text" type="text" name="member[<?php echo $a_num; ?>][sale_centa]" value="<?php echo $sale_centa; ?>" style="width:60%;"></td>
                    <?php $a_num++; } ?>
                    </tr>
                    <tr>
                        <td>分成比例(%)</td>
                        <?php foreach ($clublevel_pay as $ms){
                        $sale_centb='';
                        $s_sale_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=3 and sale_show_id=1129 and sale_level='.$ms->id);
                        if(!empty($s_sale_data)) $sale_centb=$s_sale_data->sale_centb;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="member[<?php echo $b_num; ?>][sale_centb]" value="<?php echo $sale_centb; ?>" style="width:60%;"></td>
                    <?php $b_num++; } ?>
                    </tr>
                    <tr>
                        <td>实占总毛利比例(%)</td>
                        <?php foreach ($clublevel_pay as $ms){
                        $sale_total='';
                        $s_sale_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=3 and sale_show_id=1129 and sale_level='.$ms->id);
                        if(!empty($s_sale_data)) $sale_total=$s_sale_data->sale_total;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="member[<?php echo $c_num; ?>][sale_total]" value="<?php echo $sale_total; ?>" style="width:60%;"></td>
                    <?php $c_num++; } ?>
                    </tr>
                </table>
            </div>
<!--限时抢购-->
            <div class="mt15" id="s_time">
                <table>
                    <tr class="table-title">
                        <td>限时抢购</td>
                    </tr>
                    <tr>
                        <td>销售对象：<span class="red">非单位学员</span></td>
                    </tr>
                </table>
                <?php echo $form->hiddenField($model, 'x_member'); ?>
                <table>
                    <tr>
                        <td width="12%">管理单位分配</td>
                <?php if(!empty($sharclub)) foreach ($sharclub as $cf) { ?>
                        <td><?php echo $cf->card_name; ?></td>
                <?php }?>
                    </tr>
                    <tr>
                        <td>占总毛利比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_centa='';
                        $s_time_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=0 and sale_typeid=6 and sale_show_id=1135 and sale_level='.$ms->id);
                        if(!empty($s_time_data)) $sale_centa=$s_time_data->sale_centa;
                         ?>
                         <td>
                            <input type="hidden" name="x_member[<?php echo $a_num; ?>][sale_level]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="x_member[<?php echo $a_num; ?>][sale_levelname]" value="<?php echo $ms->card_name; ?>">
                            <input type="hidden" name="x_member[<?php echo $a_num; ?>][is_member]" value="0">
                            <input type="hidden" name="x_member[<?php echo $a_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="x_member[<?php echo $a_num; ?>][sale_show_id]" value="1135">
                            <input class="input-text" type="text" name="x_member[<?php echo $a_num; ?>][sale_centa]" value="<?php echo $sale_centa; ?>" style="width:60%;"></td>
                    <?php $a_num++; } ?>
                    </tr>
                    <tr>
                        <td>分成比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_centb='';
                        $s_time_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=0 and sale_typeid=6 and sale_show_id=1135 and sale_level='.$ms->id);
                        if(!empty($s_time_data)) $sale_centb=$s_time_data->sale_centb;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="x_member[<?php echo $b_num; ?>][sale_centb]" value="<?php echo $sale_centb; ?>" style="width:60%;"></td>
                    <?php $b_num++; } ?>
                    </tr>
                    <tr>
                        <td>实占总毛利比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_total='';
                        $s_time_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=0 and sale_typeid=6 and sale_show_id=1135 and sale_level='.$ms->id);
                        if(!empty($s_time_data)) $sale_total=$s_time_data->sale_total;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="x_member[<?php echo $c_num; ?>][sale_total]" value="<?php echo $sale_total; ?>" style="width:60%;"></td>
                    <?php $c_num++; } ?>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td>销售对象：<span class="red">单位学员</span></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="12%">管理单位分配</td>
                <?php if(!empty($sharclub)) foreach ($sharclub as $cf) { ?>
                        <td><?php echo $cf->card_name; ?></td>
                <?php }?>
                    </tr>
                    <tr>
                        <td>占总毛利比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_centa='';
                        $s_time_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=6 and sale_show_id=1135 and sale_level='.$ms->id);
                        if(!empty($s_time_data)) $sale_centa=$s_time_data->sale_centa;
                         ?>
                         <td>
                            <input type="hidden" name="x_member[<?php echo $a_num; ?>][sale_level]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="x_member[<?php echo $a_num; ?>][sale_levelname]" value="<?php echo $ms->card_name; ?>">
                            <input type="hidden" name="x_member[<?php echo $a_num; ?>][is_member]" value="1">
                            <input type="hidden" name="x_member[<?php echo $a_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="x_member[<?php echo $a_num; ?>][sale_show_id]" value="1135">
                            <input class="input-text" type="text" name="x_member[<?php echo $a_num; ?>][sale_centa]" value="<?php echo $sale_centa; ?>" style="width:60%;"></td>
                    <?php $a_num++; } ?>
                    </tr>
                    <tr>
                        <td>分成比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_centb='';
                        $s_time_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=6 and sale_show_id=1135 and sale_level='.$ms->id);
                        if(!empty($s_time_data)) $sale_centb=$s_time_data->sale_centb;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="x_member[<?php echo $b_num; ?>][sale_centb]" value="<?php echo $sale_centb; ?>" style="width:60%;"></td>
                    <?php $b_num++; } ?>
                    </tr>
                    <tr>
                        <td>实占总毛利比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_total='';
                        $s_time_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=6 and sale_show_id=1135 and sale_level='.$ms->id);
                        if(!empty($s_time_data)) $sale_total=$s_time_data->sale_total;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="x_member[<?php echo $c_num; ?>][sale_total]" value="<?php echo $sale_total; ?>" style="width:60%;"></td>
                    <?php $c_num++; } ?>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="12%">社区单位(免费)</td>
                <?php if(!empty($clublevel_free)) foreach ($clublevel_free as $cf) { ?>
                        <td><?php echo $cf->card_name; ?></td>
                <?php }?>
                    </tr>
                    <tr>
                        <td>占总毛利比例(%)</td>
                        <?php foreach ($clublevel_free as $ms){
                        $sale_centa='';
                        $s_time_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=6 and sale_show_id=1135 and sale_level='.$ms->id);
                        if(!empty($s_time_data)) $sale_centa=$s_time_data->sale_centa;
                         ?>
                         <td>
                            <input type="hidden" name="x_member[<?php echo $a_num; ?>][sale_level]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="x_member[<?php echo $a_num; ?>][sale_levelname]" value="<?php echo $ms->card_name; ?>">
                            <input type="hidden" name="x_member[<?php echo $a_num; ?>][is_member]" value="1">
                            <input type="hidden" name="x_member[<?php echo $a_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="x_member[<?php echo $a_num; ?>][sale_show_id]" value="1135">
                            <input class="input-text" type="text" name="x_member[<?php echo $a_num; ?>][sale_centa]" value="<?php echo $sale_centa; ?>" style="width:60%;"></td>
                    <?php $a_num++; } ?>
                    </tr>
                    <tr>
                        <td>分成比例(%)</td>
                        <?php foreach ($clublevel_free as $ms){
                        $sale_centb='';
                        $s_time_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=6 and sale_show_id=1135 and sale_level='.$ms->id);
                        if(!empty($s_time_data)) $sale_centb=$s_time_data->sale_centb;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="x_member[<?php echo $b_num; ?>][sale_centb]" value="<?php echo $sale_centb; ?>" style="width:60%;"></td>
                    <?php $b_num++; } ?>
                    </tr>
                    <tr>
                        <td>实占总毛利比例(%)</td>
                        <?php foreach ($clublevel_free as $ms){
                        $sale_total='';
                        $s_time_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=6 and sale_show_id=1135 and sale_level='.$ms->id);
                        if(!empty($s_time_data)) $sale_total=$s_time_data->sale_total;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="x_member[<?php echo $c_num; ?>][sale_total]" value="<?php echo $sale_total; ?>" style="width:60%;"></td>
                    <?php $c_num++; } ?>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="12%">社区单位(有偿)</td>
                <?php if(!empty($clublevel_pay)) foreach ($clublevel_free as $cf) { ?>
                        <td><?php echo $cf->card_name; ?></td>
                <?php }?>
                    </tr>
                    <tr>
                        <td>占总毛利比例(%)</td>
                        <?php foreach ($clublevel_pay as $ms){
                        $sale_centa='';
                        $s_time_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=6 and sale_show_id=1135 and sale_level='.$ms->id);
                        if(!empty($s_time_data)) $sale_centa=$s_time_data->sale_centa;
                         ?>
                         <td>
                            <input type="hidden" name="x_member[<?php echo $a_num; ?>][sale_level]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="x_member[<?php echo $a_num; ?>][sale_levelname]" value="<?php echo $ms->card_name; ?>">
                            <input type="hidden" name="x_member[<?php echo $a_num; ?>][is_member]" value="1">
                            <input type="hidden" name="x_member[<?php echo $a_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="x_member[<?php echo $a_num; ?>][sale_show_id]" value="1135">
                            <input class="input-text" type="text" name="x_member[<?php echo $a_num; ?>][sale_centa]" value="<?php echo $sale_centa; ?>" style="width:60%;"></td>
                    <?php $a_num++; } ?>
                    </tr>
                    <tr>
                        <td>分成比例(%)</td>
                        <?php foreach ($clublevel_pay as $ms){
                        $sale_centb='';
                        $s_time_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=6 and sale_show_id=1135 and sale_level='.$ms->id);
                        if(!empty($s_time_data)) $sale_centb=$s_time_data->sale_centb;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="x_member[<?php echo $b_num; ?>][sale_centb]" value="<?php echo $sale_centb; ?>" style="width:60%;"></td>
                    <?php $b_num++; } ?>
                    </tr>
                    <tr>
                        <td>实占总毛利比例(%)</td>
                        <?php foreach ($clublevel_pay as $ms){
                        $sale_total='';
                        $s_time_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=6 and sale_show_id=1135 and sale_level='.$ms->id);
                        if(!empty($s_time_data)) $sale_total=$s_time_data->sale_total;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="x_member[<?php echo $c_num; ?>][sale_total]" value="<?php echo $sale_total; ?>" style="width:60%;"></td>
                    <?php $c_num++; } ?>
                    </tr>
                </table>
            </div>
<!--单位导购-->
            <div class="mt15" id="s_club">
                <table>
                    <tr class="table-title">
                        <td>单位导购</td>
                    </tr>
                    <tr>
                        <td>销售对象：<span class="red">非单位学员</span></td>
                    </tr>
                </table>
                <?php echo $form->hiddenField($model, 'club_data'); ?>
                <table>
                    <tr>
                        <td width="12%">管理单位分配</td>
                <?php if(!empty($sharclub)) foreach ($sharclub as $cf) { ?>
                        <td><?php echo $cf->card_name; ?></td>
                <?php }?>
                    </tr>
                    <tr>
                        <td>占总毛利比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_centa='';
                        $s_club_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=0 and sale_typeid=4 and sale_show_id=1130 and sale_level='.$ms->id);
                        if(!empty($s_club_data)) $sale_centa=$s_club_data->sale_centa;
                         ?>
                         <td>
                            <input type="hidden" name="club_data[<?php echo $a_num; ?>][sale_level]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="club_data[<?php echo $a_num; ?>][sale_levelname]" value="<?php echo $ms->card_name; ?>">
                            <input type="hidden" name="club_data[<?php echo $a_num; ?>][is_member]" value="0">
                            <input type="hidden" name="club_data[<?php echo $a_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="club_data[<?php echo $a_num; ?>][sale_show_id]" value="1130">
                            <input class="input-text" type="text" name="club_data[<?php echo $a_num; ?>][sale_centa]" value="<?php echo $sale_centa; ?>" style="width:60%;"></td>
                    <?php $a_num++; } ?>
                    </tr>
                    <tr>
                        <td>分成比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_centb='';
                        $s_club_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=0 and sale_typeid=4 and sale_show_id=1130 and sale_level='.$ms->id);
                        if(!empty($s_club_data)) $sale_centb=$s_club_data->sale_centb;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="club_data[<?php echo $b_num; ?>][sale_centb]" value="<?php echo $sale_centb; ?>" style="width:60%;"></td>
                    <?php $b_num++; } ?>
                    </tr>
                    <tr>
                        <td>实占总毛利比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_total='';
                        $s_club_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=0 and sale_typeid=4 and sale_show_id=1130 and sale_level='.$ms->id);
                        if(!empty($s_club_data)) $sale_total=$s_club_data->sale_total;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="club_data[<?php echo $c_num; ?>][sale_total]" value="<?php echo $sale_total; ?>" style="width:60%;"></td>
                    <?php $c_num++; } ?>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td>销售对象：<span class="red">单位学员</span></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="12%">管理单位分配</td>
                <?php if(!empty($sharclub)) foreach ($sharclub as $cf) { ?>
                        <td><?php echo $cf->card_name; ?></td>
                <?php }?>
                    </tr>
                    <tr>
                        <td>占总毛利比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_centa='';
                        $s_club_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=4 and sale_show_id=1130 and sale_level='.$ms->id);
                        if(!empty($s_club_data)) $sale_centa=$s_club_data->sale_centa;
                         ?>
                         <td>
                            <input type="hidden" name="club_data[<?php echo $a_num; ?>][sale_level]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="club_data[<?php echo $a_num; ?>][sale_levelname]" value="<?php echo $ms->card_name; ?>">
                            <input type="hidden" name="club_data[<?php echo $a_num; ?>][is_member]" value="1">
                            <input type="hidden" name="club_data[<?php echo $a_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="club_data[<?php echo $a_num; ?>][sale_show_id]" value="1130">
                            <input class="input-text" type="text" name="club_data[<?php echo $a_num; ?>][sale_centa]" value="<?php echo $sale_centa; ?>" style="width:60%;"></td>
                    <?php $a_num++; } ?>
                    </tr>
                    <tr>
                        <td>分成比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_centb='';
                        $s_club_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=4 and sale_show_id=1130 and sale_level='.$ms->id);
                        if(!empty($s_club_data)) $sale_centb=$s_club_data->sale_centb;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="club_data[<?php echo $b_num; ?>][sale_centb]" value="<?php echo $sale_centb; ?>" style="width:60%;"></td>
                    <?php $b_num++; } ?>
                    </tr>
                    <tr>
                        <td>实占总毛利比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_total='';
                        $s_club_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=4 and sale_show_id=1130 and sale_level='.$ms->id);
                        if(!empty($s_time_data)) $sale_total=$s_club_data->sale_total;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="club_data[<?php echo $c_num; ?>][sale_total]" value="<?php echo $sale_total; ?>" style="width:60%;"></td>
                    <?php $c_num++; } ?>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="12%">社区单位(免费)</td>
                <?php if(!empty($clublevel_free)) foreach ($clublevel_free as $cf) { ?>
                        <td><?php echo $cf->card_name; ?></td>
                <?php }?>
                    </tr>
                    <tr>
                        <td>占总毛利比例(%)</td>
                        <?php foreach ($clublevel_free as $ms){
                        $sale_centa='';
                        $s_club_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=4 and sale_show_id=1130 and sale_level='.$ms->id);
                        if(!empty($s_club_data)) $sale_centa=$s_club_data->sale_centa;
                         ?>
                         <td>
                            <input type="hidden" name="club_data[<?php echo $a_num; ?>][sale_level]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="club_data[<?php echo $a_num; ?>][sale_levelname]" value="<?php echo $ms->card_name; ?>">
                            <input type="hidden" name="club_data[<?php echo $a_num; ?>][is_member]" value="1">
                            <input type="hidden" name="club_data[<?php echo $a_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="club_data[<?php echo $a_num; ?>][sale_show_id]" value="1130">
                            <input class="input-text" type="text" name="club_data[<?php echo $a_num; ?>][sale_centa]" value="<?php echo $sale_centa; ?>" style="width:60%;"></td>
                    <?php $a_num++; } ?>
                    </tr>
                    <tr>
                        <td>分成比例(%)</td>
                        <?php foreach ($clublevel_free as $ms){
                        $sale_centb='';
                        $s_club_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=4 and sale_show_id=1130 and sale_level='.$ms->id);
                        if(!empty($s_club_data)) $sale_centb=$s_club_data->sale_centb;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="club_data[<?php echo $b_num; ?>][sale_centb]" value="<?php echo $sale_centb; ?>" style="width:60%;"></td>
                    <?php $b_num++; } ?>
                    </tr>
                    <tr>
                        <td>实占总毛利比例(%)</td>
                        <?php foreach ($clublevel_free as $ms){
                        $sale_total='';
                        $s_club_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=4 and sale_show_id=1130 and sale_level='.$ms->id);
                        if(!empty($s_club_data)) $sale_total=$s_club_data->sale_total;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="club_data[<?php echo $c_num; ?>][sale_total]" value="<?php echo $sale_total; ?>" style="width:60%;"></td>
                    <?php $c_num++; } ?>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="12%">社区单位(有偿)</td>
                <?php if(!empty($clublevel_pay)) foreach ($clublevel_free as $cf) { ?>
                        <td><?php echo $cf->card_name; ?></td>
                <?php }?>
                    </tr>
                    <tr>
                        <td>占总毛利比例(%)</td>
                        <?php foreach ($clublevel_pay as $ms){
                        $sale_centa='';
                        $s_club_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=4 and sale_show_id=1130 and sale_level='.$ms->id);
                        if(!empty($s_club_data)) $sale_centa=$s_club_data->sale_centa;
                         ?>
                         <td>
                            <input type="hidden" name="club_data[<?php echo $a_num; ?>][sale_level]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="club_data[<?php echo $a_num; ?>][sale_levelname]" value="<?php echo $ms->card_name; ?>">
                            <input type="hidden" name="club_data[<?php echo $a_num; ?>][is_member]" value="1">
                            <input type="hidden" name="club_data[<?php echo $a_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="club_data[<?php echo $a_num; ?>][sale_show_id]" value="1130">
                            <input class="input-text" type="text" name="club_data[<?php echo $a_num; ?>][sale_centa]" value="<?php echo $sale_centa; ?>" style="width:60%;"></td>
                    <?php $a_num++; } ?>
                    </tr>
                    <tr>
                        <td>分成比例(%)</td>
                        <?php foreach ($clublevel_pay as $ms){
                        $sale_centb='';
                        $s_club_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=4 and sale_show_id=1130 and sale_level='.$ms->id);
                        if(!empty($s_club_data)) $sale_centb=$s_club_data->sale_centb;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="club_data[<?php echo $b_num; ?>][sale_centb]" value="<?php echo $sale_centb; ?>" style="width:60%;"></td>
                    <?php $b_num++; } ?>
                    </tr>
                    <tr>
                        <td>实占总毛利比例(%)</td>
                        <?php foreach ($clublevel_pay as $ms){
                        $sale_total='';
                        $s_club_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=4 and sale_show_id=1130 and sale_level='.$ms->id);
                        if(!empty($s_club_data)) $sale_total=$s_club_data->sale_total;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="club_data[<?php echo $c_num; ?>][sale_total]" value="<?php echo $sale_total; ?>" style="width:60%;"></td>
                    <?php $c_num++; } ?>
                    </tr>
                </table>
            </div>
<!--二次上架-->
            <div class="mt15" id="s_sec">
                <table>
                    <tr class="table-title">
                        <td>二次上架</td>
                    </tr>
                    <tr>
                        <td>销售对象：<span class="red">非单位学员</span></td>
                    </tr>
                </table>
                <?php echo $form->hiddenField($model, 'dg_member'); ?>
                <table>
                    <tr>
                        <td width="12%">管理单位分配</td>
                <?php if(!empty($sharclub)) foreach ($sharclub as $cf) { ?>
                        <td><?php echo $cf->card_name; ?></td>
                <?php }?>
                    </tr>
                    <tr>
                        <td>占总毛利比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_centa='';
                        $s_sec_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=0 and sale_typeid=5 and sale_show_id=1131 and sale_level='.$ms->id);
                        if(!empty($s_sec_data)) $sale_centa=$s_sec_data->sale_centa;
                         ?>
                         <td>
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][sale_level]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][sale_levelname]" value="<?php echo $ms->card_name; ?>">
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][is_member]" value="0">
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][sale_show_id]" value="1131">
                            <input class="input-text" type="text" name="dg_member[<?php echo $a_num; ?>][sale_centa]" value="<?php echo $sale_centa; ?>" style="width:60%;"></td>
                    <?php $a_num++; } ?>
                    </tr>
                    <tr>
                        <td>分成比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_centb='';
                        $s_sec_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=0 and sale_typeid=5 and sale_show_id=1131 and sale_level='.$ms->id);
                        if(!empty($s_sec_data)) $sale_centb=$s_sec_data->sale_centb;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="dg_member[<?php echo $b_num; ?>][sale_centb]" value="<?php echo $sale_centb; ?>" style="width:60%;"></td>
                    <?php $b_num++; } ?>
                    </tr>
                    <tr>
                        <td>实占总毛利比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_total='';
                        $s_sec_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=0 and sale_typeid=5 and sale_show_id=1131 and sale_level='.$ms->id);
                        if(!empty($s_sec_data)) $sale_total=$s_sec_data->sale_total;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="dg_member[<?php echo $c_num; ?>][sale_total]" value="<?php echo $sale_total; ?>" style="width:60%;"></td>
                    <?php $c_num++; } ?>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td>销售对象：<span class="red">单位学员</span></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="12%">管理单位分配</td>
                <?php if(!empty($sharclub)) foreach ($sharclub as $cf) { ?>
                        <td><?php echo $cf->card_name; ?></td>
                <?php }?>
                    </tr>
                    <tr>
                        <td>占总毛利比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_centa='';
                        $s_sec_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=5 and sale_show_id=1131 and sale_level='.$ms->id);
                        if(!empty($s_sec_data)) $sale_centa=$s_sec_data->sale_centa;
                         ?>
                         <td>
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][sale_level]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][sale_levelname]" value="<?php echo $ms->card_name; ?>">
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][is_member]" value="1">
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][sale_show_id]" value="1131">
                            <input class="input-text" type="text" name="dg_member[<?php echo $a_num; ?>][sale_centa]" value="<?php echo $sale_centa; ?>" style="width:60%;"></td>
                    <?php $a_num++; } ?>
                    </tr>
                    <tr>
                        <td>分成比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_centb='';
                        $s_sec_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=5 and sale_show_id=1131 and sale_level='.$ms->id);
                        if(!empty($s_club_data)) $sale_centb=$s_sec_data->sale_centb;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="dg_member[<?php echo $b_num; ?>][sale_centb]" value="<?php echo $sale_centb; ?>" style="width:60%;"></td>
                    <?php $b_num++; } ?>
                    </tr>
                    <tr>
                        <td>实占总毛利比例(%)</td>
                        <?php foreach ($sharclub as $ms){
                        $sale_total='';
                        $s_sec_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=5 and sale_show_id=1131 and sale_level='.$ms->id);
                        if(!empty($s_time_data)) $sale_total=$s_sec_data->sale_total;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="dg_member[<?php echo $c_num; ?>][sale_total]" value="<?php echo $sale_total; ?>" style="width:60%;"></td>
                    <?php $c_num++; } ?>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="12%">社区单位(免费)</td>
                <?php if(!empty($clublevel_free)) foreach ($clublevel_free as $cf) { ?>
                        <td><?php echo $cf->card_name; ?></td>
                <?php }?>
                    </tr>
                    <tr>
                        <td>占总毛利比例(%)</td>
                        <?php foreach ($clublevel_free as $ms){
                        $sale_centa='';
                        $s_sec_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=5 and sale_show_id=1131 and sale_level='.$ms->id);
                        if(!empty($s_sec_data)) $sale_centa=$s_sec_data->sale_centa;
                         ?>
                         <td>
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][sale_level]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][sale_levelname]" value="<?php echo $ms->card_name; ?>">
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][is_member]" value="1">
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][sale_show_id]" value="1131">
                            <input class="input-text" type="text" name="dg_member[<?php echo $a_num; ?>][sale_centa]" value="<?php echo $sale_centa; ?>" style="width:60%;"></td>
                    <?php $a_num++; } ?>
                    </tr>
                    <tr>
                        <td>分成比例(%)</td>
                        <?php foreach ($clublevel_free as $ms){
                        $sale_centb='';
                        $s_sec_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=5 and sale_show_id=1131 and sale_level='.$ms->id);
                        if(!empty($s_sec_data)) $sale_centb=$s_sec_data->sale_centb;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="dg_member[<?php echo $b_num; ?>][sale_centb]" value="<?php echo $sale_centb; ?>" style="width:60%;"></td>
                    <?php $b_num++; } ?>
                    </tr>
                    <tr>
                        <td>实占总毛利比例(%)</td>
                        <?php foreach ($clublevel_free as $ms){
                        $sale_total='';
                        $s_sec_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=5 and sale_show_id=1131 and sale_level='.$ms->id);
                        if(!empty($s_sec_data)) $sale_total=$s_sec_data->sale_total;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="dg_member[<?php echo $c_num; ?>][sale_total]" value="<?php echo $sale_total; ?>" style="width:60%;"></td>
                    <?php $c_num++; } ?>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="12%">社区单位(有偿)</td>
                <?php if(!empty($clublevel_pay)) foreach ($clublevel_free as $cf) { ?>
                        <td><?php echo $cf->card_name; ?></td>
                <?php }?>
                    </tr>
                    <tr>
                        <td>占总毛利比例(%)</td>
                        <?php foreach ($clublevel_pay as $ms){
                        $sale_centa='';
                        $s_sec_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=5 and sale_show_id=1131 and sale_level='.$ms->id);
                        if(!empty($s_sec_data)) $sale_centa=$s_sec_data->sale_centa;
                         ?>
                         <td>
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][sale_level]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][sale_levelname]" value="<?php echo $ms->card_name; ?>">
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][is_member]" value="1">
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][sale_show_id]" value="1131">
                            <input class="input-text" type="text" name="dg_member[<?php echo $a_num; ?>][sale_centa]" value="<?php echo $sale_centa; ?>" style="width:60%;"></td>
                    <?php $a_num++; } ?>
                    </tr>
                    <tr>
                        <td>分成比例(%)</td>
                        <?php foreach ($clublevel_pay as $ms){
                        $sale_centb='';
                        $s_sec_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=5 and sale_show_id=1131 and sale_level='.$ms->id);
                        if(!empty($s_sec_data)) $sale_centb=$s_sec_data->sale_centb;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="dg_member[<?php echo $b_num; ?>][sale_centb]" value="<?php echo $sale_centb; ?>" style="width:60%;"></td>
                    <?php $b_num++; } ?>
                    </tr>
                    <tr>
                        <td>实占总毛利比例(%)</td>
                        <?php foreach ($clublevel_pay as $ms){
                        $sale_total='';
                        $s_sec_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=5 and sale_show_id=1131 and sale_level='.$ms->id);
                        if(!empty($s_sec_data)) $sale_total=$s_sec_data->sale_total;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="dg_member[<?php echo $c_num; ?>][sale_total]" value="<?php echo $sale_total; ?>" style="width:60%;"></td>
                    <?php $c_num++; } ?>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="12%">龙虎会员</td>
                <?php if(!empty($dgmember)) foreach ($dgmember as $cf) { ?>
                        <td><?php echo $cf->card_name; ?></td>
                <?php }?>
                    </tr>
                    <tr>
                        <td>占总毛利比例(%)</td>
                        <?php foreach ($dgmember as $ms){
                        $sale_centa='';
                        $s_sec_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=5 and sale_show_id=1131 and sale_level='.$ms->id);
                        if(!empty($s_sec_data)) $sale_centa=$s_sec_data->sale_centa;
                         ?>
                         <td>
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][sale_level]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][sale_levelname]" value="<?php echo $ms->card_name; ?>">
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][is_member]" value="1">
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="dg_member[<?php echo $a_num; ?>][sale_show_id]" value="1131">
                            <input class="input-text" type="text" name="dg_member[<?php echo $a_num; ?>][sale_centa]" value="<?php echo $sale_centa; ?>" style="width:60%;"></td>
                    <?php $a_num++; } ?>
                    </tr>
                    <tr>
                        <td>分成比例(%)</td>
                        <?php foreach ($dgmember as $ms){
                        $sale_centb='';
                        $s_sec_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=5 and sale_show_id=1131 and sale_level='.$ms->id);
                        if(!empty($s_sec_data)) $sale_centb=$s_sec_data->sale_centb;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="dg_member[<?php echo $b_num; ?>][sale_centb]" value="<?php echo $sale_centb; ?>" style="width:60%;"></td>
                    <?php $b_num++; } ?>
                    </tr>
                    <tr>
                        <td>实占总毛利比例(%)</td>
                        <?php foreach ($dgmember as $ms){
                        $sale_total='';
                        $s_sec_data=GfSalespersonInfoData::model()->find('infoid='.$id.' and is_member=1 and sale_typeid=5 and sale_show_id=1131 and sale_level='.$ms->id);
                        if(!empty($s_sec_data)) $sale_total=$s_sec_data->sale_total;
                         ?>
                         <td>
                            <input class="input-text" type="text" name="dg_member[<?php echo $c_num; ?>][sale_total]" value="<?php echo $sale_total; ?>" style="width:60%;"></td>
                    <?php $c_num++; } ?>
                    </tr>
                </table>
            </div>
                <table class="mt15">
                    <tr>
                        <td width="20%";>操作</td>
                        <td><?php echo show_shenhe_box(array('baocun'=>'保存'));?></td>
                    </tr>
                </table>
            </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script>
function CheckedType(op,$idname){
    var count = 0;
    var checkArry = $(op);
            for (var i = 0; i < checkArry.length; i++) { 
                if(checkArry[i].checked == true){
                    //选中的操作
                    count++; 
                }
            }
    if( count>0 ){ $($idname).show();} else{ $($idname).hide();}
}
CheckedType($('#GfSalespersonInfo_s_sale_0'),'#s_sale');
CheckedType($('#GfSalespersonInfo_s_time_0'),'#s_time');
CheckedType($('#GfSalespersonInfo_s_club_0'),'#s_club');
CheckedType($('#GfSalespersonInfo_s_sec_0'),'#s_sec');
</script>
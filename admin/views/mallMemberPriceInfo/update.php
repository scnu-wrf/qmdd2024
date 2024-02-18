<?php
    $mall_sale=MallSaleName::model()->findAll();
    $s1="f_id,card_code,mamber_type,type,mamber_type_name,card_name,card_xh,short_name,up_type,up_type_name,job_partner_num,card_level,charge";
    $s2=MemberCard::model()->findAll('mamber_type=210 or (type=502 and mamber_type in(8,9)) order by mamber_type_name DESC,card_code');
    //$member=toArray($s2,$s1);
?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>商品会员销售折扣方案管理</h1><span class="back"><a href="javascript:;" class="btn" onclick="we.back();"><i class="fa fa-reply">返回</i></a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <div class="box-detail-bd">
                <table>
                    <tr class="table-title">
                        <td colspan="4">基本信息</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="10%"><?php echo $form->labelEx($model, 'f_code'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'f_code', array('class'=>'input-text')); ?>
                            <?php echo $form->error($model, 'f_code', $htmlOptions = array()); ?>
                        </td>
                        <td width="10%"><?php echo $form->labelEx($model, 'f_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'f_name', array('class'=>'input-text')); ?>
                            <?php echo $form->error($model, 'f_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'f_content'); ?></td>
                        <td colspan="3"><?php echo $form->textField($model, 'f_content', array('class'=>'input-text')); ?></td>
                    </tr>
                </table>
<?php
$mp_num=0;
$mb_num=0;
$mc_num=0;
$id=(!empty($model->id)) ? $model->id : 0;
?>
                <table class="mt15 table-title">
                    <tr>
                        <td><?php echo $form->checkBoxList($model, 's_sale', array(3=>'自营商家-普通销售'),
                              $htmlOptions = array('separator' => '', 'class' => 'input-check', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?>
                        </td>
                    </tr>
                </table>
                <?php echo $form->hiddenField($model, 'member'); ?>
                <table>
                    <tr>
                        <td width="8%">销售对象</td>
                        <td width="8%">会员等级</td>
                    <?php if(!empty($member)) foreach ($member as $m) { ?>
                        <td><?php echo $m->card_name; ?></td>
                    <?php }?>
                    </tr>
                    <tr>
                        <td rowspan="3">销售折扣率(%)</td>
                        <td>价格折扣</td>
                    <?php foreach ($member as $ms){
                        $sale_pricea='';
                        $s_sale_data=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid=3 and sale_show_id=1129 and sale_levela='.$ms->id);
                        if(!empty($s_sale_data)) $sale_pricea=$s_sale_data->sale_pricea;
                         ?>
                         <td>
                            <input type="hidden" name="member[<?php echo $mp_num; ?>][sale_sourcena]" value="9">
                            <input type="hidden" name="member[<?php echo $mp_num; ?>][sale_obja]" value="11">
                            <input type="hidden" name="member[<?php echo $mp_num; ?>][sale_levela]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="member[<?php echo $mp_num; ?>][sale_levela_no]" value="<?php echo $ms->card_xh; ?>">
                            <input type="hidden" name="member[<?php echo $mp_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="member[<?php echo $mp_num; ?>][sale_show_id]" value="1129">
                            <input class="input-text" type="text" name="member[<?php echo $mp_num; ?>][sale_pricea]" value="<?php echo $sale_pricea; ?>" style="width:60%;"></td>
                    <?php $mp_num++; } ?>
                    </tr>
                    <tr>
                        <td>体育豆折扣</td>
                    <?php foreach ($member as $ms){
                        $sale_beana='';
                        $s_sale_data=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid=3 and sale_show_id=1129 and sale_levela='.$ms->id);
                        if(!empty($s_sale_data)) $sale_beana=$s_sale_data->sale_beana;
                         ?>
                        <td><input class="input-text" type="text" name="member[<?php echo $mb_num; ?>][sale_beana]" value="<?php echo $sale_beana; ?>" style="width:60%;"></td>
                    <?php $mb_num++; } ?>
                    </tr>
                    <tr>
                        <td>限购数量</td>
                    <?php foreach ($member as $ms){
                        $sale_counta='';
                        $s_sale_data=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid=3 and sale_show_id=1129 and sale_levela='.$ms->id);
                        if(!empty($s_sale_data)) $sale_counta=$s_sale_data->sale_counta;
                         ?>
                        <td><input class="input-text" type="text" name="member[<?php echo $mc_num; ?>][sale_counta]" value="<?php echo $sale_counta; ?>" style="width:60%;"></td>
                    <?php $mc_num++; } ?>
                    </tr>
                </table>
                <table class="mt15 table-title">
                    <tr>
                        <td><?php echo $form->checkBoxList($model, 's_club', array(4=>'自营商家-单位导购-普通销售'),
                              $htmlOptions = array('separator' => '', 'class' => 'input-check', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?>
                            </td>
                    </tr>
                </table>
                <?php echo $form->hiddenField($model, 'club_data'); ?>
                <table>
                    <tr>
                        <td width="8%">导购对象</td>
                        <td width="8%">社区单位(无偿)</td>
                    <?php if(!empty($clublevel_free)) foreach ($clublevel_free as $cf) { ?>
                        <td><?php echo $cf->card_name; ?></td>
                    <?php }?>
                    </tr>
                    <tr>
                        <td rowspan="3">销售折扣率(%)</td>
                        <td>价格折扣</td>
                    <?php foreach ($clublevel_free as $ms){
                        $sale_pricea='';
                        $s_club_data=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid=4 and sale_show_id=1130 and sale_levela='.$ms->id);
                        if(!empty($s_club_data)) $sale_pricea=$s_club_data->sale_pricea;
                    ?>
                        <td>
                            <input type="hidden" name="club_data[<?php echo $mp_num; ?>][sale_sourcena]" value="9">
                            <input type="hidden" name="club_data[<?php echo $mp_num; ?>][sale_obja]" value="2">
                            <input type="hidden" name="club_data[<?php echo $mp_num; ?>][sale_levela]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="club_data[<?php echo $mp_num; ?>][sale_levela_no]" value="<?php echo $ms->card_xh; ?>">
                            <input type="hidden" name="club_data[<?php echo $mp_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="club_data[<?php echo $mp_num; ?>][sale_show_id]" value="1130">
                            <input class="input-text" type="text" name="club_data[<?php echo $mp_num; ?>][sale_pricea]" value="<?php echo $sale_pricea; ?>" style="width:60%;"></td>
                    <?php $mp_num++; } ?>
                    </tr>
                    <tr>
                        <td>体育豆折扣</td>
                    <?php foreach ($clublevel_free as $ms){
                        $sale_beana='';
                        $s_club_data=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid=4 and sale_show_id=1130 and sale_levela='.$ms->id);
                        if(!empty($s_club_data)) $sale_beana=$s_club_data->sale_beana;
                    ?>
                        <td><input class="input-text" type="text" name="club_data[<?php echo $mb_num; ?>][sale_beana]" value="<?php echo $sale_beana; ?>" style="width:60%;"></td>
                    <?php $mb_num++; } ?>
                    </tr>
                    <tr>
                        <td>限购数量</td>
                    <?php foreach ($clublevel_free as $ms){
                        $sale_counta='';
                        $s_club_data=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid=4 and sale_show_id=1130 and sale_levela='.$ms->id);
                        if(!empty($s_club_data)) $sale_counta=$s_club_data->sale_counta;
                    ?>
                        <td><input class="input-text" type="text" name="club_data[<?php echo $mc_num; ?>][sale_counta]" value="<?php echo $sale_counta; ?>" style="width:60%;"></td>
                    <?php $mc_num++; } ?>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="8%">导购对象</td>
                        <td width="8%">社区单位(有偿)</td>
                    <?php if(!empty($clublevel_pay)) foreach ($clublevel_pay as $cp) { ?>
                        <td><?php echo $cp->card_name; ?></td>
                    <?php }?>
                    </tr>
                    <tr>
                        <td rowspan="3">销售折扣率(%)</td>
                        <td>价格折扣</td>
                    <?php foreach ($clublevel_pay as $ms){
                        $sale_pricea='';
                        $s_club_data=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid=4 and sale_show_id=1130 and sale_levela='.$ms->id);
                        if(!empty($s_club_data)) $sale_pricea=$s_club_data->sale_pricea;
                    ?>
                        <td>
                            <input type="hidden" name="club_data[<?php echo $mp_num; ?>][sale_sourcena]" value="9">
                            <input type="hidden" name="club_data[<?php echo $mp_num; ?>][sale_obja]" value="2">
                            <input type="hidden" name="club_data[<?php echo $mp_num; ?>][sale_levela]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="club_data[<?php echo $mp_num; ?>][sale_levela_no]" value="<?php echo $ms->card_xh; ?>">
                            <input type="hidden" name="club_data[<?php echo $mp_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="club_data[<?php echo $mp_num; ?>][sale_show_id]" value="1130">
                            <input class="input-text" type="text" name="club_data[<?php echo $mp_num; ?>][sale_pricea]" value="<?php echo $sale_pricea; ?>" style="width:60%;"></td>
                    <?php $mp_num++; } ?>
                    </tr>
                    <tr>
                        <td>体育豆折扣</td>
                    <?php foreach ($clublevel_pay as $ms){
                        $sale_beana='';
                        $s_club_data=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid=4 and sale_show_id=1130 and sale_levela='.$ms->id);
                        if(!empty($s_club_data)) $sale_beana=$s_club_data->sale_beana;
                    ?>
                        <td><input class="input-text" type="text" name="club_data[<?php echo $mb_num; ?>][sale_beana]" value="<?php echo $sale_beana; ?>" style="width:60%;"></td>
                    <?php $mb_num++; } ?>
                    </tr>
                    <tr>
                        <td>限购数量</td>
                    <?php foreach ($clublevel_pay as $ms){
                        $sale_counta='';
                        $s_club_data=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid=4 and sale_show_id=1130 and sale_levela='.$ms->id);
                        if(!empty($s_club_data)) $sale_counta=$s_club_data->sale_counta;
                    ?>
                        <td><input class="input-text" type="text" name="club_data[<?php echo $mc_num; ?>][sale_counta]" value="<?php echo $sale_counta; ?>" style="width:60%;"></td>
                    <?php $mc_num++; } ?>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="8%">销售对象</td>
                        <td width="8%">会员等级</td>
                    <?php if(!empty($member)) foreach ($member as $m) { ?>
                        <td><?php echo $m->card_name; ?></td>
                    <?php }?>
                    </tr>
                    <tr>
                        <td rowspan="3">销售折扣率(%)</td>
                        <td>价格折扣</td>
                    <?php foreach ($member as $ms){
                        $sale_pricea='';
                        $s_club_data=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid=4 and sale_show_id=1132 and sale_levela='.$ms->id);
                        if(!empty($s_club_data)) $sale_pricea=$s_club_data->sale_pricea;
                    ?>
                        <td>
                            <input type="hidden" name="club_data[<?php echo $mp_num; ?>][sale_sourcena]" value="2">
                            <input type="hidden" name="club_data[<?php echo $mp_num; ?>][sale_obja]" value="12">
                            <input type="hidden" name="club_data[<?php echo $mp_num; ?>][sale_levela]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="club_data[<?php echo $mp_num; ?>][sale_levela_no]" value="<?php echo $ms->card_xh; ?>">
                            <input type="hidden" name="club_data[<?php echo $mp_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="club_data[<?php echo $mp_num; ?>][sale_show_id]" value="1132">
                            <input class="input-text" type="text" name="club_data[<?php echo $mp_num; ?>][sale_pricea]" value="<?php echo $sale_pricea; ?>" style="width:60%;"></td>
                    <?php $mp_num++; } ?>
                    </tr>
                    <tr>
                        <td>体育豆折扣</td>
                    <?php foreach ($member as $ms){
                        $sale_beana='';
                        $s_club_data=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid=4 and sale_show_id=1132 and sale_levela='.$ms->id);
                        if(!empty($s_club_data)) $sale_beana=$s_club_data->sale_beana;
                    ?>
                        <td><input class="input-text" type="text" name="club_data[<?php echo $mb_num; ?>][sale_beana]" value="<?php echo $sale_beana; ?>" style="width:60%;"></td>
                    <?php $mb_num++; } ?>
                    </tr>
                    <tr>
                        <td>限购数量</td>
                    <?php foreach ($member as $ms){
                        $sale_counta='';
                        $s_club_data=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid=4 and sale_show_id=1132 and sale_levela='.$ms->id);
                        if(!empty($s_club_data)) $sale_counta=$s_club_data->sale_counta;
                    ?>
                        <td><input class="input-text" type="text" name="club_data[<?php echo $mc_num; ?>][sale_counta]" value="<?php echo $sale_counta; ?>" style="width:60%;"></td>
                    <?php $mc_num++; } ?>
                    </tr>
                </table>
                <table class="mt15 table-title">
                    <tr>
                        <td><?php echo $form->checkBoxList($model, 's_sec', array(5=>'自营商家-二次上架-普通销售'),
                              $htmlOptions = array('separator' => '', 'class' => 'input-check', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?>
                            </td>
                    </tr>
                </table>
                <?php echo $form->hiddenField($model, 'dg_member'); ?>
                <table>
                    <tr>
                        <td width="8%">二次上架</td>
                        <td width="8%">龙虎等级</td>
                    <?php if(!empty($dgmember)) foreach ($dgmember as $m) { ?>
                        <td><?php echo $m->card_name; ?></td>
                    <?php }?>
                    </tr>
                    <tr>
                        <td rowspan="3">销售折扣率(%)</td>
                        <td>价格折扣</td>
                    <?php foreach ($dgmember as $ms){
                        $sale_pricea='';
                        $s_sec_data=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid=5 and sale_show_id=1131 and sale_levela='.$ms->id);
                        if(!empty($s_sec_data)) $sale_pricea=$s_sec_data->sale_pricea;
                    ?>
                        <td>
                           <input type="hidden" name="dg_member[<?php echo $mp_num; ?>][sale_sourcena]" value="9">
                            <input type="hidden" name="dg_member[<?php echo $mp_num; ?>][sale_obja]" value="3">
                            <input type="hidden" name="dg_member[<?php echo $mp_num; ?>][sale_levela]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="dg_member[<?php echo $mp_num; ?>][sale_levela_no]" value="<?php echo $ms->card_xh; ?>">
                            <input type="hidden" name="dg_member[<?php echo $mp_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="dg_member[<?php echo $mp_num; ?>][sale_show_id]" value="1131">
                            <input class="input-text" type="text" name="dg_member[<?php echo $mp_num; ?>][sale_pricea]" value="<?php echo $sale_pricea; ?>" style="width:60%;"></td>
                    <?php $mp_num++; } ?>
                    </tr>
                    <tr>
                        <td>体育豆折扣</td>
                    <?php foreach ($dgmember as $ms){
                        $sale_beana='';
                        $s_sec_data=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid=5 and sale_show_id=1131 and sale_levela='.$ms->id);
                        if(!empty($s_sec_data)) $sale_beana=$s_sec_data->sale_beana;
                    ?>
                        <td><input class="input-text" type="text" name="dg_member[<?php echo $mb_num; ?>][sale_beana]" value="<?php echo $sale_beana; ?>" style="width:60%;"></td>
                    <?php $mb_num++; } ?>
                    </tr>
                    <tr>
                        <td>限购数量</td>
                    <?php foreach ($dgmember as $ms){
                        $sale_counta='';
                        $s_sec_data=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid=5 and sale_show_id=1131 and sale_levela='.$ms->id);
                        if(!empty($s_sec_data)) $sale_counta=$s_sec_data->sale_counta;
                    ?>
                        <td><input class="input-text" type="text" name="dg_member[<?php echo $mc_num; ?>][sale_counta]" value="<?php echo $sale_counta; ?>" style="width:60%;"></td>
                    <?php $mc_num++; } ?>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="8%">销售对象</td>
                        <td width="8%">会员等级</td>
                    <?php if(!empty($member)) foreach ($member as $m) { ?>
                        <td><?php echo $m->card_name; ?></td>
                    <?php }?>
                    </tr>
                    <tr>
                        <td rowspan="3">销售折扣率(%)</td>
                        <td>价格折扣</td>
                    <?php foreach ($member as $ms){
                        $sale_pricea='';
                        $s_sec_data=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid=5 and sale_show_id=1134 and sale_levela='.$ms->id);
                        if(!empty($s_sec_data)) $sale_pricea=$s_sec_data->sale_pricea;
                    ?>
                        <td>
                            <input type="hidden" name="dg_member[<?php echo $mp_num; ?>][sale_sourcena]" value="3">
                            <input type="hidden" name="dg_member[<?php echo $mp_num; ?>][sale_obja]" value="14">
                            <input type="hidden" name="dg_member[<?php echo $mp_num; ?>][sale_levela]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="dg_member[<?php echo $mp_num; ?>][sale_levela_no]" value="<?php echo $ms->card_xh; ?>">
                            <input type="hidden" name="dg_member[<?php echo $mp_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="dg_member[<?php echo $mp_num; ?>][sale_show_id]" value="1134">
                            <input class="input-text" type="text" name="dg_member[<?php echo $mp_num; ?>][sale_pricea]" value="<?php echo $sale_pricea; ?>" style="width:60%;"></td>
                    <?php $mp_num++; } ?>
                    </tr>
                    <tr>
                        <td>体育豆折扣</td>
                    <?php foreach ($member as $ms){
                        $sale_beana='';
                        $s_sec_data=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid=5 and sale_show_id=1134 and sale_levela='.$ms->id);
                        if(!empty($s_sec_data)) $sale_beana=$s_sec_data->sale_beana;
                    ?>
                        <td><input class="input-text" type="text" name="dg_member[<?php echo $mb_num; ?>][sale_beana]" value="<?php echo $sale_beana; ?>" style="width:60%;"></td>
                    <?php $mb_num++; } ?>
                    </tr>
                    <tr>
                        <td>限购数量</td>
                    <?php foreach ($member as $ms){
                        $sale_counta='';
                        $s_sec_data=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid=5 and sale_show_id=1134 and sale_levela='.$ms->id);
                        if(!empty($s_sec_data)) $sale_counta=$s_sec_data->sale_counta;
                    ?>
                        <td><input class="input-text" type="text" name="dg_member[<?php echo $mc_num; ?>][sale_counta]" value="<?php echo $sale_counta; ?>" style="width:60%;"></td>
                    <?php $mc_num++; } ?>
                    </tr>
                </table>
                <table class="mt15 table-title">
                    <tr>
                        <td><?php echo $form->checkBoxList($model, 's_time', array(6=>'自营商家-限时抢购'),
                              $htmlOptions = array('separator' => '', 'class' => 'input-check', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?>
                            </td>
                    </tr>
                </table>
                <?php echo $form->hiddenField($model, 'x_member'); ?>
                <table>
                    <tr>
                        <td width="8%">销售对象</td>
                        <td width="8%">会员等级</td>
                    <?php if(!empty($member)) foreach ($member as $m) { ?>
                        <td><?php echo $m->card_name; ?></td>
                    <?php }?>
                    </tr>
                    <tr>
                        <td rowspan="3">销售折扣率(%)</td>
                        <td>价格折扣</td>
                    <?php foreach ($member as $ms){
                        $sale_pricea='';
                        $s_time_data=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid=6 and sale_show_id=1135 and sale_levela='.$ms->id);
                        if(!empty($s_time_data)) $sale_pricea=$s_time_data->sale_pricea;
                         ?>
                         <td>
                            <input type="hidden" name="x_member[<?php echo $mp_num; ?>][sale_sourcena]" value="9">
                            <input type="hidden" name="x_member[<?php echo $mp_num; ?>][sale_obja]" value="15">
                            <input type="hidden" name="x_member[<?php echo $mp_num; ?>][sale_levela]" value="<?php echo $ms->id; ?>">
                            <input type="hidden" name="x_member[<?php echo $mp_num; ?>][sale_levela_no]" value="<?php echo $ms->card_xh; ?>">
                            <input type="hidden" name="x_member[<?php echo $mp_num; ?>][type]" value="<?php echo $ms->type; ?>">
                            <input type="hidden" name="x_member[<?php echo $mp_num; ?>][sale_show_id]" value="1135">
                            <input class="input-text" type="text" name="x_member[<?php echo $mp_num; ?>][sale_pricea]" value="<?php echo $sale_pricea; ?>" style="width:60%;"></td>
                    <?php $mp_num++; } ?>
                    </tr>
                    <tr>
                        <td>体育豆折扣</td>
                    <?php foreach ($member as $ms){
                        $sale_beana='';
                        $s_time_data=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid=6 and sale_show_id=1135 and sale_levela='.$ms->id);
                        if(!empty($s_time_data)) $sale_beana=$s_time_data->sale_beana;
                         ?>
                        <td><input class="input-text" type="text" name="x_member[<?php echo $mb_num; ?>][sale_beana]" value="<?php echo $sale_beana; ?>" style="width:60%;"></td>
                    <?php $mb_num++; } ?>
                    </tr>
                    <tr>
                        <td>限购数量</td>
                    <?php foreach ($member as $ms){
                        $sale_counta='';
                        $s_time_data=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid=6 and sale_show_id=1135 and sale_levela='.$ms->id);
                        if(!empty($s_time_data)) $sale_counta=$s_time_data->sale_counta;
                         ?>
                        <td><input class="input-text" type="text" name="x_member[<?php echo $mc_num; ?>][sale_counta]" value="<?php echo $sale_counta; ?>" style="width:60%;"></td>
                    <?php $mc_num++; } ?>
                    </tr>
                </table>
                <table class="mt15">
                    <tr>
                        <td width="15%">可执行操作</td>
                        <td colspan="3">
                            <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>
                </table>
            </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
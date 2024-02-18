
<div id="mask" style="display:none;width: 100%; height: 100%; position: fixed; z-index: 2000; top: 0px; left: 0px; overflow: hidden;"><div class="" style="line-height: 30px;position: absolute;top: calc(50% - 15px);left: calc(50% - 115px);"><span>导入中...</span></div></div>
<div class="box" div style="font-size: 9px">
    <div class="box-title c">
        <h1>当前界面：服务者 》平台服务者 》平台服务者导入</h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <button class="btn btn-blue" type="button" onclick="javascript:add_member()" >导入</button>
            <a class="btn" href="javascript:;" type="button" onclick="javascript:excel();"><i class="fa fa-file-excel-o"></i>导出</a>
            <a class="btn btn-blue" href="javascript:;" onclick="checkval('.check-item input:checked');">批量确认</a>
            <?php echo '<span class="exam"><p>待确认：<span style="color:red;font-weight: bold;">'.$count1.'</span></p></span>&nbsp;'; ?>
            <?php echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>导入日期</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date') ;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>导入单位：</span>
                    <input style="width:200px;" class="input-text" type="text" name="key_club" value="<?php echo Yii::app()->request->getParam('key_club');?>" >
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入账号/姓名">
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
                        <th>服务者编码</th>
                        <th><?php echo $model->getAttributeLabel('gf_account');?></th>
                        <th><?php echo $model->getAttributeLabel('zsxm');?></th>
                        <th><?php echo $model->getAttributeLabel('real_sex');?></th>
                        <th><?php echo $model->getAttributeLabel('native');?></th>
                        <th><?php echo $model->getAttributeLabel('phone');?></th>
                        <th><?php echo $model->getAttributeLabel('id_card');?></th>
                        <th><?php echo $model->getAttributeLabel('project_id');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_type');?></th>
                        <th>资质等级</th>
                        <th><?php echo $model->getAttributeLabel('qualification_code');?></th>
                        <th>资质有效期</th>
                        <th><?php echo $model->getAttributeLabel('club_name');?></th>
                        <th><?php echo $model->getAttributeLabel('add_time');?></th>
                        <th><?php echo $model->getAttributeLabel('adminid');?></th>
                        <th><?php echo $model->getAttributeLabel('remark');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php 
    $index = 1; 
    foreach($arclist as $v){ 
        $gf='';
        $gf=userlist::model()->find('id_card_type=843 and id_card="'.$v->id_card.'"');

        $cType=ClubServicerType::model()->find('type=501 and member_second_id='.$v->qualification_type);

        if(!empty($gf))$qp=QualificationsPerson::model()->find('unit_state=648 and if_del=506 and gfid='.$gf->GF_ID.' and qualification_type_id='.$v->qualification_type.($cType->if_project==649?' and project_id='.$v->project_id:'').' and auth_state=931 and check_state=2 and free_state_Id=1202');

        if(!empty($qp)&&$v->club_type==502)$qClub=QualificationClub::model()->find('qualification_person_id='.$qp->id.' and club_id='.$v->club_id.' and state in(337,437,497)');
?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>" <?=$v->pay_confirm==1?'disabled="disabled"':'' ?>></td>
                        <td><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php echo $v->import_code; ?></td>
                        <td><?php echo $v->gf_account; ?></td>
                        <td class="<?= !empty($gf)&&$gf->ZSXM!=$v->zsxm?'red':'';?>"><?php echo $v->zsxm; ?></td>
                        <td class="<?= !empty($gf)&&$gf->real_sex_name!=$v->sex?'red':'';?>"><?php echo $v->sex; ?></td>
                        <td class="<?= !empty($gf)&&$gf->native!=$v->native?'red':'';?>"><?php echo $v->native; ?></td>
                        <td class="<?= !empty($gf)&&$gf->PHONE!=$v->phone?'red':'';?>"><?php echo $v->phone; ?></td>
                        <td><?php echo $v->id_card; ?></td>
                        <td class="<?= !empty($qp)&&$qp->project_id!=$v->project_id?'red':'';?>">
                            <?php echo $v->project_name; ?>
                        </td>
                        <td class="<?= !empty($qp)&&$qp->qualification_type_id!=$v->qualification_type?'red':'';?>">
                            <?php echo $v->qualification_type_name; ?>
                        </td>
                        <td class="<?= !empty($qp)&&$qp->identity_type!=$v->identity_type&&$qp->identity_num!=$v->qualification_num?'red':'';?>">
                            <?php echo $v->identity_type_name.$v->qualification_title; ?>
                        </td>
                        <td class="<?= !empty($qp)&&$qp->qualification_code!=$v->qualification_code?'red':'';?>">
                            <?php echo $v->qualification_code; ?>
                        </td>
                        <td class="<?= !empty($qp)&&$qp->end_date!=$v->end_date&&$qp->end_date!=$v->end_date?'red':'';?>">
                            <?php echo $v->start_date.'<br>'.(empty($v->end_date)?'长期':$v->end_date); ?>
                        </td>
                        <td class="<?= !empty($qClub)&&$qClub->club_id!=$v->club_id?'red':'';?>">
                            <?php echo $v->club_name; ?>
                        </td>
                        <td><?php echo $v->add_time; ?></td>
                        <td><?php echo $v->adminname; ?></td>
                        <td>
                            <?php 
                                if(!empty($gf)&&($gf->ZSXM!=$v->zsxm||$gf->real_sex_name!=$v->sex)){
                                    echo '<a class="red">与已注册（'.$gf->GF_ACCOUNT.'）信息冲突</a>';
                                }
                            ?>
                        </td>
                        <td>
                            <?php if($v->pay_confirm==0){?>
                            <?php echo show_command('删除','\''.$v->id.'\''); ?>
                            <?php if(empty($gf)||!empty($gf)&&$gf->ZSXM==$v->zsxm&&$gf->real_sex_name==$v->sex){ ?>
                                <?php if(empty($qp)||!empty($qp)&&$qp->project_id==$v->project_id&&$qp->qualification_type_id==$v->qualification_type){ ?>
                                    <?php if(empty($qClub)||!empty($qClub)&&$qClub->club_id==$v->club_id){ ?>
                                        <a class="btn btn-blue" href="javascript:;" onclick="checkval(<?=$v->id;?>,'one')">确认</a>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                            <?php }else{ ?>
                                已确认
                            <?php } ?>
                        </td>
                    </tr>
<?php $index++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

    var $start_date=$('#start_date');
    var $end_date=$('#end_date');
    $start_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });

    var add_html = 
        '<div id="add_format" style="width:500px;">'+
            '<form id="add_form" name="add_form">'+
                '<table class="list" id="table_tag" style="width:100%;border: solid 1px #d9d9d9;table-layout:auto;">'+
                    '<thead>'+
                        '<tr>'+
                            '<td style="width:100px;padding: 5px;">选择服务者类型&nbsp;&nbsp;</td>'+
                            '<td>'+
                            '<span class="check">'+
                            '<input class="input-check qType" id="qualificationClub" name="qualification" type="radio" value="0" checked>'+
                            '<label for="qualification_club">单位服务者</label>&nbsp;&nbsp;'+
                            '<input class="input-check qType" id="qualificationPerson" name="qualification" type="radio" value="1">'+
                            '<label for="qualification_person">服务者</label>&nbsp;&nbsp;'+
                            '</span>'+
                            '</td>'+
                        '</tr>'+
                        '<tr class="qualification_club">'+
                            '<td style="width:100px;padding: 5px;">选择单位类型&nbsp;&nbsp;</td>'+
                            '<td>'+
                            '<span class="check">'+
                            '<input class="input-check" id="club_type1" name="club_type" type="radio" value="189">'+
                            '<label for="club_type1">战略伙伴</label>&nbsp;&nbsp;'+
                            '<input class="input-check" id="club_type2" name="club_type" type="radio" value="8">'+
                            '<label for="club_type2">社区单位</label>&nbsp;&nbsp;'+
                            '</span>'+
                            '</td>'+
                        '</tr>'+
                        '<tr class="qualification_club">'+
                            '<td style="width:100px;padding: 5px;">选择单位&nbsp;&nbsp;</td><td><input type="button" class="btn btn-blue" onclick="add_tag();" value="选择"></td>'+
                        '</tr>'+
                        '<tr class="qualification_person" style="display:none">'+
                            '<td style="width:100px;padding: 5px;">可执行操作</td><td colspan="2"><input type="button" class="btn btn-blue" onclick="javascript:importfile()" value="导入"></td>'+
                        '</tr>'+
                    '</thead>'+
                '</table>'+
            '</form>'+
        '</div>';

    $(document).on("change",".qType",function(){
        if($(this).val()==1){
            $(".qualification_club").hide();
            $(".qualification_person").show();
        }else{
            $(".qualification_person").hide();
            $(".qualification_club").show();
        }
    })
    function add_member(){
        if_data=0;
        $.dialog({
            id:'tianjia',
            lock:true,
            opacity:0.3,
            // height: '60%',
            // width:'80%',
            title:'选择服务者',
            content:add_html,
            button:[

            ]
        });
        $('.aui_main').css('height','auto');
    }

    function add_tag(){
        var club_type=$("input[name='club_type']:checked").val();
        if(club_type==undefined||club_type=='undefined'||club_type=='null'||club_type==null){
            we.msg('minus', '请选择单位类型');
            return false;
        }
        $.dialog.data('club_id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/club");?>&edit_state=2&club_type='+club_type,{
            id:'danwei',
            lock:true,opacity:0.3,
            width:'500px',
            // height:'60%',
            title:'选择单位',		
            close: function () {
                if($.dialog.data('club_id')>0){    
                    clubImportfile($.dialog.data('club_id'))
                }
            }
        })
    }
    function clubImportfile(club_id,cont){
        $.dialog.open('<?php echo $this->createUrl("qualificationClub/upExcel");?>&state=2&club_id='+club_id+'&logon_way=1461',{
            id:'sensitive',
            lock:true,
            opacity:0.3,
            title:'服务者信息',
            width:'60%',
            height:'50%',
            close: function () {
                window.location.reload(true);
            }
        });
    }

    function importfile(){
        $.dialog.open('<?php echo $this->createUrl("clubQualificationPerson/upExcel");?>&logon_way=1461',{
            id:'sensitive',
            lock:true,
            opacity:0.3,
            title:'服务者信息',
            width:'60%',
            height:'50%',
            close: function () {
                // window.location.reload(true);
            }
        });
    }
    
    // 获取所有选中多选框的值
    checkval = function(op,num){
        // console.log(op)
        if(num=='one'){
            var str = op;
        }else{
            var str = '';
            $(op).each(function() {
                str += $(this).val() + ',';
            });
        }
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        if(str.length<1){
            we.msg('minus','请先选中要确认的数据');
            return false;
        }
        var an = function(){
            confirmed(str);
        }
        $.fallr('show', {
            buttons: {
                button1: {text: '确定', danger: true, onclick: an},
                button2: {text: '取消'}
            },
            content: '是否确认？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });
    };

    // 确认操作
    function confirmed(id){
        console.log(id)
        we.loading('show');
        $.ajax({
            type:'post',
            url:'<?php echo $this->createUrl('confirmed'); ?>&id='+id,
            // data:{id:id},
            dataType:'json',
            success: function(data){
                we.loading('hide');
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                }else{
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }
</script>
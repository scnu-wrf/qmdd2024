<div id="mask" style="display:none;width: 100%; height: 100%; position: fixed; z-index: 2000; top: 0px; left: 0px; overflow: hidden;"><div class="" style="line-height: 30px;position: absolute;top: calc(50% - 15px);left: calc(50% - 115px);"><span>导入中...</span></div></div>
<div class="box" div style="font-size: 9px">
    <a class="btn" href="javascript:;" onclick="we.reload();" style="vertical-align: middle;float: right; margin-right: 10px;"><i class="fa fa-refresh"></i>刷新</a>
	<div class="box-title c"><h1>当前界面：服务者》服务者管理》GF服务者列表</h1></div>
    <div class="box-content">
    	<!-- <div class="box-header">
            <?php //echo show_command('添加',$this->createUrl('create'),'添加'); ?>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div>box-header end -->
        <!-- <div class="box-header">
            <button class="btn btn-blue" type="button" onclick="javascript:add_member()" >导入</button>
            <a class="btn" href="javascript:;" type="button" onclick="javascript:excel();"><i class="fa fa-file-excel-o"></i>导出</a>
        </div>box-header end -->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>入驻日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                </label>
                <label style="margin-right:20px;">
                    <span>性别：</span>
                    <?php echo downList($sex,'f_id','F_NAME','sex'); ?>
                </label>
				<label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php echo downList($project_list,'id','project_name','project'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>类型：</span>
                    <?php echo downList($type_id,'member_second_id','member_second_name','type_id'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>服务者资质：</span>
                    <select name="identity" id="identity">
                        <option value="">请选择</option>
                        <?php 
                            foreach($identity as $v){
                                $f=ServicerCertificate::model()->find('id='.$v->fater_id);
                        ?>
                        <option value="<?php echo $v->id; ?>"<?php if(Yii::app()->request->getParam('identity')!=null && Yii::app()->request->getParam('identity')==$v->id){ ?> selected<?php } ?>><?php echo $f->f_name.$v->f_type_name;?></option>
                        <?php } ?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>服务者等级：</span>
                    <select name="type_code" id="type_code">
                        <option value="">请选择</option>
                        <?php 
                            foreach($type_code as $v){
                        ?>
                        <option value="<?php echo $v->id; ?>"<?php if(Yii::app()->request->getParam('type_code')!=null && Yii::app()->request->getParam('type_code')==$v->id){ ?> selected<?php } ?>><?php echo $v->member_second_name.$v->card_name;?></option>
                        <?php } ?>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" placeholder="请输入编码 / 帐号 / 姓名" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="text-align:center;">序号</th>
                        <th><?php echo $model->getAttributeLabel('gf_code');?></th>
                        <th><?php echo $model->getAttributeLabel('gfaccount');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_name');?></th>
                        <th>姓别</th>
                        <th><?php echo $model->getAttributeLabel('area_code') ?></th>
                        <th><?php echo $model->getAttributeLabel('project_name');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_type');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_level');?></th>
                        <th><?php echo $model->getAttributeLabel('if_del');?></th>
                        <th>入驻日期</th>
                        <th>有效期</th>
                        <th><?php echo $model->getAttributeLabel('logon_way');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1;foreach($arclist as $v){ ?>
                    <tr>
                        <td style="text-align:center;"><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php echo CHtml::link($v->gf_code, array('update', 'id'=>$v->id)); ?></td>
                        <td><?php echo CHtml::link($v->gfaccount, array('update', 'id'=>$v->id)); ?></td>
                        <td><?php echo $v->qualification_name; ?></td>
                        <td><?php if(!empty($v->userlist->real_sex_name))echo $v->userlist->real_sex_name; ?></td>
                        <td>
                            <?php 
                                $area_code='';
                                if(!empty($v->area_code))$t_region=TRegion::model()->findAll('id in('.$v->area_code.')');
                                if(!empty($t_region))foreach($t_region as $t){
                                    $area_code.=$t->region_name_c;
                                }
                                echo $area_code; 
                            ?>
                        </td>
                        <td><?php echo $v->project_name; ?></td>
                        <td><?php echo $v->qualification_type; ?></td>
                        <td><?php echo $v->level_name; ?></td>
                        <td><?php echo $v->acc_status->F_NAME; ?></td>
                        <td><?php echo !is_null($v->entry_validity)?date('Y-m-d',strtotime($v->entry_validity)):'';?></td>
                        <td><?php if(!empty($v->expiry_date_start)&&!empty($v->expiry_date_end))echo  date('Y-m-d',strtotime($v->expiry_date_start)).'至<br>'.date('Y-m-d',strtotime($v->expiry_date_end)); ?></td>
                        <td><?php echo $v->logon_way_name; ?></td>
                        <td>
                            <!-- <a class="btn" href="<?php //echo $this->createUrl('', array('id'=>$v->id));?>" title="续签">续签详情</a> -->
                            <?php echo show_command('详情',$this->createUrl('update', array('id'=>$v->id))); ?>
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
        $.dialog.open('<?php echo $this->createUrl("qualificationClub/upExcel");?>&state=2&club_id='+club_id,{
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
        $.dialog.open('<?php echo $this->createUrl("upExcel");?>',{
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
</script>
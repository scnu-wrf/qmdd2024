<?php //var_dump(get_where_club_project('club_id',''))?>
<div id="mask" style="display:none;width: 100%; height: 100%; position: fixed; z-index: 2000; top: 0px; left: 0px; overflow: hidden;">
<div  style="line-height: 30px;position: absolute;top: calc(50% - 15px);left: calc(50% - 115px);"><span>导入中...</span></div> <!--aui_loading-->
</div>
<div class="box">
    <span style="float:right;padding-right:15px;">
        <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
    </span>
    <div class="box-title c"><h1>当前界面：会员 》学员管理 》学员导入</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <button class="btn btn-blue" type="button" onclick="javascript:importfile()">导入</button>
            <a class="btn" href="javascript:;" type="button" onclick="javascript:excel();"><i class="fa fa-file-excel-o"></i>导出</a>
            <a class="btn btn-blue" href="javascript:;" onclick="checkval('.check-item input:checked');">批量确认</a>
            <?php echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>导入日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="regtime" name="regtime" value="<?php echo $regtime;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="endregtime" name="endregtime" value="<?php echo $endregtime;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>导入单位：</span>
                    <input style="width:200px;" class="input-text" type="text" name="key_club" value="<?php echo Yii::app()->request->getParam('key_club');?>" >
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入姓名/账号">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('gf_account');?></th>
                        <th><?php echo $model->getAttributeLabel('zsxm');?></th>
                        <th><?php echo $model->getAttributeLabel('real_sex');?></th>
                        <th><?php echo $model->getAttributeLabel('native');?></th>
                        <th><?php echo $model->getAttributeLabel('phone');?></th>
                        <th><?php echo $model->getAttributeLabel('id_card');?></th>
                        <th><?php echo $model->getAttributeLabel('import_id');?></th>
                        <th><?php echo $model->getAttributeLabel('project_id');?></th>
                        <th><?php echo $model->getAttributeLabel('club_type');?></th>
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
?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>" <?=$v->pay_confirm==1?'disabled="disabled"':'' ?>></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->gf_account; ?></td>
                        <td class="<?= !empty($gf)&&$gf->ZSXM!=$v->zsxm?'red':'';?>"><?php echo $v->zsxm;?></td>
                        <td class="<?= !empty($gf)&&$gf->real_sex_name!=$v->sex?'red':'';?>"><?php echo $v->sex;?></td>
                        <td class="<?= !empty($gf)&&$gf->native!=$v->native?'red':'';?>"><?php echo $v->native; ?></td>
                        <td class="<?= !empty($gf)&&$gf->PHONE!=$v->phone?'red':'';?>"><?php echo $v->phone; ?></td>
                        <td><?php echo $v->id_card; ?></td>
                        <td>
                            <?php 
                                if($v->club_type==8){
                                    echo '学员'; 
                                }elseif($v->club_type==189){
                                    echo '成员'; 
                                }
                            ?>
                        </td>
                        <td><?php echo $v->project_name; ?></td>
                        <td>
                            <?php 
                                $club=ClubList::model()->find('id='.$v->club_id);
                                if(!empty($club))echo $club->partnership_name;
                            ?>
                        </td>
                        <td><?php echo $v->club_name;?></td>
                        <td><?php echo $v->add_time;?></td>
                        <td><?php echo $v->adminname;?></td>
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
                                <a class="btn btn-blue" href="javascript:;" onclick="checkval(<?=$v->id;?>,'one')">确认</a>
                            <?php } ?>
                            <?php }else{ ?>
                                已确认
                            <?php } ?>
                        </td>
                    </tr>
<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
    $(function(){
        var $regtime=$('#regtime');
        var $endregtime=$('#endregtime');
        $regtime.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
        $endregtime.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
    });

    function on_exam(){
        var exam = $('.exam p span').text();
        if(exam>0){ 
            $('#state').val(371);
            $('#index').val('');
            $('.box-search select').html('<option value>请选择</option>');
            $('.box-search .input-text').val('');
            document.getElementById('submit_button').click();
        }
    }

    function excel(){
        $("#is_excel").val(1);
        $("#submit_button").click();
        $("#is_excel").val(0);
    }
    
    function importfile() {
        $.dialog.open('<?php echo $this->createUrl("clubMemberList/upExcel"); ?>', {
            id: 'sensitive',
            lock: true,
            opacity: 0.3,
            title: '导入学员信息',
            width: '60%',
            height: '50%',
            close: function() {
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
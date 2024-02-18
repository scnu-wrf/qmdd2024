<?php
    if(!isset($_REQUEST['country'])){
        $_REQUEST['country'] = '';
    }
    if(!isset($_REQUEST['province'])){
        $_REQUEST['province'] = '';
    }
?>
<!-- <style>
   *{
        box-sizing: border-box!important;
    }
    i{
        font-size: 10px!important;
    }
    .box,a,button,input,select,span{
        font-size: 10px!important;
        height:auto!important;
        padding: 0.4vw 0.8vw!important;
    }
    h1,h1 span,h1 a,h1 i{
        font-size: 14px!important;
    }
</style> -->
<div class="box">
    <div class="box-title c">
        <h1>
            <span>
              当前界面：会员 》实名管理 》实名会员列表
            </span>
        </h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <span class="exam" onclick="on_exam();"><p>今日实名：<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span></p></span>
            <!-- <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a> -->
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="state" id="state" value="<?php echo Yii::app()->request->getParam('state');?>">
                <!-- <label style="margin-right:10px;">
                    <span>民族：</span>
                    <?php //echo downList($nation,'nation','nation','nation'); ?>
                </label> -->
                <!-- <label style="margin-right:10px;">
                    <span>地区：</span>
                    <?php //echo downList($country,'id','chinese_name','country','onchange="onchangeCountry(this);"'); ?>
                    <select name="country" id="country"  onchange="onchangeCountry(this);">
                        <option value tvalue="">请选择</option>
                        <?php //if(!empty($country_name))foreach($country_name as $c){ ?>
                            <option value="<?php //echo $c->chinese_name; ?>" tvalue="<?php //echo $c->id; ?>" <?php //if($_REQUEST['country']==$c->chinese_name)echo 'selected='; ?>><?php //echo $c->chinese_name; ?></option>
                        <?php //}?>
                    </select>
                    <select name="province" id="province" style="display:none;"></select>
                </label> -->
                <label style="margin-right:10px;">
                    <span>实名时间：</span>
                    <input style="width:100px;" class="input-text" type="text" id="valid_date" name="valid_date" value="<?php echo $valid_date==''?date('Y-m-d'):$valid_date;?>">
                    <span>-</span>
                    <input style="width:100px;" class="input-text" type="text" id="end_valid_date" name="end_valid_date" value="<?php echo $end_valid_date==''?date('Y-m-d'):$end_valid_date;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>性别：</span>
                    <?php echo downList($real_sex,'f_id','F_NAME','real_sex'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>证件类型：</span>
                    <?php echo downList($id_card_type,'f_id','F_NAME','id_card_type'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="账号/昵称/手机号/证件号">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <?php //var_dump(Yii::app()->request->getParam('state'));?>
        <div class="box-table">
            <table class="list">
                    <thead>
                        <tr>
                            <th width="3%">序号</th>
                            <th width="8.8%"><?php echo $model->getAttributeLabel('GF_ACCOUNT');?></th>
                            <th width="8.8%"><?php echo $model->getAttributeLabel('GF_NAME');?></th>
                            <th width="8.8%"><?php echo $model->getAttributeLabel('ZSXM');?></th>
                            <th width="8.8%"><?php echo $model->getAttributeLabel('real_sex_name');?></th>
                            <th width="8.8%"><?php echo $model->getAttributeLabel('native');?></th>
                            <th width="8.8%"><?php echo $model->getAttributeLabel('security_phone');?></th>
                            <th width="8.8%"><?php echo $model->getAttributeLabel('user_state');?></th>
                            <th width="8.8%">实名证件</th>
                            <!-- <th><?php // echo $model->getAttributeLabel('id_card');?></th> -->
                            <th width="8.8%">实名时间</th>
                            <th width="8.8%">有效期限</th>
                            <th width="8.8%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>

                            <td><?php echo $v->GF_ACCOUNT; ?></td>
                            <td><?php echo $v->GF_NAME; ?></td>
                            <td><?php echo $v->ZSXM; ?></td>
                            <td><?php echo $v->real_sex_name; ?></td>
                            <td><?php echo $v->native; ?></td>
                            <td>
                                <?php
                                    // if(!empty($v->security_phone))echo substr($v->security_phone, 0, 3).'****'.substr($v->security_phone, 7);
                                    echo $v->security_phone;
                                ?>
                            </td>
                            <td><?php echo $v->user_state_name; ?></td>
                            <td><?php echo $v->id_card_type_name; ?></td>
                            <!-- <td> -->
                                <?php
                                    // echo substr_replace($v->id_card, '**************', 2, 14);
                                    // echo $v->id_card;
                                ?>
                            <!-- </td> -->
                            <td>
                                <?php
                                    $left = substr($v->realname_entertime,0,10);
                                    $right = substr($v->realname_entertime,11);
                                    echo $left.'<br>'.$right;
                                ?>
                            </td>
                            <td>
                                <?php
                                    $left = substr($v->valid_date,0,10);
                                    $right = substr($v->valid_date,11);
                                    echo $left.' '.$right.'<br>'.$v->end_valid_date;
                                ?>
                            </td>
                            <td>
                                <?php echo show_command('详情',$this->createUrl('update_exam', array('id'=>$v->GF_ID))); ?>
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
    // function on_exam(){
    //     if(<?php echo $count1; ?>>0){
    //         $('#state').val(1);
    //         $('.box-search select').html('<option value>请选择</option>');
    //         $('.box-search .input-text').val('');
    //         document.getElementById('click_submit').click();
    //     }
    // }
    var $valid_date=$('#valid_date');
    var $end_valid_date=$('#end_valid_date');
    $valid_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_valid_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });

    onchangeCountry($('#country'));
    function onchangeCountry(obj){
        var obj = $('#country option:selected').attr('tvalue');
        var province = $('#province');
        var pr = '<?php echo $_REQUEST['province']; ?>';
        var s_html = '<option value>请选择</option>';
        if(obj!=''){
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('province'); ?>&id='+obj,
                dataType: 'json',
                success: function(data){
                    if(data!=''){
                        for(var i=0;i<data.length;i++){
                            s_html += '<option value="'+data[i]['region_name_c']+'" '+((data[i]['region_name_c']==pr) ? 'selected>' : '>')+data[i]['region_name_c']+'</option>';
                        }
                        $('#province').css('display','inline-block');
                    }
                    province.html(s_html);
                }
            })
        }
        else{
            province.html(s_html);
        }
    }

    $("#zsxm").on("click",function(){
        $.dialog.data('GF_ID', 0);
            $.dialog.open('<?php echo $this->createUrl("select/gfuser");?>&passed=0',{
            id:'zhanghao',
            lock:true,opacity:0.3,
            width:'500px',
            // height:'60%',
            title:'选择未登记账号',
            close: function () {
                if($.dialog.data('GF_ID')>0){
                    window.location.href="<?php echo $this->createUrl('update_c'); ?>&passed=372&id="+$.dialog.data('GF_ID');
                }
            }
        })
    })
</script>

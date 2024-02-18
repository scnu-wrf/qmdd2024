<?php
    if(!isset($_REQUEST['country'])){
        $_REQUEST['country'] = '';
    }
    if(!isset($_REQUEST['province'])){
        $_REQUEST['province'] = '';
    }
?>
<div class="box">
    <div class="box-title c">
        <h1>
            <span>
                当前界面：会员 》会员管理 》实名登记申请
            </span>
        </h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <?php if(empty($_REQUEST['state'])){?>
            <div class="box-header">
                <span class="exam" onclick="on_exam();"><p>今日申请：<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span></p></span>
            </div><!--box-header end-->
        <?php }?>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="state" id="state" value="<?php echo Yii::app()->request->getParam('state');?>">
                <!-- <label>
                    <span>地区：</span>
                    <select name="country" id="country"  onchange="onchangeCountry(this);">
                        <option value tvalue="">请选择</option>
                        <?php if(!empty($country_name))foreach($country_name as $c){ ?>
                            <option value="<?php echo $c->chinese_name; ?>" tvalue="<?php echo $c->id; ?>" <?php if($_REQUEST['country']==$c->chinese_name)echo 'selected='; ?>><?php echo $c->chinese_name; ?></option>
                        <?php }?>
                    </select>
                    <select name="province" id="province" style="display:none;"></select>
                </label> -->
                <!-- <label style="margin-right:20px;">
                    <span>性别：</span>
                    <?php echo downList($real_sex,'f_id','F_NAME','real_sex','style="margin-left: 12px;"'); ?>
                </label> -->
                <label style="margin-right:10px;">
                    <span>申请日期：</span>
                    <input style="width:100px;" class="input-text" type="text" id="star_time" name="star_time" value="<?php echo Yii::app()->request->getParam('star_time');?>">
                    <span>-</span>
                    <input style="width:100px;" class="input-text" type="text" id="end_time" name="end_time" value="<?php echo Yii::app()->request->getParam('end_time');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入账号/昵称/姓名/手机号码">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <?php //var_dump(Yii::app()->request->getParam('state'));?>
        <div class="box-table">
            <table class="list">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('GF_ACCOUNT');?></th>
                            <th style='width: 100px;'><?php echo $model->getAttributeLabel('GF_NAME');?></th>
                            <th><?php echo $model->getAttributeLabel('ZSXM');?></th>
                            <th><?php echo $model->getAttributeLabel('real_sex_name');?></th>
                            <th><?php echo $model->getAttributeLabel('location');?></th>
                            <th><?php echo $model->getAttributeLabel('PHONE');?></th>
                            <th><?php echo $model->getAttributeLabel('id_card_type');?></th>
                            <th>申请时间</th>
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
                            <td><?php echo $v->PHONE; ?></td>
                            <td><?php echo $v->id_card_type_name; ?></td>
                            <td>
                                <?php 
                                    $left = substr($v->realname_time,0,10);
                                    $right = substr($v->realname_time,11);
                                    echo $left.'<br>'.$right; 
                                ?>
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
        var $star_time=$('#star_time');
        var $end_time=$('#end_time');
        $star_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
        $end_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
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
</script>
<?php
    if(isset($_REQUEST['is_salable'])==''){
        $_REQUEST['is_salable'] = '';
    }
    echo $_REQUEST['is_salable'];
?>
<style type="text/css" media="screen">
    .switch-btn {position: relative; display: block; vertical-align: top; width: 80px; height: 30px; border-radius: 18px; cursor: pointer;}
    .checked-switch {position: absolute; top: 0; left: 0; opacity: 0;}
    .text-switch {background-color: #a9a9a9; border: 1px solid #808080; border-radius: inherit; color: #fff; display: block; font-size: 12px; height: inherit; position: relative; text-transform: uppercase;}
    .text-switch:before, .text-switch:after {position: absolute; top: 50%; margin-top: -.5em; line-height: 1; -webkit-transition: inherit; -moz-transition: inherit; -o-transition: inherit; transition: inherit;}
    .text-switch:before {content: attr(data-no); right: 11px;}
    .text-switch:after {content: attr(data-yes); left: 11px; color: #FFFFFF; opacity: 0;}
    .checked-switch:checked ~ .text-switch {background-color: #00af2c; border: 1px solid #068506;}
    .checked-switch:checked ~ .text-switch:before {opacity: 0;}
    .checked-switch:checked ~ .text-switch:after {opacity: 1;}
    .toggle-btn {background: linear-gradient(#eee, #fafafa); border-radius: 100%; height: 28px; left: 1px; position: absolute; top: 2px; width: 28px;}
    .toggle-btn::before {color: #aaaaaa; display: inline-block; font-size: 12px; letter-spacing: -2px; padding: 4px 0; vertical-align: middle;}
    .checked-switch:checked ~ .toggle-btn {left: 51px;}
    .text-switch, .toggle-btn {transition: All 0.3s ease; -webkit-transition: All 0.3s ease; -moz-transition: All 0.3s ease; -o-transition: All 0.3s ease;}
</style>
<div class="box" style="font-size: 9px">
    <div class="box-title c">
        <h1>当前界面：动动约 》资源登记 》服务者登记</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
    <div class="box-detail-tab">
            <ul class="c">
                <li style="width:150px;"><a href="<?=$this->createUrl('index')?>">登记中</a></li>
                <li class="current" style="width:150px;">已登记</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <!-- <label style="margin-right:20px;">
                    <span>审核状态：</span>
                    <?php //echo downList($base_code,'f_id','F_NAME','state'); ?>
                </label> -->
                <!-- <label style="margin-right:20px;">
                    <span>按类型：</span>
                    <?php //echo downList($type_id,'id','f_uname','type_id'); ?>
                </label> -->
                <!-- <label style="margin-right:20px;">
                    <span>按等级：</span>
                    <?php //echo downList($type_code,'f_id','card_name','type_code'); ?>
                </label> -->
                <!-- <label style="margin-right:20px;">
                    <span>按项目：</span>
                    <?php //echo downList($project_list,'id','project_name','project'); ?>
                </label> -->
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" placeholder="编号 / 帐号 / 姓名" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
                <?php
                    if(get_session('club_id')<>1){
                        echo show_command('添加',$this->createUrl('create'),'添加');
                    }
                ?>
                <a style="display:none;vertical-align: middle;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('qcode');?></th>
                        <!-- <th><?php // echo $model->getAttributeLabel('server_name');?></th> -->
                        <th><?php echo $model->getAttributeLabel('qualification_name');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_project_name');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_type');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_title');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_level');?></th>
                        <th><?php echo $model->getAttributeLabel('servic_site_name');?></th>
                        <th><?php echo $model->getAttributeLabel('is_salable');?></th>
                        <th><?php echo $model->getAttributeLabel('check_state1');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->qcode; ?></td>
                        <!-- <td><?php // echo $v->server_name; ?><!-- </td> -->
                        <td><?php echo $v->qualification_name; ?></td>
                        <td><?php echo $v->qualification_project_name; ?></td>
                        <td><?php echo $v->qualification_type; ?></td>
                        <td><?php echo $v->qualification_title; ?></td>
                        <td><?php echo $v->qualification_level_name; ?></td>
                        <td>
                            <?php
                                if(!empty($v->qmddsite)) echo $v->qmddsite->site_name;
                            ?>
                        </td>
                        <td>
                            <label class="switch-btn">
                            <?php $num = ($v->is_salable==0) ? 1 : 0; ?>
                            <?php echo ($v->is_salable==0) ? "<input class=\"checked-switch\" type=\"checkbox\" onclick=\"clickSetSalable($v->id,$num)\" />" : "<input class=\"checked-switch\" type=\"checkbox\" onclick=\"clickSetSalable($v->id,$num)\" checked=\"checked\" />"; ?>
                                <span class="text-switch" data-yes="可售" data-no="不可售"></span>
                                <span class="toggle-btn"></span>
                            </label>
                        </td>
                        <td><?php echo $v->check_state_name; ?></td>
                        <td>
                            <?php
                                // $num = ($v->is_salable==0) ? 1 : 0;
                                // $txt = ($v->is_salable==0) ? '设为可售' : '取消可售';
                                // echo show_command('可售','javascript:;',$txt,'onclick="clickSetSalable(\''.$v->id.'\','.$num.');"','is_salable');
                                // echo '&nbsp;';
                                echo show_command('详情',$this->createUrl('update_check', array('id'=>$v->id)),'详情');
                                echo '&nbsp;';
                                echo show_command('删除','\''.$v->id.'\'');
                            ?>
                        </td>
                    </tr>
                <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

    function clickSetSalable(id,n){
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('setSalable'); ?>&id='+id+'&is_salable='+n,
            dataType: 'json',
            success: function(data){
                console.log(data);
                if (data.status==1){
                    we.success(data.msg, data.redirect);
                }else{
                    we.msg('minus', data.msg);
                }
            },
            error: function(request){
                console.log(request);
            }
        })
    }
</script>
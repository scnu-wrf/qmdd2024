<div class="box" div style="font-size: 9px">
    <div class="box-title c">
        <h1>当前界面：动动约 》资源登记 》服务者登记</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
    	<div class="box-detail-tab">
            <ul class="c">
                <li class="current" style="width:150px;">登记中</li>
                <li style="width:150px;"><a href="<?=$this->createUrl('index_service')?>">已登记</a></li>
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
                <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
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
                                //if(!empty($v->qmddsite)) echo $v->qmddsite->site_name;
                                echo $v->servic_site_name;
                            ?>
                        </td>
                        <td><?php echo $v->check_state_name; ?></td>
                        <td>
                            <?php
                                $action = 'update';
                                $action = ($v->check_state==371 || $v->check_state==373) ? 'update_check' : $action;
                                $title = ($v->check_state==371 || $v->check_state==373) ? '详情' : '编辑';
                                echo show_command('修改',$this->createUrl($action, array('id'=>$v->id,'rn'=>1)),$title);
                                echo '&nbsp;';
                                if($v->check_state==371){
                                    echo '<a href="javascript:;" class="btn" onclick="fnDel_Sourcer('.$v->id.');">撤销</a>';
                                }
                                else{
                                    echo show_command('删除','\''.$v->id.'\'','删除');
                                }
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
    //设置服务资源
    function fnSave_Sourcer(id){
        $.ajax({
            type: 'get',
            url: '<?php echo $this->createUrl("save_Sourcer");?>',
            data: {id: id},
            dataType:'json',
            success: function(data) {
                if (data.status==1){
                    //we.success(data.msg, data.redirect);
                    we.msg('check', data.msg);
                }else{
                    we.msg('minus', data.msg);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest);
                console.log(textStatus);
            }
        });
    }

    //撤销服务资源
    function fnDel_Sourcer(id){
        var a = confirm('是否撤销?');
        if(a){
            $.ajax({
                type: 'get',
                url: '<?php echo $this->createUrl("del_Sourcer",['num'=>1]);?>',
                data: {id: id},
                dataType:'json',
                success: function(data) {
                    if (data.status==1){
                        //we.success(data.msg, data.redirect);
                        we.msg('minus', data.msg);
                    }else{
                        we.msg('minus', data.msg);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log(XMLHttpRequest);
                    console.log(textStatus);
                }
            });
        }
    }
</script>
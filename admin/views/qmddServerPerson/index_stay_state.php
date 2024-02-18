<div class="box" style="font-size: 9px">
    <div class="box-title c">
        <h1>当前界面：动动约 》资源审核 》服务者审核 》待审核</h1>
        <span class="back">
            <a class="btn" href="<?php echo $this->createUrl('index_check'); ?>">返回上一层</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search" style=" border:none;">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <!-- <label style="margin-right:20px;">
                    <span>服务类别：</span>
                    <?php // echo downList($type_id,'id','f_uname','type_id'); ?>
                </label> -->
				<!-- <label style="margin-right:20px;">
                    <span>登记项目：</span>
                    <?php // echo downList($project_list,'id','project_name','project'); ?>
                </label> -->
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" placeholder="编号 / 账号 / 姓名" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="width:25px;" class="check">序号</th>
                        <th><?php echo $model->getAttributeLabel('qcode');?></th>
                        <th><?php echo $model->getAttributeLabel('person_id');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_project_name');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_type');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_title');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_level');?></th>
                        <!-- <th><?php //echo $model->getAttributeLabel('qmdd_user_type1');?></th> -->
                        <th><?php echo $model->getAttributeLabel('servic_site_name');?></th>
                        <th>登记单位</th>
                        <th><?php echo $model->getAttributeLabel('uDate1');?></th>
                        <th style="width:71px;">操作</th>

                    </tr>
                </thead>
                <tbody>
                <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td style="text-align:center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->qcode; ?></td>
                        <td><?php if($v->person_id) echo $v->qualification_name; ?></td>
                        <td><?php echo $v->qualification_project_name; ?></td>
                        <td><?php echo $v->qualification_type; ?></td>
                        <td><?php echo $v->qualification_title; ?></td>
                        <td><?php echo $v->qualification_level_name; ?></td>
                        <!-- <td><?php //if(!empty($v->qmdd_user_type)) echo $v->qmdd_user_type->t_name; ?></td> -->
                        <td><?php echo $v->servic_site_name; ?></td>
                        <td><?php if(!empty($v->club_list)) echo $v->club_list->club_name; ?></td>
                        <td><?php echo $v->uDate; ?></td>
                        <td>
                            <?php echo show_command('审核',$this->createUrl('update_check', array('id'=>$v->id)),'审核'); ?>
                        </td>
                    </tr>
                <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约》场馆管理》<a class="nav-a">场馆查询</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>入驻日期：</span>
                    <input style="width:80px;" class="input-text" type="text" id="star" name="star" value="<?php echo $star;?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>所属单位：</span>
                    <input style="width:200px;" class="input-text" type="text" name="club" placeholder="单位名称" value="<?php echo Yii::app()->request->getParam('club');?>">
                </label>
                <label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php echo downList($project,'project_id','project_name','project'); ?>
                </label>
                <label style="margin-right:10px;">
                        <span>场馆等级：</span>
                        <?php echo downList($level,'id','card_name','level'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="场馆编号 / 场馆名称" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style='text-align: center; width:25px;'>序号</th>
                        <th width="10%"><?php echo $model->getAttributeLabel('site_code');?></th>
                        <th width="10%"><?php echo $model->getAttributeLabel('site_name');?></th>
                        <th><?php echo $model->getAttributeLabel('site_envir');?></th>
                        <th><?php echo $model->getAttributeLabel('site_origin');?></th>
                        <th><?php echo $model->getAttributeLabel('project_list');?></th>
                        <th><?php echo $model->getAttributeLabel('site_level');?></th>
                        <th width="15%"><?php echo $model->getAttributeLabel('area_province');?></th>
                        <th width="10%"><?php echo $model->getAttributeLabel('user_club_name');?></th>
                        <th style='width:70px;'>入驻时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1;
    foreach($arclist as $v){ ?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->site_code; ?></td>
                        <td><?php echo $v->site_name; ?></a></td>
                        <td><?php if(!empty($v->site_envir)) $envir=BaseCode::model()->findAll('f_id in('.$v->site_envir.')');
                         if(!empty($envir)) foreach ($envir as $e) echo $e->F_NAME.' '; ?></td>
                        <td><?php if(!empty($v->origin)) echo $v->origin->F_NAME; ?></td>
                        <td><?php if(!empty($v->project_list)){
                            $project=ProjectList::model()->findAll('id in('.$v->project_list.')');
                            $tx='';
                            if(count($project)>=2){
                                $tx=$project[0]['project_name'].' '.$project[1]['project_name'].'...';
                            } elseif (count($project)==1) {
                                $tx=$project[0]['project_name'];
                            }
                            echo $tx;
                        }  ?></td>
                        <td><?php echo $v->site_level_name; ?></td>
                        <td><?php echo $v->area_province; ?><?php echo $v->area_city; ?><?php echo $v->area_district; ?></td>
                        <td><?php echo $v->user_club_name; ?></td>
                        <td><?php echo $v->reasons_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_check', array('id'=>$v->id,'list'=>'search'));?>" title="详情">详情</a>
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
    var $star_time=$('#star');
    var $end_time=$('#end');
    $star_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
    });
</script>
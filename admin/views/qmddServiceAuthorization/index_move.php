<?php
    check_request('back_url','');
    $arr = explode(',',str_replace(['{','}','"'],'',base64_decode($_REQUEST['back_url'])));
    $skey = '';
    $stimestar = '';
    $stimeend = '';
    if(!empty($arr))foreach($arr as $ar){
        $af = explode(':',$ar);
        if($af[0]=='keywords') $skey = $af[1];
        if($af[0]=='servic_time_star') $stimestar = $af[1];
        if($af[0]=='servic_time_end') $stimeend = $af[1];
    }
    // echo $back_url['keywords'];
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约 》服务签到 》签到管理 》动动约签到授权</h1>
        <span class="back">
            <a class="btn" href="<?php echo $this->createUrl('gfServiceData/signin_index',array('keywords'=>$skey,'servic_time_star'=>$stimestar,'servic_time_end'=>$stimeend)); ?>">返回上一层</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create_move'),'添加') ?>
        </div>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="back_url" value="<?php echo $_REQUEST['back_url'];?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="动动约类型，被授权人姓名及账号">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
                <span>授权说明
                    <span class="span_tip">
                        <a href="javascript:;" class="dis_rounds" style="width:25px;height:25px;font-size: 18px;vertical-align: text-top;"><i class="fa fa-exclamation"></i></a>
                        <div class="tip" style="width:500px;left: -29px;top: 35px;">
                            <p>1、当预订服务类型为“服务者”，默认该服务者对与之相关的服务单进行签到</p>
                            <p>2、当预订服务类型为“约赛”时，默认该约赛绑定的裁判员可对约赛服务单进行签到</p>
                            <p>3、当预订服务类型为“约练、场馆”，默认该单位管理员可对该服务单进行签到(默认待讨论)</p>
                            <p>4、单位可添加授权签到人员，添加后新增的添加人员与默认的签到人员均可对相关服务单进行签到</p>
                            <p>5、默认”单位管理员”时存在多个的情况下，默认全部单位管理员都可对服务单进行签到</p>
                            <p>6、按【服务类型】添加签到授权，仅可添加【两名签到操作员】</p>
                            <p>7、被授权用户为已实名登记的GF会员</p>
                            <i class="t"></i>
                        </div>
                    </span>
                </span>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('service_type');?></th>
                        <th><?php echo $model->getAttributeLabel('authorization_account');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td><?php echo $index ?></td>
                        <td><?php echo $v->service_type_name; ?></td>
                        <td>
                            <?php
                                if(!empty($v->authorized_person_id)){
                                    $str = '';
                                    $list = GfUser1::model()->findAll('GF_ID in('.$v->authorized_person_id.')');
                                    if(!empty($list))foreach($list as $ls){
                                        if(!empty($str)) $str .= '，';
                                        $str .= $ls->GF_ACCOUNT.'/'.$ls->GF_NAME;
                                    }
                                    echo $str;
                                }
                            ?>
                        </td>
                        <td>
                            <?php echo show_command('修改',$this->createUrl('update_move',['id'=>$v->id]),'编辑'); ?>
                            <?php echo show_command('删除','\''.$v->id.'\''); ?>
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
    var deleteUrl = '<?php echo $this->createUrl('delete',array('id'=>'ID')); ?>';
</script>
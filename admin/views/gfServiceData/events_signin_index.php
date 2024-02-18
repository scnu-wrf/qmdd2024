
<?php 
    $s1 = 'id';
    $s2 = GfServiceData::model()->findAll('service_id='.$game_id.' and order_type=351 and is_pay=464 and isnull(sign_come) and supplier_id='.get_session('club_id'));
    $arr = toArray($s2,$s1);
?>
<script>
    var arr_index = <?php echo json_encode($arr); ?>;
</script>
<div class="box" style="font-size:10px;">
    <div class="box-title c"><h1><i class="fa fa-table"></i>签到管理</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <!-- <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a> -->
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <!-- <span style="vertical-align: middle;margin-top: 10px;display: inline-block;margin-right:10px;"><input id="j-sele" class="input-check" type="checkbox" style="width:30px;height:30px;">全选</span> -->
                <a id="j-sele" class="btn" href="javascript:;" onclick="" style="vertical-align: middle;margin-right:10px;" value="1">全选</a>
                <a id="j-send" class="btn" href="javascript:;" onclick="getSendCode();" style="vertical-align: middle;margin-right:10px;">一键发送验证码</a>
                <a id="j-check" class="btn" href="javascript:;" onclick="save_Sourcer('.check-item input:checked',1);" style="vertical-align: middle;margin-right:10px;">一键报到</a>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入服务流水号">
                </label>
                <!-- <label style="margin-right:10px;">
                    <span>日程时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="servic_time_star" name="servic_time_star" value="<?php //echo $startDate;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="servic_time_end" name="servic_time_end" value="<?php //echo $endDate;?>">
                </label> -->
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="text-align: center;">序号</th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('project_name');?></th>
                        <th style="text-align: center;width:150px;">赛事标题</th>
                        <th style="text-align: center;width:150px;">竞赛项目</th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('gf_name');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('contact_phone');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('sign_come');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('sign_code');?></th>
                        <th style='text-align: center;width: 150px;'>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $basepath=BasePath::model()->getPath(170);?>
                <?php $index = 1;
                 foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item">
                            <?php if($v->sign_come==null){ ?>
                                <input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>">
                            <?php } ?>
                        </td>
                        <td style="text-align: center"><?php echo $index ?></td>
                        <!-- <td style="text-align: center"><?php //if(!empty($v->service_type))echo $v->serviceTypeName->F_NAME; ?></td> -->
                        <td style="text-align: center"><?php echo $v->order_num; ?></td>
                        <td style="text-align: center"><?php echo $v->project_name; ?></td>
                        <td style="text-align: center"><?php echo $v->service_name; ?></td>
                        <td style="text-align: center"><?php echo $v->service_data_name; ?></td>
                        <td style="text-align: center"><?php echo $v->gf_name; ?></td>
                        <td style="text-align: center"><?php echo $v->contact_phone; ?></td>
                        <td style="text-align: center">
                            <?php 
                                if($v->sign_come==null){
                                    // if(strtotime($v->servic_time_star)<time()){
                                        echo '未签到';
                                    // }
                                }else{
                                    $left = substr($v->sign_come,0,10);
                                    $right = substr($v->sign_come,11);
                                    echo $left.'<br>'.$right;
                                } 
                            ?>
                        </td>
                        <td style="text-align: center"><?php echo $v->sign_code; ?></td>
                        <td style='text-align: center;'>
                            <?php if($v->sign_come==null||$v->sign_come=='0000-00-00 00:00:00') { ?>
                                <?php if($v->send_sign_code==648){ ?>
                        	        <a class="btn" onClick="sendVerificationCode(<?php echo $v->id;?>);" href="javascript:;" title="服务签到" style="font-size:10px;">发送验证码</a>
                                <?php }else{ ?>
                        	        <a class="btn" onClick="sendVerificationCode(<?php echo $v->id;?>);" href="javascript:;" title="服务签到" style="font-size:10px;">重发验证码</a>
                                <?php } ?>
                        	    <a class="btn" onClick="save_Sourcer(<?php echo $v->id;?>);" href="javascript:;" title="服务签到" style="font-size:10px;">报到</a>
                            <?php }else{ ?>
                        	    已签到
                            <?php } ?>
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
</script>
<script>
    
    var mArr = sessionStorage.getItem("memIdArray");
    if(mArr!=''){
        mArr = $.parseJSON(mArr);
    }
    if(mArr==null||mArr==''||mArr=='[]'){
        mArr=[];
    }else{
        $.each(mArr,function(k,info){
            $('.check-item .input-check').each(function(){
                if(info==$(this).val()){
                    $(this).prop("checked",true);
                }
            });
        })
    }
    
    $(function(){
        var value = sessionStorage.getItem("value");
        if(value==null){value=1;}
        if(value==1){
            $("#j-sele").attr("value",1).text('全选');
        }else{
            $("#j-sele").attr("value",0).text('取消全选');
            $("#j-checkall").prop("checked",true);
        }
    })
    sessionStorage.removeItem("memIdArray");
    sessionStorage.removeItem("value");

    // 总页全选
    $("#j-sele").on('click', function(){
        $temp1 = $('.list .input-check');
        $temp2 = $('.box-table .list tbody tr');
        $this = $(this);
        mArr=[];
        if($this.attr("value")=='1'){
            value=0;
            $this.attr("value",value).text('取消全选');
            $temp1.each(function(){
                this.checked = true;
            });
            $temp2.addClass('selected');
            $.each(arr_index,function(k,info){
                mArr.push(info.id);
            })
        }else{
            value=1;
            $this.attr("value",value).text('全选');
            $temp1.each(function(){
                this.checked = false;
            });
            $temp2.removeClass('selected');
            mArr=[];
        }
    });
    // 每页全选
    $('#j-checkall').on('click', function(){
        $temp1 = $('.check-item .input-check');
        $temp2 = $('.box-table .list tbody tr');
        $this = $(this);
        if($this.is(':checked')){
            $temp1.each(function(){
                mArr.push($(this).val());
                this.checked = true;
            });
            $temp2.addClass('selected');
            mArr=uniqueArray(mArr);
        }else{
            $temp1.each(function(){
                this.checked = false;
                removeByValue(mArr,$(this).val());
            });
            $temp2.removeClass('selected');
        }
    });
    // 单选
    $('.check-item .input-check').on('click', function() {
        $this = $(this);
        if ($this.is(':checked')) {
            $this.parent().parent().addClass('selected');
            mArr.push($this.val());
        } else {
            $this.parent().parent().removeClass('selected');
            removeByValue(mArr,$this.val());
        }
    });

    //移除数组中的固定元素
    function removeByValue(arr, val) {
        for(var i=0; i<arr.length; i++) {
            if(arr[i] == val) {
                arr.splice(i, 1);
                break;
            }
        }
        
    }
    //删除数组重复元素
    function uniqueArray(arr){
        var tmp = new Array();
        for(var i in arr){
            if(tmp.indexOf(arr[i])==-1){
                tmp.push(arr[i]);
            }
        }
        return tmp;
    }
    
    $("#yw0 li").on("click",function(){
        mArr= JSON.stringify(mArr);
        sessionStorage.setItem("memIdArray", mArr);
        sessionStorage.setItem("value", value);
    })


    // 获取所有选中多选框的值
    function getSendCode(){
        if(mArr.length<1){
            we.msg('minus','请选择要发送验证码的成员');
            return false;
        }
        var str= mArr.join(',');
        sendVerificationCode(str);
        mArr=[];
        value=1;
    };

    // 发送验证码
    function sendVerificationCode(id){
        we.loading('show');
        $.ajax({
            type: 'get',
            url: '<?php echo $this->createUrl('getSignCode');?>&id='+id,
            // data: {id: id},
            dataType: 'json',
            success: function(data) {
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                }
                else{
                    we.msg('minus',data.msg);
                }
            }
        });
        return false;
    }
    // 点击报到
    function save_Sourcer(id,val){
        if(val==1){
            if(mArr.length<1){
                we.msg('minus','请选择要报到的成员');
                return false;
            }
            id=mArr.join(',');
        }
        $.ajax({
            type: 'get',
            url: '<?php echo $this->createUrl('save_Sourcer');?>&id='+id,
            dataType: 'json',
            success: function(data) {
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                }else{
                    we.msg('minus', data.msg);
                }
            }
        });
        mArr=[];
        value=1;
        return false;
    }
</script>
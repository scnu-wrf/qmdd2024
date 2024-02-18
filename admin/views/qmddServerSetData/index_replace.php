<?php
    $myDate=$nowDate;
    $seDate=substr($myDate,5,9);
    $c1=($seDate<10?substr($seDate,1,2):$seDate);
    // if($myDate==''){
    //     $c1=date('m');
    // }
    //$days = cal_days_in_month(CAL_GREGORIAN, $c1, date('Y'));
    //$key_name = QmddServerSetData::model()->find('s_name like "%' . $keywords . '%" OR order_name like "%' . $keywords . '%"');
    //if(empty($key_name)){
        //if($keywords!='AAA')
            //echo "<script>$(document).ready(function(){we.msg('minus','无服务');});</script>";
    //}
?>
<?php
    check_request('t_typeid',0);
    check_request('t_stypeid',0);
?>
<style type="text/css">
    .project {
        background-color: #ffffff;
    }
    .project
</style>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约》动动约管理》服务安排管理</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();" style="float:right;"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div>
        <!-- <br><br> -->
        <!-- <small>仅供查询单个服务资源的每月安排情况</small> -->
    <div class="box-content">
        <div class="box-detail-tab" style="margin-top: 15px;">
            <ul class="c">
                <li style="width:150px;"><a href='javascript:alert("暂未开放");'>场地</a></li>
                <li class="current" style="width:150px;"><a href="<?=$this->createUrl('index_replace')?>">服务者</a></li>
                <li style="width:150px;"><a href='javascript:alert("暂未开放");'>约赛</a></li>
                <li style="width:150px;"><a href='javascript:alert("暂未开放");'>约练</a></li>
            </ul>
        </div>
        <div class="box-header">
        <span style="float: left;">
            <a class="btn" style="text-align: center; width: 150px; background-color: #fde9d9;" href="<?php echo $this->createUrl(''); ?>">日服务安排</a>
            <a class="btn" style="text-align: center; width: 150px; margin-left: -5px; background-color: #d9d9d9;" href="<?php echo $this->createUrl(''); ?>">月服务安排</a>
        </span>
        <span style="display: block; text-align: right;">
            <a class="btn" style="text-align: center; width: 80px; background-color: #B0DCA4;">在售</a>
            <a class="btn" style="text-align: center; width: 80px; margin-left: -5px; background-color: #FDE9D9;">预订中</a>
            <a class="btn" style="text-align: center; width: 80px; margin-left: -5px; background-color: #FAB47B;">已预订</a>
            <a class="btn" style="text-align: center; width: 80px; margin-left: -5px; background-color: #D9D9D9;">未售出</a>
            <a class="btn" style="text-align: center; width: 80px; margin-left: -5px; background-color: #D9D9D9;">已关闭</a>
        </span>
        </div><!--box-header end-->
        <div class="box-table">
            <form name="showTable" action="<?php echo Yii::app()->request->url;?>" method="get">
                <table class="list">
                <!-- <input type="hidden" value="<?php // echo "$t_typeid"; ?>"> -->
                    <tr>
                        <td width="10%">项目</td>
                        <td>
                            <?php echo downList($project_list,'project_id','project_name','project_id'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>类别</td>
                        <td>
                            <?php $t_typeid = 2; ?>
                            <select name="t_stypeid" id="t_stypeid">
                                <option value="">请选择</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>年</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>月</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>日</td>
                        <td></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<script>
    function changeGetUserType(op){
        var type_id = $(op).val();
        if(type_id>0){
            $.ajax({
                type: 'get',
                url: '<?php echo $this->createUrl('getUserType'); ?>&type_id='+type_id,
                dataType: 'json',
                success: function(data){
                    // console.log(data);
                    var html = '<option value="">请选择</option>';
                    var sed = <?php echo $_REQUEST['t_stypeid']; ?>;
                    if(data!=''){
                        for(var i=0;i<data.length;i++){
                            html += '<option value="'+data[i]["id"]+'"';
                            if(data[i]["id"]==sed){
                                html += 'selected';
                            }
                            html += '>'+data[i]['f_uname']+'</option>';
                        }
                    }
                    $('#t_stypeid').html(html);
                }
            })
        }
    }
</script>
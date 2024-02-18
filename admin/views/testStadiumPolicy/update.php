<div class="box">

    <div class="box-title c">
        <?php if($sign == 'create'){?>
            <h1>当前界面：订场管理》场馆可预订时间管理》场馆策略管理》<a class="nav-a">添加</a></h1>
        <?php }?>
        <?php if($sign == 'update'){?>
            <h1>当前界面：订场管理》场馆可预订时间管理》场馆策略管理》<a class="nav-a">编辑</a></h1>
        <?php }?>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->

    <div class="box-detail">

    <div class="box-detail-bd">
            <table>

                <tr class="table-title">
                    <td colspan="4" style="font-size: 15px;font-weight: bold;">场馆策略信息</td>
                </tr>

                <tr>
                <td>
                <label for="stadium">场馆名称</label>
                </td>
                <td>
                <select id="stadium">
                    <?php foreach($stadium as $eachstadium){ ?>
                    <option><?php echo $eachstadium->name ?></option>
                    <?php } ?>
                </select>
                </td>
                <td>
                <label for="policy">价格策略</label>
                </td>
                <td>
                <select id="policy">
                    <?php foreach($time as $eachtime){ ?>
                    <option><?php echo $eachtime->name ?></option>
                    <?php } ?>
                </select>
                </td>
                </tr>

                <tr>
                <td>
                <label for="type">场地类型</label>
                </td>
                <td>
                <select id="type">
                    <?php foreach($type as $eachtype){ ?>
                    <option><?php echo $eachtype->name ?></option>
                    <?php } ?>
                </select>
                </td>
                <td><label for="place">场地</label>&emsp;&emsp;&emsp;<button onclick="getPlace()">一键获取场地列表</button></td>  
                <td>
                <div id="placeList">等待获取场地数据中......</div>
                </td>
                </tr>

                <tr>
                <td><label for="advance_day">可提前订场天数</label></td>
                <td><input type="text" id="advance_day"></td>
                <td><label for="line_day">订场截止天数</label></td>
                <td><input type="text" id="line_day"></td>
                </tr>

                <tr>
                <td><label for="start">开始日期</label></td>
                <td><input type="date" id="start"></td>
                <td><label for="end">结束日期</label></td>
                <td><input type="date" id="end"></td>
                </tr>

                </table>

        <div class="box-detail-submit">
            <button onclick="submit()" class="btn btn-blue">保存</button>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>

    </div><!--box-detail-bd end-->

    </div><!--box-detail end-->

</div><!--box end-->

<script type="text/javascript">
    function getPlace(){
        let stadium=document.getElementById('stadium').value;
        let type=document.getElementById('type').value;
        $.ajax({
            type: 'get',
            url: "<?php echo $this->createUrl('testStadiumPolicy/placeList');?>",
            data: {
                stadium:stadium,
                type:type
            },
            dataType: 'json',
            success: function(data){
                let placeList = document.getElementById('placeList');
                placeList.innerHTML = ''; // 清空原有内容
                for (let i = 0; i < data.length; i++) {
                    let input = document.createElement('input');
                    input.type = 'checkbox';
                    input.name = 'place';
                    input.value = data[i];
                    let label = document.createElement('label');
                    label.appendChild(input);
                    label.appendChild(document.createTextNode(data[i]));
                    placeList.appendChild(label);
                }
            }
        });
    }
    function submit(){
        let stadium=document.getElementById('stadium').value;
        let policy=document.getElementById('policy').value;
        let advance_day=document.getElementById('advance_day').value;
        let line_day=document.getElementById('line_day').value;
        let start=this.changetime(document.getElementById('start').value);
        let end=this.changetime(document.getElementById('end').value);
        let type=document.getElementById('type').value;
        var selectedplaces = [];
        var checkboxes = document.getElementsByName("place");
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                selectedplaces.push(checkboxes[i].value);
            }
        }
        var places=selectedplaces.join(',');
        $.ajax({
            type: 'get',
            url: "<?php echo $this->createUrl('testStadiumPolicy/policyDetail');?>",
            data: {
                stadium:stadium,
                policy:policy,
                advance_day:advance_day,
                line_day:line_day,
                start:start,
                end:end,
                places:places,
                type:type
            },
            dataType: 'json',
            success: function(data){
                if(data="成功"){
                    history.back();
                }
            }
        });
    }
    function changetime(time){
        var date = new Date(time);
        var year = date.getFullYear();
        var month = date.getMonth(); // 月份从0开始，所以需要加1
        var day = date.getDate();
        if (month < 10) {
            month = '0' + (month+1);
        }
        if (day < 10) {
            day = '0' + day;
        }
        var formattedDate = year + "-" + month + "-" + day;
        return formattedDate;
    }
</script>
<style type="text/css">
    #Gbtn{
        padding-top:4px;
        padding-bottom:4px;
        padding-right:2px;
        padding-left:2px;
        font-weight: bold;
    }
    input{
        height:20px;
    }
    input[type="checkbox"] {
        display: inline-block;
        vertical-align: middle;
        margin-left: 5px;
    }
</style>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：订场管理》场馆可预订时间管理》价格策略管理》<a class="nav-a">详细设置</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div>
</div>
<div id="title"><?php echo $model->place_type ?>的<?php echo $model->name ?>策略详细设置</div>
<?php if($sign==0) { ?>
<table>
    <tr>
        <th></th>
        <?php foreach($week as $eachweek){ ?>
        <th><?php echo $eachweek->week ?>(价格：元)</th>
        <?php }?>
    </tr>

    <?php
    $i=1;
    foreach($timespace as $eachspace){ ?>
    <tr>
        <td><?php echo $eachspace->time ?></td>
        <td><input type="text" id="data_<?php echo $i ?>_1"></td>
        <td><input type="text" id="data_<?php echo $i ?>_2"></td>
        <td><input type="text" id="data_<?php echo $i ?>_3"></td>
        <td><input type="text" id="data_<?php echo $i ?>_4"></td>
        <td><input type="text" id="data_<?php echo $i ?>_5"></td>
        <td><input type="text" id="data_<?php echo $i ?>_6"></td>
        <td><input type="text" id="data_<?php echo $i ?>_7"></td>
    </tr>
    <?php 
    $i++;
    }?>
    <tr>
        <td>按钮</td>
        <td><button id="btn2" onclick="samecopy('1')">和首行相同</button></td>
        <td><button id="btn2" onclick="same('2')">和左列相同</button><button id="btn2" onclick="samecopy('2')">和首行相同</button></td>
        <td><button id="btn2" onclick="same('3')">和左列相同</button><button id="btn2" onclick="samecopy('3')">和首行相同</button></td>
        <td><button id="btn2" onclick="same('4')">和左列相同</button><button id="btn2" onclick="samecopy('4')">和首行相同</button></td>
        <td><button id="btn2" onclick="same('5')">和左列相同</button><button id="btn2" onclick="samecopy('5')">和首行相同</button></td>
        <td><button id="btn2" onclick="same('6')">和左列相同</button><button id="btn2" onclick="samecopy('6')">和首行相同</button></td>
        <td><button id="btn2" onclick="same('7')">和左列相同</button><button id="btn2" onclick="samecopy('7')">和首行相同</button></td>
    </tr>
</table>
<?php } ?>

<?php if($sign==1) { 
?>
<table>
    <tr>
        <th></th>
        <?php foreach($week as $eachweek){ ?>
        <th><?php echo $eachweek->week ?>(价格：元)</th>
        <?php }?>
    </tr>

    <?php
    $i=1;
    foreach($timespace as $eachspace){ 
    ?>
    <tr>
        <td><?php echo $eachspace->time ?></td>
        <?php
        foreach($oldmodel as $each){
        ?>

        <?php if($each->week=='星期一'&&$each->time==$eachspace->time){ ?>
            <td><input type="text" id="data_<?php echo $i ?>_1" value="<?php echo $each->price?>"></td>
        <?php } ?>
        <?php if($each->week=='星期二'&&$each->time==$eachspace->time){ ?>
            <td><input type="text" id="data_<?php echo $i ?>_2" value="<?php echo $each->price?>"></td>
        <?php } ?>
        <?php if($each->week=='星期三'&&$each->time==$eachspace->time){ ?>
            <td><input type="text" id="data_<?php echo $i ?>_3" value="<?php echo $each->price?>"></td>
        <?php } ?>
        <?php if($each->week=='星期四'&&$each->time==$eachspace->time){ ?>
            <td><input type="text" id="data_<?php echo $i ?>_4" value="<?php echo $each->price?>"></td>
        <?php } ?>
        <?php if($each->week=='星期五'&&$each->time==$eachspace->time){ ?>
            <td><input type="text" id="data_<?php echo $i ?>_5" value="<?php echo $each->price?>"></td>
        <?php } ?>
        <?php if($each->week=='星期六'&&$each->time==$eachspace->time){ ?>
            <td><input type="text" id="data_<?php echo $i ?>_6" value="<?php echo $each->price?>"></td>
        <?php } ?>
        <?php if($each->week=='星期日'&&$each->time==$eachspace->time){ ?>
            <td><input type="text" id="data_<?php echo $i ?>_7" value="<?php echo $each->price?>"></td>
        <?php break;} ?>

        <?php } ?>
    </tr>
    <?php 
    $i++;
    } ?>
    <tr>
        <td>按钮</td>
        <td><button id="btn2" onclick="samecopy('1')">和首行相同</button></td>
        <td><button id="btn2" onclick="same('2')">和左列相同</button><button id="btn2" onclick="samecopy('2')">和首行相同</button></td>
        <td><button id="btn2" onclick="same('3')">和左列相同</button><button id="btn2" onclick="samecopy('3')">和首行相同</button></td>
        <td><button id="btn2" onclick="same('4')">和左列相同</button><button id="btn2" onclick="samecopy('4')">和首行相同</button></td>
        <td><button id="btn2" onclick="same('5')">和左列相同</button><button id="btn2" onclick="samecopy('5')">和首行相同</button></td>
        <td><button id="btn2" onclick="same('6')">和左列相同</button><button id="btn2" onclick="samecopy('6')">和首行相同</button></td>
        <td><button id="btn2" onclick="same('7')">和左列相同</button><button id="btn2" onclick="samecopy('7')">和首行相同</button></td>
    </tr>
</table>
<?php } ?>

<div id="subtn"><button id="submit" onclick="submit()">提交</button><div>

<script type="text/javascript">
    function submit(){
        let values = [];
        for (let i = 1; i <= <?php echo count($timespace); ?>; i++) {
            let rowValues = [];
            for (let j = 1; j <= 7; j++) {
                let inputValue = document.getElementById("data_" + i + "_" + j).value;
                rowValues.push(inputValue);
            }
            values.push(rowValues);
       }
       $.ajax({
            type: 'get',
            url: "<?php echo $this->createUrl('testPricePolicy/submitDetail');?>",
            data: {
                values:JSON.stringify(values),
                id:<?php echo $model->id ?>
            },
            dataType: 'json',
            success: function(data){
                if(data="成功"){
                    history.back();
                }
            }
        });
    }
    function same(id){
        for (let i=1; i<= <?php echo count($timespace); ?>; i++) {
            let inputValue = document.getElementById("data_" + i + "_" + (parseInt(id)-1).toString()).value;
            let sameValue = document.getElementById("data_" + i + "_" + id);
            sameValue.value = inputValue;
        }
    }
    function samecopy(id){
        let inputValue = document.getElementById("data_1" + "_" + id).value;
        for (let i=2; i<= <?php echo count($timespace); ?>; i++) {
            let sameValue = document.getElementById("data_" + i + "_" + id);
            sameValue.value = inputValue;
        }
    }
</script>

<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid black;
        padding: 5px;
        text-align: center;
        width:12.5%;
    }
    th {
        background-color: #f2f2f2;
    }
    input{
        width:40%;
    }
    #btn2{
        font-weight: bold;
        margin-right:5px;
        background-color: rgb(54, 142, 224);
        color:white;
        padding-left:3px;
        padding-right:3px;
    }
    #subtn{
        display: flex;
        flex-direction: row;
        justify-content: center;
        margin-top:20px;
    }
    #submit{
        color:white;
        padding:5px;
        padding-left:20px;
        padding-right:20px;
        font-size:15px;
        font-weight: bold;
        background-color: rgb(54, 142, 224);
    }
    #title{
        display: flex;
        flex-direction: row;
        justify-content: center;
        padding-top:5px;
        padding-bottom:10px;
        font-weight: bold;
        font-size: 20px;
    }
</style>
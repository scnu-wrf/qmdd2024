<div class="box">
    <div class="box-title c">
        <h1>当前界面：订场管理》场馆可预订时间管理》场馆策略管理》<a class="nav-a">详细设置</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div>
</div>
<?php 
$res=1;
foreach($detail as $eachdetail){ ?>
<div id="title"><?php echo $show->stadium_name ?>的<?php echo $eachdetail['place'] ?>策略详细设置
</div>
<table>
    <tr>
        <th></th>
        <?php foreach($dates as $eachdate){  ?>
        <th><?php echo $eachdate ?></th>
        <?php }?>
    </tr>

    <?php
    $i=1;
    foreach($timespaces as $eachspace){
    $j=1;
    ?>
    <tr>
        <td><?php echo $eachspace->time ?></td>
        <?php
        foreach($eachdetail['model'] as $each){
            foreach($dates as $eachdate){ ?>
            <?php if($each->sell_time==$eachdate&&$each->timespace==$eachspace->time){ ?>
                <td><input type="text" id="data_<?php echo $res ?>_<?php echo $i ?>_<?php echo $j ?>" value="<?php echo $each->price?>"></td>
            <?php $j++;break; } ?>
        <?php }if($j>count($dates))break; } ?>
    </tr>
    <?php 
    $i++;
    } ?>
    <tr>
        <td>按钮</td>
        <?php 
        $k=1;
        foreach($dates as $eachdate){ 
            if($k==1){ ?>
                <td><button id="btn2" onclick="samecopy('<?php echo $res ?>','<?php echo $k ?>')">和首行相同</button></td>
            <?php }else{ ?>
                <td><button id="btn2" onclick="same('<?php echo $res ?>','<?php echo $k ?>')">和左列相同</button><button id="btn2" onclick="samecopy('<?php echo $res ?>','<?php echo $k ?>')">和首行相同</button></td>
            <?php } $k++;
        } ?>
    </tr>
</table>
<?php 
$res++;
} ?>

<div id="subtn"><button id="submit" onclick="submit()">提交</button><div>

<script type="text/javascript">
    function submit(){
        let All = [];
        for(let k=1;k<=<?php echo count($detail); ?>;k++){
            let values = [];
            for (let i = 1; i <= <?php echo count($timespaces); ?>; i++) {
                let rowValues = [];
                for (let j = 1; j <= <?php echo count($dates); ?>; j++) {
                    let inputValue = document.getElementById("data_" + k + "_" + i + "_" + j).value;
                    rowValues.push(inputValue);
                }
                values.push(rowValues);
            }
            All.push(values);
       }
       $.ajax({
            type: 'post',
            url: "<?php echo $this->createUrl('testStadiumPolicy/submitDetail');?>",
            data: {
                values:JSON.stringify(All),
                id:<?php echo $show->id ?>
            },
            dataType: 'json',
            success: function(data){
                if(data="成功"){
                    history.back();
                }
            }
        });
    }
    function same(res,id){
        for (let i=1; i<= <?php echo count($timespaces); ?>; i++) {
            let inputValue = document.getElementById("data_"+ res + "_" + i + "_" + (parseInt(id)-1).toString()).value;
            let sameValue = document.getElementById("data_" + res + "_" + i + "_" + id);
            sameValue.value = inputValue;
        }
    }
    function samecopy(res,id){
        let inputValue = document.getElementById("data_" + res +"_1" + "_" + id).value;
        for (let i=2; i<= <?php echo count($timespaces); ?>; i++) {
            let sameValue = document.getElementById("data_" + res + "_" + i + "_" + id);
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
        width:5%;
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
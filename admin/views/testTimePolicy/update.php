<div class="box">

    <div class="box-title c">
        <?php if($sign == 'create'){?>
            <h1>当前界面：订场管理》场馆可预订时间管理》时间策略管理》<a class="nav-a">添加</a></h1>
        <?php }?>
        <?php if($sign == 'update'){?>
            <h1>当前界面：订场管理》场馆可预订时间管理》时间策略管理》<a class="nav-a">编辑</a></h1>
        <?php }?>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?>
    <div class="box-detail-bd">
        <table>
        <tr class="table-title">
        <td colspan="4" style="font-size: 15px;font-weight: bold;">时间策略信息</td>
        </tr><tr>
            <?php echo readData($form,$model,'code');?>
            <?php echo readData($form,$model,'name');?>
            </tr><tr>
            <?php echo readData($form,$model,'timespace');?>
            <?php echo readData($form,$model,'memo');?>
            </tr><tr>
            <?php echo readData($form,$model,'morning_start:list(testTime)');?>
            <?php echo readData($form,$model,'morning_end:list(testTime)');?>
          </tr><tr>
            <?php echo readData($form,$model,'afternoon_start:list(testTime)');?>
            <?php echo readData($form,$model,'afternoon_end:list(testTime)');?>
            </tr><tr>
            <?php echo readData($form,$model,'night_start:list(testTime)');?>
            <?php echo readData($form,$model,'night_end:list(testTime)');?>
            </tr>

            </table>

        <div class="box-detail-submit">
            <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>

    </div><!--box-detail-bd end-->

    <?php $this->endWidget(); ?>

    </div><!--box-detail end-->

</div><!--box end-->
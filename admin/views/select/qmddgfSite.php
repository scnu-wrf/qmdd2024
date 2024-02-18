<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="club_id" value="<?php echo $_GET["club_id"];?>">
                <input type="hidden" name="site_id" value="<?php echo $_GET["site_id"];?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox" value="全选"><span style="display:none;"><a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="add_chose();">添加</a></span></th>
                        <th style="text-align: center; width:25px;">序号</th>
                        <th style="text-align: center;">资源编号</th>
                        <th style="text-align: center;">资源名称</th>
                        <th style="text-align: center;">场地类型</th>
                        <th style="text-align: center;">所属场馆</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr
                            data-id="<?php echo $v->id; ?>"
                            data-site_id="<?php echo $v->site_id;?>"
                            data-code="<?php echo $v->site_code; ?>"
                            data-title="<?php echo $v->site_name; ?>"
                            data-level="<?php echo $v->site_level_name; ?>"
                            data-address="<?php echo $v->site_address; ?>"
                            data-province="<?php echo $v->area_province; ?>"
                            data-city="<?php echo $v->area_city; ?>"
                            data-district="<?php echo $v->area_district; ?>"
                            data-township="<?php echo $v->area_township; ?>"
                            data-street="<?php echo $v->area_street; ?>"
                            data-longitude="<?php echo $v->site_longitude; ?>"
                            data-contact-phone="<?php echo $v->contact_phone; ?>"
                            data-site-location="<?php echo $v->site_location; ?>"
                            data-latitude="<?php echo $v->site_latitude; ?>">
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td style="text-align: center;"><?php echo $index; ?></td>
                            <td><?php echo $v->site_code; ?></td>
                            <td><?php echo $v->site_name; ?></td>
                            <td><?php if(!empty($v->sitetype)) echo $v->sitetype->F_NAME; ?></td>
                            <td><?php if(!empty($v->site)) echo $v->site->site_name; ?></td>
                        </tr>
                    <?php $index++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    /*
$(function(){
    api = $.dialog.open.api;	// art.dialog.open扩展方法
    if (!api) return;

    // 操作对话框
    api.button( { name: '取消' } );

    $('.box-table tbody tr').on('click', function(){
        var id=$(this).attr('data-id');
        var title=$(this).attr('data-title');
        $.dialog.data('site_id', id);
        $.dialog.data('site_name', title);
		$.dialog.data('site_code', $(this).attr('data-code'));
		$.dialog.data('site_level', $(this).attr('data-level'));

		$.dialog.data('address', $(this).attr('data-address'));
		$.dialog.data('province', $(this).attr('data-province'));
		$.dialog.data('city', $(this).attr('data-city'));
		$.dialog.data('district', $(this).attr('data-district'));
        $.dialog.data('township', $(this).attr('data-township'));
		$.dialog.data('street', $(this).attr('data-street'));
		$.dialog.data('longitude', $(this).attr('data-longitude'));
		$.dialog.data('contact_phone', $(this).attr('data-contact-phone'));
		$.dialog.data('site_location', $(this).attr('data-site-location'));
		$.dialog.data('latitude', $(this).attr('data-latitude'));
        $.dialog.close();
    });
});
*/

$(function(){
    var parentt = $.dialog.parent;              // 父页面window对象
    api = $.dialog.open.api;    //          art.dialog.open扩展方法
    if (!api) return;

    // 操作对话框
    api.button(
            {
                name:'确定',
                callback:function(){
                    return add_chose();
                },
                focus:true
            },
            {
                name:'取消',
                callback:function(){
                    return true;
                }
            }
    );
});

function add_chose(){
        var boxnum = $('table.list ').find('.selected');
        //$.dialog.data('site_id', -1);
        $.dialog.data('qmddsite', boxnum );
        $.dialog.data('site_id', $this.attr('data-site_id'));
        $.dialog.close();
 };
</script>
<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="club_id" value="<?php echo $_GET["club_id"];?>">
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
                        <th style="text-align:center; width:25px;">序号</th>
                        <th width="15%" style="text-align:center;">场馆编号</th>
                        <th width="15%" style="text-align:center;">场馆名称</th>
                        <th width="15%" style="text-align:center;">项目</th>
                        <th width="10%" style="text-align:center;">场馆等级</th>
                        <th style="text-align:center;">场馆地址</th>
                        <th width="10%" style="text-align:center;">场馆电话</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1;
 foreach($arclist as $v){ ?>
                        <tr data-id="<?php echo $v->id; ?>" 
                            data-code="<?php echo $v->site_code; ?>" 
                            data-title="<?php echo $v->site_name; ?>" 
                            data-star="<?php echo $v->site_date_start; ?>" 
                            data-end="<?php echo $v->site_date_end; ?>" 
                            data-phone="<?php echo $v->contact_phone; ?>" 
                            data-address="<?php echo $v->site_address; ?>" 
                            data-location="<?php echo $v->site_location; ?>" 
                            data-longitude="<?php echo $v->site_longitude; ?>" 
                            data-latitude="<?php echo $v->site_latitude; ?>" 
                            data-area-country="<?php echo $v->area_country; ?>" 
                            data-area-province="<?php echo $v->area_province; ?>" 
                            data-area-city="<?php echo $v->area_city; ?>" 
                            data-area-district="<?php echo $v->area_district; ?>" 
                            data-area-township="<?php echo $v->area_township; ?>" 
                            data-area-street="<?php echo $v->area_street; ?>" 
                            data-level="<?php echo $v->site_level_name; ?>">
                            <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->site_code; ?></td>
                            <td><?php echo $v->site_name; ?></td>
                            <td>
                                <?php 
                                    if(!empty($v->site_code)){
                                        $project = GfSiteProject::model()->findAll('site_id="'.$v->id.'"');
                                        if(!empty($project))foreach($project as $p){
                                            echo $p->project_list->project_name.' ';
                                        }
                                    }
                                ?>
                            </td>
                            <td><?php echo $v->site_level_name; ?></td>
                            <td><?php echo $v->site_address; ?></td>
                            <td><?php echo $v->contact_phone; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    $(function(){
        api = $.dialog.open.api;	// art.dialog.open扩展方法
        if (!api) return;

        // 操作对话框
        //api.button( { name: '取消' } );

        $('.box-table tbody tr').on('click', function(){
            var id=$(this).attr('data-id');
            var title=$(this).attr('data-title');
            $.dialog.data('site_id', id);
            $.dialog.data('site_name', title);
            $.dialog.data('site_code', $(this).attr('data-code'));
            $.dialog.data('site_star', $(this).attr('data-star'));
            $.dialog.data('site_end', $(this).attr('data-end'));
            $.dialog.data('site_phone', $(this).attr('data-phone'));
            $.dialog.data('site_address', $(this).attr('data-address'));
            $.dialog.data('site_location', $(this).attr('data-location'));
            $.dialog.data('site_longitude', $(this).attr('data-longitude'));
            $.dialog.data('site_latitude', $(this).attr('data-latitude'));
            $.dialog.data('site_country', $(this).attr('data-area-country'));
            $.dialog.data('site_province', $(this).attr('data-area-province'));
            $.dialog.data('site_city', $(this).attr('data-area-city'));
            $.dialog.data('site_district', $(this).attr('data-area-district'));
            $.dialog.data('site_township', $(this).attr('data-area-township'));
            $.dialog.data('site_street', $(this).attr('data-area-street'));
            $.dialog.close();
        });
    });
</script>
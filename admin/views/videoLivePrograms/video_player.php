<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<meta name="referrer" content="never">
<meta http-equiv="X-UA-Compatible" content="IE=11" />
<meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" id="viewport" name="viewport">
</head>
<body marginwidth="0" marginheight="0" style="position:absolute;width:100%;top:0;bottom:0;backgroung:#000">
<link rel="stylesheet" href="ckplayer/dp/DPlayer.min.css">
<div id="player1"></div>
<script type="text/javascript" src="ckplayer/dp/hls.min.js"></script>
<script type="text/javascript" src="ckplayer/dp/DPlayer.min.js" charset="utf-8"></script>
<script>
$("title").html("<?php echo $url;?>");
var dp = new DPlayer({
    element: document.getElementById('player1'),
    video: {
        url: "<?php echo $url;?>"
    }
});
dp.play();
</script>

</body>
</html>


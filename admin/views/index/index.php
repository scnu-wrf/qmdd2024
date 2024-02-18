<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="background-color: #f2f2f2;">
<head>
<title><?php echo $cp_home;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="Text/Javascript" language="JavaScript">
<!--
if (window.top != window)
{
  window.top.location.href = document.location.href;
}
 style="background:#212121;"
//-->
</script>

<frameset rows="118,*" framespacing="0" border="0">
  <frame src="<?php echo $this->createUrl('top');?>" id="header-frame" name="header-frame" frameborder="no" scrolling="no" style="background:#212121;">
  <frameset cols="200, 10, *" framespacing="0" border="1" id="frame-body">
    <frame src="<?php echo $this->createUrl('menu');?>" id="menu-frame" name="menu-frame" frameborder="no" scrolling="yes">
    <frame src="<?php echo $this->createUrl('drag');?>" id="drag-frame" name="drag-frame" frameborder="no" scrolling="no">
    <frame src="<?php echo $this->createUrl('start');?>" id="main-frame" name="main-frame" frameborder="no" scrolling="yes">
  </frameset>
</frameset>
<noframes></noframes>
  <frameset rows="0, 0" framespacing="0" border="0">
  <frame src="#" id="hidd-frame" name="hidd-frame" frameborder="no" scrolling="no">
  </frameset>
</head>
<body>
</body>
</html>
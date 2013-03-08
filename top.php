<?php
//findmessages
$pmquery = "SELECT id FROM comments WHERE toid='".$_SESSION['userid']."' && ischecked='0' && toisdesigner='".$_SESSION['ifisdesigner']."' && ispm='1'";
if ($pmresults = mysql_query($pmquery)){
$numofpm = mysql_num_rows($pmresults);
$numofpm = '('.$numofpm.')';
}else{
    $numofpm = 'ERROR ('.mysql_errno().'): '. mysql_error();
}
if ($_SERVER['HTTP_HOST'] == 'patrickmurphyphoto.com'){
   $domain = 'PatrickMurphyPhoto.com';
}else{
    $domain = 'PatrickMurphyWebdesign.com';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <title>Client.<? print $domain;?></title>
  <link rel="stylesheet" type="text/css" href="style.css" />
  <script type="text/javascript" language="javascript" src="js/ajax.js"></script>
  <script type="text/javascript" language="javascript" src="js/dropdown.js"></script>
  <link rel="icon" href="images/favicon.ico" type="image/x-icon" />
</head>

<body onload="placeIt(); showIt()">

  <div id="page-container">
  
    <div id="branding">
      
      <h1><? print $domain;?><span>| Client records and Design Progress</span></h1>
      <span class="searchmail">
        <span>
          <a href="index.php?act=inbox"><img src="images/mail.gif" alt="mail" /><?php print $numofpm; ?></a>
        </span><?php if($_SESSION['ifisdesigner']==1){?>
        <form name="form" action="index.php?act=search" method="get">
          <input type="text" name="q" />
          <input class="submit" type="submit" name="act" value="Search" />
        </form>
        <?php } ?>
    </span>
        
    </div><!-- end branding -->
    
    <div id="page-navigation" class="clearfix">
      
      <ul>

        <li <? if (empty($_GET['act'])) { ?>class="current"<? } ?>><a href="index.php">Home</a></li>
        <li <? if ($_GET['act'] == 01 or $_GET['act'] == 'editclient' or $_GET['act'] == 'clientview') { ?>class="current"<? } ?>><a href="index.php?act=01">Clients</a></li>
        <li <? if ($_GET['act'] == 'inbox' && $_GET['sent']!=1) { ?>class="current"<? } ?>><a href="index.php?act=inbox">Inbox</a></li>
        <li <? if ($_GET['act'] == 'inbox' && $_GET['sent']==1) { ?>class="current"<? } ?>><a href="index.php?act=inbox&sent=1">Outbox</a></li>
        <?php if($_SESSION['ifisdesigner']==1){ ?><li <? if ($_GET['act'] == 02) { ?>class="current"<? } ?>><a href="index.php?act=02">Payments</a></li><?php } ?>
        <? if ($_SESSION['loggedin'] == 1) {
    print '<li><a href="login.php?act=logout">Logout</a></li>';
} ?>
      </ul>
      <ul id="sddm" style="float:right;">
      	<li>
      		<a href="#" onmouseover="mopen('m1')" onmouseout="mclosetime()">Account</a>
      		<div id="m1" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
		        <a href="index.php?act=changepassword">Change Password</a>
		        <a href="index.php?act=inbox">Inbox</a>
        	</div>

        </li>
        <li style="width:70px"></li>
      </ul> 
        
    </div><!-- end page-navigation -->

    
    <div id="page-content" class="clearfix">
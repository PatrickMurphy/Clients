<?php
session_start();
$link = mysql_connect('localhost', 'grimhqco_slapweb', 'cowcow1');
mysql_select_db('grimhqco_slapdashwebdeisgn', $link);
$previewres = mysql_query('SELECT * FROM websites WHERE id='.$_GET['id']);
$pre = mysql_fetch_array($previewres);
$commentres = mysql_query('SELECT * FROM comments WHERE ispm=0, toid='.$pre['id']);
while($comment = mysql_fetch_array($commentres)){
    if($comment['fromisdesigner']==1){
        $query = 'SELECT * FROM designers WHERE id='.$comment['fromid'];
        $prefix = 'first';
    }else{
        $query = 'SELECT * FROM clients WHERE id='.$comment['fromid'];
        $prefix = '';
    }
    $senderres = mysql_query($query);
    $sender = mysql_query($senderres);
    $comments = $comments . '<tr><td></td>'.$sender[$prefix.'name'].'<td>'.$comment['message'].'</td></tr>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="EN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php print $pre['title']; ?> - Client Page Preview</title>
<style type="text/css">
html {overflow: auto;}
html, body, iframe {margin: 0px; padding: 0px; height: 100%; border: none;}
iframe {display: block; width: 100%; height:90%; border: none; overflow-y: auto; overflow-x: hidden;}
div{
    height: 9%;
    background-color:#CECECE;
    border:1px solid #000;
    }
</style>
</head>
<body>
<iframe id="tree" name="tree" src="<?php print $pre['previewurl']; ?>" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="100%" scrolling="auto"></iframe>
<div><b><?php print $pre['title']; ?></b><br /><table><tr><td>Name:</td><td>Message</td></tr><?php print $comments; ?></table></div>
</body>
</html>
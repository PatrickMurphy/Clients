<?php
//view.php
$inboxquery = "SELECT * FROM comments WHERE id=".$_GET['id'];
$inboxresult = mysql_query($inboxquery, $link) or die(mysql_error());
$updateviewed = mysql_query('UPDATE comments SET ischecked=1 WHERE id='.$_GET['id'], $link) or die(mysql_error());
$row = mysql_fetch_array($inboxresult) or die(mysql_error());
if($row['fromisdesigner']==0){
  $tabletype="clients";
  $viewpage = "clientview";
  $type = "name";
}else{
  $tabletype = 'designers';
  $viewpage = "designerview";
  $type = "designerid";
}
$fromquery = 'SELECT '.$type.' FROM '.$tabletype.' WHERE id=\''.$row['fromid'].'\'';
$fromresult = mysql_query($fromquery) or die(mysql_error());
$from = mysql_fetch_array($fromresult) or die(mysql_error());
print'<p><h1>Subject: '.$row['subject'].'</h1>';
print'<B>From: <a href="index.php?act='.$viewpage.'&id='.$row['fromid'].'">'.$from[$type].'</a></b></p><br />';
print'<p>'.nl2br($row['message']).'</p>';
print'<a id="editbutton" href="index.php?act=inbox&reply=1&title=RE:'.$row['subject'].'&isdesigner='.$row['fromisdesigner'].'&toid=' . $row['fromid'] . '">Reply</a> <a id="editbutton" class="reset" href="index.php?act=7&table=comments&id=' . $row['id'] . '">Delete</a>';
?>
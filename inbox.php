<?php
/**
 * @author Patrick Turner, SlapdashWebdesign.info
 * @copyright 2009, All Rights Reserved
 * inbox.php
 * display list of messages, and each message, send and reply to messages
 */
 if($_GET['view']==1){
     //view
     include('view.php');
 }else{
 if($_GET['compose']==1 OR $_GET['reply']==1){
     if(isset($_GET['submit'])){
         if(empty($_GET['title'])){
             $error['title'] = 'The Subject must be set.';
         }
         if(empty($_GET['message'])){
             $error['message'] = 'The message must be contain text.';
         }
         if(empty($error)){
             list($toisdesigner, $toid) = explode(",", $_GET['toid']);
             $sendmsgquery = 'INSERT INTO comments (id, ispm, ischecked, fromisdesigner, toisdesigner, fromid, toid, subject, message, date) values(0, 1, 0, '.$_SESSION['ifisdesigner'].', '.$toisdesigner.', '.$_SESSION['userid'].', '.$toid.', \''.$_GET['title'].'\', \''.$_GET['message'].'\', CURDATE())';
             if(mysql_query($sendmsgquery)){
                 print'<span class="success">Message Sent!</span>';
             }else{
                 print'<span class="error">'.mysql_error().'</span>
                 <span>The query was: '.$sendmsgquery.'</span>';
             }
         }else{
             foreach ($error as $e){
                     print '<span class="error">'.$e.'</span><br />';
             }
         }
     }else{
         include('composeform.php');
     }
 }else{
?>
<div id="table-block">
    <h1>Messages</h1>
    <div>
        <a href="index.php?act=inbox&compose=1">New Message</a>
        <table cellspacing="0" cellpadding="0">
            <tbody>
                <tr id="tableheader" class="header">
                    <td>From:</td>
                    <td>Title:</td>
                    <td>Date:</td>
                    <td>Actions:</td>
                </tr>
                <?php
                if($_GET['sent']==1){
                    $query = "SELECT * FROM comments WHERE fromid='".$_SESSION['userid']."' && fromisdesigner='".$_SESSION['ifisdesigner']."' && ispm='1' ORDER BY id DESC";
                 }else{
                    $query = "SELECT * FROM comments WHERE toid='".$_SESSION['userid']."' && toisdesigner='".$_SESSION['ifisdesigner']."' && ispm='1' ORDER BY id DESC";
                 }
                 $msgs = 0;
                 $n = 0;
                    if ($inboxresult = mysql_query($query, $link)) {
                        while ($row = mysql_fetch_array($inboxresult)) {
                            $msgs++;
                            if($row['fromisdesigner']==0){
                                $tabletype="clients";
                                $viewpage = "clientview";
                                $type = "name";
                            }else{
                                $tabletype = 'designers';
                                $viewpage = "designerview";
                                $type = "designerid";
                            }
                            $checked = "";
                            if($row['ischecked']==0){
                                $checked=' id="checked"';
                            }
                            $fromquery = 'SELECT '.$type.' FROM '.$tabletype.' WHERE id=\''.$row['fromid'].'\'';
                            $fromresult = mysql_query($fromquery) or die(mysql_error());
                            $from = mysql_fetch_array($fromresult) or die(mysql_error());
                            if ($n == 1) {
                                print '<tr'.$checked.' class="alternate">';
                                $n = 0;
                            } else {
                                print '<tr'.$checked.'>';
                                $n = 1;
                            }
                            list($year, $month, $day) = explode("-",$row['date']);
                            print '<td><a href="index.php?act='.$viewpage.'&id='.$row['fromid'].'">'. $from[$type] .'</a></td>';
                            print '<td><a href="index.php?act=inbox&view=1&id='.$row['id'].'">'. $row['subject'] .'</a></td>';
                            print '<td>'. $month . '/' . $day . '/' . $year .'</td>';
                            print '<td><a id="editbutton" href="index.php?act=inbox&reply=1&title=RE:'.$row['subject'].'&isdesigner='.$row['fromisdesigner'].'&toid=' . $row['fromid'] . '">Reply</a> <a id="editbutton" class="reset" href="index.php?act=7&table=comments&id=' . $row['id'] . '">Delete</a></td></tr>';
                        }
                        if($msgs==0){
                            print'<tr id="checked"><td colspan=4>Your inbox contains no messages.</td></tr>';
                        }
                        print'</tbody></table></div></div>';
                    }else{
                        print'error:'.mysql_error().' - The query was '. $inboxquery;
                    }
                 }
            }
                ?>
                    
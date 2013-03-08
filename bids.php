<div id="table-block">
          <table cellspacing="0" cellpadding="0">
          <tbody>
              <tr class="header">
                  <td>ID</td>
                  <td>Name</td>
                  <td>E-Mail</td>
                  <td>Type</td>
                  <td>Subject</td>
                  <td>Message</td>
                  <td>ip</td>
                  <td>Status</td>
                  <td>Actions</td>
               </tr>
<?php
//bids.php
$bids = mysql_query('SELECT * FROM bids'.$limitedbid);
$alt[1]='class="alternate"';
$alt[0]=NULL;
$n = 0;
while ($bid = mysql_fetch_array($bids)){
      switch ($bid['type']){
             Case 1:
                  $type = 'Photography';
             break;
             Case 2:
                  $type = 'Website';
             break;
             default:
                 $type = 'Undefined';
             break;
      }
      $count = 0;
      $claimed = 'Not Claimed';
      $styleclaimed = 'false';
      if($bid['claimed']==1){
          $claimed = 'Claimed';
          $styleclaimed = 'true';
      }
	print'<tr '.$alt[$n].'>
              <td>'.$bid['id'].'</td>
              <td>'.$bid['name'].'</td>
              <td>'.$bid['email'].'</td>
              <td>'.$type.'</td>
              <td>'.$bid['subject'].'</td>
              <td>'.$bid['message'].'</td>
              <td>'.$bid['ip'].'</td>
              <td class="'.$styleclaimed.'">'.$claimed.'</td>
              <td class="actions"><a class="edit" href="claim.php?claimid='.$bid['id'].'">Claim</a> | <a class="delete" href="index.php?act=7&table=bids&id='.$bid['id'].'">Delete</a></td>
            </tr>';
            if($n == 1){
                  $n = 0;
            }else{
                $n = 1;
            }
            $count++;
}
if ($count == 0){
      print '<tr>
              <td colspan="9">There are currently no Bids to display</td>
            </tr>';
}
?>
          </tbody>
        </table>
        
</div>
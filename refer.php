<?php
$query = mysql_query('SELECT * FROM clients');
while($client = mysql_fetch_array($query)){
    $websitesq = mysql_query('SELECT referid FROM websites WHERE paymentrecieved=\'1\' AND referid =\''.$client['id'].'\' AND price != \'0.00\'');
    $photosq = mysql_query('SELECT referid FROM photos WHERE paymentrecieved=\'1\' AND referid =\''.$client['id'].'\' AND price != \'0.00\'');
    $photosnum = mysql_num_rows($photosq);
    $websitesnum = mysql_num_rows($websitesq);
    $totalgigs = $photosnum+$websitesnum;
    $profit = 0;
    while($photoitem = mysql_fetch_array($photosq)){
			$profit = $profit + 5;
    }
    while($websiteitem = mysql_fetch_array($websitesq)){
            $profit = $profit + 10;
    }    
    if($profit != 0){
    $refered = $refered. '<tr>
        <td><a href="index.php?act=clientview&id='.$client['id'].'">'.$client['name'].'</a></td><td>'.$totalgigs.'</td><td style="color: darkblue; font-weight:bolder;">'.$websitesnum.'</td><td style="color: darkred; font-weight:bolder;">'.$photosnum.'</td><td>$'.number_format($profit, 2, '.', ',').'</td>
    </tr>';
    }
    }
?>
<div id="table-block">
    <h3 style="width:81%">Refered</h3>
    <div>
    <table cellspacing="0" cellpadding="0" style="width:83%">
          <tbody>
            <tr class="header">
                <td>Name</td><td>Total Refered</td><td>Websites</td><td>Photos</td><td>Profit</td>
            </tr>
            <?php print $refered; ?>
          </tbody>
    </table>
    </div>
</div>
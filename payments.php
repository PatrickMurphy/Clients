<h1>Payments</h1>
<?php
switch($_GET['pact']){
    case 00:
        $inc = 'homepayment.php';
    break;
    case 01:
        $inc = 'overviewpayment.php';
        $pid = 01;
    break;
    case 02:
        $inc = 'designers.php';
        $pid = 02;
    break;
    case 03:
        $inc = 'refer.php';
        $pid = 03;
    break;
    default:
        $inc = 'homepayment.php';
    break;
}
$total = 0;
$n = 0;
$npaid = 0;
$results = mysql_query('SELECT price, paymentrecieved FROM websites');
$results1 = mysql_query('SELECT price, paymentrecieved FROM photos');
While ($row = mysql_fetch_array($results)){
	$n++;
	if ($row['price']!='0.00'){
		$npaid++;
		if($row['paymentrecieved']=='1'){
			$total = $total + $row['price'];
			$nrecieved++;
		}else{
			$totalnot = $totalnot + $row['price'];
			$nnotrecieved++;
		}
	}else{
		$freewebsites++;
	}
}
While ($row = mysql_fetch_array($results1)){
	$n++;
	if ($row['price']!='0.00'){
		$npaid++;
		if($row['paymentrecieved']=='1'){
			$total = $total + $row['price'];
			$nrecieved++;
		}else{
			$totalnot = $totalnot + $row['price'];
			$nnotrecieved++;
		}
	}else{
		$freewebsites++;
	}
}
$totalavg = round($total/$n, 2);
$totalpaidavg = round($total/($npaid-$nnotrecieved), 2);

//designers
$query = mysql_query('SELECT id, firstname, lastname, email FROM designers');
while($design = mysql_fetch_array($query)){
    $websitesq = mysql_query('SELECT price, designerid, paymentrecieved FROM websites WHERE designerid =\''.$design['id'].'\'');
    $photosq = mysql_query('SELECT price, designerid, paymentrecieved FROM photos WHERE designerid =\''.$design['id'].'\'');
    $photosnum = mysql_num_rows($photosq);
    $websitesnum = mysql_num_rows($websitesq);
    $totalgigs = $photosnum+$websitesnum;
    $profit = 0;
    while($photoitem = mysql_fetch_array($photosq)){
		if($photoitem['paymentrecieved']=='1'){
			$profit = $profit + $photoitem['price'];
		}
    }
    while($websiteitem = mysql_fetch_array($websitesq)){
        if($websiteitem['paymentrecieved']=='1'){
            $profit = $profit + $websiteitem['price'];
        }
    }    
    $designers = $designers. '<tr>
        <td><a href="index.php?act=designerview&id='.$design['id'].'">'.$design['firstname'].' '.$design['lastname'].'</a></td><td>'.$design['email'].'</td><td>'.$totalgigs.'</td><td style="color: darkblue; font-weight:bolder;">'.$websitesnum.'</td><td style="color: darkred; font-weight:bolder;">'.$photosnum.'</td><td>$'.round($profit, 2).'</td>
    </tr> 
    ';
}
?>
<div id="sidebar" style="width: 15%;">

        
          <ul>
            <li class="head">Payments</li>
            <li <?if($pid==00){?>class="current"<?}?>><a href="index.php?act=02">Home</a></li>
            <li <?if($pid==01){?>class="current"<?}?>><a href="index.php?act=02&pact=01">Overview</a></li>
            <li <?if($pid==02){?>class="current"<?}?>><a href="index.php?act=02&pact=02">Designers</a></li>
            <li <?if($pid==03){?>class="current"<?}?>><a href="index.php?act=02&pact=03">Refered</a></li>
          </ul>        
        
</div>
<?php
include($inc);
?>
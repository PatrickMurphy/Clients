<?php
//designerview.php
$idtype = $_GET['id'];
print'<!-- designerview.php -->';
$admindetails = '';
if ($_SESSION['ifisdesigner']==1){
    $websitesq = mysql_query('SELECT price, designerid, paymentrecieved FROM websites WHERE designerid =\''.$idtype.'\'');
    $photosq = mysql_query('SELECT price, designerid, paymentrecieved FROM photos WHERE designerid =\''.$idtype.'\'');
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
    $admindetails = '<tr><td>Photos:</td><td style="color: darkred; font-weight:bolder;">'.$photosnum.'</td></tr><tr><td>Websites:</td><td style="color: darkblue; font-weight:bolder;">'.$websitesnum.'</td></tr><tr><td>Profit:</td><td style="color:green;">$'.$profit.'.00</td></tr>';
}
$query = "SELECT * FROM designers WHERE id=" . $idtype . ' LIMIT 1';
if ($result = mysql_query($query)) {
   $row = mysql_fetch_array($result);
        print '<h1>' . $row['firstname'] .' '. $row['lastname'] . '</h1>';
         print'<a id="editbutton" href="index.php?act=inbox&reply=1&title=&isdesigner='.$_SESSION['ifisdesigner'].'&toid=' . $_SESSION['userid'] . '">Send PM</a><br /><br clear="both" />';
        print '<table id="showwebsite">';
        print '<tr><td>Name: </td><td>' . $row['firstname'] . $row['lastname'];
        print '</td></tr><tr><td>Age:</td><td>' . $row['age'];
        print '</td></tr><tr><td>Email:</td><td>' . $row['email'];
        print '</td></tr><tr><td>DesignerID Login:</td><td>' . $row['designerid'];
        print '</td></tr><tr><td>Designer Bio:</td><td>' . $row['bio'];
        print '</td></tr>'.$admindetails.'</table>';
    }
    if ($_SESSION['ifisdesigner'] == 1) {
        $querys[0] = 'photos';
        $querys[1] = 'websites';
        foreach($querys as $query){
            $result = mysql_query('SELECT id, clientid, title, status, price, paymentrecieved, commissiondate, deadline FROM '.$query.' WHERE designerid='.$idtype.' AND finished=0 ORDER BY id DESC') or die(mysql_error());
            if ($query == 'photos'){
                $color = 'darkred';
            }else{
                $color = 'darkblue';
            }
            while($gig = mysql_fetch_array($result)){
                if($gig['paymentrecieved']==1){
                	$payment = '<span style="color:green;">Yes</span>';
                }else{
                	$payment = '<span style="color:red;">No</span>';
                }
                $clientresult = mysql_query('SELECT name FROM clients WHERE id='.$gig['clientid']);
                $client = mysql_fetch_array($clientresult);
                 list($month, $day, $year) = explode('/', $gig['commissiondate']);
                $key = (($month*100)+$day+($year*1000)).'.'.$n2;
                $current[$key] = '<tr><td>'.$gig['id'].'</td><td style="color: '.$color.'; font-weight:bolder;">'.ucfirst($query).'</td><td><a href="index.php?act=clientview&id='.$gig['clientid'].'">'.$client['name'].'</a></td><td>'.$gig['title'].'</td><td>'.$gig['status'].'</td><td>$'.$gig['price'].'</td><td>'.$payment.'</td><td>'.$gig['commissiondate'].'</td><td>'.$gig['deadline'].'</td></tr>';
                $n++;
            }
        }
        $queryz[0] = 'photos';
        $queryz[1] = 'websites';
        foreach($queryz as $query){
            $result = mysql_query('SELECT id, clientid, title, price, paymentrecieved, commissiondate, finishdate FROM '.$query.' WHERE designerid='.$idtype.' AND finished=1 ORDER BY id DESC') or die(mysql_error());
            if ($query == 'photos'){
                $color = 'darkred';
            }else{
                $color = 'darkblue';
            }
            while($gig = mysql_fetch_array($result)){
                if($gig['paymentrecieved']==1){
                	$payment = '<span style="color:green;">Yes</span>';
                }else{
                	$payment = '<span style="color:red;">No</span>';
                }
                $clientresult = mysql_query('SELECT name FROM clients WHERE id='.$gig['clientid']);
                $client = mysql_fetch_array($clientresult);
                list($month, $day, $year) = explode('/', $gig['commissiondate']);
                $key = (($month*100)+$day+($year*1000)).'.'.$n2;
                $finishedar[$key] = '<tr><td>'.$gig['id'].'</td><td style="color: '.$color.'; font-weight:bolder;">'.ucfirst($query).'</td><td><a href="index.php?act=clientview&id='.$gig['clientid'].'">'.$client['name'].'</a></td><td>'.$gig['title'].'</td><td>$'.$gig['price'].'</td><td>'.$payment.'</td><td>'.$gig['commissiondate'].'</td><td>'.$gig['finishdate'].'</td></tr>';
                $n2++;
            }
        }
        krsort($current);
        krsort($finishedar);        
        ?>
        <div id="table-block">
            <table cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr class="header">
                        <td>ID #</td><td>Type</td><td>Client</td><td>Title</td><td>Status</td><td>Price</td><td>Payment Recieved</td><td>Commissioned</td><td>Deadline/Photoshoot</td>
                    </tr>
                    <?php foreach($current as $val){ print $val; } ?>
                  </tbody>
            </table>
        </div>
        <div id="table-block">
            <table cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr class="header">
                        <td>ID #</td><td>Type</td><td>Client</td><td>Title</td><td>Price</td><td>Payment Recieved</td><td>Commissioned</td><td>Finished</td>
                    </tr>
                    <?php foreach($finishedar as $val){ print $val; } ?>
                  </tbody>
            </table>
        </div>
        <?php
    }
?>
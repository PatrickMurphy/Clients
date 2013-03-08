<?php
//photos.php
if (isset($photosid)) {
    print '<!--running from external script-->';
    $external = true;
    $idjobid = $photosid;
} else {
    if (isset($_GET['id'])) {
        $photosid = $_GET['id'];
        $idjobid = $photosid;
    }else{
        print'ERROR no photoid set!';
    }
}
$selectquery = 'SELECT * FROM photos WHERE id=' . $photosid;
$photosquery = mysql_query($selectquery) or die(mysql_error().' Select Photos Query = '.$selectquery);
$photos = mysql_fetch_array($photosquery) or die(mysql_error().'Fetch Photos');
    print '<h1>' . $photos['title'] . '</h1>';
    print '<div id="photos' . $photos['id'] . '" style="display: inline">';
    if ($_SESSION['ifisdesigner'] === 1) {
        print '<a id="editbutton" href="index.php?act=editphoto&id=' . $photosid .
            '">Edit</a> <a id="editbutton" class="reset" href="index.php?act=7&table=photos&id=' .
            $photosid . '">Delete</a><br /><br style="clear:both;" />';
    }
    $designerquery = mysql_query('SELECT designerid, firstname, lastname FROM designers WHERE id=' . $photos['designerid']) or die(mysql_error());
    $designer = mysql_fetch_array($designerquery) or die(mysql_error());
    $clientquery = mysql_query('SELECT name, email FROM clients WHERE id=' . $photos['clientid']) or die(mysql_error());
    $client = mysql_fetch_array($clientquery) or die(mysql_error());
    if($photos['paymentrecieved']==1){
    	$payment = '<span style="color:green;">Yes</span>';
    }else{
    	$payment = '<span style="color:red;">No</span>';
    }
    if($photos['finished']==1){
    	$finished1 = '<span style="color:green;">Yes</span>';
    }else{
    	$finished1 = '<span style="color:red;">No</span>';
    }
            print '<h3>Client name: <a href="index.php?act=clientview&id='.$photos['clientid'].'">' . $client['name'] . '</a></h3>';
            print '<table id="showwebsite">';
            print '<tr><td>Client email: </td><td>' . $client['email'];
            print '</td></tr><tr><td>Photographer:</td><td><a href="index.php?act=designerview&id='.$photos['designerid'].'">' . $designer['firstname'].' '.$designer['lastname'].'</a>';
            print '</td></tr><tr><td>Title:</td><td> ' . stripslashes($photos['title']);
            print '</td></tr><tr><td>URL:</td><td> <a href="' . $photos['url'] . '">Your Photos Click here</a>';
            print '</td></tr><tr><td>Description:</td><td> ' . nl2br(stripslashes($photos['description']));
            print '</td></tr><tr><td>Equipment:</td><td> ' . nl2br(stripslashes($photos['equipment']));
            print '</td></tr><tr><td>Order Date: </td><td>' . nl2br($photos['commissiondate']);
            print '</td></tr><tr><td>Deadline:</td><td> ' . nl2br($photos['deadline']);
            print '</td></tr><tr><td>Status: </td><td>' . $photos['status'];
            print '</td></tr><tr><td>Progress</td><td>';
            $table = "photos";
            include('list.php');
            print '</td></tr><tr><td>Photoshoot Date:</td><td> ' . $photos['finishdate'];
            print '</td></tr><tr><td>Price:</td><td> $' . $photos['price'];
            print '</td></tr><tr><td>Payment Recieved:</td><td>' . $payment;
            print '</td></tr><tr><td>Finished:</td><td>' . $finished1;
            print '</td></tr><tr><td>URL:</td><td> <a href="' . $photos['url'] . '">Your Photos Click here</a>';
            print '</a></td></tr></table></div>';
?>
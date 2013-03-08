<?php
//website.php
if (isset($websiteid)) {
    print '<!--running from external script-->';
    $external = true;
    $idjobid = $websiteid;
} else {
    if (isset($_GET['id'])) {
        $websiteid = $_GET['id'];
        $idjobid = $websiteid;
    }
}
$websitequery = mysql_query('SELECT * FROM websites WHERE id=' . $websiteid);
$website = mysql_fetch_array($websitequery);
    print '<h1>' . $website['title'] . '</h1>';
    print '<div id="website' . $website['id'] . '" style="display: inline">';
    if ($_SESSION['ifisdesigner'] === 1) {
        print '<a id="editbutton" href="index.php?act=06&id=' . $websiteid .
            '">Edit</a> <a id="editbutton" class="reset" href="index.php?act=7&table=websites&id=' .
            $websiteid . '">Delete</a><br /><br style="clear:both;" />';
    }
    $designerquery = mysql_query('SELECT designerid, firstname, lastname FROM designers WHERE id=' . $website['designerid']);
    $designer = mysql_fetch_array($designerquery);
    $clientquery = mysql_query('SELECT name, email FROM clients WHERE id=' . $website['clientid']);
    $client = mysql_fetch_array($clientquery);
    if($website['paymentrecieved']==1){
    	$payment = '<span style="color:green;">Yes</span>';
    }else{
    	$payment = '<span style="color:red;">No</span>';
    }
    if($website['finished']==1){
    	$finished1 = '<span style="color:green;">Yes</span>';
    }else{
    	$finished1 = '<span style="color:red;">No</span>';
    }
            print '<h3>Client name: <a href="index.php?act=clientview&id='.$website['clientid'].'">' . $client['name'] . '</a></h3>';
            print '<table id="showwebsite">';
            print '<tr><td>Client email: </td><td>' . $client['email'];
            print '</td></tr><tr><td>Designer:</td><td><a href="index.php?act=designerview&id='.$website['designerid'].'">' . $designer['firstname'].' '.$designer['lastname'].'</a>';
            print '</td></tr><tr><td>Title:</td><td> ' . $website['title'];
            print '</td></tr><tr><td>URL:</td><td> <a href="' . $website['url'] . '">' . $website['title'] .
                '</a>';
            print '</td></tr><tr><td>Description:</td><td> ' . nl2br(stripslashes($website['description']));
            print '</td></tr><tr><td>Design Brief:</td><td> ' . nl2br(stripslashes($website['designbrief']));
            print '</td></tr><tr><td>Needs:</td><td> ' . nl2br(stripslashes($website['needs']));
            print '</td></tr><tr><td>Files:</td><td>' . nl2br($website['files']);
            print '</td></tr><tr><td>Database:</td><td> ' . nl2br($website['dbs']);
            print '</td></tr><tr><td>Version: </td><td>' . $website['version'];
            print '</td></tr><tr><td>Order Date: </td><td>' . nl2br($website['commissiondate']);
            print '</td></tr><tr><td>Deadline:</td><td> ' . nl2br($website['deadline']);
            print '</td></tr><tr><td>Status: </td><td>' . $website['status'];
            print '</td></tr><tr><td>Progress</td><td>';
            $table = "websites";
            include('list.php');
            print '</td></tr><tr><td>Date Finished:</td><td> ' . $website['finishdate'];
            print '</td></tr><tr><td>Price:</td><td> $' . $website['price'];
            print '</td></tr><tr><td>Payment Recieved:</td><td>' . $payment;
            print '</td></tr><tr><td>Finished:</td><td>' . $finished1;
            print '</td></tr><tr><td>Preview:</td><td> <a href="'. $website['previewurl'].'"> ' . $website['previewurl'];
            print '</a></td></tr></table></div>';
?>
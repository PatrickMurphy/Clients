<?php
$table = "websites";
if (isset($_POST['createwebsite'])) {
        $error = null;
        $designer = $_POST['designerid'];
        $client = $_POST['clientid'];
        $title = addslashes($_POST['title']);
        $commissioned = $_POST['commssiondate1'] . '/' . $_POST['commssiondate2'] . '/' . $_POST['commssiondate3'];
        $deadline = $_POST['deadlinedate1'] . '/' . $_POST['deadlinedate2'] . '/' . $_POST['deadlinedate3'];
        $finished = $_POST['finishdate1'] . '/' . $_POST['finishdate2'] . '/' . $_POST['finishdate3'];
        if (is_numeric($_POST['price'])) {
            $price = $_POST['price'];
        } else {
            $error['price'] = 'The price is not a number';
        }
        if (empty($_POST['title'])) {
            $title = $_POST['title'];
        } else {
            $title = $_POST['title'];
        }
        $desc = addslashes($_POST['description']);
        $designb= addslashes($_POST['designb']);
        $needs = addslashes($_POST['needs']);
        if($_POST['paymentrecieved']!=1){
        	$paymentrecievedvalue = 0;
        }else{
        	$paymentrecievedvalue = 1;
        }
        if($_POST['finished']!=1){
        	$finished1 = 0;
        }else{
        	$finished1 = 1;
        }
        if ($error == null) {
            $query = 'UPDATE websites SET designerid=' . $designer . ', clientid=' . $client . ', title=\'' . $title . '\', url=\'' . $_POST['url'] . '\', description=\'' . $desc . '\', designbrief=\'' . $designb . 
                '\', needs=\'' . $needs . '\', files=\'' . $_POST['files'] . '\', version=\'' . $_POST['version'] . '\', commissiondate=\'' . $commissioned . '\', deadline=\'' . $deadline .
                '\', status=\'' . $_POST['status'] . '\', dbs=\'' . $_POST['databases'] . '\', finishdate=\'' . $finished . '\', price=\'' . $_POST['price'] . '\',
				 paymentrecieved=\''. $paymentrecievedvalue . '\', previewurl=\'' . $_POST['previewurl'] . '\', finished='.$finished1.', referid='.$_POST['referid'].' WHERE id = ' . $_POST['id'];
            if ($ifquery = mysql_query($query)) {
                print '<div class="success">Website Edited</div>';
            } else {
                print '<div class="error">The mysql statement failed. ' . mysql_error() .
                    ', the query was ' . $query . '.</div>';
            }
        } else {
            foreach ($error as $errors) {
                print '<div class="error">' . $errors . '</div>';
            }
        }
        }else{
        $websitequery = mysql_query('SELECT * FROM websites WHERE id=' . $_GET['id']);
        $web = mysql_fetch_array($websitequery);
        $result = mysql_query('SELECT name, id FROM clients');
        $result2 = mysql_query('SELECT firstname, lastname, id FROM designers');
        $select = '<select id="clientid" name="clientid">';
        $select2 = '<select id="referid" name="referid"><option value="0">None</option>';
        while ($row = mysql_fetch_array($result)) {
            $select = $select . '<option value="' . $row['id'] . '"';
            if($row['id']==$web['clientid']){
                $select = $select . 'SELECTED ';
            }
            $select = $select . '>' . $row['name'] . "</option>";
            $select2 = $select2 . '<option value="' . $row['id'] . '"';
            if($row['id']==$web['referid']){
                $select2 = $select2 . 'SELECTED ';
            }
            $select2 = $select2 . '>' . $row['name'] . "</option>";
        }
        $select = $select . '</select>';
        $select2 = $select2 . '</select>';
        $select1 = '<select id="designerid" name="designerid">';
        while ($row2 = mysql_fetch_array($result2)) {
            $select1 = $select1 . '<option value="' . $row2['id'] . '"';
            if($row2['id']==$web['designerid']){
                $select1 = $select1 . 'SELECTED ';
            }
            $select1 = $select1 . '>' . $row2['firstname'] .' '. $row2['lastname'] . "</option>";
        }
        $select1 = $select1 . '</select>';
        list($cdate1, $cdate2, $cdate3) = explode("/", $web['commissiondate']);
        list($ddate1, $ddate2, $ddate3) = explode("/", $web['deadline']);
        list($fdate1, $fdate2, $fdate3) = explode("/", $web['finishdate']);
        $currentyear = date('Y');
        $yearoffsset = $currentyear - 5;
        $yearend = $currentyear + 5;
        //month1
        for ($n = 1; $n <= 12; $n++) {
            $month1 = $month1 . '<option value="' . $n . '"';
            if ($n == $cdate1) {
                $month1 = $month1 . ' SELECTED ';
            }
            $month1 = $month1 . '>' . $n . '</option>';
        }
        //month2
        for ($n = 1; $n <= 12; $n++) {
            $month2 = $month2 . '<option value="' . $n . '"';
            if ($n == $ddate1) {
                $month2 = $month2 . ' SELECTED ';
            }
            $month2 = $month2 . '>' . $n . '</option>';
        }
        //month3
        for ($n = 1; $n <= 12; $n++) {
            $month3 = $month3 . '<option value="' . $n . '"';
            if ($n == $fdate1) {
                $month3 = $month3 . ' SELECTED ';
            }
            $month3 = $month3 . '>' . $n . '</option>';
        }
        //day1
        for ($n1 = 1; $n1 <= 31; $n1++) {
            $day1 = $day1 . '<option value="' . $n1 . '"';
            if ($n1 == $cdate2) {
                $day1 = $day1 . ' SELECTED ';
            }
            $day1 = $day1 . '>' . $n1 . '</option>';
        }
        //day2
        for ($n1 = 1; $n1 <= 31; $n1++) {
            $day2 = $day2 . '<option value="' . $n1 . '"';
            if ($n1 == $ddate2) {
                $day2 = $day2 . ' SELECTED ';
            }
            $day2 = $day2 . '>' . $n1 . '</option>';
        }
        //day3
        for ($n1 = 1; $n1 <= 31; $n1++) {
            $day3 = $day3 . '<option value="' . $n1 . '"';
            if ($n1 == $fdate2) {
                $day3 = $day3 . ' SELECTED ';
            }
            $day3 = $day3 . '>' . $n1 . '</option>';
        }
        //year1
        for ($n2 = $yearoffsset; $n2 <= $yearend; $n2++) {
            $year1 = $year1 . '<option value="' . $n2 . '"';
            if ($n2 == $cdate3) {
                $year1 = $year1 . ' SELECTED ';
            }
            $year1 = $year1 . '>' . $n2 . '</option>';
        }
        //year2
        for ($n2 = $yearoffsset; $n2 <= $yearend; $n2++) {
            $year2 = $year2 . '<option value="' . $n2 . '"';
            if ($n2 == $ddate3) {
                $year2 = $year2 . ' SELECTED ';
            }
            $year2 = $year2 . '>' . $n2 . '</option>';
        }
        //year2
        for ($n2 = $yearoffsset; $n2 <= $yearend; $n2++) {
            $year3 = $year3 . '<option value="' . $n2 . '"';
            if ($n2 == $fdate3) {
                $year3 = $year3 . ' SELECTED ';
            }
            $year3 = $year3 . '>' . $n2 . '</option>';
        }
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        if ($web['paymentrecieved']==1){
        	$paymentrecievedchecked = 'CHECKED';
        }else{
        	$paymentrecievedchecked = NULL;
        }
        if ($web['finished']==1){
        	$finished1 = 'CHECKED';
        }else{
        	$finished1 = NULL;
        }
        
?>
<form action="index.php?act=06" id="creatwebsite" method="post">
    <label for="clientid">For Client:</label><?php print $select; ?><br />
    <label for="clientid">By Designer:</label><?php print $select1; ?><br />
    <label for="clientid">Refered By:</label><?php print $select2; ?><br />
    <label for="title">Title:</label><input type="text" name="title" id="title" value="<?php print $web['title']; ?>" /><input type="hidden" name="id" style="display:none" value="<?php print $_GET['id']; ?>" /><br />
    <label for="url">URL:</label><input type="text" name="url" id="url" value="<?php print $web['url']; ?>" /><br />
    <label for="description">Description:</label><textarea id="description" name="description"><?php print stripslashes($web['description']);?></textarea><br />
    <label for="designbrief">Design brief:</label><textarea id="designbrief" name="designbrief"><?php print stripslashes($web['designbrief']);?></textarea><br />
    <label for="needs">Needs:</label><textarea id="needs" name="needs"><?php print stripslashes($web['needs']);?></textarea><br />
    <label for="files">Files:</label><textarea id="files" name="files"><?php print $web['files'];?></textarea><br />
    <label for="databases">Databases:</label><textarea id="databases" name="databases"><?php print $web['dbs'];?></textarea><br />
    <label for="version">Version:</label><input type="text" name="version" id="version" value="<?php print $web['version']; ?>" /><br />
    <label for="commssiondate1">Commissioned:</label><select id="commssiondate1" name="commssiondate1"><?php print
$month1; ?></select><select id="commssiondate2" name="commssiondate2"><?php print
$day1; ?></select><select id="commssiondate3" name="commssiondate3"><?php print
$year1; ?></select><br />
    <label for="deadlinedate1">Deadline:</label><select id="deadlinedate1" name="deadlinedate1"><?php print
$month2; ?></select><select id="deadlinedate2" name="deadlinedate2"><?php print
$day2; ?></select><select id="deadlinedate3" name="deadlinedate3"><?php print
$year2; ?></select><br />
    <label for="status">Status:</label><input type="text" name="status" id="status"  value="<?php print $web['status']; ?>" /><br />
    <label for="finishdate1">Finish Date:</label><select id="finishdate1" name="finishdate1"><?php print
$month3; ?></select><select id="finishdate2"    name="finishdate2"><?php print
$day3; ?></select><select id="finishdate3" name="finishdate3"><?php print
$year3; ?></select><br />
    <label for="price">Price:</label><input type="text" name="price" id="price"  value="<?php print $web['price']; ?>" /><br />
    <label for="payment">Payment Recieved?</label><input type="checkbox" name="paymentrecieved" value="1" <?php print $paymentrecievedchecked; ?> /><br />
    <label for="finished">Finished:</label><input type="checkbox" name="finished" value="1" <?php print $finished1; ?> /><br />
    <label for="previewurl">Preview URL:</label><input type="text" name="previewurl" id="previewurl" value="<?php print $web['previewurl']; ?>" /><input type="submit" class="submit" name="createwebsite" value="Edit Website" /></form>
    <?php }
    $jobid = $_GET['id'];
    print '<br style="clear:both;" />';
    include('createlist.php');
    ?>
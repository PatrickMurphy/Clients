<?php
$table = "websites";
if ($_SESSION['ifisdesigner'] == 1) {
    if (isset($_POST['createwebsite'])) {
        $error = null;
        $designer = $_GET['designerid'];
        $client = $_POST['clientid'];
        $title = $_POST['title'];
        $commissioned = $_POST['commssiondate1'] . '/' . $_POST['commssiondate2'] . '/' .
            $_POST['commssiondate3'];
        $deadline = $_POST['deadlinedate1'] . '/' . $_POST['deadlinedate2'] . '/' . $_POST['deadlinedate3'];
        $finished = $_POST['finishdate1'] . '/' . $_POST['finishdate2'] . '/' . $_POST['finishdate3'];
        if (is_numeric($_POST['price'])) {
            $price = $_POST['price'];
        } else {
            $error['price'] = 'The price is not a number';
        }
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
        if (empty($_POST['title'])) {
            $title = $_POST['title'];
        } else {
            $title = $_POST['title'];
        }
        $desc = addslashes($_POST['description']);
        if ($error == null) {
            $query = 'INSERT INTO websites VALUES (0, ' . $designer . ', ' . $client . ', \'' .
                $title . '\', \'' . $_POST['url'] . '\', \'' . $desc . '\', \'' .addslashes($_POST['designbrief']) .
                '\', \'' .addslashes($_POST['needs']) . '\', \'' .addslashes($_POST['files']) . '\', \'' . addslashes($_POST['databases']) .
                '\', \'' .addslashes($_POST['version']) . '\', \'' . $commissioned . '\', \'' . $deadline .
                '\', \'' .addslashes($_POST['status']) . '\', \'' . $finished . '\', \'' . $_POST['price'] .
                '\', '.$paymentrecievedvalue.', '.$finished1.', \'' . $_POST['previewurl'] . '\', '.$_POST['referid'].') ';
            if ($ifquery = mysql_query($query)) {
                $photosres = mysql_query('SELECT id FROM websites ORDER BY id DESC LIMIT 1');
            	$photosnew = mysql_fetch_array($photosres);
            	$designres = mysql_query('SELECT websites FROM designers WHERE id='.$_SESSION['userid']);
            	$design = mysql_fetch_array($designres);
            	mysql_query('UPDATE designers SET websites=`'.$design['websites'].', '.$photosnew['id'].'` WHERE id='.$_SESSION['userid']);
                print '<div class="success">Website Created</div>';
            } else {
                print '<div class="error">The mysql statement failed. ' . mysql_error() .
                    ', the query was ' . $query . '.</div>';
            }
        } else {
            foreach ($error as $errors) {
                print '<div class="error">' . $errors . '</div>';
            }
        }
    } else {
        $result = mysql_query('SELECT name, id FROM clients ORDER BY name ASC');
        $select = '<select id="clientid" name="clientid">';
        $select2 = '<select id="referid" name="referid"><option value="0">None</option>';
        while ($row = mysql_fetch_array($result)) {
            $select = $select . '<option value="' . $row['id'] . '">' . $row['name'] .
                "</option>";
            $select2 = $select2 . '<option value="' . $row['id'] . '">' . $row['name'] .
                "</option>";
        }
        $select = $select . '</select>';
        $select2 = $select2 . '</select>';
        $currentday = date('j');
        $currentyear = date('Y');
        $currentmonth = date('n');
        $yearoffsset = $currentyear - 3;
        $yearend = $currentyear + 3;
        for ($n = 1; $n <= 12; $n++) {
            $month = $month . '<option value="' . $n . '"';
            if ($n == $currentmonth) {
                $month = $month . ' SELECTED ';
            }
            $month = $month . '>' . $n . '</option>';
        }
        for ($n1 = 1; $n1 <= 31; $n1++) {
            $day = $day . '<option value="' . $n1 . '"';
            if ($n1 == $currentday) {
                $day = $day . ' SELECTED ';
            }
            $day = $day . '>' . $n1 . '</option>';
        }
        for ($n2 = $yearoffsset; $n2 <= $yearend; $n2++) {
            $year = $year . '<option value="' . $n2 . '"';
            if ($n2 == $currentyear) {
                $year = $year . ' SELECTED ';
            }
            $year = $year . '>' . $n2 . '</option>';
        }
?>
<form action="index.php?act=05&designerid=<?php print $_SESSION['userid']; ?>" id="creatwebsite" method="post">
    <label for="clientid">For Client:</label><?php print $select; ?><a href="index.php">Create Client first</a><br />
    <label for="referid">Refering Client:</label><?php print $select2; ?><br />
    <label for="title">Title:</label><input type="text" name="title" id="title" /><br />
    <label for="url">URL:</label><input type="text" name="url" id="url" /><br />
    <label for="description">Description:</label><textarea id="description" name="description"></textarea><br />
    <label for="designbrief">Design brief:</label><textarea id="designbrief" name="designbrief"></textarea><br />
    <label for="needs">Needs:</label><textarea id="needs" name="needs"></textarea><br />
    <label for="files">Files:</label><textarea id="files" name="files"></textarea><br />
    <label for="databases">Databases:</label><textarea id="databases" name="databases"></textarea><br />
    <label for="version">Version:</label><input type="text" name="version" id="version" /><br />
    <label for="commssiondate1">Commissioned:</label><select id="commssiondate1" name="commssiondate1"><?php print
$month; ?></select><select id="commssiondate2" name="commssiondate2"><?php print
$day; ?></select><select id="commssiondate3" name="commssiondate3"><?php print
$year; ?></select><br />
    <label for="deadlinedate1">Deadline:</label><select id="deadlinedate1" name="deadlinedate1"><?php print
$month; ?></select><select id="deadlinedate2" name="deadlinedate2"><?php print
$day; ?></select><select id="deadlinedate3" name="deadlinedate3"><?php print
$year; ?></select><br />
    <label for="status">Status:</label><input type="text" name="status" id="status" /><br />
    <label for="finishdate1">Finish Date:</label><select id="finishdate1" name="finishdate1"><?php print
$month; ?></select><select id="finishdate2"     name="finishdate2"><?php print
$day; ?></select><select id="finishdate3" name="finishdate3"><?php print
$year; ?></select><br />
    <label for="url">Price:</label><input type="text" name="price" id="price" /><br />
    <label for="payment">Payment Recieved?</label><input type="checkbox" name="paymentrecieved" value="1" /><br />
    <label for="finished">Finished?</label><input type="checkbox" name="finished" value="1" /><br />
    <label for="previewurl">Preview URL:</label><input type="text" name="previewurl" id="previewurl" /><input type="submit" class="submit" name="createwebsite" value="Create Website" /></form><br style="clear:both;" /><br />
    <?php include('createlist.php'); ?><br />
<?php }
} ?>
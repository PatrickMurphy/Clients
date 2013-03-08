<form action="index.php" method="get">
<input type="hidden" style="display:none;" name="act" value="inbox" />
<input type="hidden" style="display:none;" name="compose" value="1" />
<label for="title">Subject:</label><input type="text" <?php if($_GET['reply']==1){ print'value="'.$_GET['title'].'"';} ?> name="title" id="title">
<?php
 if($_GET['reply']==1){
 print'<input type="hidden" style="display:none;" name="toid" value="'.$_GET['isdesigner'].','.$_GET['toid'].'">';
 }else{
print'<label for="to">To:</label>';
$result = mysql_query('SELECT designerid, firstname, lastname, id FROM designers ORDER BY designerid ASC');
        $select = '<select id="to" name="toid">';
        while ($row = mysql_fetch_array($result)) {
            $select = $select . '<option value="1,' . $row['id'] . '">' . $row['firstname'].' '. $row['lastname'] . "</option>";
        }
        if($_SESSION['ifisdesigner'] == 1){
        $result = mysql_query('SELECT name, id FROM clients ORDER BY name ASC');
        while ($row = mysql_fetch_array($result)) {
            $select = $select . '<option value="2,' . $row['id'] . '">' . $row['name'] . "</option>";
        }
        }
print $select;
print '</select>';
}
?>
<label for="body"><textarea id="body" name="message"></textarea>
<input type="submit" class="submit" name="submit" value="Send Message" />
</form>



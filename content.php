<?php
switch ($_GET['cact']) {
    case '00':
        $pid = "00";
        $query = false;
        break;
    case '01':
        $pid = "01";
        $query = "SELECT*FROM cal ORDER BY id DESC";
        $tablename = 'cal';
        break;
    case '02':
        $pid = "02";
        $query = "SELECT*FROM note ORDER BY id DESC";
        $tablename = 'note';
        break;
    case '03':
        $pid = "03";
        $query = "SELECT*FROM quiz ORDER BY id DESC";
        $tablename = 'quiz';
        break;
    case '04':
        $pid = "04";
        $query = "SELECT*FROM study ORDER BY id DESC";
        $tablename = 'study';
        break;
    case '05':
        $pid = "05";
        $query = "SELECT*FROM comments ORDER BY id DESC";
        $tablename = 'comments';
        break;
    case '06':
        $pid = "06";
        $query = "SELECT*FROM messages ORDER BY id DESC";
        $tablename = 'messages';
        break;
    case '07':
        $pid = "07";
        $query = "SELECT*FROM shout ORDER BY id DESC";
        $tablename = 'shout';
        break;
    case '08':
        $pid = "08";
        $query = "SELECT*FROM friends ORDER BY id DESC";
        $tablename = 'friends';
        break;

    default:
        $pid = "00";
        break;
}
?>
<div id="sidebar">

        
          <ul>
            <li class="head">Content</li>
            <li <? if ($pid == 00) { ?>class="current"<? } ?>><a href="index.php?act=02">Home</a></li>
            <li <? if ($pid == 01) { ?>class="current"<? } ?>><a href="index.php?act=02&cact=01">Calender</a></li>
            <li <? if ($pid == 02) { ?>class="current"<? } ?>><a href="index.php?act=02&cact=02">Notes</a></li>
            <li <? if ($pid == 03) { ?>class="current"<? } ?>><a href="index.php?act=02&cact=03">Quizzes</a></li>
            <li <? if ($pid == 04) { ?>class="current"<? } ?>><a href="index.php?act=02&cact=04">Study Guides</a></li>
            <li <? if ($pid == 05) { ?>class="current"<? } ?>><a href="index.php?act=02&cact=05">Comments</a></li>
            <li <? if ($pid == 06) { ?>class="current"<? } ?>><a href="index.php?act=02&cact=06">Messages</a></li>
            <li <? if ($pid == '08') { ?>class="current"<? } ?>><a href="index.php?act=02&cact=08">Friends</a></li>
            <li <? if ($pid == 07) { ?>class="current"<? } ?>><a href="index.php?act=02&cact=07">Shout Box</a></li>
          </ul>        
        
</div>
<div id="table-block">
<h1>Content</h1>
<div>
<?php
if ($query != false) {
    print "<table cellspacing=\"0\" cellpadding=\"0\"><tbody><tr class=header>";
    $n1 = 0;
    $n2 = 0;
    $query1 = "DESCRIBE $tablename";
    $result = mysql_query($query1);
    while ($i = mysql_fetch_assoc($result)) {
        echo "<td>{$i['Field']}</td>";
        $n1++;
    }
    print "<td>Actions</td></tr>";
    $r = mysql_query($query);
    while ($row = mysql_fetch_array($r)) {
        $n = 0;
        if ($n2 == 1) {
            print '<tr class="alternate">';
            $n2 = 0;
        } else {
            print '<tr>';
            $n2 = 1;
        }
        while ($n < $n1) {
            if ($pid == 03 && $n == 4) {
                print '<td>Answers</td>';
            } else {
                print '<td>' . html_entity_decode($row[$n]) . '</td>';
            }
            $n++;
        }
        print '<td class="actions"><a class="edit" href="index.php?act=03&table=' . $tablename .
            '&pid=' . $pid . '&id=' . $row['id'] .
            '">Edit</a>|<a class="delete" href="delete.php?table=' . $tablename . '&pid=' .
            $pid . '&id=' . $row['id'] . '">Delete</a></td></tr>';
    }
    print '</tbody></table>';
} else {
    print '<p style="font-size:150%;">Welcome to the Content admin. Select the group of content you would like to edit from the menu on the right.</p>';
}
?>
</div></div>


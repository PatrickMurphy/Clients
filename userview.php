<h1>Admin Users</h1>
<?php
if ($_SESSION['admin'] == 1) {
    $results = mysql_query('SELECT * FROM users ORDER BY id ASC');
    print '
<div id="table-block">
     <table cellspacing="0" cellpadding="0">
          <tbody>
            <tr class="header">

              <td>ID</td>
              <td>First Name</td>
              <td>Last Name</td>
              <td>Username</td>
              <td>Email</td>
              <td>Locker</td>
              <td>Age</td>
              <td>Gender</td>
              <td>Grade</td>
              <td>Joined</td>
              <td>Actions</td>

            </tr>';
    $n = 0;
    while ($row = mysql_fetch_array($results)) {
        if ($n == 1) {
            print '<tr class="alternate">';
            $n = 0;
        } else {
            print '<tr>';
            $n = 1;
        }
        if ($row['gender'] == 0) {
            $gender = "Male";
        } else {
            $gender = "Female";
        }
        print '
                   <td>' . $row['id'] . '</td>
                   <td>' . $row['fname'] . '</td>
                   <td>' . $row['lname'] . '</td>
                   <td>' . $row['username'] . '</td>
                   <td>' . $row['email'] . '</td>
                   <td>' . $row['locker'] . '</td>
                   <td>' . $row['age'] . '</td>
                   <td>' . $gender . '</td>
                   <td>' . $row['grade'] . '</td>
                   <td>' . $row['regdate'] . '</td>
                   <td class="actions"><a class="edit" href="index.php?act=03&id=' .
            $row['id'] . '">Edit</a>|<a class="delete" href="index.php?act=03&delete=1&id=' .
            $row['id'] . '">Delete</a></td>
               </tr>';
    }
} else {
    print '<h1 style="color:red;">Denied Access</h1>';
}
?>
          </tbody>
   </table>
        
</div>
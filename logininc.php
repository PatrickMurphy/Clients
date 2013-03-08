<?php
print '<div class="' . $_GET['msgtype'] . '">' . $_GET['msg'] . '</div>';
print '<form width="50%" action="login.php" method="post"><label for="username">Client Id</label><input type="text" name="username"><label for="password">Password</label><input type="password" name="password"><input type="submit" class="submit" value="Login" name="login"></form>';
?>
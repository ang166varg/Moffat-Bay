//Logout

<?php
session_start();

//Destroy all session data
session_destroy();

//Redirect back to landing page
header("Location: ../index.php");
exit();
?>
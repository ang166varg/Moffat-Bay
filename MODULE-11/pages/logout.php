
<!--
Bravo Team - Tevyah Hanley, Angela Vargas, Cameron Mendez, Zachary Anderson
CSD460 - Software Development Capstone
Description - This is the logout page for the Moffat Bay Lodge project. It handles the user logout functionality and redirects them to the home page.
-->
<?php
session_start();

//Destroy all session data
session_destroy();

//Redirect back to landing page
header("Location: ../index.php");
exit();
?>
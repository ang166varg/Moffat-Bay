<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$dbname = "MoffatBayBooking";
$username = "root";
$password = "Starship12!";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email_input = $_POST['email'];
    $password_input = $_POST['password'];
    

    //Query database for user
    $sql = "SELECT * FROM Customer WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email_input);
    $stmt->execute();

    $result = $stmt->get_result();
    

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        //Plain text password check (simple version for school project)
        if (password_verify($password_input, $user['password_hash'])) {

            //Store session variables
            $_SESSION['user_id'] = $user['customer_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['first_name'] = $user['first_name'];
            
            
            

            //Redirect to home page
            header("Location: ../index.php");
            exit();

        } else {
            $error = "Invalid password";
        }

    } else {
        $error = "User not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Moffat Bay Lodge</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>


    <header>

        <div class="top-bar">
            <div class="logo">
                
                <span>Moffat Bay Lodge</span>
            </div>
            <nav>
        
                <ul>
                    <li>
                        <?php if (isset($_SESSION['first_name'])): ?>
                            <p style="color: #355e3b;">Welcome, <?php echo $_SESSION['first_name']; ?> 👋</p>
                            <a href="logout.php" style ="border: solid #355e3b;">Logout</a>    
                        <?php endif; ?>
                    </li>
                    <li><a href="../index.php">Home Page</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="attractions.php">Attractions</a></li>
                    <li><a href="registration.php">Registration</a></li>
                    <li><a href="login.php">Login Page</a></li>
                    <li><a href="reservation.php">Reservations</a></li>
                    <li><a href="reservation-lookup.php">Reservation Lookup</a></li>
                </ul>
            </nav>
        </div>
    </header>

<div class="login-container">
    <form class="login-form" method="POST" action="">
        <h2 class="login-title">Login</h2>
        
        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'login_required'): ?>
            <p style="color: red; margin-bottom: 10px;">You must be logged in to make a reservation.</p>
        <?php endif; ?>
        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'lookup'): ?>
            <p style="color:red; text-align:center;">
                Please log in to look up your reservation.
            </p>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <input type="email" name="email" class="login-input" placeholder="Email" required>
        <input type="password" name="password" class="login-input" placeholder="Password" required>

        <button type="submit" class="login-button">Submit</button>
    </form>
</div>

</body>
</html>
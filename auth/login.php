<?php
session_start();
include('../db_connect/DatabaseConnection.php');

// Login handler
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['user_password']);
    if ($username == $password && $username == 'admin') {
        $_SESSION['role_user'] = 'admin';
        header("Location:../main_form/admin.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM publisher WHERE publisher_name = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if($user){
        $_SESSION['user_id'] = $user['id_publisher'];
        $_SESSION['username'] = $user['publisher_name'];
        header("Location: ../main_form/mainForm.php");
    }else{

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['user_password'])) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
    
            if (isset($_POST['remember_me'])) {
                $user_id = $user['id_user'];
                $expiry = time() + (30 * 24 * 60 * 60); // 30 hari
                $secret_key = 'your_secret_key';
            
                $data = "$user_id|$expiry";
                $signature = hash_hmac('sha256', $data, $secret_key);
                $token = base64_encode("$data|$signature");
            
                setcookie('remember_me_token', $token, $expiry, "/", "", false, true); // Buat cookie
                error_log("Cookie dibuat: $token");
    
            } 
            if (isset($_COOKIE['remember_me_token'])) {
                $token = $_COOKIE['remember_me_token'];
                error_log("Cookie diterima: $token");
            } else {
                error_log("Cookie tidak ditemukan");
            }
                       
            header("Location: ../main_form/mainForm.php");
            exit();
        } else {
            $error_message = "Username atau password salah.";
        }
    }
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="icon" href= "../assets/UAP.ico" type="image/x-icon"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>

    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #2C2C2C;
        color: white;

    }
    #login-section{
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background-image: url('../assets/Login.png');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center top;
        margin: 0;
        padding: 0;
    }
    .navbar {
        background-color: #2C2C2C;
        font-family: Arial, sans-serif;
        padding: 10px 20px;
    }
    .navbar-brand, .nav-link {
        color: #FFFFFF !important;
    }
    .navbar-brand {
        font-weight: bold;
        font-size: 1.5rem;
    }

    .container {
        flex: 1; /* Agar section login menyesuaikan tinggi */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-box {
        background-color: rgba(0, 0, 0, 0.8);
        padding: 30px 25px;
        border-radius: 10px;
        color: white;
        width: 100%;
        max-width: 400px;
        margin: 10px 0;
    }

    section {
        font-size: 1rem;
        line-height: 1.6;
        padding: 30px 0;
        margin:0;
    }
    section h3 {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 20px;
    }
    section p {
        color: #AAA;
        margin-bottom: 15px;
    }
    section .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 10px 20px;
        font-size: 1rem;
        border-radius: 5px;
    }
    section .btn-primary:hover {
        background-color: #0056b3;
    }

    .text-section {
        padding: 40px 20px;
    }

    footer {
    
        font-size: 0.9rem;
        color: #AAA;
        text-align: center;
        padding: 30px;
        background-color: #1C1C1C;
    }

    .register-btn{
        background: linear-gradient(90deg, #1b73e8, #004ba0);
        border: none;
        color: white;
        transition: background-color 0.3s ease, transform 0.3s ease;
        
    }

        /* Efek saat hover */
        .register-btn:hover {
        background: linear-gradient(90deg, #004ba0, #1b73e8); /* Gradien berbalik */
        transform: scale(1.05); /* Sedikit memperbesar tombol */
    }

    /* Menghilangkan padding khusus footer*/
    section.text-white-5py{
        margin-bottom: 0;
    }

    .register{
        padding-bottom: 20px;
    }

</style>

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand mx-auto" href="..\main_form\mainForm.php">
                <img src="..\assets\UapLogoText.svg" alt="UapLogo">
            </a>
        </div>
    </nav>

    <!-- Section Login -->
    <section id="login-section">
        <div class="container">
            <div class="login-box">
                <h2>Login</h2>
                <form action="#" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="user_password" placeholder="Enter your password" required>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember_me">
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                <div class="text-center mt-3">
                    <a href="..\auth\forgotPassword.php" class="text-decoration-none text-info">Forgot Password?</a>
                </div>
            </div>
        </div>
    </section>

<!-- Baru di UAP Section -->
<section class="text-white pt-5 pb-1" style="background-color: #1C1C1C;">
    <div class="container register">
        <div class="row">
            <!-- Kolom 1 -->
            <div class="col-md-9 d-flex flex-column justify-content-center">
                <h3 class="mb-3" style="font-size: 1.5rem; font-weight: bold;">Baru di UAP?</h3>
                <p style="color: #ccc; font-size: 1.1rem;">
                    Gratis dan mudah. Temukan ribuan game untuk dimainkan dengan jutaan teman baru.
                </p>
            </div>
            <!-- Kolom 2 -->
            <div class="col-md-3 d-flex flex-column justify-content-center">
            <a href="..\auth\Register.php" class="btn btn-primary mb-3  py-3 register-btn">
                Buat Akun
            </a>
                
            </div>
        </div>
    </div>
</section>




    <!-- Footer -->
    <footer class="text-center text-white" style="background-color: #1C1C1C;">
        <div class="container">
            <p>© 2024 UAP Corporation. Hak cipta dilindungi Undang-Undang.</p>
            <p>Semua game gratis</p>
        </div>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>







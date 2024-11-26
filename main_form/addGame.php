<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href= "../assets/UAP.ico" type="image/x-icon"> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <title>Add Game</title>
</head>
<style>
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

    .card {
      cursor: pointer;
      transition: transform 0.2s ease;
    }
    .card:hover {
     transform: scale(1.05);
    }
    .icon-plus {
      font-size: 2rem;
      text-align: center;
      color: #007bff;
    }
    
</style>
<body>
      <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand mx-auto" href="..\main_form\mainForm.php">
                <img src="..\assets\UapLogoText.svg" alt="UapLogo">
            </a>
        </div>
    </nav>
    <section>
        <div class="container mt-5" >
          <div class="row justify-content-left" style="width:16rem;height:17rem;" >
              <!-- Kartu Game -->
              <div class="card text-center"id="gameCard">
                  <div class="card-body d-flex justify-content-center align-items-center">
                      <i class="bi bi-plus-circle icon-plus"></i>
                  </div>
              </div>
          </div>

        <!-- Modal Here-->
        
    </section>
    

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
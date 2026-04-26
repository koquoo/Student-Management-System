<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Student Portal Home</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
    html, body {
      height: 100%;
      margin: 0;
      display: flex;
      flex-direction: column;
    }
    body {
      background-color: #e6f2e6;
    }
    .navbar, footer {
      background-color: #70a570
    }
    .navbar-nav .nav-link, footer {
      color:rgb(38, 80, 65) !important;
      font-weight: 600;
    }
    .container {
      margin-top: 60px;
      margin-bottom: 60px;
      flex: 1;
    }
    footer {
      padding: 15px 0;
      text-align: center;
      margin-top: auto;
    }
</style>

</head>
<body>

<nav class="navbar navbar-expand-lg">
  <a class="navbar-brand text-white font-weight-bold" href="index.php">Student Portal</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navMenu"
    aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon" style="color:white;">&#9776;</span>
  </button>

  <div class="collapse navbar-collapse" id="navMenu">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="dashboard.php">Dashboard</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container text-center">
    <h1 class="mb-4" style="color:#2f4f4f;">Welcome to the Student Portal</h1>
    <p class="lead" style="color:#2f4f4f;">
        This portal allows students to securely log in, view, and update their profile information,
        including uploading a profile picture. Manage your data easily with our intuitive interface.
    </p>
</div>

<footer class="text-white">
    &copy; 2025 Xenium Christina Thebe
</footer>


<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

</body>
</html>


<?php
    
    session_start();

    if (!isset($_SESSION['UserID'])) {
        $_SESSION['UserID'] = null;
    }
    
    if (!isset($_SESSION['loggedin'])) {
        $_SESSION['loggedin'] = false;
    }
    
    if ($_SESSION['UserID'] == null || $_SESSION['loggedin'] == false) {
        $loginLink = '<a href="login.php">Login</a>';  
    } else {
        $loginLink = '<a href="logout.php">Logout</a>';
    }
    
    echo '
    <head>
        <meta charset="utf-8">
        <title>IT Newsletter</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <header>
    <h1 class="logo">IT Newsletter</h1>
    <nav class="main-nav">
      <ul class="nav-list">
        <li><a href="index.php">Home</a></li>
        <li><a href="dashboard.php">Dashboard</a></li>
        
        <li>
          <form class="search-form">
            <label for="search">Search:</label>
            <br>
            <input type="text" id="search" name="search">
            <button type="submit">Search</button>
          </form>
        </li>
        
        <li>' . $loginLink . '</li>

        </ul>
    </nav>
</header>';

?>
<?php
session_start();

// Kontrola prihlasovacích údajov
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'config.php'; // Pripojenie k databáze
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            header("Location: index.php");
            exit(); 
        } else {
            echo "Invalid password";
        }
    } else {
        echo "No user found";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NHL</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #111;
        }
        .navbar-brand img {
            width: 120px;
            height: auto;
            margin-left: 150px;
        }
        .navbar-nav .nav-link {
            color: #fff !important;
            text-transform: uppercase;
            font-size: 16px;
        }
        .navbar-nav .nav-link:hover {
            color: #ccc !important;
        }
        header a {
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }
        header ul {
            padding: 0;
            list-style: none;
        }
        header li {
            float: left;
            display: inline;
            padding: 0 20px 0 20px;
        }
        .content {
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            margin-top: 20px;
        }
        footer {
            background: #111;
            color: #fff;
            text-align: center;
            padding: 20px;
            margin-top: 30px;
        }
        .hero-section {
            position: relative;
            background: url('hero_section.jpg') no-repeat center/auto;
            color: #B4975A;
            text-align: center;
            padding: 0; /* Odebrat původní padding */
            margin-bottom: 50px;
            height: 700px; /* Přizpůsobit výšku podle vašich potřeb */
        }
        .text-container {
            font-family: 'Open Sans', sans-serif;
            font-weight: bold;
        }
        .hero-section .text-container {
            position: absolute;
            top: 12.5%; /* Posunout na střed vertikálně */
            left: 50%; /* Posunout na střed horizontálně */
            transform: translate(-50%, -50%); /* Posunout text na střed */
        }       

        .hero-section h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .hero-section p {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.2rem;
            color: #fff;
            position: absolute;
            top: 21%; /* Posunout na střed vertikálně */
            left: 50%; /* Posunout na střed horizontálně */
            transform: translate(-50%, -50%); /* Posunout text na střed */
        }

        .text p{
        font-family: 'Montserrat', sans-serif;
    }

        .text1 {
            max-width: 1250px;
            margin: 20px auto;
            padding: 20px;
            background-color: transparent;
            border-radius: 5px;
            box-shadow: none;
        }

        .text1 h2 {
            color: #000000;
            font-size: 24px;
            margin-top: 20px;
        }

        .text1 p {
            color: #000000;
            font-size: 18px;
            line-height: 1.6;
        }

        
        
        
.btn-53,
.btn-53 *,
.btn-53 :after,
.btn-53 :before,
.btn-53:after,
.btn-53:before {
  border: 0 solid;
  box-sizing: border-box;
}

.btn-53 {
  -webkit-tap-highlight-color: transparent;
  -webkit-appearance: button;
  background-color: #fff;
  background-image: none;
  color: #333F42;
  cursor: pointer;
  font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont,
    Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif,
    Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
  font-size: 100%;
  line-height: 1.5;
  margin: 0;
  -webkit-mask-image: -webkit-radial-gradient(#000, #fff);
  padding: 0;
}

.btn-53:disabled {
  cursor: default;
}

.btn-53:-moz-focusring {
  outline: auto;
}

.btn-53 svg {
  display: block;
  vertical-align: middle;
}

.btn-53 [hidden] {
  display: none;
}

.btn-53 {
  border: 1px solid;
  border-radius: 999px;
  box-sizing: border-box;
  display: block;
  font-weight: 900;
  overflow: hidden;
  padding: 1.2rem 3rem;
  position: relative;
  text-transform: uppercase;
}

.btn-53 .original {
  background: #B4975A;
  color: #fff;
  display: grid;
  inset: 0;
  place-content: center;
  position: absolute;
  transition: transform 0.2s cubic-bezier(0.87, 0, 0.13, 1);
}

.btn-53:hover .original {
  transform: translateY(100%);
}

.btn-53 .letters {
  display: inline-flex;
}

.btn-53 span {
  opacity: 0;
  transform: translateY(-15px);
  transition: transform 0.2s cubic-bezier(0.87, 0, 0.13, 1), opacity 0.2s;
}

.btn-53 span:nth-child(2n) {
  transform: translateY(15px);
}

.btn-53:hover span {
  opacity: 1;
  transform: translateY(0);
}

.btn-53:hover span:nth-child(2) {
  transition-delay: 0.1s;
}

.btn-53:hover span:nth-child(3) {
  transition-delay: 0.2s;
}

.btn-53:hover span:nth-child(4) {
  transition-delay: 0.3s;
}

.btn-53:hover span:nth-child(5) {
  transition-delay: 0.4s;
}

.btn-53:hover span:nth-child(6) {
  transition-delay: 0.5s;
}

.btn-53 {
    transform: translateY(200px);
    margin: auto;
}

    </style>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="loga/logo_nhl.png" alt="NHL Logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Domov</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="teams.php">Tímy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="matches.php">Zápasy</a>
                    </li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="edit_team.php">Manage Teams</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add_match.php">Pridaj zápas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.html">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.html">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- Hero Section -->
<div class="hero-section">
    <h1 class="text-container">Stanley Cup Champions 2022/23</h1>
    <p>Stay updated with the latest news, scores, and stats from the world of hockey!</p>
    <button class="btn-53">
  <div class="original">VEGAS</div>
  <div class="letters">
    <span>V</span>
    <span>E</span>
    <span>G</span>
    <span>A</span>
    <span>S</span>
  </div>
</button>

</div>

<div class="text1">
    <h2>Aktuality</h2>
    <p>Buďte v obraze so všetkými správami a udalosťami zo sveta NHL. Od prestížnych ocenení po obchodné správy a výmeny hráčov - u nás zistíte všetko prvý.</p>
    <h2>Zápasy a výsledky</h2>
    <p>Nezmeškajte žiadnu chvíľu akcie. Sledujte aktuálne výsledky zápasov, plán zápasov a štatistiky, aby ste vždy vedeli, ako vaše obľúbené tímy a hráči v lige vypadajú.</p>
    <h2>Štatistiky a vedenie bodov</h2>
    <p>Pozrite sa na rebríčky kanadského bodovania, štatistiky brankárov, tímové štatistiky a ďalšie. Zistite, kto vedie v bodoch, asistenciách a góloch a sledujte súboj o individuálne ocenenia.</p>
    <h2>Rozhovory a analýzy</h2>
    <p>Prečítajte si exkluzívne rozhovory s hráčmi a trénermi, získajte hlbší vhľad do diania vo svete NHL. Naše analýzy a komentáre vám pomôžu lepšie porozumieť stratégii a taktike, ktoré hrajú úlohu na ľade.</p>
    <h2>Fanúšikovský kútik</h2>
    <p>Ste vášnivý fanúšik? Pripojte sa k diskusiám, súťažiam a komunitným udalostiam vo fanúšikovskom kútiku. Sdíľajte svoje názory, fotky a zážitky s ostatnými fanúšikmi NHL.</p>
    <p>Nezabudnite si nechať ujsť ani jediný okamih akcie! Sledujte nás a buďte stále na prvom mieste, keď ide o všetky správy a udalosti z NHL.</p>
</div>

<footer>
    <p>Sebastián Šatan &copy; 2024</p>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
</body>
</html>

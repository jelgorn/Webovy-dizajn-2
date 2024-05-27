<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teams</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #303030;
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
        .container {
            width: 90%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #333;
            color: #fff;
            min-height: 70px;
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
        footer {
            background: #111;
            color: #fff;
            text-align: center;
            padding: 20px;
            margin-top: 30px;
        }
        .content {
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            margin-top: 20px;
            background-color: #303030;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
        }
        .card {
            display: flex;
            align-items: center;
            background: #303030;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 20px;
            width: calc(50% - 10px);
            box-sizing: border-box;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .team-logo {
            width: 50px;
            height: auto;
            margin-right: 20px;
        }
        .team-info {
            flex: 1;
        }
        .team-info h3 {
            margin: 0;
            padding: 0;
            font-size: 1.5rem;
            color: #fff;
        }
        .team-info a {
            color: #fff;
        }
        .team-info p {
            margin: 5px 0;
            color: #fff;
        }
        .conference {
            margin-top: 20px;
        }
        .conference h2 {
            font-size: 1.8rem;
            color: #fff;
        }
        .division h3 {
            font-size: 1.6rem;
            color: #fff;
            margin-top: 10px;
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

<div class="container">
    <div class="content">
        <?php
        include 'config.php';

        $conferences = [
            'Eastern' => [
                'Atlantic' => [3, 4, 11, 13, 16, 21, 27, 28],
                'Metropolitan' => [6, 9, 18, 19, 20, 22, 23, 31]
            ],
            'Western' => [
                'Central' => [2, 7, 8, 10, 15, 17, 26, 32],
                'Pacific' => [1, 5, 12, 14, 24, 25, 29, 30]
            ]
        ];

        foreach ($conferences as $conference => $divisions) {
            echo "<div class='conference'>";
            echo "<h2>$conference Conference</h2>";
            foreach ($divisions as $division => $team_ids) {
                echo "<div class='division'>";
                echo "<h3>$division Division</h3>";
                echo "<div class='card-container'>";
                $sql = "SELECT * FROM teams WHERE id IN (" . implode(',', $team_ids) . ")";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='card'>";
                        echo "<img class='team-logo' src='loga/{$row['id']}.png' alt='" . htmlspecialchars($row['name']) . "'>";
                        echo "<div class='team-info'>";
                        echo "<h3><a href='team_info.php?id={$row['id']}'>" . htmlspecialchars($row['name']) . "</a></h3>";
                        echo "<p><strong>City:</strong> " . htmlspecialchars($row['city']) . "</p>";
                        echo "<p><strong>Founded Year:</strong> " . htmlspecialchars($row['founded_year']) . "</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No teams found in this division.</p>";
                }
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
        }

        $conn->close();
        ?>
    </div>
</div>

<footer>
    <p>Sebastián Šatan &copy; 2024</p>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
</body>
</html>

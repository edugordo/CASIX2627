<?php
// Northstar SOC - Simulador de portal corporatiu
// Laboratori de proves: no es recullen contrasenyes.

$host = "localhost";
$user = "root";
$password = "";
$database = "soc_honeypot";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    http_response_code(500);
    die("Error de connexió amb la base de dades.");
}

$conn->set_charset("utf8mb4");

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $test_id = "NORTHSTAR-SIM-001";

    // Només registrem si els camps s'han emplenat.
    // No llegim ni desem els seus valors.
    $username_filled = !empty($_POST["username"]) ? 1 : 0;
    $password_filled = !empty($_POST["password"]) ? 1 : 0;

    $ip = $_SERVER["REMOTE_ADDR"] ?? "Desconeguda";
    $user_agent = $_SERVER["HTTP_USER_AGENT"] ?? "Desconegut";

    $headers = function_exists("getallheaders") ? getallheaders() : [];
    $headers_json = json_encode(
        $headers,
        JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
    );

    $stmt = $conn->prepare(
        "INSERT INTO telemetria_simulador
        (test_id, ip, user_agent, headers, username_filled, password_filled)
        VALUES (?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "ssssii",
        $test_id,
        $ip,
        $user_agent,
        $headers_json,
        $username_filled,
        $password_filled
    );

    if ($stmt->execute()) {
        $message = "Simulació registrada correctament.";
    } else {
        $message = "No s'ha pogut registrar l'esdeveniment.";
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Northstar Office Portal</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f2f4f8;
            color: #333;
        }
        .container {
            width: 350px;
            max-width: calc(100% - 60px);
            margin: 90px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.12);
        }
        h1 {
            text-align: center;
            color: #24476b;
            font-size: 23px;
        }
        p {
            text-align: center;
            color: #666;
        }
        label {
            display: block;
            margin-top: 18px;
        }
        input {
            width: 100%;
            box-sizing: border-box;
            padding: 11px;
            margin-top: 7px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            margin-top: 22px;
            padding: 12px;
            background: #24476b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .message {
            margin-top: 20px;
            text-align: center;
            color: #247344;
        }
        .notice {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Northstar Office</h1>
    <p>Portal corporatiu d'ofimàtica</p>

    <form method="POST" action="">
        <label for="username">Usuari de prova</label>
        <input type="text" id="username" name="username" autocomplete="off">

        <label for="password">Contrasenya fictícia de prova</label>
        <input type="password" id="password" name="password" autocomplete="off">

        <button type="submit">Accedir</button>
    </form>

    <?php if ($message !== ""): ?>
        <div class="message">
            <?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?>
        </div>
    <?php endif; ?>

    <div class="notice">
        Entorn de simulació Northstar SOC.
        No introduïu credencials reals.
    </div>
</div>
</body>
</html>

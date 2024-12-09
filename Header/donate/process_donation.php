<?php
$dsn = 'mysql:host=localhost;dbname=donations';
$username = 'root'; // Setze hier deinen MySQL-Benutzer
$password = ''; // Setze hier dein MySQL-Passwort

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $donationAmount = filter_input(INPUT_POST, 'customAmount', FILTER_VALIDATE_FLOAT);

        if ($donationAmount && $donationAmount > 0) {
            $stmt = $pdo->prepare("INSERT INTO donations_log (amount) VALUES (:amount)");
            $stmt->execute([':amount' => $donationAmount]);

            echo "<h1>Danke für deine Spende!</h1>";
            echo "<p>Du hast erfolgreich €$donationAmount gespendet. Deine Unterstützung hilft uns, Peckventure weiterzuentwickeln!</p>";
            echo '<a href="donate.html">Zurück zur Spenden-Seite</a>';
        } else {
            echo "<h1>Ungültige Eingabe</h1>";
            echo "<p>Bitte gebe einen gültigen Betrag ein.</p>";
            echo '<a href="donate.html">Zurück zur Spenden-Seite</a>';
        }
    } else {
        echo "<h1>Fehler</h1>";
        echo "<p>Ungültige Anforderung.</p>";
        echo '<a href="donate.html">Zurück zur Spenden-Seite</a>';
    }
} catch (PDOException $e) {
    echo "Verbindungsfehler: " . $e->getMessage();
}
?>

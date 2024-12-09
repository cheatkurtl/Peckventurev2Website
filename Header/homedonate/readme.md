```markdown
# Spendenfunktion für Peckventure

## Projektbeschreibung
Dieses Projekt dient dazu, Spenden zu erfassen und in einer MySQL-Datenbank zu speichern. Es verwendet PHP mit PDO und speichert die Daten sicher in einer Datenbank.

---

## Voraussetzungen
- **Datenbank:** MySQL oder MariaDB.
- **PHP:** PHP-Version mit PDO-Erweiterung (`php-mysql`).
- **Webserver:** Apache oder Nginx.
- **PHP-Skripte:** `process_donation.php`.

---

## Einrichtung der Datenbank

### 1. Datenbank erstellen
```sql
CREATE DATABASE donations;
```

### 2. Tabelle erstellen
```sql
USE donations;

CREATE TABLE donations_log (
    id INT AUTO_INCREMENT PRIMARY KEY,        -- Eindeutige ID für jede Spende
    amount DECIMAL(10, 2) NOT NULL,           -- Betrag der Spende (z. B. 10.50)
    donation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Datum und Uhrzeit der Spende
);
```

### 3. Benutzer und Berechtigungen erstellen
```sql
CREATE USER 'donations_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON donations.* TO 'donations_user'@'localhost';
FLUSH PRIVILEGES;
```

---

## PHP-Konfiguration

### Verbindung zur Datenbank herstellen
```php
<?php
$dsn = 'mysql:host=localhost;dbname=donations';
$username = 'donations_user'; // Benutzername, den du erstellt hast
$password = 'secure_password'; // Passwort, das du beim Benutzer erstellt hast

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Datenbankverbindung erfolgreich!";
} catch (PDOException $e) {
    echo "Verbindungsfehler: " . $e->getMessage();
}
?>
```

---

## Beispiel: Spenden speichern

```php
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dsn = 'mysql:host=localhost;dbname=donations';
    $username = 'donations_user';
    $password = 'secure_password';

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
    } catch (PDOException $e) {
        echo "Verbindungsfehler: " . $e->getMessage();
    }
} else {
    echo "<h1>Fehler</h1>";
    echo "<p>Ungültige Anforderung.</p>";
    echo '<a href="donate.html">Zurück zur Spenden-Seite</a>';
}
?>
```

---

## Datenbankabfragen

### Alle Spenden anzeigen
```sql
SELECT * FROM donations_log;
```

### Datenbank sichern
```bash
mysqldump -u donations_user -p donations > donations_backup.sql
```

### Datenbank wiederherstellen
```bash
mysql -u donations_user -p donations < donations_backup.sql
```

---

## Datenbankstruktur

| Feldname       | Typ            | Beschreibung                              |
|----------------|----------------|------------------------------------------|
| `id`           | INT (Auto-Increment) | Eindeutige ID für jede Spende.         |
| `amount`       | DECIMAL(10, 2) | Der gespendete Betrag.                   |
| `donation_date`| TIMESTAMP      | Zeitpunkt der Spende (automatisch generiert). |

---

## Hinweise
1. **Sicherheitsmaßnahmen:**
   - Benutze ein starkes Passwort für den MySQL-Benutzer.
   - Stelle sicher, dass nur localhost-Zugriff erlaubt ist.

2. **Zukunftserweiterungen:**
   - Hinzufügen eines Feldes für den Spendernamen oder die E-Mail.
   - Integration von Zahlungsanbietern wie PayPal oder Stripe.

3. **Fehlerbehebung:**
   - Wenn PHP keine Verbindung zur Datenbank herstellen kann, überprüfe:
     - Ob die PDO-Erweiterung installiert ist.
     - Ob die MySQL-Datenbank läuft.
     - Ob die Benutzeranmeldedaten korrekt sind.
```
```
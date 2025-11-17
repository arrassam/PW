<?php
/**
 * SCRIPT D'INSTALLATION - GAMECYCLE
 * Exécute le script SQL pour créer les tables
 *
 * UTILISATION :
 * 1. Assure-toi que XAMPP/MySQL est démarré
 * 2. Ouvre ton navigateur : http://localhost/MS/install.php
 * 3. Les tables seront créées automatiquement
 */

// Configuration de la base de données
$host = "localhost";
$db_name = "gamecycle";
$username = "root";
$password = "";

// Chemin vers le fichier SQL
$sql_file = __DIR__ . '/database/gamecycle.sql';

echo "<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Installation GameCycle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #1a1a1a;
            color: #fff;
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
        }
        h1 {
            color: #5352ed;
            border-bottom: 2px solid #5352ed;
            padding-bottom: 10px;
        }
        .step {
            background: #2d2d2d;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            border-left: 4px solid #5352ed;
        }
        .success {
            border-left-color: #26de81;
            color: #26de81;
        }
        .error {
            border-left-color: #ff4757;
            color: #ff4757;
        }
        .info {
            border-left-color: #ffa502;
            color: #ffa502;
        }
        code {
            background: #1a1a1a;
            padding: 2px 6px;
            border-radius: 3px;
            color: #ffa502;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #5352ed;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        a:hover {
            background: #3742fa;
        }
    </style>
</head>
<body>
    <h1>🎮 Installation GameCycle</h1>";

try {
    // Étape 1: Vérification du fichier SQL
    echo "<div class='step'>";
    echo "<strong>📄 Étape 1:</strong> Vérification du fichier SQL...<br>";

    if (!file_exists($sql_file)) {
        throw new Exception("Le fichier SQL n'existe pas : $sql_file");
    }

    echo "✓ Fichier SQL trouvé : <code>$sql_file</code>";
    echo "</div>";

    // Étape 2: Connexion à MySQL
    echo "<div class='step'>";
    echo "<strong>🔌 Étape 2:</strong> Connexion à MySQL...<br>";

    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "✓ Connexion à MySQL réussie";
    echo "</div>";

    // Étape 3: Création de la base de données
    echo "<div class='step'>";
    echo "<strong>🗄️ Étape 3:</strong> Création de la base de données...<br>";

    $conn->exec("CREATE DATABASE IF NOT EXISTS `$db_name` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $conn->exec("USE `$db_name`");

    echo "✓ Base de données <code>$db_name</code> créée/sélectionnée";
    echo "</div>";

    // Étape 4: Exécution du script SQL
    echo "<div class='step'>";
    echo "<strong>⚙️ Étape 4:</strong> Exécution du script SQL...<br>";

    $sql = file_get_contents($sql_file);

    // Séparation des requêtes (par point-virgule)
    $statements = array_filter(array_map('trim', explode(';', $sql)));

    $executed = 0;
    foreach ($statements as $statement) {
        if (!empty($statement)) {
            $conn->exec($statement);
            $executed++;
        }
    }

    echo "✓ $executed requêtes SQL exécutées avec succès";
    echo "</div>";

    // Étape 5: Vérification des tables
    echo "<div class='step'>";
    echo "<strong>✅ Étape 5:</strong> Vérification des tables...<br>";

    $stmt = $conn->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "✓ Tables créées : <code>" . implode(", ", $tables) . "</code>";
    echo "</div>";

    // Résumé final
    echo "<div class='step success'>";
    echo "<strong>🎉 INSTALLATION RÉUSSIE !</strong><br><br>";
    echo "Les tables ont été créées avec succès dans la base de données <code>$db_name</code>.<br>";
    echo "Tu peux maintenant utiliser l'application.";
    echo "</div>";

    echo "<a href='index.php?page=posts'>🚀 Accéder aux posts</a> ";
    echo "<a href='index.php?page=admin-posts' style='background:#ff4757;'>🔐 Accéder au back-office</a>";

} catch (PDOException $e) {
    echo "<div class='step error'>";
    echo "<strong>❌ ERREUR DE BASE DE DONNÉES</strong><br>";
    echo "Message : " . $e->getMessage();
    echo "</div>";

    echo "<div class='step info'>";
    echo "<strong>💡 Solutions possibles :</strong><br>";
    echo "• Vérifie que XAMPP/MySQL est démarré<br>";
    echo "• Vérifie les identifiants dans <code>config/database.php</code><br>";
    echo "• Vérifie que le port MySQL est bien 3306<br>";
    echo "</div>";

} catch (Exception $e) {
    echo "<div class='step error'>";
    echo "<strong>❌ ERREUR</strong><br>";
    echo "Message : " . $e->getMessage();
    echo "</div>";
}

echo "</body></html>";
?>

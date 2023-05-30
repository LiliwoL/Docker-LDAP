<?php
session_start();

//██╗         ██████╗      █████╗     ██████╗
//██║         ██╔══██╗    ██╔══██╗    ██╔══██╗
//██║         ██║  ██║    ███████║    ██████╔╝
//██║         ██║  ██║    ██╔══██║    ██╔═══╝
//███████╗    ██████╔╝    ██║  ██║    ██║
//╚══════╝    ╚═════╝     ╚═╝  ╚═╝    ╚═╝

// https://www.php.net/manual/fr/function.ldap-connect.php

$ldapServer = "openldap";
$ldapPort = 389;
$ldapBaseDn = "ou=people,dc=example,dc=org";

/**
 * Méthode utilisée pour vérifier laé connexion avec le serveur LDAP
 * @param $host
 * @param $port
 * @param $timeout
 * @return string
 */
function checkConnexion($host, $port=389, $timeout=1): string
{
    $op = fsockopen($host, $port, $errno, $errstr, $timeout);
    if (!$op) return "✖"; //DC is N/A
    else {
        fclose($op); //explicitly close open socket connection
        return "&#10003;"; //DC is up & running, we can safely connect with ldap_connect
    }
}

// ========================================================================

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

// ========================================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $ldapUsername = "uid=" . $_POST['username'] . "," . $ldapBaseDn;
    $ldapPassword = $_POST['password'];

    // Préparation de la connexion au serveur LDAP
    $ldapConnection = ldap_connect($ldapServer, $ldapPort);
    ldap_set_option($ldapConnection, LDAP_OPT_PROTOCOL_VERSION, 3);

    echo sprintf("Tentative de connexion à %s <br/> DN: %s<br/>Password: %s",
        $ldapServer . ":" . $ldapPort,
            $ldapUsername,
            $ldapPassword);

    if ($ldapConnection)
    {
        // Connexion au serveur LDAP
        // https://www.php.net/manual/fr/function.ldap-bind.php
        $ldapBind = ldap_bind($ldapConnection, $ldapUsername, $ldapPassword);

        if ($ldapBind) {
            $_SESSION['authenticated'] = true;
            $_SESSION['username'] = $ldapUsername;
        } else {
            $errorMessage = "Échec de l'authentification.";
        }
    } else {
        $errorMessage = "Impossible de se connecter au serveur LDAP.";
    }
}
else {
    echo "Test de connexion au serveur ldap: " . checkConnexion($ldapServer, $ldapPort);
}


$isAuthenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification LDAP</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-200">
<div class="container mx-auto max-w-md mt-16">
    <div class="bg-white p-8 rounded shadow">
        <?php if ($isAuthenticated) : ?>
            <h1 class="text-2xl mb-4">Bonjour, <?php echo $username; ?>!</h1>
            <p class="text-green-500 mb-4">Vous êtes connecté avec succès.</p>
            <a href="index.php?logout=true" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Se déconnecter</a>
        <?php else : ?>
            <?php if (isset($errorMessage)) : ?>
                <p class="text-red-500 mb-4"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
            <form method="POST" action="index.php">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Nom d'utilisateur:</label>
                    <input type="text" name="username" id="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mot de passe:</label>
                    <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Se connecter</button>
            </form>
        <?php endif; ?>
    </div>
</div>
</body>

</html>

<?php
// Test des dépendances et configuration
echo "<h1>Test des dépendances Scolaris Meta VR</h1>";

// 1. Vérifier PHP
echo "<h2>1. Configuration PHP</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Extensions chargées:<br>";
$extensions = get_loaded_extensions();
sort($extensions);
echo "<ul>";
foreach ($extensions as $ext) {
    echo "<li>$ext</li>";
}
echo "</ul>";

// 2. Vérifier cURL (pour API Unsplash)
echo "<h2>2. Configuration cURL</h2>";
if (function_exists('curl_version')) {
    $curl_info = curl_version();
    echo "cURL Version: " . $curl_info['version'] . "<br>";
    echo "SSL Support: " . ($curl_info['features'] & CURL_VERSION_SSL ? 'Oui' : 'Non') . "<br>";
} else {
    echo "cURL: NON DISPONIBLE<br>";
}

// 3. Tester l'accès à Unsplash API
echo "<h2>3. Test API Unsplash</h2>";
$test_url = "https://api.unsplash.com/photos/random?query=test&client_id=test";
$ch = curl_init($test_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Code HTTP: $http_code<br>";
if ($http_code === 401) {
    echo "Unsplash API: Accessible (mais clé invalide - c'est normal)<br>";
} elseif ($http_code === 200) {
    echo "Unsplash API: Accessible<br>";
} else {
    echo "Unsplash API: Problème de connexion<br>";
}

// 4. Vérifier la configuration
echo "<h2>4. Configuration de l'application</h2>";
echo "UNSPLASH_ACCESS_KEY: " . (defined('UNSPLASH_ACCESS_KEY') && !empty(UNSPLASH_ACCESS_KEY) ? 'Configurée' : 'Non configurée (mode simulé)') . "<br>";
echo "BASE_URL: " . (defined('BASE_URL') ? BASE_URL : 'Non définie') . "<br>";

// 5. Rechercher le message "No auto mode endpoints provided"
echo "<h2>5. Recherche du message d'erreur</h2>";
echo "Le message 'No auto mode endpoints provided' pourrait venir de :<br>";
echo "<ul>";
echo "<li>Un framework d'API auto-généré</li>";
echo "<li>Un service d'IA (TensorFlow Serving, etc.)</li>";
echo "<li>Une configuration de route manquante</li>";
echo "<li>Une bibliothèque externe mal configurée</li>";
echo "</ul>";

// 6. Suggestions
echo "<h2>6. Solutions</h2>";
echo "<ol>";
echo "<li>Vérifiez si vous avez des bibliothèques externes dans vendor/</li>";
echo "<li>Vérifiez les logs Apache (C:\\xampp\\apache\\logs\\error.log)</li>";
echo "<li>Testez l'API à : <a href='public/api.php?endpoint=status'>public/api.php?endpoint=status</a></li>";
echo "<li>Utilisez la version simplifiée : <a href='index_simple.php'>index_simple.php</a></li>";
echo "</ol>";

// 7. Test de l'API interne
echo "<h2>7. Test de l'API interne</h2>";
echo "<button onclick='testAPI()'>Tester l'API generate</button>";
echo "<div id='api-result'></div>";

echo "<script>
function testAPI() {
    fetch('public/api.php?endpoint=status')
        .then(response => response.json())
        .then(data => {
            document.getElementById('api-result').innerHTML = 
                '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
        })
        .catch(error => {
            document.getElementById('api-result').innerHTML = 
                'Erreur: ' + error;
        });
}
</script>";
?>
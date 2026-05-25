<?php
// View - Affichage du login
function view_login() {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion - <?php echo APP_NAME; ?></title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { font-family: Arial; background: #f5f5f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
            .login-box { background: white; padding: 30px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); width: 300px; }
            h1 { text-align: center; color: #333; margin-bottom: 20px; }
            input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 3px; }
            button { width: 100%; padding: 10px; background: #0066cc; color: white; border: none; border-radius: 3px; cursor: pointer; margin-top: 10px; }
            button:hover { background: #0052a3; }
            .error { color: red; font-size: 12px; margin-top: 10px; }
            p { text-align: center; margin-top: 15px; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class="login-box">
            <h1><?php echo APP_NAME; ?></h1>
            
            <?php if (isset($_GET['error'])): ?>
                <p class="error">❌ Identifiants incorrects</p>
            <?php endif; ?>
            
            <form method="POST" action="">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Mot de passe" required>
                <button type="submit">Se connecter</button>
            </form>
            
            <p>Admin: admin@example.com / password123</p>
        </div>
    </body>
    </html>
    <?php
}

// View - Affichage du générateur
function view_generator($image = null, $prompt = '') {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo APP_NAME; ?></title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { font-family: Arial; background: #f5f5f5; padding: 20px; }
            .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
            h1 { color: #333; margin-bottom: 10px; }
            .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid #ddd; }
            .header a { color: #0066cc; text-decoration: none; }
            .header a:hover { text-decoration: underline; }
            textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 3px; margin: 15px 0; font-family: Arial; }
            button { background: #0066cc; color: white; padding: 10px 20px; border: none; border-radius: 3px; cursor: pointer; }
            button:hover { background: #0052a3; }
            .result { margin: 20px 0; padding: 15px; background: #f0f8ff; border-left: 4px solid #0066cc; border-radius: 3px; }
            img { max-width: 100%; height: auto; margin: 15px 0; border-radius: 3px; }
            .actions { margin: 15px 0; }
            .actions a { display: inline-block; padding: 8px 15px; background: #0066cc; color: white; border-radius: 3px; text-decoration: none; margin-right: 10px; }
            .actions a:hover { background: #0052a3; }
            footer { margin-top: 30px; text-align: center; color: #999; font-size: 12px; border-top: 1px solid #ddd; padding-top: 15px; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1><?php echo APP_NAME; ?></h1>
                <a href="../../app/auth/auth.php?action=logout">Déconnexion</a>
            </div>
            
            <p>Bonjour, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
            
            <h2>Générateur d'images VR</h2>
            
            <form method="POST" action="">
                <textarea name="prompt" placeholder="Décrivez votre image (forêt, montagne, plage, ville, espace...)" rows="4" required></textarea>
                <button type="submit">Générer l'image</button>
            </form>
            
            <?php if ($image): ?>
            <div class="result">
                <h3>Image générée</h3>
                <img src="<?php echo htmlspecialchars($image); ?>" alt="Image générée">
                <div class="actions">
                    <a href="../../app/vr/vr.php?image=<?php echo urlencode($image); ?>" target="_blank">Voir en VR</a>
                    <a href="">Nouvelle recherche</a>
                </div>
            </div>
            <?php endif; ?>
            
            <footer>
                <p><?php echo APP_NAME; ?> - Projet éducatif</p>
            </footer>
        </div>
    </body>
    </html>
    <?php
}
?>

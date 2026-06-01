    
   <?php
    require '../config/config.php';
   ?>
    
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo CSS .'sign.css';?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-pbM0bVxHzFZBk5J0f1f8rF9eJYz+lYlVgzj3YkN6x1A4juY2Vf74GIo8Q0AWZ5rE16aqnB+qG3aDEaCtp8aTbw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Connexion - <?php echo APP_NAME; ?></title>
</head>
<body>
    <section>
        <div class="partie2">
            <header>
                <nav>
                    <ul>
                        
                        <button>DEMO</button>
                    </ul>
                </nav>
            </header>
            <div class="centre">
                <form method="POST" action="verifier_code.php">

                    <h2>Vérification</h2>
                    <p>Entrez le code envoyé à votre email</p>

                    <input type="text" name="code" placeholder="Code de vérification" required>

                    <button type="submit">Valider</button>

                </form>
            </div>
        </div>
        <div class="cote">
            <div class="c "></div>
            <div class="c"></div>
            <div class="c o1"></div>
        </div>
    </section>
    <script>
    document.getElementById("type").addEventListener("change", function() {
        let adminField = document.getElementById("adminCode");

        if(this.value === "admin") {
            adminField.style.display = "block";
        } else {
            adminField.style.display = "none";
        }

    });
    document.getElementById("btnInscrire").addEventListener("click", function() {
        window.location.href = "confirm.php";
    });
</script>
</body>
</html>
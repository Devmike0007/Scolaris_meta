    
   <?php
    require '../config/config.php';
   ?>
    
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo CSS .'login.css';?>">
    <title>Connexion - <?php echo APP_NAME; ?></title>
</head>
<body>
    <section>
        <div class="partie1">
            <div class="logo">
                <img src="<?php echo IMG.'logo.png';?>" alt="">
            </div>
            <div class="center">
                <div class="titre">
                    <h2>Sign in</h2>
                    <div class="bar"></div>
                </div>
                <form method="POST" action="../auth/auth.php?action=process">  
                    <div class="inpt">
                        <input type="email" name="email" placeholder="Email" required>
                        <div></div>
                        <input type="password" name="password" placeholder="Password" required>
                        <div></div>
                    </div>
                    <div class="bouton">
                        <button type="submit">Se connecter</button>
                    </div>
                </form>

            </div>


            <div class="bas">
                <i class="fab fa-facebook-f"></i>
                <i class="fab fa-twitter"></i>
                <i class="fab fa-google"></i>
            </div>
        </div>


        <div class="partie2">
            <header>
                <nav>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">What we serve</a></li>
                        <li><a href="#">Who we are</a></li>
                        <button>DEMO</button>
                    </ul>
                </nav>
            </header>
            <div class="centre">
                <div class="titre">
                    <h2>Veuillez vous connecter</h2>
                    <div class="bar"></div>
                </div>
                <p>
                    Bienvenue sur notre plateforme. Ici, nous valorisons l’excellence, l'engagement et la transparence. Chaque service que nous proposons vise à améliorer votre expérience utilisateur. Notre équipe travaille jour et nuit pour vous offrir des solutions fiables, accessibles et sécurisées. Que vous soyez un parent, un élève ou un partenaire, vous trouverez chez nous écoute, accompagnement et innovation. Nous croyons en un avenir où la technologie soutient l’éducation et facilite la communication. Rejoignez-nous pour découvrir tout ce que nous avons à offrir.
                </p>
                <button>En savoir plus</button>
            </div>
        </div>
        <div class="cote">
            <div class="c o1"></div>
            <div class="c"></div>
            <div class="c"></div>
        </div>
    </section>
</body>
</html>
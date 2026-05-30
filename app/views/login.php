    
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
                        
                        <button>DEMO</button>
                    </ul>
                </nav>
            </header>
            <div class="centre">
                <div class="titre">
                    <h2>Bienvenue sur Scolaris VR</h2>
                    <div class="bar"></div>
                </div>
                <p>
                    Bienvenue sur Scolaris VR, une plateforme éducative innovante qui exploite la réalité virtuelle pour transformer l'apprentissage. Notre objectif est d'offrir aux élèves, enseignants et établissements scolaires une expérience immersive, interactive et enrichissante. Grâce à la technologie VR, les apprenants peuvent explorer des environnements virtuels, visualiser des concepts complexes et développer leurs compétences de manière pratique et engageante. Scolaris VR place l'innovation au cœur de l'éducation afin de rendre l'apprentissage plus accessible, captivant et efficace pour tous.
                </p>
                <div class="bntc">
                    <button>Inscrirer</button>
                        <button>
                            <i class="fas fa-arrow-right"></i>
                        </button>

                </div>
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
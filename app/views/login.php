    
   <?php
    require '../config/config.php';
   ?>
    
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo CSS .'login.css';?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-pbM0bVxHzFZBk5J0f1f8rF9eJYz+lYlVgzj3YkN6x1A4juY2Vf74GIo8Q0AWZ5rE16aqnB+qG3aDEaCtp8aTbw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <div class="vrimage">
            <img src="<?php echo IMG.'vr.png';?>" alt="">
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
                <div class="slide active ">
                    <div class="titre">
                        <h2>Bienvenue sur Scolaris VR</h2>
                        <div class="bar"></div>
                    </div>
                    <p>
                        Bienvenue sur Scolaris VR, une plateforme éducative innovante qui exploite la réalité virtuelle pour transformer l'apprentissage. Notre objectif est d'offrir aux élèves, enseignants et établissements scolaires une expérience immersive, interactive et enrichissante. Grâce à la technologie VR, les apprenants peuvent explorer des environnements virtuels, visualiser des concepts complexes et développer leurs compétences de manière pratique et engageante. Scolaris VR place l'innovation au cœur de l'éducation afin de rendre l'apprentissage plus accessible, captivant et efficace pour tous.
                    </p>               
                </div>
                <div class="slide  ">
                    <div class="titre">
                        <h2>Un enseignement interactif et moderne</h2>
                        <div class="bar"></div>
                    </div>
                    <p>
                        Avec Scolaris VR, les enseignants disposent d’un outil puissant pour enrichir leurs méthodes pédagogiques. Ils peuvent créer des cours interactifs, simuler des situations réelles et capter davantage l’attention des apprenants. Cette approche favorise une meilleure compréhension des notions complexes et stimule la curiosité des élèves.
                    </p>               
                </div>
                <div class="slide  ">
                    <div class="titre">
                        <h2>Une immersion sans limites</h2>
                        <div class="bar"></div>
                    </div>
                    <p>
                        La plateforme offre également une accessibilité accrue à des expériences éducatives uniques, indépendamment des contraintes géographiques ou matérielles. Les utilisateurs peuvent visiter des lieux historiques, explorer le corps humain ou encore voyager dans l’espace, le tout depuis une salle de classe ou leur domicile.                    </p>               
                </div>

                <div class="bntc">
                    <button type="button" id="btnInscrire">Inscrire</button>
                    <button type="button" class="suivant" id="btnSuivant">
                        <p>Suivant</p>
                        <img src="<?php echo IMG.'direction.png';?>" alt="">
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
    <script>
    let index = 0;
    const cercles = document.querySelectorAll(".c");
    const slides = document.querySelectorAll(".slide");

    document.getElementById("btnSuivant").addEventListener("click", function() {
        
        // enlever actif
        slides[index].classList.remove("active");
        cercles[index].classList.remove("o1");
        
        // passer au suivant
        index++;
        if(index >= slides.length) {
            index = 0;
        }

        // ajouter actif
        slides[index].classList.add("active");
        cercles[index].classList.add("o1");
    });
    document.getElementById("btnInscrire").addEventListener("click", function() {
        window.location.href = "sign_ups.php";
    });
    </script>
</body>
</html>
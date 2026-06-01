    
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
        <div class="partie1">
            <div class="logo">
                <img src="<?php echo IMG.'logo.png';?>" alt="">
            </div>
            <div class="center">
                <div class="titre">
                    <h2>Créer un compte</h2>
                    <div class="bar"></div>

                </div>
                <p>Rejoignez Scolaris VR et commencez votre expérience immersive.</p>
            </div>


            <div class="bas">
                <i class="fab fa-facebook-f"></i>
                <i class="fab fa-twitter"></i>
                <i class="fab fa-google"></i>
            </div>
        </div>


        <div class="partie2">

            <div class="centre">
                <form method="POST" action="../auth/auth.php?action=register" enctype="multipart/form-data">
                    <div class="InpC">
                        <div class="InpG">
                            <input type="text" name="nom" placeholder="Nom" required>
                            <div class="ligne"></div>
                        </div>

                        <div class="InpG">
                            <input type="text" name="prenom" placeholder="Prénom" required>
                            <div class="ligne"></div>
                        </div>
                    </div>

                    <div class="InpC">
                        <div class="InpG">
                            <input type="email" name="email" placeholder="Email" required>
                            <div class="ligne"></div>
                        </div>

                        <div class="InpG">
                            <input type="password" name="password" placeholder="Mot de passe" required>
                            <div class="ligne"></div>
                        </div>
                    </div>

                    <div class="InpC">
                        <div class="InpG">
                            <input type="password" name="confirm_password" placeholder="Confirmer mot de passe" required>
                            <div class="ligne"></div>
                        </div>

                        <div class="InpG">
                            <select name="type" id="type">
                                <option value="user">Utilisateur</option>
                                <option value="admin">Admin</option>
                            </select>
                            <div class="ligne"></div>
                        </div>
                    </div>

                    <!-- PHOTO -->
                    <div class="InpC">
                        <div class="InpG">
                            <div class="upload-box">
                                <input type="file" name="photo" id="photo" accept="image/*">
                                <span id="file-name" ><label for="photo" id="file-name" class="upload-btn"> 📷 Aucun fichier choisi</label></span>
                            </div>
                            <div class="ligne"></div>
                        </div>
                        <div class="InpG">
                              <!-- CODE ADMIN -->
                            <div id="adminCode" style="display:none; margin-top: -13px;">
                                <div class="InpG">
                                    <input type="text" name="code_admin" placeholder="Code admin">
                                    <div class="ligne"></div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <button type="submit" >S'inscrire</button>

                </form>
            </div>
        </div>
        <div class="cote">
            <div class="c"></div>
            <div class="c o1"></div>
            <div class="c"></div>
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
        document.getElementById("photo").addEventListener("change", function () {
    let fileName = this.files[0] ? this.files[0].name : "Aucun fichier choisi";
    document.getElementById("file-name").textContent = fileName;
    });
    </script>
</body>
</html>
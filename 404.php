<!DOCTYPE html>
<html lang="en">Jose
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Découvrez de délicieuses recettes françaises et cubaines sur notre site de gastronomie. Publiez vos propres recettes, partagez vos avis et découvrez de nouvelles saveurs avec notre communauté de gourmands.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bigshot+One&family=Rubik+Gemstones&family=Sigmar&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Rye&family=Young+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="asset/css/main.css">
    <title>Erreur</title>
</head>
<body>
<header class="header" >
      <div class="rangeheader" id="rangeheaderid">
            <div class="logo">
              <img class="logoun" src="./asset/img/advertencia.webp" alt="logotype" id="sitelogo">
              </div>
              <div>
                <ul class="titre">
                <a class="nodecoration" href="index.php"><li ><h1 class="titreun">Gastronomie</h1></li></a>
                  <a class="nodecoration" href="recettes_francaises.php"><li ><h1 class="titredeux">Franco-</h1></li></a>
                  <a class="nodecoration" href="recettes_cubaines.php"><li ><h1 class="titretrois">Cubaine</h1></li></a>
                </ul>
              </div>
      </div>
      <nav class="rangeheaderun" >
              <div class="menu-btn">
              <div class="btn-line"></div>
              <div class="btn-line"></div>
              <div class="btn-line"></div>
              </div>
              
        <ul class="botonesheader" >

            <!-- Apartir de aqui todo lo que se mostrara si estas desconectado  -->
            <li ><a class="abotones" href="index.php">Accueil</a></li>
   
            
                </ul>
              </nav>
      </header>
    <main class="pageerreur">

        <div class="container-main-erreur">
        <ul  class="container-ul-erreur">
        <li><img class="img-souris-erreur" src="./asset/img/logofromage.webp" alt="logo erreur"></li>
        <li  class="container-li-erreur"><h1>Oops!</h1></li>
        </ul>
        <div class="container-h3-erreur">
<?php if (isset( $_SESSION["compte-erreur-sql"])) {
                  echo '<div id="messageerror">' .  $_SESSION["compte-erreur-sql"] . '</div>';
                  unset( $_SESSION["compte-erreur-sql"]); // Eliminar el mensaje de la sesión
                  }
                  ?>
        
                  
        <h3 class="h3-erreur"> The page you are looking for might have been removed  had its name changed or is temporarily unavailable. </h3>
        <h3 class="h3-erreur">La page que vous recherchez a peut-être été supprimée, renommée ou temporairement indisponible.</h3>
       
       
        </div>
        </div>
    </main>
   <footer class="pageerreur">
    <div class="container-cable-erreur">
   <img class="img-cable-erreur" src="./asset/img/cables.png" alt="link-out">
   </div>
   </footer>
   <script defer>
            const menuBtn=document.querySelector(".menu-btn");

            const menuItems=document.querySelector(".botonesheader");

            menuBtn.addEventListener("click",()=>{

                menuItems.classList.toggle('active');
            });

            window.addEventListener('resize',()=>{
            if(window.innerWidth> 599){
                menuItems.classList.remove('active');
            }
            });
            </script>
            <script src="asset/js/script.js"></script>
</body>
</html>
        


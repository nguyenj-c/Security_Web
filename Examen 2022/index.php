<?php
if(!isset($_SESSION)) { //démarre la gestion des sessions PHP
session_start();
}
?>
<!DOCTYPE HTML>
<!--
	Adaptation du modèle "Editorial by HTML5 UP"
	html5up.net | @ajlkn
	Utilisé sous licence CCA 3.0 (html5up.net/license)
	
	Page administrateur adaptée du modèle gratuit Bootply "Bootstrap 3 Admin"
	
	Images du domaine public de Pixabay.com
-->
<html>
	<head>
		<title>LPWeb by LeProfdeSécuritéWeb</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	</head>
	<body>

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<div id="main">
						<div class="inner">

							<!-- Header -->
								<header id="header">
									<a href="index.php" class="logo"><strong>LPWeb</strong> by LeProfdeSécuritéWeb</a>
									<ul class="icons">
										<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
										<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
										<li><a href="#" class="icon fa-snapchat-ghost"><span class="label">Snapchat</span></a></li>
										<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
										<li><a href="#" class="icon fa-medium"><span class="label">Medium</span></a></li>
									</ul>
								</header>

							<?php
                            if(!isset($_SESSION['user'])) {
                                include 'login.php';
                            }
                            else{
							try
							{
								
								$mysqli = new mysqli("localhost", "cyber1", "azerty", "bdd_1");
							}
							catch (Exception $e)
							{
								die('Erreur : '. $e->getMessage());
							}	
								
								if(isset($_POST['query'])) { 
									echo "Vous avez cherché : " . $_POST['query']; 
								} else {
								?>
								
							<!-- Banner -->
								<section id="banner">
									<div class="content">
										<header>
											<h1>Hey, je suis LPWeb<br />
											</h1>
											<p style="text-align:justify; border: solid 3px red ">Voici les consignes pour l'examen de sécurité web</p>
										</header>
										<p style="text-align:justify">Un développeur Web a crée par négligence des erreurs de conception en terme de sécurité et des vulnérabilités Web les plus courantes. Votre rôle consiste à trouver ces erreurs et failles, et à faire des propositions de correction directement dans le code.</p>
										<p style="text-align:justify">La page index.php doit être accessible uniquement aux utilisateurs authentitifiés. Malheureusement, le développeur a oublié la page de connexion. <br> A la connexion, vous devez afficher les informations des 3 dernières connexions de l'utilisateur : IP, user agent, code postal et pays, afin qu'il s'assure d'aucun accès illégitime.Vous pouvez récupérer le code postal et le pays grace à la ligne de code suivante : <code>$ip_details = json_decode(file_get_contents("https://ipinfo.io/{$ip}"));</code><br>Vous pourrez utiliser les adresses IP de votre choix pour illustrer les exemples</p>
										<p style="text-align:justify">Vous créerez également une page html dédiée, <strong>examen_votrenom_votreprenom.html</strong>, répertoriant toutes les erreurs et vunérabilités, en expliquant en quoi ce sont des erreurs et des vulnérablités, quelle(s) correction(s) vous avez apportée(s), ainsi que la justification (précisez l'erreur, la page, et la ligne corrigée) </p>
										<p style="text-align:justify">Le développeur vigilant que vous êtes saura les trouver. C'est bientôt Paques, la chasse aux Easter Eggs est ouverte! <b><u>Un bonus d'un point sera accordé si vous trouvez l'Easter Egg.</u></b></p>
										<p style="text-align:justify">Vous enverrez votre fichier html et vos fichiers sql dans un dossier zip nommé votrenom_votreprenom.zip à <a href="mailto:ffabregue@protonmail.com">ffabregue@protonmail.com</a>.</p>
										<p style="text-align:justify">Vous avez 4h. Bon courage!</p>
										<ul class="actions">
											<li><a href="#" class="button big" onclick="alert('Raté ! Il n\'y a aucune aide ici :) ')">Cliquer pour avoir de l'aide</a></li>
										</ul>
									</div>
									<span class="image object">
										<img src="images/pic10.jpg" alt="" />
									</span>
								</section>

							<!-- Section -->
								<section>
									<header class="major">
										<h2>Nos dernières publications</h2>
									</header>
									<div class="posts">
									<?php
										$rows=$mysqli->query("SELECT * FROM `articles`");
										if ($rows->num_rows==0) {
											echo "Aucun article à afficher.";
										}   
										else {
                                            $ip = '147.94.73.0';
                                            $ip_details = json_decode(file_get_contents("https://ipinfo.io/{$ip}"));
                                            $user_agent = $_SERVER['HTTP_USER_AGENT'];
                                            var_dump($ip_details);
											while($row = $rows->fetch_array()) //Boucle pour chaque article
											{
												//Les images sont affichées suivant les identifiants (id) d'articles...
												echo "<article><a href=\"#\" class=\"image\"><img src=\"images/pic0" . $row['id'] . ".jpg\" /></a>";
												echo "<h3>" . $row['titre'] . "</h3>";
												
												echo substr($row['contenu'], 0, 150); 			
												echo "<ul class=\"actions\"><li><a href=\"article.php?id=" . $row['id'] . "\" class=\"button\">Lire plus</a></li></ul>";
												echo "</article>";
											}
										}
										$rows->close();
									?>
										
									</div>
								</section>
							<?php } ?>
						</div>
					</div>

				<!-- Sidebar -->
					<div id="sidebar">
						<div class="inner">

							<!-- Search -->
								<section id="search" class="alt">
									<form method="post" action="#">
										<input type="text" name="query" id="query" placeholder="Rechercher" />
									</form>
								</section>

							<!-- Menu -->
								<nav id="menu">
									<header class="major">
										<h2>Menu</h2>
									</header>
									<ul>
										<li><a href="index.php">Accueil</a></li>
										<li><a href="admin">Admin</a></li>
										<li>
											<span class="opener">Sous-menu</span>
											<ul>
												<li><a href="article.php?page=galerie.php">Galerie</a></li>
												<li><a href="#">Ipsum Adipiscing</a></li>
											</ul>
										</li>
										<li><a href="#">Partenaires</a></li>
										<li><a href="#">À propos</a></li>
										<li><a href="#">Contact</a></li>
										<li><a href="#">Mentions légales</a></li>
										<li><a href="logout.php">Deconnexion</a></li>
									</ul>
								</nav>

							<!-- Section -->
								<section>
									<header class="major">
										<h2>Ante interdum</h2>
									</header>
									<div class="mini-posts">
										<article>
											<a href="#" class="image"><img src="images/pic07.jpg" alt="" /></a>
											<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore aliquam.</p>
										</article>
										<article>
											<a href="#" class="image"><img src="images/pic08.jpg" alt="" /></a>
											<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore aliquam.</p>
										</article>
									</div>
									<ul class="actions">
										<li><a href="#" class="button">Lire plus</a></li>
									</ul>
								</section>

							<!-- Section -->
								<section>
									<header class="major">
										<h2>Nous contacter</h2>
									</header>
									<p>Sed varius enim lorem ullamcorper dolore aliquam aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin sed aliquam facilisis ante interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>
									<ul class="contact">
										<li class="fa-envelope-o"><a href="#">information@entreprise.fr</a></li>
										<li class="fa-phone">(+33) 712345678</li>
										<li class="fa-home">1234 Rue de la Ville<br />
										Paris, 75000</li>
									</ul>
								</section>

							<!-- Footer -->
								<footer id="footer">
									<p class="copyright">&copy; MonSite. Tous Droits Réservés. Images de Démonstration : <a href="https://unsplash.com">Unsplash</a>. Design: <a href="https://html5up.net">HTML5 UP</a>.</p>
								</footer>

						</div>
					</div>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>
<?php
}

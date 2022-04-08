<?php
if(!isset($_SESSION)) { //démarre la gestion des sessions PHP
	session_start();
}

if(isset($_POST['nomutilisateur']) && isset($_POST['motdepasse'])) {
	
	$mysqli = new mysqli("localhost", "cyber1", "azerty", "bdd_1");
	if ($mysqli->connect_errno) {
		die("Impossible de se connecter");
	}
	else {

        $username = hash('sha512',htmlentities($_POST['nomutilisateur']));
        $password = password_hash(htmlentities($_POST['motdepasse']),PASSWORD_BCRYPT, ['cost' => 10,]);

		$rows=$mysqli->query("SELECT * FROM `admin` WHERE `nomutilisateur`= '$username'  LIMIT 1");

        $row = $rows->fetch_assoc();

        $password = password_verify($_POST['motdepasse'], $row['password']);

        if ($rows->num_rows==0 || $password !== true) {
			echo "Mauvais nom d'utilisateur ou mot de passe.";
		}  else {
			$_SESSION['admin']=$rows->fetch_array()[1];
		}
		
	}
}

if(!isset($_SESSION['admin'])) { //Si on n'est pas connecté on affiche le formulaire de connexion?>
	<div style="width:480px; margin:0 auto; border:black 1px solid; text-align:center;">
		<b>Veuillez vous connecter :</b> <br><br>
		<form method="post" action="#">
			<label>Nom d'utilisateur</label><br>
			<input type="text" name="nomutilisateur" placeholder="Ex: 'Admin'"/><br><br>
			<label>Mot de passe</label><br>
			<input type="password" name="motdepasse"/><br><br>
			<input type="submit" value="Se connecter"/> 												
		</form>
	</div>
	<?php
		exit(0); // on n'affiche rien de plus
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Bootstrap 3 Admin</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href="css/styles.css" rel="stylesheet">
	</head>
	<body>
<!-- header -->
<div id="top-nav" class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Tableau de bord</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#">
						<i class="glyphicon glyphicon-user"></i> <?php echo $_SESSION['admin']; ?> 
						<span class="caret"></span>
						</a>
                    <ul id="g-account-menu" class="dropdown-menu" role="menu">
                        <li><a href="#">Mon Profil</a></li>
                    </ul>
                </li>
                <li><a href="logout.php"><i class="glyphicon glyphicon-lock"></i> Se déconnecter</a></li>
            </ul>
        </div>
    </div>
    <!-- /container -->
</div>
<!-- /Header -->

<!-- Main -->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3">
            <!-- Left column -->
            <a href="#"><strong><i class="glyphicon glyphicon-wrench"></i> Outils</strong></a>

            <hr>

            <ul class="nav nav-stacked">
                <li class="nav-header"> <a href="#" data-toggle="collapse" data-target="#userMenu">Paramètres <i class="glyphicon glyphicon-chevron-down"></i></a>
                    <ul class="nav nav-stacked collapse in" id="userMenu">
                        <li class="active"> <a href="#"><i class="glyphicon glyphicon-home"></i> Accueil</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-envelope"></i> Messages <span class="badge badge-info">4</span></a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-cog"></i> Options</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-comment"></i> Commentaires</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-user"></i> Membres</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-off"></i> Se déconnecter</a></li>
                    </ul>
                </li>
                <li class="nav-header"> <a href="#" data-toggle="collapse" data-target="#menu2"> Rapports <i class="glyphicon glyphicon-chevron-right"></i></a>

                    <ul class="nav nav-stacked collapse" id="menu2">
                        <li><a href="#">Statistiques</a>
                        </li>
                        <li><a href="#">Vues</a>
                        </li>
                        <li><a href="#">Requêtes</a>
                        </li>
                        <li><a href="#">Alertes</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">
                    <a href="#" data-toggle="collapse" data-target="#menu3"> Réseaux sociaux <i class="glyphicon glyphicon-chevron-right"></i></a>
                    <ul class="nav nav-stacked collapse" id="menu3">
                        <li><a href=""><i class="glyphicon glyphicon-circle"></i> Facebook</a></li>
                        <li><a href=""><i class="glyphicon glyphicon-circle"></i> Twitter</a></li>
                    </ul>
                </li>
            </ul>

            <hr>

            <a href="#"><strong><i class="glyphicon glyphicon-link"></i> Ressources</strong></a>

            <hr>

            <ul class="nav nav-pills nav-stacked">
                <li class="nav-header"></li>
                <li><a href="#"><i class="glyphicon glyphicon-list"></i> Modèles</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-briefcase"></i> Boîte à outils</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-link"></i> Widgets</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-list-alt"></i> Rapports</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-book"></i> Pages</a></li>
            </ul>

            <hr>

            <a href="#"><strong><i class="glyphicon glyphicon-list"></i> Aide</strong></a>

            <hr>

            <ul class="nav nav-stacked">
                <li class="active"><a rel="nofollow" href="http://www.leblogduhacker.fr" target="ext">Le Blog Du Hacker</a></li>
                <li><a rel="nofollow" href="https://udemy.com">Udemy</a></li>
            </ul>
        </div>
        <!-- /col-3 -->
        <div class="col-sm-9">

            <!-- column 2 -->
            <ul class="list-inline pull-right">
                <li><a href="#"><i class="glyphicon glyphicon-cog"></i></a></li>
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-comment"></i><span class="count">3</span></a>
                </li>
                <li><a href="#"><i class="glyphicon glyphicon-user"></i></a></li>
                <li><a title="Add Widget" data-toggle="modal" href="#addWidgetModal"><span class="glyphicon glyphicon-plus-sign"></span> Ajouter Widget</a></li>
            </ul>
            <a href="#"><strong><i class="glyphicon glyphicon-dashboard"></i> Mon Tableau de Bord</strong></a>
            <hr>

            <div class="row">
                <!-- center left-->
                <div class="col-md-6">
                    <div class="well">Liste des articles <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Titre</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Mon premier article</td>
									
                                    <td><a href="delete.php?id=1" class="btn btn-primary">Supprimer</a></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Nulla amet dolore</td>
                                    <td><a href="delete.php?id=2" class="btn btn-primary">Supprimer</a></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Tempus ullamcorper</td>
                                    <td><a href="delete.php?id=3" class="btn btn-primary">Supprimer</a></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Sed etiam facilis</td>
                                    <td><a href="delete.php?id=4" class="btn btn-primary">Supprimer</a></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Feugiat lorem aenean</td>
                                    <td><a href="delete.php?id=5" class="btn btn-primary">Supprimer</a></td>
                                </tr>
								 <tr>
                                    <td>6</td>
                                    <td>Amet varius aliquam</td>
                                    <td><a href="delete.php?id=6" class="btn btn-primary">Supprimer</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div></div>

                    <hr>

                    <div class="btn-group btn-group-justified">
                        <a href="#" class="btn btn-primary col-sm-3">
                            <i class="glyphicon glyphicon-plus"></i>
                            <br> Service
                        </a>
                        <a href="#" class="btn btn-primary col-sm-3">
                            <i class="glyphicon glyphicon-cloud"></i>
                            <br> Cloud
                        </a>
                        <a href="#" class="btn btn-primary col-sm-3">
                            <i class="glyphicon glyphicon-cog"></i>
                            <br> Outils
                        </a>
                        <a href="#" class="btn btn-primary col-sm-3">
                            <i class="glyphicon glyphicon-question-sign"></i>
                            <br> Aide
                        </a>
                    </div>

                    <hr>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>Rapports</h4></div>
                        <div class="panel-body">

                            <small>Succès</small>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100" style="width: 72%">
                                    <span class="sr-only">72% Complet</span>
                                </div>
                            </div>
                            <small>Info</small>
                            <div class="progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                    <span class="sr-only">20% Complet</span>
                                </div>
                            </div>
                            <small>Attention</small>
                            <div class="progress">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                    <span class="sr-only">60% Complet (attention)</span>
                                </div>
                            </div>
                        </div>
                        <!--/panel-body-->
                    </div>
                    <!--/panel-->

                    <hr>

				</div>
                <!--/col-->
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>Notices</h4></div>
                        <div class="panel-body"> 
                            <p>Ce Tableau de bord n'est pas fonctionnel. Il ne sert que d'exemple pour le cours vidéo sur le hacking éthique issu du site Udemy.com</p>
                            <p>Visit the Bootstrap Playground at <a href="http://bootply.com">Bootply</a> to tweak this layout or discover more useful code snippets.</p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Visites</th>
                                    <th>ROI</th>
                                    <th>Source</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>45</td>
                                    <td>2.45%</td>
                                    <td>Direct</td>
                                </tr>
                                <tr>
                                    <td>289</td>
                                    <td>56.2%</td>
                                    <td>Référant</td>
                                </tr>
                                <tr>
                                    <td>98</td>
                                    <td>25%</td>
                                    <td>Type</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="glyphicon glyphicon-wrench pull-right"></i>
                                <h4>Faire une requête</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form form-vertical">
                                <div class="control-group">
                                    <label>Nom</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" placeholder="Entrez votre nom">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label>Message</label>
                                    <div class="controls">
                                        <textarea class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label>Categorie</label>
                                    <div class="controls">
                                        <select class="form-control">
                                            <option>options</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label></label>
                                    <div class="controls">
                                        <button type="submit" class="btn btn-primary">
                                            Envoyer
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--/panel content-->
                    </div>
                    <!--/panel-->

                </div>
                <!--/col-span-6-->

            </div>
            <!--/row-->

            <hr>

          
        </div>
        <!--/col-span-9-->
    </div>
</div>
<!-- /Main -->

<footer class="text-center">Modèle initial fourni gratuitement par <a href="http://www.bootply.com/85850"><strong>Bootply.com</strong></a></footer>

	<!-- script references -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/scripts.js"></script>
	</body>
</html>

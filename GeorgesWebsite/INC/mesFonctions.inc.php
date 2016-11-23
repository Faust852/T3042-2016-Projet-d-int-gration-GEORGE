<?php
//______________________________________________________ConnectBDD______________________________________________________

function ConnectBDD (){
    $host = "185.14.186.97";
    $dbname = 'georges';
    $user = 'root';
    $pswd = 'c3m3cqu10';
    try {
        $bdd = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8', $user, $pswd);
    } catch (PDOException $e) {
        send('connectionFailed', 'ERREURPDO dans '.$e);
    };

    return $bdd;
}
//__________________________________________________new User____________________________________________________________
function newUser()
{
    $pseudo = $_POST['pseudo'];
    $mdp = $_POST['mdp'];
    $email = $_POST['email'];
    $verifEmail = $_POST['verifEmail'];
    $verifMdp = $_POST['verifMdp'];

    $sections = ConnectBDD()->prepare("select pseudo from USER");
    $sections->execute();
    $sectionTab = $sections->fetchAll(PDO::FETCH_COLUMN, 0);
    $i = 0;
    $b = " ";
    if (in_array($pseudo, $sectionTab)) {
        $b .= "Ce pseudo est déjà utilisé";
        $i = 1;
    }
    if ($mdp !== $verifMdp) {
        $b .= '<br>Les mots de passe sont différents';
        $i = 1;
        //send('variable', 'c');
    }
    if (!($pseudo && $email && $mdp && $verifMdp && $verifEmail)){
        $b .= '<br>Tous les champs ne sont pas completés';
        $i = 1;
        //send('variable', 'd' . $b);
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $b.= '<br>Email non valide';
        $i = 1;
    }
    if($i == 0){
        $sections = ConnectBDD()->prepare("INSERT INTO USER (pseudo, mdp, email)
                                       VALUES (:pseudo, :mdp, :email)");
        $sections->execute(array(':pseudo' => $pseudo, ':mdp' => md5($mdp), ':email' => $email));
        $b .= "Votre compte a bien été enregistré";
        return $b;
    }else{
        send('connectionFailed', $b);
        return chargeTemplate('signup');
    }
}
//__________________________________________________gestion login_______________________________________________________

function gestionLogin() {
    $username = $_POST['username'];

    $sections = ConnectBDD()->prepare("select id, pseudo, email, mdp, status
                                 from USER where pseudo =:pseudo");
    $sections->execute(array(':pseudo' => $username));
    $sectionTab = $sections->fetchAll(PDO::FETCH_ASSOC);

    //else {*/
    //if (md5($_POST['password'])==$sectionTab[0]['mdp']) return monPrint_r($sectionTab);
    if (md5($_POST['password']) !== "" && md5($_POST['password']) == $sectionTab[0]['mdp']) {
        $_SESSION['is']['connected'] = 1;
        $_SESSION['user'] = $sectionTab[0]['id'];
        $_SESSION['status'] = $sectionTab[0]['status'];
        $_SESSION['username'] = $sectionTab[0]['pseudo'];
        creeConnectedMenu();
    } else {
        send('connectionFailed', 'Mot de passe ou utilisateur incorrect');
        return chargeTemplate('login');
    }
    //}
}

//______________________________________________________Lier un robot et un user _________________________________________

function linkRobot(){
    $id = $_POST['robot_id'];
    $mdp = $_POST['robot_password'];
    $userCo = $_SESSION['user'];

    $sections = ConnectBDD()->prepare("select mdp
                                 from ROBOT where id =:id");

    $sections->execute(array(':id' => $id));

    $sectionTab = $sections->fetchAll(PDO::FETCH_ASSOC);

    if($mdp == $sectionTab[0]['mdp']){
        $results = ConnectBDD()->prepare("INSERT INTO USER_ROBOT(id_user, id_robot) VALUES (:id_user, :id_robot)");
        $results->execute(array(':id_user' => $userCo, ':id_robot' => $id));
        return "Votre robot vous est désormais lié!";
    }else{
        send('connectionFailed', "Le mot de passe ou l'id est incorrect");
        return chargeTemplate('adminRobot');
    }
}


//______________________________________________________creer menu________________________________________________________

function creeMenu ($tabMenu) {
    $htmlMenu = '';
    $htmlMenu.='<ul>';

    $nomMenu = array_keys($tabMenu);
    $i=0;
    foreach ($tabMenu as $value) {
        $titreOnglet = ucfirst(strtolower($nomMenu[$i]));
        if($value){
            if(is_array($value)){
                $htmlMenu .= '<li>'.$titreOnglet.'<ul>';
                foreach($value as $k=>$v){
                    $htmlMenu .= '<li><a href='.$v.'>'.$k.'</a></li>';
                }
                $htmlMenu .= '</ul></li>';
            }
            else{
                $htmlMenu.='<li><a href='.$value.' id= o_'.$titreOnglet.'>'.$titreOnglet.'</a></li>';
            }
        }
        else{
            $htmlMenu.='<li><h1>'.$nomMenu[$i].'</a></li>';
        }
        /*($value)    ? $htmlMenu.='<li><a href='.$value.' id= o_'.$titreOnglet.'>'.$titreOnglet.'</a></li>'
                    : $htmlMenu.='<li><h1>'.$nomMenu[$i].'</a></li>';
           */
        $i++;
    }

    $htmlMenu.='</ul>';

    return $htmlMenu;
}

//______________________________________________________mon print_______________________________________________________

function monPrint_r ($tab){
    $chaine = '<pre>';
    $chaine .= print_r($tab, true);
    $chaine .= '</pre>';
    return $chaine;
}


//______________________________________________________charger Accueil________________________________________________

function chargeAccueil (){
    if($_SESSION['is']['connected'] == 1){
        $temp  = chargeTemplate('accueilConnected');
        send('user', ' ' . ucfirst($_SESSION['username']));
    }else{
        $temp  = chargeTemplate('accueil');
    }
    return $temp;
}

//______________________________________________________charger template________________________________________________

function chargeTemplate ($t){
    $file = file('INC/'.$t.'.template.inc.php');

    global $envoi;
    $tab = [$t => '' ];
    $envoi['sous-menu'] = creeMenu($tab);

    return implode ('', $file);
}

//___________________________________________________Afficher info formulaire___________________________________________

function getFormInfo() {
    $liste = ['_GET'=>$_GET, '_POST'=>$_POST, '_FILES'=>$_FILES];
    return monPrint_r($liste,true);
}
//__________________________________________________get data____________________________________________________________

function getData($g, $n){
    if (isset($_SESSION['iniA'][$g][$n])) return $_SESSION['iniA'][$g][$n];
    else return "[$g][$n] inconnu";
}

//__________________________________________________Menu for if connected_______________________________________________

function creeConnectedMenu(){
    $lesMenus = ['menu' => ['Accueil' => 'accueil.html',
        'Contact' => 'contact.html',
        'Se connecter' => 'login.html',
        'S\'inscrire' => 'signup.html',
        'Page de présentation' => 'goToFirst.html'
    ],
        'connectedUser' => ['Accueil' => 'accueil.html',
            'Contact' => 'contact.html',
            'Forum' => 'chat.html',
            'Robot' => ['Contrôle ton robot' => 'video.html',
			'Vidéos disponibles' => 'mesVideos.html',
            'Lier un robot' => 'adminRobot.html'],
            'Déconnexion' => 'logout.html',
            'Page de présentation' => 'goToFirst.html'
        ],
        'adminMenu' => ['Accueil' => 'accueil.html',
            'Contact' => 'contact.html',
            'Forum' => 'chat.html',
            'Robot' => ['Contrôle ton robot' => 'video.html',
                'Vidéos disponibles' => 'mesVideos.html',
                'Lier un robot' => 'adminRobot.html'],
            'Admin' => ['Utilisateurs' => 'users.html',
                            'Robots' => 'robots.html',
                            'Links' => 'robotLinks.html'],
            'Déconnexion' => 'logout.html',
            'Page de présentation' => 'goToFirst.html'
        ]
    ];
    switch(true){
        case isConnected() and ($_SESSION['status'] == 'admin'):
            send('menu', creeMenu($lesMenus['adminMenu']));
            break;
        case isConnected():
            send('menu', creeMenu($lesMenus['connectedUser']));
            break;
        default:
            send('menu', creeMenu($lesMenus['menu']));
    }
}
//______________________________________________isConnected()___________________________________________________________
function isConnected(){return $_SESSION['is']['connected'];}
//______________________________________________send____________________________________________________________________

function send($location, $text) {
    global $envoi;
    $envoi[$location] = $text;
}
//__________________________________________________ Traiter les formulaires ___________________________________________
function traiteForm(){
    if(!isset($_GET['submit'])){
        return 'Impossible d\'identifier le formulaire';
    }
    switch($_GET['submit']){
        case 'sendLogin' :
            $return = gestionLogin();
            break;
        case 'sendNewAccount':
            $return = newUser();
            break;
        case 'sendRobot' :
            $return = linkRobot();
            break;
        case 'goToPortal':
            $return = chargeTemplate('layout');
            $_SESSION['startPageViewed'] = true;
            break;
        case 'sendChat':
            //$retour = addMessage();
            //break;
        case 'sendMdpPerdu':
        default : $return = getFormInfo();
    }
    return $return;
}
//________________________________________________ If robot is linked___________________________________________________
function checkLinkedRobots(){
    $idRobot = ConnectBDD()->prepare("SELECT id_robot FROM USER_ROBOT where id_user = ".$_SESSION['user']);
    $idRobot->execute();
    $idRobotAnswer = $idRobot->fetchAll(PDO::FETCH_ASSOC);
    if($idRobotAnswer){
        return true;
    }else{
        return false;
    }
}
//__________________________________________________connect sockets_____________________________________________________

function socket ($socket) {
    $idRobot = ConnectBDD()->prepare("SELECT ip FROM ROBOT where id = (SELECT id_robot FROM USER_ROBOT where id_user=".$_SESSION['user'].")");
	$idRobot->execute();
    $idRobotAnswer = $idRobot->fetchAll(PDO::FETCH_ASSOC);
    $host = $idRobotAnswer[0]['ip'];
	$port = 62900;
	$output=$socket ;
	$socket1 = socket_create(AF_INET, SOCK_STREAM,0) or die("Could not create socket\n");
	socket_connect ($socket1 , $host,$port ) ;
	socket_write($socket1, $output, strlen ($output)) or die("Could not write output\n");
	socket_close($socket1) ;
}
//__________________________________________________See user____________________________________________________________
function getUserlist()
{
    $users = ConnectBDD()->exec("select * from USER");
    //$users->execute();
    //$usersList = $users->fetchAll(PDO::FETCH_ASSOC);

    //return monPrint_r($usersList);

    $tableau = new tableau();
    $tableau->entete = true;
    $tableau->id = 'usersTab';
    $tableau->liste = $users;

    return $tableau->html();
}
//__________________________________________________creerVideos_________________________________________________________

function creerVideos () {
	//$dir    = './../picturesBackUp/motion/*.avi';
	$dir    = './IMG/motion/*.avi';
	$files = glob($dir);
	$retour = '';
	
	
	foreach($files as $image)
		{ 
			$retour.='<a href='.$image.'>'.$image.'</a><br>';

		  // $retour.='<img src='.$image.'></img>';
		}
		
		

//$files1 = scandir($dir);

	return $retour;	
}

//__________________________________________________traiter request_____________________________________________________

function traiteRequest($rq) {
    send('contenu', '');

    switch ($rq){
        case 'accueil' :
            send('contenu', chargeAccueil());
            if($_SESSION['is']['connected'] == 1){
                send('user', ' ' . ucfirst($_SESSION['username']));
            }
            break;
        case 'contact' :
            send('contenu', chargeTemplate($rq));
            break;
        case 'video' :
            if(checkLinkedRobots()){
                send('contenu', chargeTemplate($rq));
            }else{
                send('contenu', chargeTemplate('noLinkedRobot'));
            }
            break;
        case 'adminRobot' :
            send('contenu', chargeTemplate($rq));
            break;
        case 'chat':
            send('contenu', chargeTemplate($rq));
            break;
        case 'testForm' :
            send('contenu', traiteForm());
            break;
        case 'login' :
            send('contenu', chargeTemplate($rq));
            break;
        case 'logout' :
            session_unset();
            session_destroy();
            creeConnectedMenu();
            break;
        case 'signup' :
            send('contenu', chargeTemplate($rq));
            break;
        case 'users':
            send('contenu', getUserlist());
            break;
        case 'goToFirst':
            $_SESSION['startPageViewed'] = false;
            //Creer les menus reload la page
            creeConnectedMenu();
            break;
        case 'up' :
		case 'down' :
		case 'left' :
		case 'right' :
        case 'auto':
        case 'stop':
		    socket($rq);
			break;
		case 'mesVideos' :
            if(checkLinkedRobots()){
                send('contenu', creerVideos());
            }else{
                send('contenu', chargeTemplate('noLinkedRobot'));
            }
			break;
        default : send('contenu', 'Requête inconnue : '.$_GET['rq']);
    }
}

?>


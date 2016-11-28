<?php
//Made by Adrien Culem
include 'tableau.php';
//______________________________________________________ConnectBDD______________________________________________________

function ConnectBDD (){
    $host = "";
    $dbname = '';
    $user = '';
    $pswd = '';
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
    $sectionTab = $sections->fetchAll(PDO::FETCH_COLUMN);
    $i = 0;
    $b = " ";
    send("variable", $sectionTab);
    if (in_array($pseudo, $sectionTab)) {
        $b .= 'Ce pseudo est déjà utilisé';
        $i = 1;
    }
    if ($mdp !== $verifMdp) {
        $b .= '<br>Les mots de passe sont différents';
        $i = 1;
    }
    if (!($pseudo && $email && $mdp && $verifMdp && $verifEmail)){
        $b .= '<br>Tous les champs ne sont pas completés';
        $i = 1;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $b.= '<br>Email non valide';
        $i = 1;
    }
    if($i == '0'){
        $sections = ConnectBDD()->prepare("INSERT INTO USER (pseudo, mdp, email)
                                       VALUES (:pseudo, :mdp, :email)");
        $sections->execute(array(':pseudo' => $pseudo, ':mdp' => md5($mdp), ':email' => $email));
        $b .= "<h1 class='signLogP'>Votre compte a bien été enregistré</h1>";
        return $b;
    }
    if($i == '1'){
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
//☰
function creeMenu ($tabMenu, $a) {
    $htmlMenu = '';
    $htmlMenu.='<ul class="w3-navbar w3-large w3-dark-grey w3-left-align">';
    /*$htmlMenu.='<li class="w3-hide-medium w3-hide-large w3-dark-grey w3-opennav w3-right">
    <a href="javascript:void(0);" onclick="sideMenu()" style="color: white"></a>
    </li>';*/
    $htmlMenu.='<li class="w3-hide-medium w3-hide-large w3-dark-grey w3-opennav w3-right">
    <div onclick="sideMenu();" class="nav-icon">
    <div></div>
    </div>
    </li>';

    $nomMenu = array_keys($tabMenu);
    $i=0;
    foreach ($tabMenu as $value) {
        $titreOnglet = str_replace(' ', '', ucfirst($nomMenu[$i]));
        if($value){
            if(is_array($value)){
                $htmlMenu .= '<li style="width:'.$a.'%; text-align: center" class="w3-dropdown-hover w3-hide-small"><a href="#">'.$titreOnglet.' <i class="fa fa-chevron-down" aria-hidden="true"></i></a><div style="width:'.$a.'%;" class="w3-dropdown-content w3-white w3-card-4">';
                foreach($value as $k=>$v){
                    $htmlMenu .= '<a onclick="return menuClick(this)" href='.$v.'>'.$k.'</a>';
                }
                $htmlMenu .= '</div></li>';
            }
            elseif($titreOnglet == 'Home'){
                $htmlMenu.='<li style="width:'.$a.'%; text-align: center"><a onclick="return menuClick(this)" href='.$value.' id= o_'.$titreOnglet.'>'.$titreOnglet.'</a></li>';
            }else{
                $htmlMenu.='<li style="width:'.$a.'%; text-align: center" class="w3-hide-small"><a onclick="return menuClick(this)" href='.$value.' id= o_'.$titreOnglet.'>'.$titreOnglet.'</a></li>';
            }
        }
        else{
            $htmlMenu.='<li><h1>'.$nomMenu[$i].'</a></li>';
        }
        $i++;
    }

    $htmlMenu.='</ul>';

    $htmlMenu.='<div id="demo" class="w3-hide w3-hide-large w3-hide-medium">';
    $htmlMenu.='<ul class="w3-navbar w3-left-align w3-large w3-dark-grey">';
    $i=0;
    foreach ($tabMenu as $value) {
        $titreOnglet = ucfirst(strtolower($nomMenu[$i]));
        if($value){
            if(is_array($value)){
                $htmlMenu .= '<li class="w3-dropdown-hover"><a href="#">'.$titreOnglet.' <i class="fa fa-chevron-down" aria-hidden="true"></i></a><div class="w3-dropdown-content w3-white w3-card-4">';
                foreach($value as $k=>$v){
                    $htmlMenu .= '<a onclick="sideMenu(); return menuClick(this);" href='.$v.'>'.$k.'</a>';
                }
                $htmlMenu .= '</div></li>';
            }elseif($titreOnglet == 'Home'){
            }else{
                $htmlMenu.='<li><a onclick="sideMenu(); return menuClick(this);" href='.$value.' id= o_'.$titreOnglet.'>'.$titreOnglet.'</a></li>';
            }
        }
        else{
            $htmlMenu.='<li><h1>'.$nomMenu[$i].'</a></li>';
        }
        $i++;
    }

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
    //The menu that is created
    $lesMenus = ['menu' => ['Home' => 'home.html',
        'Contact' => 'contact.html',
        'Sign in' => 'login.html',
        'Sign up' => 'signup.html',
        'Home page' => 'goToFirst.html'
    ],
        'connectedUser' => ['Home' => 'home.html',
            'Contact' => 'contact.html',
            'Forum' => 'chat.html',
            'Georges' => ['Controls' => 'video.html',
			'Videos' => 'mesVideos.html',
            'Link to your Georges' => 'adminRobot.html'],
            'Log out' => 'logout.html',
            'Home page' => 'goToFirst.html'
        ],
        'adminMenu' => ['Home' => 'home.html',
            'Contact' => 'contact.html',
            'Forum' => 'chat.html',
            'Georges' => ['Controls' => 'video.html',
                'Videos' => 'mesVideos.html',
                'Link to your Georges' => 'adminRobot.html'],
            'Admin' => ['Users' => 'users.html',
                            'Robots' => 'robots.html',
                            'Links' => 'robotLinks.html'],
            'Log out' => 'logout.html',
            'Home page' => 'goToFirst.html'
        ]
    ];
    //Division for li's width in menu
    switch(true){
        case isConnected() and ($_SESSION['status'] == 'admin'):
            send('menu', creeMenu($lesMenus['adminMenu'], 100/7));
            break;
        case isConnected():
            send('menu', creeMenu($lesMenus['connectedUser'], 100/6));
            break;
        default:
            send('menu', creeMenu($lesMenus['menu'], 100/5));
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
    $users = ConnectBDD()->prepare("select id, pseudo, email, status from USER");
    $users->execute();
    $usersList = $users->fetchAll(PDO::FETCH_ASSOC);

    //return monPrint_r($usersList);

    $tableau = new tableau();
    $tableau->entete = true;
    $tableau->id = 'usersTab';
    $tableau->liste = $usersList;
    $tableau->titre = 'Utilisateurs';
    $tableau->tabId = 'id';
    $tableau->type = 'user';

    send('contenu', $tableau->html());
    send('dataTable', $tableau->id);
}
//__________________________________________________ See Robots ________________________________________________________
function getRobotList()
{
    $robots = ConnectBDD()->prepare("select * from ROBOT");
    $robots->execute();
    $robotsList = $robots->fetchAll(PDO::FETCH_ASSOC);

    //return monPrint_r($usersList);

    $tableau = new tableau();
    $tableau->entete = true;
    $tableau->id = 'robotList';
    $tableau->liste = $robotsList;
    $tableau->titre = 'Robots';
    $tableau->tabId = 'id';
    $tableau->type = 'robot';

    send('contenu', $tableau->html());
    send('dataTable', $tableau->id);
}
//_________________________________________________ see Links __________________________________________________________
function getRobotLinksList()
{
    $links = ConnectBDD()->prepare("select u.id, pseudo, id_robot
          from USER as u JOIN USER_ROBOT as r ON u.id =r.id_user");
    $links->execute();
    $linksList = $links->fetchAll(PDO::FETCH_ASSOC);

    //return monPrint_r($usersList);

    $tableau = new tableau();
    $tableau->entete = true;
    $tableau->id = 'linksList';
    $tableau->liste = $linksList;
    $tableau->titre = 'Linked Users';
    $tableau->tabId = 'id';
    $tableau->type = 'link';

    send('contenu', $tableau->html());
    send('dataTable', $tableau->id);
}
//___________________________________________________ Admin delete in db _______________________________________________
function deleteFromDb(){
    $id = $_GET['idDelete'];
    send('variable', $id);
    $type = $_GET['type'];
    send('variable', $type);
    if($type == 'link'){
        $db = ConnectBDD()->prepare("delete from USER_ROBOT where id_user=".$id);
        $db->execute();
        return getRobotLinksList();
    }elseif ($type == 'robot'){
        $db = ConnectBDD()->prepare("delete from ROBOT where id=".$id);
        $db->execute();
        return getRobotList();
    }elseif ($type == 'user'){
        $db = ConnectBDD()->prepare("delete from USER where id=".$id);
        $db->execute();
        return getUserlist();
    }else{
        send('contenu', 'Oops, something went wrong');
    }
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
        case 'home' :
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
            $_SESSION['is']['connected'] = 0;
            $_SESSION['user'] = '';
            $_SESSION['status'] = '';
            $_SESSION['username'] = '';
            creeConnectedMenu();
            break;
        case 'signup' :
            send('contenu', chargeTemplate($rq));
            break;
        case 'users':
            getUserlist();
            break;
        case 'robots':
            getRobotList();
            break;
        case 'robotLinks':
            getRobotLinksList();
            break;
        case 'startPageViewed':
            $_SESSION['startPageViewed'] = true;
            break;
        case 'goToFirst':
            $_SESSION['startPageViewed'] = false;
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
            $titrePage = 'Georgesecurity - Videos';
			break;
        case 'deleteFromDb':
            deleteFromDb();
            break;
        default : send('contenu', 'Requête inconnue : '.$_GET['rq']);
    }
}

?>

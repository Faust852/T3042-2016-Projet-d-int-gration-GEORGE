<?php
//By Adrien Culem and Simon Ponchau
include 'tableau.php';
//______________________________________________________ConnectBDD______________________________________________________
// Connection to the database
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
// Create a new user in database
function newUser()
{
    $username = htmlspecialchars($_POST['username']);
    $mdp = htmlspecialchars($_POST['signupPassword']);
    $email = htmlspecialchars($_POST['email']);
    $verifEmail = htmlspecialchars($_POST['verifEmail']);
    $verifMdp = htmlspecialchars($_POST['verifMdp']);

    $sections = ConnectBDD()->prepare("select pseudo from USER");
    $sections->execute();
    $sectionTab = $sections->fetchAll(PDO::FETCH_COLUMN);
    $i = 0;
    $b = " ";
    //Check conditions
    // Username already in database?
    if (in_array($username, $sectionTab)) {
        $b .= 'Ce pseudo est déjà utilisé';
        $i = 1;
    }
    // Same passwords?
    if ($mdp !== $verifMdp) {
        $b .= '<br>Les mots de passe sont différents';
        $i = 1;
    }
    // All fields completed?
    if (!($username && $email && $mdp && $verifMdp && $verifEmail)){
        $b .= '<br>Tous les champs ne sont pas completés';
        $i = 1;
    }
    //Right email type?
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $b.= '<br>Email non valide';
        $i = 1;
    }
    //Create user if there is no error
    if($i == '0'){
        $sections = ConnectBDD()->prepare("INSERT INTO USER (pseudo, mdp, email)
                                       VALUES (:pseudo, :mdp, :email)");
        $sections->execute(array(':pseudo' => $username, ':mdp' => md5($mdp), ':email' => $email));
        $b .= "<h1 class='signLogP'>Votre compte a bien été enregistré</h1>";
        return $b;
    }
    //If not, send message error
    if($i == '1'){
        send('connectionFailed',$b);
        return chargeTemplate('signup');
    }
}
//__________________________________________________gestion login_______________________________________________________
// Allow users to connect
function gestionLogin() {
    $username = htmlspecialchars($_POST['username']);

    $sections = ConnectBDD()->prepare("select id, pseudo, email, mdp, status
                                 from USER where pseudo =:pseudo");
    $sections->execute(array(':pseudo' => $username));
    $sectionTab = $sections->fetchAll(PDO::FETCH_ASSOC);

    //Check if md5 hashes are the same
    if (md5($_POST['password']) !== "" && md5($_POST['password']) == $sectionTab[0]['mdp']) {
        $_SESSION['is']['connected'] = 1;
        $_SESSION['user'] = $sectionTab[0]['id'];
        $_SESSION['status'] = $sectionTab[0]['status'];
        $_SESSION['username'] = $sectionTab[0]['pseudo'];
        $_SESSION['userHash'] = $sectionTab[0]['mdp'];
        try{
            checkLinkedRobots();
        }catch(Exception $e){
        };
        creeConnectedMenu();
    } else {
        //if not, send error
        send('connectionFailed', 'Mot de passe ou utilisateur incorrect');
        return chargeTemplate('login');
    }
    //}
}

//______________________________________________________Lier un robot et un user _________________________________________
//Allow a user to link with his robot
function linkRobot(){
    $id = htmlspecialchars($_POST['robot_id']);
    $mdp = htmlspecialchars(md5($_POST['robot_password']));
    $userCo = htmlspecialchars($_SESSION['user']);

    $sections = ConnectBDD()->prepare("select mdp
                                 from ROBOT where id =:id");

    $sections->execute(array(':id' => $id));

    $sectionTab = $sections->fetchAll(PDO::FETCH_ASSOC);
    //Check if passwords are the same (Should be encrypted)
    if($mdp == $sectionTab[0]['mdp']){
        $results = ConnectBDD()->prepare("INSERT INTO USER_ROBOT(id_user, id_robot) VALUES (:id_user, :id_robot)");
        $results->execute(array(':id_user' => $userCo, ':id_robot' => $id));
        return "<h1 class='signLogP'>Votre robot vous est désormais lié!</h1>";
        try{
            checkLinkedRobots();
        }catch(Exception $e){
        }
    }else{
        //if not send error
        send('connectionFailed', "Le mot de passe ou l'id est incorrect");
        return chargeTemplate('robotLink');
    }
}


//______________________________________________________creer menu________________________________________________________
//☰
//Create all the menus (Small format, and desktop format)
function creeMenu ($tabMenu, $a) {
    $htmlMenu = '';
    $htmlMenu.='<ul class="w3-navbar w3-large w3-dark-grey w3-left-align">';
    //Menu icon
    $htmlMenu.='<li class="accessFocus w3-hide-medium w3-hide-large w3-dark-grey w3-opennav w3-right">
    <div onclick="sideMenu();" class="nav-icon">
    <div></div>
    </div>
    </li>';

    $nomMenu = array_keys($tabMenu);
    $i=0;
    $j=0;
    foreach ($tabMenu as $value) {
        $titreOnglet = str_replace(' ', '', ucfirst($nomMenu[$i]));
        $content = ucfirst($nomMenu[$i]);
        if($value){
            if(is_array($value)){
                //Creating the menu and submenu with the value in the array
                $htmlMenu .= '<li style="width:'.$a.'%; text-align: center" class="w3-dropdown-hover w3-hide-small"><a onfocus="showContent('.$j.')" class="accessFocus" href="#">'.$content.' <i class="fa fa-chevron-down" aria-hidden="true"></i></a><div style="width:'.$a.'%;" class="w3-dropdown-content w3-white w3-card-4">';
                $j++;
                foreach($value as $k=>$v){
                    $htmlMenu .= '<a class="accessFocus" onclick="return menuClick(this)" href='.$v.'>'.$k.'</a>';
                }
                $htmlMenu .= '</div></li>';
            }
            elseif($titreOnglet == 'Portal'){
                //To stay displayed on the small menu
                $htmlMenu.='<li style="width:'.$a.'%; text-align: center"><a class="accessFocus" onclick="return menuClick(this)" href='.$value.' id= o_'.$titreOnglet.'>'.$content.'</a></li>';
            }elseif($titreOnglet == "Homepage") {
                //To go back on presentation website
                $htmlMenu.='<li style="width:'.$a.'%;text-align: center" class="w3-hide-small"><a class="accessFocus" href="javascript:void(startPageViewed());" id= o_'.$titreOnglet.'>'.$content.'</a></li>';
            }
            else{
                $htmlMenu.='<li style="width:'.$a.'%; text-align: center" class="w3-hide-small"><a onfocus="showContent(2)" class="accessFocus" onclick="return menuClick(this)" href='.$value.' id= o_'.$titreOnglet.'>'.$content.'</a></li>';
            }
        }else{
            $htmlMenu.='<li><h1>'.$nomMenu[$i].'</a></li>';
        }
        $i++;
    }

    $htmlMenu.='</ul>';

    $htmlMenu.='<div id="demo" class="w3-hide w3-hide-large w3-hide-medium">';
    $htmlMenu.='<ul class="w3-navbar w3-left-align w3-large w3-dark-grey">';
    $i=0;
    foreach ($tabMenu as $value) {
        $titreOnglet = str_replace(' ', '', ucfirst($nomMenu[$i]));
        $content = ucfirst($nomMenu[$i]);
        if($value){
            if(is_array($value)){
                //Creating the menu and submenu with the value in the array
                $htmlMenu .= '<li class="w3-dropdown-hover"><a href="#">'.$content.' <i class="fa fa-chevron-down" aria-hidden="true"></i></a><div class="w3-dropdown-content w3-white w3-card-4">';
                foreach($value as $k=>$v){
                    $htmlMenu .= '<a onclick="sideMenu(); return menuClick(this);" href='.$v.'>'.$k.'</a>';
                }
                $htmlMenu .= '</div></li>';
            }elseif($titreOnglet == 'Portal'){
                //So the portal is not displayed twice (Since it stays even in small format)
            }elseif($titreOnglet == "Homepage") {
                $htmlMenu.='<li style="width:'.$a.'%;"><a href="javascript:void(startPageViewed());" id= o_'.$titreOnglet.'>'.$content.'</a></li>';
            }
            else{
                $htmlMenu.='<li><a onclick="sideMenu(); return menuClick(this);" href='.$value.' id= o_'.$titreOnglet.'>'.$content.'</a></li>';
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
//Simple array format
function monPrint_r ($tab){
    $chaine = '<pre>';
    $chaine .= print_r($tab, true);
    $chaine .= '</pre>';
    return $chaine;
}


//______________________________________________________charger Accueil________________________________________________
//Load adapted message on the portal (If you are connected or not)
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
// Load .template.inc.php files
function chargeTemplate ($t){
    $file = file('INC/'.$t.'.template.inc.php');

    global $envoi;
    $tab = [$t => '' ];
    $envoi['sous-menu'] = creeMenu($tab);

    return implode ('', $file);
}

//___________________________________________________Afficher info formulaire___________________________________________
//Use in debuging (Shows a form informations)
function getFormInfo() {
    $liste = ['_GET'=>$_GET, '_POST'=>$_POST, '_FILES'=>$_FILES];
    return monPrint_r($liste,true);
}

//__________________________________________________Menu for if connected_______________________________________________

function creeConnectedMenu(){
    //The menu that is created
    $lesMenus = ['menu' => ['Portal' => 'home.html',
        'Contact' => 'contact.html',
        'Sign in' => 'login.html',
        'Sign up' => 'signup.html',
        'Home page' => 'homepage.html'
    ],
        'connectedUser' => ['Portal' => 'home.html',
            'Contact' => 'contact.html',
            'Forum' => 'forum.html',
            'Georges' => ['Controls' => 'controls.html',
			'Videos' => 'mesVideos.html',
            'Link to your Georges' => 'robotLink.html'],
            'Log out' => 'logout.html',
            'Home page' => 'homepage.html'
        ],
        'adminMenu' => ['Portal' => 'home.html',
            'Contact' => 'contact.html',
            'Forum' => 'forum.html',
            'Georges' => ['Controls' => 'controls.html',
                'Videos' => 'mesVideos.html',
                'Link to your Georges' => 'robotLink.html'],
            'Admin' => ['Users' => 'users.html',
                            'Robots' => 'robots.html',
                            'Links' => 'robotLinks.html',
                            'Add robots' => 'addRobots.html'],
            'Log out' => 'logout.html',
            'Home page' => 'homepage.html'
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
//Send in the layout
function send($location, $text) {
    global $envoi;
    $envoi[$location] = $text;
}
//__________________________________________________ Traiter les formulaires ___________________________________________
//Do the right thing for the right submit
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
        case 'sendAddRobots':
            $return = newRobot();
            break;
        case 'sendRobot' :
            $return = linkRobot();
            break;
        default : $return = getFormInfo();
    }
    return $return;
}
//-------------------------------------------------Add robots-----------------------------------------------------------
function newRobot(){
    $counter = $_GET['counter'];
    if($_SESSION["status"] == "admin"){
        for($i=0;$i<=$counter; $i++){
            $id = htmlspecialchars($_POST["robotID".$i]);
            $mdp = htmlspecialchars($_POST["robotPsw".$i]);
            $ip = htmlspecialchars($_POST["robotIP".$i]);
            $sections = ConnectBDD()->prepare("INSERT INTO ROBOT (id, mdp, ip)
                                       VALUES (:id, :mdp, :ip)");
            $sections->execute(array(':id' => $id, ':mdp' => md5($mdp), ':ip' => $ip));
        }
    }
    return '<h2 class="w3-center">Robots ajouté</h2>';
}
//________________________________________________ If robot is linked___________________________________________________
//Just to check if you are linked with a robot
function checkLinkedRobots(){
    $idRobot = ConnectBDD()->prepare("select id_robot, mdp
      from USER_ROBOT natural join ROBOT
      where id_user =".$_SESSION['user']);
    $idRobot->execute();
    $idRobotAnswer = $idRobot->fetchAll(PDO::FETCH_ASSOC);
    if($idRobotAnswer){
        $_SESSION['robotId'] = $idRobotAnswer[0]['id_robot'];
        $_SESSION['robotPasswd'] = $idRobotAnswer[0]['mdp'];
        return true;
    }else{
        return false;
    }
}
//__________________________________________________connect sockets_____________________________________________________
//Send commands to the raspberry on the Georges
function socket ($socket) {
    $idRobot = ConnectBDD()->prepare("SELECT ip FROM ROBOT where id = (SELECT id_robot FROM USER_ROBOT where id_user=".$_SESSION['user'].")");
	$idRobot->execute();
    $idRobotAnswer = $idRobot->fetchAll(PDO::FETCH_ASSOC);
    $host = $idRobotAnswer[0]['ip'];
	$port = 62900;
	$output=$socket;
	$socket1 = socket_create(AF_INET, SOCK_STREAM,0) or die("Could not create socket\n");
	socket_connect ($socket1 , $host,$port ) ;
	socket_write($socket1, $output, strlen ($output)) or die("Could not write output\n");
	socket_close($socket1) ;
}
//__________________________________________________See user____________________________________________________________
//Used in admin mode, show users
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

    if($_SESSION['status'] == "admin"){
        send('contenu', $tableau->html());
        send('dataTable', $tableau->id);
    }else{
        send('variable', 'Nice try');
    }
}
//__________________________________________________ See Robots ________________________________________________________
//Used in admin mode, show robots
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

    if($_SESSION['status'] == "admin"){
        send('contenu', $tableau->html());
        send('dataTable', $tableau->id);
    }else{
        send('variable', 'Nice try');
    }
}
//_________________________________________________ see Links __________________________________________________________
//Used in admin mode, show links between users and robots
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
    if($_SESSION['status'] == "admin"){
        send('contenu', $tableau->html());
        send('dataTable', $tableau->id);
    }else{
        send('variable', 'Nice try');
    }
}
//___________________________________________________ Admin delete in db _______________________________________________
//Used in admin mode, delete anything you clicked on
function deleteFromDb(){
    $id = $_GET['idDelete'];
    $type = $_GET['type'];
    if($_SESSION['status'] == "admin"){
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
    }else{
        send('variable', 'Nice try');
    }
}
//__________________________________________________creerVideos_________________________________________________________
//Displays the videos of your robot
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
//----------------------------------------Actual id for robots----------------------------------------------------------
function getActualId(){
    $db = ConnectBDD()->prepare("select max(id) from ROBOT");
    $db->execute();
    $sectionTab = $db->fetchAll(PDO::FETCH_ASSOC);
    return $sectionTab[0]['id'];
}
//__________________________________________________traiter request_____________________________________________________
//Used to manage clicks in the site
function traiteRequest($rq) {
    send('contenu', '');

    switch ($rq){
        case 'home' :
            //Back to the portal's home
            send('contenu', chargeAccueil());
            if($_SESSION['is']['connected'] == 1){
                send('user', ' ' . ucfirst($_SESSION['username']));
            }
            break;
        case 'contact' :
            //Contact page
            send('contenu', chargeTemplate($rq));
            break;
        case 'controls' :
            //Controls page
            if(checkLinkedRobots()){
                $templateControl = chargeTemplate($rq);
                $control = str_replace('#motionURL' , $_SESSION['robotId']."/".$_SESSION['robotPasswd']."/", $templateControl );
                send('contenu', $control);
            }else{
                send('contenu', chargeTemplate('noLinkedRobot'));
            }
            break;
        case 'robotLink' :
            //Controls page
            send('contenu', chargeTemplate($rq));
            break;
        case 'forum':
            //Opens forum
            send('contenu', chargeTemplate($rq));
            break;
        case 'testForm' :
            //Manage forms
            send('contenu', traiteForm());
            break;
        case 'login' :
            //Sign in page
            send('contenu', chargeTemplate($rq));
            break;
        case 'logout' :
            //Disconection
            $_SESSION['is']['connected'] = 0;
            $_SESSION['user'] = '';
            $_SESSION['status'] = '';
            $_SESSION['username'] = '';
            creeConnectedMenu();
            break;
        case 'signup' :
            //Sign up page
            send('contenu', chargeTemplate($rq));
            break;
        case 'users':
            //Admin use users list
            getUserlist();
            break;
        case 'robots':
            //Admin use robots list
            getRobotList();
            break;
        case 'robotLinks':
            //Admin use links list
            getRobotLinksList();
            break;
        case 'startPageViewed':
            //Set session variable
            if($_SESSION['startPageViewed']){
                $_SESSION['startPageViewed'] = false;
            }else{
                $_SESSION['startPageViewed'] = true;
            }
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
            //All the movements of Georges
		    socket($rq);
			break;
		case 'mesVideos' :
		    //Dipslays the saved videos
            if(checkLinkedRobots()){
                send('contenu', creerVideos());
            }else{
                send('contenu', chargeTemplate('noLinkedRobot'));
            }
            $titrePage = 'Georgesecurity - Videos';
			break;
        case 'deleteFromDb':
            //Delete from database
            deleteFromDb();
            break;
        case "addRobots":
            $actualId = getActualId();
            send("actualId", $actualId);
            send('variable', $actualId);
            send('contenu', chargeTemplate($rq));
            break;
        default : send('contenu', 'Requête inconnue : '.$_GET['rq']);
    }
}

?>

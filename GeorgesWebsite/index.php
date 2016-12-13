<?php
include_once 'INC/main.inc.php';

session_start();

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    traiteRequest('logout');
    $_SESSION['startPageViewed'] = false;
    send('reload', '');
}

if (!isset ($_SESSION['start'])) {
    $_SESSION["time"] = microtime(true);
    $_SESSION['start'] = microtime(true);
}

$titrePage  = 'Georgesecurity - Home';

$cookie_name = "vspdh";
// Random
$ticket = session_id().microtime().rand(0,9999999999);
// Hash
$ticket = hash('sha512', $ticket);

// record
setcookie($cookie_name, $ticket, time() + (60 * 20)); // Expire after 20min
$_SESSION['vspdh'] = $ticket;

if (isset($_COOKIE['ticket']) == isset($_SESSION['ticket']))
{
    //New ones, maximum security
    $ticket = session_id().microtime().rand(0,9999999999);
    $ticket = hash('sha512', $ticket);
    $_COOKIE['vspdh'] = $ticket;
    $_SESSION['vspdh'] = $ticket;
}
else
{
    // On détruit la session
    $_SESSION = array();
    session_destroy();
    header('location:index.php');
}


if (isset ($_GET['rq'])) {
    $_SESSION['rqLog'][time()]=$_GET['rq'];
    $envoi=[];
    traiteRequest($_GET['rq']);
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        session_unset();
        session_destroy();
        send('reload', '');
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
    die (json_encode($envoi));
}

else {
    creeConnectedMenu();
    if($_SESSION['startPageViewed'] == false){
        include 'INC/startPage.template.inc.php';
    }else{
        include 'INC/layout.html.inc.php';
    }
}

?>

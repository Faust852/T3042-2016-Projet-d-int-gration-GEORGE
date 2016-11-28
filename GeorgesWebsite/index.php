<?php
include_once 'INC/mesFonctions.inc.php';

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
    if($_SESSION['startPageViewed'] == true){
        include 'INC/layout.html.inc.php';
    }else{
        include 'INC/startPage.template.inc.php';
    }
}

?>

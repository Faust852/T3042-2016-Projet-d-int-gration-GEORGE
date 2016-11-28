<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <title>
        <?php echo $titrePage?>
    </title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
    <link rel="stylesheet" href="./CSS/w3.css">
    <link rel="stylesheet" href="./font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="./CSS/dialog.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="./CSS/site.css"/>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>
    <script src= './JS/index.js'></script>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-87263084-1', 'auto');
        ga('send', 'pageview');

    </script>
</head>

<body>
<div class="w3-top">
    <nav id="menu" class="">
        <?php
        //echo creeMenu($lesMenus['menu']);
        echo $envoi['menu'];
        ?>
    </nav>
</div>

<div id="global">

    <header id="entete">

        <h1>
            <?php echo $titreSite?>
        </h1>

    </header><!-- #entete -->



    <section id="contenu">
        <div id="contenuTitre"><?php echo $textLogo?></div>
        <div id="errorMessage" name="errorMessage"></div>
        <?php echo chargeAccueil();?>
    </section><!-- #contenu -->

    <div id="popUpDialog" class="deletingDialog" title="Delete?" style="display: none;">
        <p>Do you want to delete?</p>
    </div>

</div><!-- #global -->
</body>
</html>

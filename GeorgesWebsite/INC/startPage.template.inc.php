<!DOCTYPE html>
<html>
<title>Georges the little robot </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script
<script src="./JS/jquery.slicknav.js"></script>
<script src='./JS/index.js'></script>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-87263084-1', 'auto');
    ga('send', 'pageview');

</script>

<style>
    body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif;}
    body, html {
        height: 100%;
        color: #777;
        line-height: 1.8;
    }

    input[type=submit]{
        padding:5px 15px;
        font-size: 30px;
        background:#ccc;
        border:0 none;
        cursor:pointer;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        margin-top: 50px;
    }

    form{
        text-align: center;
    }

    input[type=submit]:hover{
        background: #8b8b8b;
    }

    /* Create a Parallax Effect */
    .bgimg-1, .bgimg-2, .bgimg-3 {
        opacity: 0.7;
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    /* First image (Logo. Full height) */
    .bgimg-1 {
        background-image: url("../IMG/robotHome.png");
        min-height: 100%;
    }

    .w3-wide {letter-spacing: 10px;}
    .w3-hover-opacity {cursor: pointer;}

    /* Turn off parallax scrolling for tablets and phones */
    @media only screen and (max-width: 1024px) {
        .bgimg-1, .bgimg-2, .bgimg-3 {
            background-attachment: scroll;
        }
    }
</style>
<body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
    <ul class="w3-navbar" id="myNavbar">
        <li><a href="#">HOME</a></li>
        <li style="float: right"><a href="index.php">Go to portal</a></li>
    </ul>
</div>

<!-- First Parallax Image with Logo Text -->
<div class="bgimg-1 w3-display-container">
    <div class="w3-display-middle" style="white-space:nowrap;">
        <span class="w3-center w3-padding-xlarge w3-black w3-xlarge w3-wide w3-animate-opacity"><span>Georges</span></span>
    </div>
</div>

<!-- Container (About Section) -->
<div class="w3-content w3-container w3-padding-64">
    <h3 class="w3-center">ABOUT US</h3>
    <p class="w3-center"><em>We love technology</em></p>
    <p style="text-align: center"t>We have created a Robot that secures your house while you're gone.
    </p>
    <div class="w3-row">
        <div class="w3-col m6 w3-center w3-padding-large">
            <p><b>Georges the little robot</b></p><br>
            <img src="/w3images/avatar_hat.jpg" class="w3-round w3-image w3-opacity w3-hover-opacity-off" alt="Coming soon" width="500" height="333">
        </div>

        <!-- Hide this text on small devices -->
        <div class="w3-col m6 w3-hide-small w3-padding-large">
            <p>Georges is a robot made to secure your house while you're gone. He is doing that by watching all around your house on it's own.
                If someone comes in Georges takes a picture and send you an email/sms with the picture he just took.
                The project is made by Dimitri Verdonck, Cyril Wastchenko, Marco Peters, Simon Ponchau, David Micciche and Adrien Culem</p>
        </div>
    </div>
    <p class="w3-large w3-center w3-padding-16">Im really good at:</p>
    <p class="w3-wide">Securing your house</p>
    <div class="w3-progress-container">
        <div class="w3-progressbar" style="width:100%"></div>
    </div>
    <p class="w3-wide">Making sure your house is fine</p>
    <div class="w3-progress-container">
        <div class="w3-progressbar" style="width:100%"></div>
    </div>
    <p class="w3-wide">Preventing your house from being robbed</p>
    <div class="w3-progress-container">
        <div class="w3-progressbar" style="width:100%"></div>
    </div>

    <!--<form method ='post' action="index.php" id="formPortal">
        <input type="submit" name="goToPortal" id="goToPortal" value="Go to portal" <?php $_SESSION['startPageViewed'] = true?>>
    </form>-->
</div>
<!-- Footer -->
<footer class="w3-center w3-black w3-padding-16 w3-opacity w3-hover-opacity-off">
    <div class="w3-xlarge w3-padding-32">
        <!--<a href="https://twitter.com/georgesecurity1" class="w3-hover-text-indigo"><i class="fa fa-facebook-official"></i></a>-->
        <a href="https://twitter.com/georgesecurity1" class="w3-hover-text-light-blue"><i class="fa fa-twitter"></i></a>
    </div>
</footer>

<script>
    // Modal Image Gallery
    function onClick(element) {
        document.getElementById("img01").src = element.src;
        document.getElementById("modal01").style.display = "block";
        var captionText = document.getElementById("caption");
        captionText.innerHTML = element.alt;
    }

    // Change style of navbar on scroll
    window.onscroll = function() {myFunction()};
    function myFunction() {
        var navbar = document.getElementById("myNavbar");
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
            navbar.className = "w3-navbar" + " w3-card-2" + " w3-animate-top" + " w3-white";
        } else {
            navbar.className = navbar.className.replace(" w3-card-2 w3-animate-top w3-white", "");
        }
    }
</script>

</body>
</html>

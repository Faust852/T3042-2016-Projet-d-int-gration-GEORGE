<!DOCTYPE html>
<html>
<title>Georgesecurity - Home pages</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="./CSS/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
<script
    src="http://code.jquery.com/jquery-1.10.2.min.js"
    integrity="sha256-C6CB9UYIS9UJeqinPHWTHVqh/E1uhG5Twh+Y5qFQmYg="
    crossorigin="anonymous"></script>
<script
    src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
    integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
    crossorigin="anonymous"></script>
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
        /*opacity: 0.7;*/
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    /* First image (Logo. Full height) */

    /*.bgimg-2{
        background-image: url("../IMG/ecoFriendly-min.jpg");
        min-height: 70%;
    }*/

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
        <li style="color: black;background-color: rgba(255, 255, 255, 0.56)"><a href="#">Home page</a></li>
        <li style="float: right;;background-color:rgba(255, 255, 255, 0.56); color: black;"><a href="javascript:void(startPageViewed());">Go to portal</a></li>
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
        <div class="w3-col m6 w3-center w3-card-12">
            <img src="/IMG/Georges-min.JPG" class="w3-round w3-image" alt="First Georges prototype" width="100%" height="333">
            <div class="w3-container w3-center">
                <p><b>First prototype of Georges</b></p><br>
            </div>
        </div>

        <!-- Hide this text on small devices -->
        <div class="w3-col m6 w3-padding-large">
            <p>Georges is a robot made to secure your house while you're gone. He is doing so by watching all around your house on it's own.
                If someone comes in Georges snaps a picture and send it you by email/sms with the picture he just took.
                This project was brought to life by Dimitri Verdonck, Cyril Wastchenko, Marco Peters, Simon Ponchau, David Micciche and Adrien Culem.</p>
        </div>
    </div>
    <p class="w3-large w3-center w3-padding-16">I'm really good at:</p>
    <p class="w3-myfont w3-xlarge">Securing your house</p>
    <div class="w3-progress-container">
        <div class="w3-progressbar" style="width:100%"></div>
    </div>
    <p class="w3-myfont w3-xlarge">Making sure your house is fine</p>
    <div class="w3-progress-container">
        <div class="w3-progressbar" style="width:100%"></div>
    </div>
    <p class="w3-myfont w3-xlarge">Preventing your house from being robbed</p>
    <div class="w3-progress-container">
        <div class="w3-progressbar" style="width:100%"></div>
    </div>

    <p style="text-align: center; margin-top: 60px"t>If you want to connect yourself or create an account for Georges. Go to the portal right here.</p>
    <h3 class="w3-center"><a href="javascript:void(0);" onclick='startPageViewed();'>Go to portal</a></h3>

</div>
<!--<div class="bgimg-2 w3-display-container">
</div>
<div class="w3-content w3-container w3-padding-64">
    <h3 class="w3-center">Eco friendly</h3>
    <p style="text-align: center"t>We wanted Georges to be as eco-responsible as possible</p>
    <div class="w3-col m6 w3-padding-large w3-center">
        <p>Yet to be written</p>
    </div>
</div>-->
<!-- Footer -->
<footer class="w3-center w3-black w3-padding-16 w3-opacity w3-hover-opacity-off">
    <div class="w3-xlarge">
        <a href="https://twitter.com/georgesecurity1" class="w3-hover-text-light-blue"><i class="fa fa-twitter"></i></a>
    </div>
    <div>
        Contact us at : <a href="mailto:info@georgesecurity.me" target="_top"> info@georgesecurity.me</a>
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

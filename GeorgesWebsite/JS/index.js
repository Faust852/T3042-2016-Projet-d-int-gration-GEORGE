//Made by Adrien Culem
function traiteRetour(objetJS){
    $.map( objetJS, function(val, i) {
        switch (i) {
            case 'menu' :
                //$('.' + 'slicknav_nav').html(val);
                location.reload();
                break;
            case 'mdpConcord':
                $('#' + i).html(objetJS[i]);
                break;
            case 'user':
                $('#' + i).html(objetJS[i]);
                break;
            case 'emailConcord':
                $('#' + i).html(objetJS[i]);
                break;
            case 'pseudoExists':
                $('#' + i).html(objetJS[i]);
                break;
            case 'sous-menu' :
                $('#' + i).html(objetJS[i]);
                break;
            case 'contenu' :
                $('#' + i).html(objetJS[i]);
                break;
            case 'connectionFailed':
                $('#' + i).css( "display", "block" )
                $('#' + i).html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>' + ' ' + objetJS[i]);
                break;
            case 'variable':
                console.log(objetJS[i]);
                break;
            case 'dataTable':
                $('#' + objetJS[i]).DataTable();
                break;
            case 'reload':
                location.reload();
                break;
            default :
                alert('Err.retour : cas non traité ...' + i);
        }
    });

}

function mailOk(mail){
    var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
    return reg.test(mail);
}

function sendKey(e){
    $.get('index.php', 'rq=' + e, function (result) {
    });
}

function sendStop(){
    $.get('index.php', 'rq=stop', function (result) {
    });
}

function sendAuto() {
    $.get('index.php', 'rq=auto', function (result) {
    });
}

function sendId(id, type){
    $('#popUpDialog').css('display: block');
    $('#popUpDialog').dialog({
        modal: true,
        width: 350,
        height: 140,
        autoOpen: true,
        buttons: [
            {
                text: 'Yes, proceed!',
                open: function() { $(this).addClass('yescls') },
                click: function() {$.get('index.php', 'rq=deleteFromDb&idDelete=' + id + '&type=' + type, function (result) {
                    console.log(result);
                    traiteRetour(JSON.parse(result));
                });
                    $(this).dialog("close");}
            },
            {
                text: "Cancel",
                open: function() { $(this).addClass('cancelcls') },
                click: function() {$(this).dialog("close");}
            }
        ],


    }).prev(".ui-dialog-titlebar").css("background","#CD2626");
}

function startPageViewed(){
    $.get('index.php', 'rq=startPageViewed', function (result) {
    });
}
var no4tabs = 0;
function menuClick(a){
    e = $(a);
    var rq= e.attr('href').split('.')[0];
    switch(rq) {
        case 'users':
            document.title = 'Georgesecurity - Users';
            break;
        case 'robots':
            document.title = 'Georgesecurity - Robots';
            break;
        case 'robotLinks':
            document.title = 'Georgesecurity - Links';
            break;
        case 'login':
            document.title = 'Georgesecurity - Sign in';
            break;
        case 'signup':
            document.title = 'Georgesecurity - Sign Up';
            break;
        case 'contact':
            document.title = 'Georgesecurity - Contact';
            break;
        case 'home':
            document.title = 'Georgesecurity - Home';
            break;
        case 'video':
            document.title = 'Georgesecurity - Controls';
            break;
        case 'adminRobot':
            document.title = 'Georgesecurity - Link your robot';
            break;
        case 'mesVideos':
            document.title = 'Georgesecurity - Videos';
            break;

    }
    //For firefox
    if(rq == "chat") {
        if (no4tabs == 0) {
            newTab();
            no4tabs++;
            if (typeof InstallTrigger !== 'undefined') {
                location.reload();
            }
        } else {
            no4tabs = 0;
        }
    }else{
        $.get('index.php', 'rq=' + rq, function (result) {
            traiteRetour(JSON.parse(result));
        })
    }
    return false;
}

function sendForm(a){
    var rq = $(a).attr('action').split('.')[0];
    console.log(rq);
    var monFormData = new FormData($('form')[0]);
    $.ajax({
        url: 'index.php?' + 'rq=' + rq + '&submit=' + $(a).attr('id'),
        type: 'POST',
        data: monFormData,
        contentType: false,
        processData: false,
        dataType: 'html',
        success: function (data) {
            traiteRetour(JSON.parse(data));
        }
    });
    return false;
}

function newTab() {
    var form = document.createElement("form");
    form.method = "GET";
    form.action = "http://georgesecurity.me/chat.html";
    form.target = "_blank";
    document.body.appendChild(form);
    form.submit();
}

function sideMenu() {
    var x = document.getElementById("demo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

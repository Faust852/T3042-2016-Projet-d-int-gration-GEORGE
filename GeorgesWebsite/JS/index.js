$(document).ready(function(){
    $('#usersList').DataTable();
    $(function(){
        $('#menu').slicknav({
            label: 'Menu',
            brand: 'Georges',
            closeOnClick: true,
            easingOpen: 'swing'
        });
    });


});
//
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

function sendAuto(){
    $.get('index.php', 'rq=auto', function (result) {
    });
}




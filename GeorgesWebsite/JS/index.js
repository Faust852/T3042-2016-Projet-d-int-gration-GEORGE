//
function traiteRetour(objetJS) {
    //What is returned from the php
    $.map(objetJS, function (val, i) {
        switch (i) {
            case 'menu' :
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
                $('#' + i).css("display", "block")
                $('#' + i).html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>' + ' ' + objetJS[i]);
                break;
            case 'variable':
                console.log(objetJS[i]);
                break;
            case 'actualId':
                $('#' + i).html(objetJS[i]);
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

function sendKey(e){
    //Send movements to georges
    $.get('index.php', 'rq=' + e, function (result) {
    });
}

function sendStop(){
    //Send stop to georges
    $.get('index.php', 'rq=stop', function (result) {
    });
}

function sendAuto() {
    //Set auto mode for Georges
    $.get('index.php', 'rq=auto', function (result) {
    });
}

function sendId(id, type){
    //Admin used
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
    //For users not to see the presentation website when they are connected
    $.get('index.php', 'rq=startPageViewed', function (result) {
    });
    setTimeout(function(){
        location.reload();
    }, 500);
}

function menuClick(a){
    e = $(a);
    var rq= e.attr('href').split('.')[0];
    //Show the right title
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
            document.title = 'Georgesecurity - Portal';
            break;
        case 'controls':
            document.title = 'Georgesecurity - Controls';
            break;
        case 'robotLink':
            document.title = 'Georgesecurity - Link your robot';
            break;
        case 'mesVideos':
            document.title = 'Georgesecurity - Videos';
            break;

    }
    //open new tab with forum
    if(rq == "forum") {
        newTab();
    }else{
        $.get('index.php', 'rq=' + rq, function (result) {
            traiteRetour(JSON.parse(result));
        })
    }
    return false;
}

function sendForm(a){
    //Send forms to php
    var rq = $(a).attr('action').split('.')[0];
    var formType = $(a).attr('id');
    var monFormData = new FormData($('form')[0]);
    if(formType == "sendNewAccount"){
        var x = 0;
        var y = '';
        if($("#signupPassword").val() !== $("#verifMdp").val()){
            x++;
            y += 'Les mots de passes sont différents';
        }
        if($("#email").val() !== $("#verifEmail").val()){
            x++;
            y += '<br>Les emails sont différentes';
        }
        if(x > 0){
            $('#connectionFailed').css("display", "block");
            $('#connectionFailed').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ' + y);
        }else{
            $.ajax({
                url: 'index.php?' + 'rq=' + rq + '&submit=' + formType,
                type: 'POST',
                data: monFormData,
                contentType: false,
                processData: false,
                dataType: 'html',
                success: function (data) {
                    traiteRetour(JSON.parse(data));
                }
            });
        }
    }else if(formType == "sendAddRobots"){
        console.log(counter);
        $.ajax({
            url: 'index.php?' + 'rq=' + rq + '&submit=' + formType + '&counter=' + counter,
            type: 'POST',
            data: monFormData,
            contentType: false,
            processData: false,
            dataType: 'html',
            success: function (data) {
                traiteRetour(JSON.parse(data));
            }
        });
    }else{
        $.ajax({
            url: 'index.php?' + 'rq=' + rq + '&submit=' + formType,
            type: 'POST',
            data: monFormData,
            contentType: false,
            processData: false,
            dataType: 'html',
            success: function (data) {
                traiteRetour(JSON.parse(data));
            }
        });
    }
    return false;
}

function newTab() {
    //Create the new tab
    var form = document.createElement("form");
    form.method = "GET";
    form.action = "https://georgesecurity.me/chat.html";
    form.target = "_blank";
    document.body.appendChild(form);
    form.submit();
}

function sideMenu() {
    //Shows side menu and hide big one
    var x = document.getElementById("demo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}

function capitalizeFirstLetter(string) {
    //Capitalize first letter of a string
    return string.charAt(0).toUpperCase() + string.slice(1);
}

var counter = 0;
function duplicateFields(){
    $('#addRobotsFields').append(
        '<div class="w3-row w3-section addRobotsDivLeft">' +
            '<div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>' +
            '<div class="w3-rest">' +
                '<input class="w3-input w3-border" type="text" name="robotID' + counter +'" id="robotID' + counter +'" placeholder="robotID" required>' +
            '</div>' +
        '</div>' +

        '<div class="w3-row w3-section addRobotsDivLeft">' +
            '<div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>' +
            '<div class="w3-rest">' +
                '<input class="w3-input w3-border" type="password"  name="robotPsw' + counter +'" id="robotPsw' + counter +'" placeholder="robotPsw" required>' +
            '</div>' +
        '</div>' +

        '<div class="w3-row w3-section addRobotsDivLeft">' +
            '<div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>' +
            '<div class="w3-rest">' +
                '<input class="w3-input w3-border" type="text" name="robotIP' + counter +'" id="robotIP' + counter +'" placeholder="robotIP" required>' +
            '</div>' +
        '</div>'
    )
    counter++;
}

function showContent(a){
    if(a == 0){
        document.getElementsByClassName("w3-dropdown-content")[a].style.display = 'block';
        document.getElementsByClassName("w3-dropdown-content")[1].style.display = 'none';
    }else if(a == 1){
        document.getElementsByClassName("w3-dropdown-content")[a].style.display = 'block';
        document.getElementsByClassName("w3-dropdown-content")[0].style.display = 'none';
    }else{
        try{
            document.getElementsByClassName("w3-dropdown-content")[1].style.display = 'none';
            document.getElementsByClassName("w3-dropdown-content")[0].style.display = 'none';
        }catch(e){

        }
    }
}

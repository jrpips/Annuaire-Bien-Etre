var GpAnnuaire = GpAnnuaire || {
    headerColor: function () {
        if ($(window).scrollTop() === 0) {
            $('header').attr('header-transparent');
            $('.header-wrapper').css('background-color', 'transparent');
        } else {
            $('header').removeAttr('header-transparent');
            $('.header-wrapper').css('background-color', 'rgba(0, 159, 139, 0.9)');
        }
    },
    subscribe: function () {
    },
    connection: function () {
    }
};
var GpPopup = {
    'construct': function () {
        var html = [];
        var i = 0;
        var home = "'home'";
        html[i++] = '<section id="popup">';

        //titre Popup
        html[i++] = '<header><h3>Connection<button type="button" id="cancel" class="close" data-dismiss="modal">&times;</button></h3></header>';
        //content Popup
        html[i++] = '<section id="body">';
        html[i++] = '<form action="{{ path(' + home + ') }}" method="post">';
        html[i++] = '<div>';
        html[i++] = '<label for="mail">Email</label><input type="text" id="mail" class="required">';
        html[i++] = '</div>';
        html[i++] = '<div>';
        html[i++] = '<label for="nom">Mot de passe</label><input type="password" id="pwd" >';
        html[i++] = '</div>';
//        html[i++] = '<div>';
//        html[i++] = '<label for="sujet">Sujet *</label><input type="text" id="mail" class="required" data-minLength="5">';
//        html[i++] = '</div>';
//        html[i++] = '<div>';
//        html[i++] = '<label for="msg">Message *</label><textarea id="msg" class="required" data-minLength="10"></textarea>';
//        html[i++] = '</div>';
        html[i++] = '<div>';
        html[i++] = '<input type="submit" class="btn btn-default" id="cmdSend" value="Envoyer" />';
        html[i++] = '</div>';
        html[i++] = '</form>';
        html[i++] = '</section>';

        html[i++] = '</section>';

        $('body').append(html.join(''));
        $('body').append('<div id="modale"></div>');
    },
    'event': function () {
    },
    'display': function (e) {

        var event = e.currentTarget;
        var eventId = event.id
        console.log(eventId);

        if (eventId == 'subscribe') {
            var height = '500px';
            $('#popup h3').empty().prepend('Inscription');
            $('#subscribeForm').css('display', 'block');
            $('#connectForm').css('display', 'none');
        } else {
            var height = '330px';
            $('#popup h3').empty().prepend('Connection');
            $('#subscribeForm').css('display', 'none');
            $('#connectForm').css('display', 'block');
        }
        $('#popup h3').append('<button type="button" id="cancel" class="close" data-dismiss="modal">&times;</button>');
        $('#popup').css({'height': height});
        var top = $(window).scrollTop() + (($(window).height() - $('#popup').height()) / 2);
        var right = ($(window).width() - $('#popup').width()) / 2;

        //Affichage de la Popup
        console.log(top, $(window).scrollTop(), $(window).height(), $('html:eq(0)').height(), $('#popup').height());
        $('#popup').css({top: top, 'right': right}).slideDown('slow').find(':text,textarea').first().focus();
        $('#modale').fadeIn();
        $('#cancel').on('click', GpPopup.hide);

    },
    'send': function () {
    },
    'hide': function () {
        $('#modale').hide();
        $('#popup').hide('fast');
    }
};
$(function () {
    document.getElementsByTagName('body')[0].onscroll = GpAnnuaire.headerColor;
    setInterval(GpAnnuaire.headerColor, 2000);
    $('#body form:eq(1)').attr('id','subscribeForm');
    $('#gp_menu #subscribe').on('click', function (e) {
        GpPopup.display(e)
    });
    $('#gp_menu #connection').on('click', function (e) {
        GpPopup.display(e)
    });
});



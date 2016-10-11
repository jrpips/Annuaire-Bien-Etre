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
    
    'display': function (e) {

        var event = e.currentTarget;
        var eventId = event.id
        console.log(eventId);

        if (eventId == 'subscribe') {
            var height = '400px';
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
    },
    gpAjax: function () {
        var inputVal = $('#subscribeForm #form_adresseRue').val();
        console.log('ok');
        $.ajax({
            type: "POST",
            data:inputVal,
            url: generate('login'),
            dataType: 'json',
            success: function (data) {
                console.log(data);
            }
        });
    }
};

$(function () {
    document.getElementsByTagName('body')[0].onscroll = GpAnnuaire.headerColor;
    setInterval(GpAnnuaire.headerColor, 2000);
    $('#body form:eq(1)').attr('id', 'subscribeForm');
    
    $('#gp_menu #subscribe').on('click', function (e) {GpPopup.display(e)});
    $('#gp_menu #connection').on('click', function (e) {GpPopup.display(e)});
    
    $('#body form:eq(0)').attr('id', 'connectForm').append('<button id="cmdSend" class="btn btn-default">Envoyer</button>');
    $('#body form:eq(1)').attr('id', 'subscribeForm').append('<button id="cmdSend" class="btn btn-default">Envoyer</button>');

    $('#subscribeForm #form_adresseRue').on('keyup',function(e){gpAjax(e)});
    $('#subscribeForm #form_adresseNumero').on('keyup',function(e){gpAjax(e)});
    $('#subscribeForm #form_email').on('keyup',function(e){gpAjax(e)});
    $('#subscribeForm').on('submit',function(e){gpAjax(e)});
});



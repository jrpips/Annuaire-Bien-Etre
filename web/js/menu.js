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
    subscribe: function (data) {
        console.log(data);
        if (data.valide) {
            console.log('inscription validée!');
            $('#body').html('<div class="valide">Un email de confirmation a été envoyé à cette adresse:<span>' + data.values.sign_up.email + '</span></div>');
            setTimeout(function(){
                GpPopup.hide();
                
            },3000);
        }
        else {
            $('.error').remove();
            for (item in data.errors) {
                console.log(item, data.errors[item][0]);
                $('#sign_up_' + item).parent().append('<div class="error">' + data.errors[item][0] + '</div>');
            }
        }
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
            data: inputVal,
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
    setInterval(GpAnnuaire.headerColor, 5000);
    $('#body form:eq(1)').attr('id', 'subscribeForm');

    $('#gp_menu #subscribe').on('click', function (e) {
        GpPopup.display(e)
    });
    $('#gp_menu #connection').on('click', function (e) {
        GpPopup.display(e)
    });
    $('#gp_menu #connection').on('keypress', function (e) {
        $('#connexion').get(0).click();
    });

    $('#body form:eq(1) button').attr({'class': 'btn btn-default', 'id': 'cmdSend'});

    $('#subscribeForm').on('submit', function (e) {
        gpAjax(e)
    });

});



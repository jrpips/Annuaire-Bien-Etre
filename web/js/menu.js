var GpAnnuaire = GpAnnuaire || {
    /**
     * view : init menu -> etat : user anonymous
     *
     */
    init:function(){
        for(var i=1;i<5;i++) {
            var etat=(i<3)?'block':'none';
            $('#myNavBar li:nth-child(i)').css({'display':etat});
        }
    },
    /**
     * view : gestion du background-color de la  nav selon l'état du scroll
     * 
     **/
    headerColor: function () {
        if ($(window).scrollTop() === 0) {
            $('header').attr('header-transparent');
            $('.header-wrapper').css('background-color', 'transparent');
        } else {
            $('header').removeAttr('header-transparent');
            $('.header-wrapper').css('background-color', 'rgba(0, 159, 139, 0.9)');
        }
    },
    /**
     * view : traitement réponse soumission popup['s'inscrire','se connecter']
     * 
     **/
    subscribe: function (data) {

        if (data.valide) {
            $('#body').html('<div class="valide">Un email de confirmation a été envoyé à cette adresse:<span>' + data.values.sign_up.email + '</span></div>');

            setTimeout(function () {
                GpPopup.hide();
            }, 3000);
        }
        else {
            $('.error').remove();

            for (item in data.errors) {
                $('#sign_up_' + item).parent().append('<div class="error">' + data.errors[item][0] + '</div>');
            }
        }
    }
};
var GpPopup = GpPopup || {
    /**
     * view:construction et affichage popup['s'inscrire','se connecter'] 
     * 
     **/
    'display': function (e) {

        var event = e.currentTarget;
        var eventId = event.id

        if (eventId == 'subscribe') {

            var height = '400px';

            $('#popup h3').empty().prepend('Inscription');
            $('#subscribeForm').css('display', 'block');
            $('#connectConteneur').css('display', 'none');

        } else {

            var height = '330px';

            $('#popup h3').empty().prepend('Connection');
            $('#subscribeForm').css('display', 'none');
            $('#connectConteneur').css('display', 'block');

        }

        $('#popup h3').append('<button type="button" id="cancel" class="close" data-dismiss="modal">&times;</button>');
        $('#popup').css({'height': height});

        var top = $(window).scrollTop() + (($(window).height() - $('#popup').height()) / 2);
        var right = ($(window).width() - $('#popup').width()) / 2;

        //Affichage de la Popup

        $('#popup').css({top: top, 'right': right}).slideDown('slow').find(':text,textarea').first().focus();
        $('#modale').fadeIn();
        $('#cancel').on('click', GpPopup.hide);
        $('#popup').css({'height': 'auto'});

    },
    /**
     * view:hide de la nav popup['s'inscrire','se connecter']
     * 
     **/
    'hide': function () {

        $('#modale').hide();
        $('#popup').hide('fast');
    },
    /**
     * model:ajaxBuilder
     * 
     * moteur AJAX //en construction
     * 
     */
    'ajaxBuilder': function (param) {

        $.ajax({
            type: param.METHODE,
            data: param.VALUES,
            url: Routing.generate(param.ROUTE, {values: param.VALUES}),
            dataType: param.TYPE,
            beforeSend: param.function.beforeSEND,
            success: param.function.SUCCESS
        });
    },
    /**
     * model:ajax for nav popup['s'inscrire','se connecter']
     * 
     **/
    'ajaxPreSignup': function (e) {

        e.preventDefault();

        var $form = $('form');
        var values = {};

        $.each($form.serializeArray(), function (i, field) {
            values[field.name] = field.value;
        });
//        console.log('ok', values);
//        id = e.currentTarget.id;
//        inputVal = $('#subscribeForm #' + id).val();

        $.ajax({
            type: "POST",
            data: values,
            url: Routing.generate('signup', {values: values}),
            dataType: 'json',
            success: function (data) {
                GpAnnuaire.subscribe(data);
            }
        })
    },
    /**
     * model:ajax for nav popup['s'inscrire','se connecter']
     * 
     **/
    'ajaxConnection': function (e) {

        e.preventDefault();

        var $form = $('#connectForm');console.log($form);
        var values = {};

        $.each($form.serializeArray(), function (i, field) {
            values[field.name] = field.value;
        });
        console.log('ok', values);
        //id = e.currentTarget.id;
        //inputVal = $('#subscribeForm #' + id).val();

        $.ajax({
            type: "POST",
            //data: values,
            url: Routing.generate('login_check'),// {values: values}),
            dataType: 'json',
            success: function (data) {
               console.log(data);
            }
        })
    },
    /**
     * model:ajax for autocomplete form[internaute][adresseUtilisateur]
     * 
     **/
    'gpAjaxFinalSignup': function (e) {

        e.preventDefault();

        event_id = e.currentTarget.id;

        if ($('#' + event_id).val().length === 4) {

            $.ajax({
                type: "POST",
                data: {'valeur': $('#' + event_id).val()},
                dataType: 'json',
                url: Routing.generate('autocomplete'),
                beforeSend: function () {

                    if ($('.loader').length === 0) {
                        $('#' + event_id).parent().append('<div class="loader"><img src="http://127.0.0.1/Annuaire-Bien-Etre/web/image/Loading_icon.gif"/></div>');
                    }

                    $('#' + event_id + ' option').remove();
                    console.log(event_id, 'rr');
                },
                success: function (data) {

                    $('.loader').remove();

                    var prefix = event_id;
                    var event_id_length = event_id.length - 10;
                    event_id = prefix.substring(0, event_id_length);

                    $('#' + event_id + 'commune option').remove();

                    $.each(data.communes, function (index, value) {

                        $('#' + event_id + 'commune').append($('<option>', {value: value, text: value}));

                    });

                    $('#' + event_id + 'localite').val(data.province);

                }
            });
        } else {

//            $('#' + event_id + ' option').remove();
            $('#' + event_id).append($('<option>', {value: 'error', text: 'Aucunes communes ne correspondent à ce code postal!'}));
        }
    }
};
/**
 * 
 * 
 **/
$(function () {//controller

    /**
     * Event to nav background-color                        
     * 
     * function(): GpAnnuaire.headerColor
     * 
     **/

    document.getElementsByTagName('body')[0].onscroll = GpAnnuaire.headerColor;

    setInterval(GpAnnuaire.headerColor, 5000);

    GpAnnuaire.init();


    /**
     * Events to display popup['s'inscrire','se connecter']  
     * 
     * function(): GpPopup.display
     * 
     **/

    $('.gp_menu #subscribe').on('click', function (e) {
        GpPopup.display(e)
    });

    $('.gp_menu #connection').on('click', function (e) {
        GpPopup.display(e)
    });
    //    $('.gp_menu #connection').on('keypress', function (e) {//test simulation click
    //        $('#connexion').get(0).click();
    //    });


    /**
     * Event to submit data field's popup['s'inscrire','se connecter']
     * 
     **/

    $('form[name=sign_up]').on('submit', function (e) {
        console.log('submit');
        GpPopup.ajaxPreSignup(e);
    });
    $('#connectForm').on('submit', function (e) {
        GpPopup.ajaxConnection(e);
    });

    /**
     * Events from form Internaute[code_postal] to find commune and localite
     *
     */

    $('#internaute_utilisateur_adresseUtilisateur_codePostal').on('change', function (e) {
        GpPopup.gpAjaxFinalSignup(e);
        console.log('ok');
    });

//    $('#internaute_utilisateur_adresseUtilisateur_codePostal').on('keyup', function (e) {
//        GpPopup.gpAjaxForSignUp(e);
//        console.log('oky');
//    });

    /**
     * Events from form Prestataire[code_postal] to find commune and localite
     *
     */

    $('#prestataire_utilisateur_adresseUtilisateur_codePostal').on('change', function (e) {
        GpPopup.gpAjaxFinalSignup(e);
    });

//    $('#prestataire_utilisateur_adresseUtilisateur_codePostal').on('keyup', function (e) {
//        GpPopup.gpAjaxForSignUp(e);
//    });


    /**
     * DOM manipulations
     * 
     **/

    //add référence id to popup['s'inscrire']

    $('#body form:eq(1)').attr('id', 'subscribeForm');


    //button submit popup['s'inscrire','se connecter']

    $('#body form:eq(1) button').attr({'class': 'btn btn-default', 'id': 'cmdSend'});


    //checkox form[internaute][newsletter] -> hack construct mistake checbok for field newsletter -> <label><input type=checkox/></label>

    //$('.checkbox').empty();

    //$('.checkbox').append('<input type="checkbox" id="utilisateur_internaute_newsletter" name="utilisateur[internaute][newsletter]" value="0"><label>Recevoir la newsletter</label>');


    //    $('#utilisateur_adresseUtilisateur_commune').on('change', function (e) {
    //        gpAjaxForSignUp(e);
    //        console.log('e2');
    //    });
    //    $('#utilisateur_adresseUtilisateur_localite').on('change', function (e) {
    //        gpAjaxForSignUp(e);
    //        console.log('e3');
    //    });


});



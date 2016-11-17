var GpAnnuaire = GpAnnuaire || {
        /**
         *  view : init menu -> etat : user anonymous
         *
         */
        init: function () {
            /* menu principal : display des boutons [s'inscrire] & [se connecter] */
            for (var i = 1; i < 5; i++) {
                var etat = (i < 3) ? 'block' : 'none';
                $('#myNavBar li:nth-child(' + i + ')').css({'display': etat});
            }
            /**
             **  jquery pour customiser input[type=file]
             **
             **/

            /* ajout des classes au formulaire et l'input type file */

            $('input[type=file]').attr({'class': 'input-file'});//masque l'input file par défaut
            $('input[type=file]').parent().attr({'class': 'input-file-container'});
            $('.input-file-container label').attr({'class': 'input-file-trigger'});
        },
        /**
         **  view : gestion du background-color de la  nav selon l'état du scroll
         **
         **/
        headerColor: function () {
            if ($(window).scrollTop() === 0) {//scroll null

                $('header').attr('header-transparent');
                $('.header-wrapper').css({'background-color': 'transparent'});

            } else {//scroll actif

                $('header').removeAttr('header-transparent');
                $('.header-wrapper').css('background-color', 'rgba(100, 100, 128,0.4)');
            }//TODO couleur police nav pages != index
        },
        /**
         **  view : traitement réponse soumission popup['s'inscrire','se connecter']
         **
         **/
        subscribe: function (data) {

            if (data.valide) {

                $('.error').remove();

                $('[type=submit]')//ajout de la balise contenant le message de validation
                    .parent()
                    .parent()
                    .append('<div class="message"><i class="glyphicon glyphicon-send"></i> Un email de confirmation a été envoyé l\'adresse <br><span>' + data.values.sign_up.email + '</span></div>')
                ;
                $('#body div.message').css({'display': 'block'}).slideDown('slow');

                setTimeout(function () {//aprés 5s

                    $('#body div.message').remove();

                    GpAnnuaire.resetForm('#body');//reset du formulaire
                    GpAnnuaire.hide();//retrait de la popup

                }, 5000);
            }
            else {

                $('.error').remove();

                for (item in data.errors) {
                    $('#sign_up_' + item).parent().append('<div class="error">' + data.errors[item][0] + '</div>');
                }
            }
        },
        resetForm: function (element) {// param element --> form.parent()

            var form = $(element + ' form input');
            //TODO 1.a boucle avec un tableau des types input
            $(element + ' input[type=text]').each(function (index) {//TODO 1.b insérer dynamiquement les différents types
                $(this).val('');
            });
        },
        /**
         **  view : construction et affichage popup['s'inscrire','se connecter']
         **
         **/
        'display': function (e) {

            var event = e.currentTarget;
            var eventId = event.id

            if (eventId == 'subscribe') {//récupére l'id qui renseigne le type de form à afficher

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

            /**
             **  Calcul de la position top & right pour un afichage centré
             **/

            var top = $(window).scrollTop() + (($(window).height() - $('#popup').height()) / 2);//TODO régler centrage onscroll
            var right = ($(window).width() - $('#popup').width()) / 2;

            /**
             **  Affichage de la Popup
             **/

            $('#popup').css({top: top, 'right': right}).slideDown('slow').find(':text,textarea').first().focus();
            $('#modale').fadeIn();
            $('#cancel').on('click', GpAnnuaire.hide);
            $('#popup').css({'height': 'auto'});

        },
        /**
         **  view : retrait de la nav popup['s'inscrire','se connecter']
         **
         **/
        'hide': function () {

            $('#modale').hide('slow');
            $('#popup').hide('slow');
        },
        /**
         **  model : ajaxBuilder
         **
         **  moteur AJAX //en construction
         **
         **/
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
         **  model : ajax for nav popup['s'inscrire','se connecter']
         **
         **/
        'ajaxPreSignup': function (e) {

            e.preventDefault();

            var $form = $('form');
            var values = {};

            $.each($form.serializeArray(), function (i, field) {
                values[field.name] = field.value;
            });

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
         **  model : ajax for nav popup['s'inscrire','se connecter']
         **
         **/
        'ajaxConnection': function (e) {

            e.preventDefault();

            var $form = $('#connectForm');
            console.log($form);
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
                url: Routing.generate('login_check'), // {values: values}),
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                }
            })
        },
        /**
         **  model : moteur de recherche -> prestataire
         **/
        'ajaxSearchPrestataire': function (e) {
            e.preventDefault();

            var $form = $('#searchPrestataire');
            var values = {};
            console.log($form);
            $.each($form.serializeArray(), function (i, field) {
                values[field.name] = field.value;
            });
            console.log('ok', values);
            var event_id = e.currentTarget.id;
            console.log(event_id);
            $.ajax({
                type: "POST",
                data: {nom: $('#' + event_id).val()},
                url: Routing.generate('search_nom_prestataire'),
                dataType: 'json',
                success: function (data) {
                    console.log(data);
//                for(a in data.prestataire){
//                console.log(a);}
                }
            })
        },
        /**
         **  model : ajax for autocomplete form[internaute][adresseUtilisateur]
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
                $('#' + event_id).append($('<option>', {
                    value: 'error',
                    text: 'Aucunes communes ne correspondent à ce code postal!'
                }));
            }
        },
        'ajaxCommentaire': function (e) {
            console.log(e);
            e.preventDefault();

            var $form = $('form[name=commentaire]');
            var values = {};
            console.log($form);
            $.each($form.serializeArray(), function (i, field) {
                values[field.name] = field.value;
            });
            console.log('ok', values, $('#nom').text());

            $.ajax({
                type: "POST",
                data: values,
                url: Routing.generate('add_comment', {'prestataire_nom': $('#nomPrestataire').text()}),
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (!data.valide) {

                        $('.errorCommentaire').remove();

                        for (item in data.errors) {
                            $('#commentaire_' + item).parent().append('<div class="errorCommentaire" >' + data.errors[item][0] + '</div>');
                        }
                    }
                }
            })
        },
        'ajaxContactPrestataire': function (e) {
            console.log(e);
            e.preventDefault();

            var $form = $('form[name=contact_prestataire]');
            var values = {};
            console.log($form);
            $.each($form.serializeArray(), function (i, field) {
                values[field.name] = field.value;
            });
            console.log('ok', values, $('#nomPrestataire').text());

            $.ajax({
                type: "POST",
                data: values,
                url: Routing.generate('add_comment', {'prestataire_nom': $('#nomPrestataire').text()}),
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (!data.valide) {

                        $('.errorCommentaire').remove();

                        for (item in data.errors) {
                            $('#contact_prestataire_' + item).parent().append('<div class="errorCommentaire" >' + data.errors[item][0] + '</div>');
                        }
                    }
                }
            })
        },
        'checkTypeImg': function () {

            var allowedTypes = ['png', 'jpg', 'jpeg'];//extensions attendues

            var files = this.files,
                imgType;

            imgType = files[0].name.split('.');//1.a
            imgType = imgType[imgType.length - 1];//1.b récupération de l'extension du fichier reçu

            if (allowedTypes.indexOf(imgType) != -1) {//si l'extension est valide...
                GpAnnuaire.createThumbnail(files[0]);
            }
        },
        createThumbnail: function (file) {

            var reader = new FileReader();

            var $reader = $(reader);

            $reader.on('load', function () {
                $('.input-file-trigger').css({'backgroundImage': "url(" + this.result + ")"});
            });

            reader.readAsDataURL(file);
        },
        starCotationFormCommentaire: function () {
            for (i = 1; i < 11; i++) {

                $('#rating-' + i).on('click', function () {
                    $('#rating-' + i).attr('data', 'toto');
                    console.log('ok');
                });
            }
        }
    };
/**
 **
 **
 **/
$(function () {//controller

    /**
     **  Event to nav background-color
     **
     **  function(): GpAnnuaire.headerColor
     **
     **/

    document.getElementsByTagName('body')[0].onscroll = GpAnnuaire.headerColor;

    setInterval(GpAnnuaire.headerColor, 5000);

    GpAnnuaire.init();

    /**
     **  Events to display popup['s'inscrire','se connecter']
     **
     **  function(): GpAnnuaire.display
     **
     **/

    $('.gp_menu #subscribe').on('click', function (e) {
        GpAnnuaire.display(e)
    });

    //$('.gp_menu #connection').on('click', GpAnnuaire.display());

    /**
     **  Event to submit data field's popup['s'inscrire','se connecter']
     **/

    $('form[name=sign_up]').on('submit', function (e) {
        GpAnnuaire.ajaxPreSignup(e)
    });

    /**
     **  Event from form Internaute[code_postal] to find commune and localite
     **/

    $('#utilisateur_adresseUtilisateur_codePostal').on('change', function (e) {
        GpAnnuaire.gpAjaxFinalSignup(e)
    });

    /**
     **  Events from form Prestataire[code_postal] to find commune and localite
     **/

    $('#prestataire_utilisateur_adresseUtilisateur_codePostal').on('change', function (e) {
        GpAnnuaire.gpAjaxFinalSignup(e)
    });

    /**
     **  Event change value input[type=file]
     **/

    $('[id*=file]').on('change', GpAnnuaire.checkTypeImg);

    /**
     **
     **/

//    $('#nom').on('change', function (e) {
//        console.log('ok');
//        GpAnnuaire.ajaxSearchPrestataire(e);
//    });

    /**
     **  DOM manipulations
     **
     **/

    /**
     **  add référence id to popup['s'inscrire']
     **/

    $('#body form:eq(1)').attr('id', 'subscribeForm');

    /**
     **  button submit popup['s'inscrire','se connecter']
     **/

    $('#body form:eq(1) button').attr({'class': 'btn btn-default', 'id': 'cmdSend'});

    /**
     **  checkbox form[internaute][newsletter] -> hack construct mistake checkbok for field newsletter -> <label><input type=checkox/></label>
     **/

    //$('.checkbox').empty();

    //$('.checkbox').append('<input type="checkbox" id="utilisateur_internaute_newsletter" name="utilisateur[internaute][newsletter]" value="0"><label>Recevoir la newsletter</label>');
    /**
     **  submit form contact Prestataire
     **/
    $('form[name=contact_prestataire]').on('submit', function (e) {
        GpAnnuaire.ajaxContactPrestataire(e);
    });
    /**
     **  soumission du formulaire d'ajout de commentaire
     **/
    $('form[name=commentaire]').on('submit', function (e) {
        GpAnnuaire.ajaxCommentaire(e)
    });
    /**
     **  cotation star --> form ajout commentaire
     **/
    $('#ratingStar').on('mouseover', GpAnnuaire.starCotationFormCommentaire);
});



var GpAnnuaire_Ajax = GpAnnuaire_Ajax || {
        /**
         **  model : ajaxBuilder
         **
         **  moteur AJAX
         **
         **/
        'ajaxBuilder': function (param) {

            $.ajax({
                type: param.METHODE,
                data: param.VALUES,
                url: Routing.generate(param.ROUTE, {'label': param.valueGET}),
                dataType: param.DATATYPE,
                beforeSend: param.beforeSEND,
                success: param.SUCCESS
            });
        },
        'serializerAjaxValues': function ($form) {
            var values = {};
            $.each($form.serializeArray(), function (i, field) {
                values[field.name] = field.value;
            });
            return values;
        },
        'ajaxCommentaire': function (e) {

            e.preventDefault();
            var $form = $('form[name=commentaire]');

            var values = GpAnnuaire_Ajax.serializerAjaxValues($form);
            console.log(values);
            /*var values = {};
             $.each($form.serializeArray(), function (i, field) {
             values[field.name] = field.value;
             });*/

            var param = {};
            param.METHODE = 'POST';
            param.VALUES = values;
            param.ROUTE = 'add_comment';
            param.valueGET = $('#nomPrestataire').text();
            param.DATATYPE = 'json';
            param.beforeSEND = null;
            param.SUCCESS = GpAnnuaire_Ajax.successAjaxCommentaire;

            GpAnnuaire_Ajax.ajaxBuilder(param);
        },
        'successAjaxCommentaire': function (data) {

            if (!data.valide) {
                console.log(data);
                $('.errorCommentaire').remove();
                GpAnnuaire.resetForm('section');
                for (item in data.errors) {
                    $('#commentaire_' + item).parent().append('<div class="errorCommentaire" >' + data.errors[item][0] + '</div>');
                }
            } else {
                console.log(data);
            }
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
        /* 'ajaxConnection': function (e) {

         e.preventDefault();

         var $form = $('#connectForm');
         console.log($form);
         var values = {};

         $.each($form.serializeArray(), function (i, field) {
         values[field.name] = field.value;
         });

         $.ajax({
         type: "POST",

         url: Routing.generate('login_check'),
         dataType: 'json',
         success: function (data) {
         console.log(data);
         }
         })
         },*/
        /**
         **  model : moteur de recherche -> prestataire
         **/
        /* 'ajaxSearchPrestataire': function (e) {
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
         },*/
        /**
         **  model : ajax for autocomplete form[internaute][adresseUtilisateur]
         **/
        'ajaxAutocompleteAdresse': function (e) {

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
                url: Routing.generate('send_mail_prestataire'),// ({'prestataire_email': "wg.wargnier%40gmail.com"})),
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (data.valide) {

                        $('.errorCommentaire').remove();
                        GpAnnuaire.resetForm('#contactPresta');
                        $('#info').empty().text('Votre message est envoyé!');

                        var back = function () {
                            console.log("Boom!");
                            $('#info').empty().html("Champs obligatoires <span class='required' >*</span>");
                        };
                        setTimeout(back, 5000);

                        console.log(data.valide);
                    } else {

                        $('.errorCommentaire').remove();

                        for (item in data.errors) {
                            $('#contact_prestataire_' + item).parent().append('<div class="errorCommentaire" >' + data.errors[item][0] + '</div>');
                        }
                    }
                }
            })
        }
    }
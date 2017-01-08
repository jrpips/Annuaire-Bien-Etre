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
        /**
         **  model : serializer values Ajax request
         **
         **/
        'serializerAjaxValues': function ($form) {
            var values = {};
            $.each($form.serializeArray(), function (i, field) {
                values[field.name] = field.value;
            });
            return values;
        },
        /**
         **  model : prepare requête Ajax pour gestion commentaires internautes -> prestataires
         **
         **/
        'ajaxCommentaire': function (e) {

            e.preventDefault();
            var $form = $('form[name=commentaire]');

            var values = GpAnnuaire_Ajax.serializerAjaxValues($form);

            var param = {};
            param.METHODE = 'POST';
            param.VALUES = values;
            param.ROUTE = 'add_comment';
            param.valueGET = $('#nomPrestataire').text();
            param.DATATYPE = 'json';
            param.beforeSEND = null;
            param.SUCCESS = GpAnnuaire_Call_Ajax.successAjaxCommentaire;

            GpAnnuaire_Ajax.ajaxBuilder(param);
        },
        /**
         **  model : prepare requête Ajax pour fenêtre popup['s'inscrire'] (navigation principale)
         **
         **/
        'ajaxPreSignup': function (e) {

            e.preventDefault();

            var $form = $('form');
            var values = GpAnnuaire_Ajax.serializerAjaxValues($form);

            var param = {};
            param.METHODE = 'POST';
            param.VALUES = values;
            param.ROUTE = 'signup';
            param.valueGET = null;
            param.DATATYPE = 'json';
            param.beforeSEND = null;
            param.SUCCESS = GpAnnuaire_Call_Ajax.successAjaxPreSignup;

            GpAnnuaire_Ajax.ajaxBuilder(param);
        },

        /**
         **  model : prepare requête Ajax autocomplete form[internaute][adresseUtilisateur]
         **
         **/
        'ajaxAutocompleteAdresse': function (e) {

            e.preventDefault();

            event_id = e.currentTarget.id;

            if ($('#' + event_id).val().length === 4) {

                var values = {'valeur': $('#' + event_id).val()}
                var param = {};

                param.METHODE = 'POST';
                param.VALUES = values;
                param.ROUTE = 'autocomplete';
                param.valueGET = null;
                param.DATATYPE = 'json';
                param.beforeSEND = GpAnnuaire_Call_Ajax.beforeSendAjaxAutocompleteAdresse;
                param.SUCCESS = GpAnnuaire_Call_Ajax.successAjaxAutocompleteAdresse;

                GpAnnuaire_Ajax.ajaxBuilder(param);

            } else {
                $('#' + event_id).append($('<option>', {
                    value: 'error',
                    text: 'Aucunes communes ne correspondent à ce code postal!'
                }));
            }
        },

        /**
         **  model : prepare requête Ajax pour formulaire de contact Prestataire
         **
         **/
       /* 'ajaxContactPrestataire': function (e) {

            e.preventDefault();

            var $form = $('form[name=contact]');
            var values = {};

            var values = GpAnnuaire_Ajax.serializerAjaxValues($form);

            var param = {};
            param.METHODE = 'POST';
            param.VALUES = values;
            param.ROUTE = 'send_mail_prestataire';
            param.valueGET = null;
            param.DATATYPE = 'json';
            param.beforeSEND = null;
            param.SUCCESS = GpAnnuaire_Call_Ajax.successAjaxContact;

            GpAnnuaire_Ajax.ajaxBuilder(param);

        },*/
        /**
         **  model : prepare requête Ajax pour formulaire de contact Bien-Être
         **
         **/
        'ajaxContact': function (e) {

            e.preventDefault();

            var $form = $('form[name=contact]');
            var values = {};

            var values = GpAnnuaire_Ajax.serializerAjaxValues($form);

            var param = {};
            param.METHODE = 'POST';
            param.VALUES = values;
            param.ROUTE = 'send_mail_prestataire';
            param.valueGET = null;
            param.DATATYPE = 'json';
            param.beforeSEND = null;
            param.SUCCESS = GpAnnuaire_Call_Ajax.successAjaxContact;

            GpAnnuaire_Ajax.ajaxBuilder(param);

        }
    };
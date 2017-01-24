var GpAnnuaire_Call_Ajax = GpAnnuaire_Call_Ajax || {
        /**
         *  call by ajaxCommentaire
         */
        'successAjaxCommentaire': function (data) {

            if (!data.valide) {


                $('.errorCommentaire').remove();

                for (item in data.errors) {

                    $('#commentaire_' + item).parent().append(
                        '<div class="errorCommentaire" >' + data.errors[item][0] + '</div>'
                    );
                }
            } else {


                $('.errorCommentaire').remove();
                GpAnnuaire.resetForm('section');
                $('#statut').empty().text('Votre commentaire est publiée!');

                var back = function () {
                    $('#statut').empty().html(
                        "Champs obligatoires <span class='required' >*</span>"
                    );
                };
                setTimeout(back, 5000);
            }
        },
        /**
         *  call by ajaxPreSignup
         */
        'successAjaxPreSignup': function (data) {

            if (data.valide) {


                $('.error').remove();
                $('[type=submit]')//ajout de la balise contenant le message de validation
                    .parent()
                    .parent()
                    .append(''
                        + '<div class="message">'
                        + '<i class="glyphicon glyphicon-send"></i> Un email de confirmation a été envoyé l\'adresse <br>'
                        + '<span>'
                        + data.values.sign_up.email + '</span></div>'
                    );

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
        /**
         * call by ajaxAutocompleteAdresse
         */
        'beforeSendAjaxAutocompleteAdresse': function () {

            if ($('.loader').length === 0) {


                $('#' + event_id)
                    .parent()
                    .append('<div class="loader" >'
                        + '<img src="http://127.0.0.1/Annuaire-Bien-Etre/web/image/Loading_icon.gif"/></div>'
                    );
            }

            $('#' + event_id + ' option').remove();
        },
        /**
         *
         */
        'successAjaxAutocompleteAdresse': function (data) {

            $('.loader').remove();

            var prefix = event_id;
            var event_id_length = event_id.length - 10;//TODO: retrait dynamique (-10)

            event_id = prefix.substring(0, event_id_length);

            $('#' + event_id + 'commune option').remove();

            $.each(data.communes, function (index, value) {
                $('#' + event_id + 'commune').append($('<option>', {value: value, text: value}));
            });

            $('#' + event_id + 'localite').val(data.province);
        },
        /**
         *  call by ajaxContact
         */
        'successAjaxContact': function (data) {

            if (data.valide) {


                $('.errorCommentaire').remove();
                GpAnnuaire.resetForm('#contact');

                $('#info').empty().text('Votre message est envoyé!');

                var back = function () {
                    $('#info').empty().html("Champs obligatoires <span class='required' >*</span>");
                };

                setTimeout(back, 5000);

            } else {


                $('.errorCommentaire').remove();
                for (item in data.errors) {
                    $('#contact_' + item).parent().append('<div class="errorCommentaire" >' + data.errors[item][0] + '</div>');
                }
            }
        },
        'successAjaxImg': function (data) {
            console.log(data);
            $('#info div').text('');
            $('#info a').remove();

            var owner=1;

            if (!$.isEmptyObject(data.data)) {


                for (item in data.data[0]) {

                    $('#info').append('<div>' + item + ':' + data.data[0][item] + '</div>');
                    console.log('propiétaire');
                }

            } else {


                $('#info').append('<div>Cette image n\'a pas de propriétaire!</div>');
                owner=0;
            }
            var url = Routing.generate('delete_img',{'path':data.path,'owner':owner});

            console.log(url, data);

            $('#info').append("<a href=" + url + " class='btn btn-primary'>Supprimer</a>");
        }

    }

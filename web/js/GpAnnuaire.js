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

                //$('header').attr('header-transparent');
                $('.header-wrapper').css({'background-color': 'rgba(100, 100, 128,0.2)'/*'transparent'*/});

            } else {//scroll actif

                //$('header').removeAttr('header-transparent');
                $('.header-wrapper').css('background-color', 'rgba(100, 100, 128,0.4)');
            }//TODO couleur police nav pages != index
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
         **  view : traitement réponse soumission popup['s'inscrire','se connecter']
         **
         **/
        'successAjaxPreSignup': function (data) {

            if (data.valide) {
                console.log(data);
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
                console.log(data);
                $('.error').remove();

                for (item in data.errors) {
                    $('#sign_up_' + item).parent().append('<div class="error">' + data.errors[item][0] + '</div>');
                }
            }
        },
        'beforeSendAjaxAutocompleteAdresse': function () {

            if ($('.loader').length === 0) {
                $('#' + event_id).parent().append('<div class="loader"><img src="http://127.0.0.1/Annuaire-Bien-Etre/web/image/Loading_icon.gif"/></div>');
            }
            $('#' + event_id + ' option').remove();
        },
        'successAjaxAutocompleteAdresse':function (data) {

            $('.loader').remove();

            var prefix = event_id;
            var event_id_length = event_id.length - 10;
            event_id = prefix.substring(0, event_id_length);

            $('#' + event_id + 'commune option').remove();
            $.each(data.communes, function (index, value) {
                $('#' + event_id + 'commune').append($('<option>', {value: value, text: value}));
            });
            $('#' + event_id + 'localite').val(data.province);

        },
        'successAjaxContactPrestataire':function (data) {

            if (data.valide) {
                $('.errorCommentaire').remove();
                GpAnnuaire.resetForm('#contactPresta');
                $('#info').empty().text('Votre message est envoyé!');
                var back = function () {

                    $('#info').empty().html("Champs obligatoires <span class='required' >*</span>");
                };
                setTimeout(back, 5000);
            } else {
                $('.errorCommentaire').remove();
                for (item in data.errors) {
                    $('#contact_prestataire_' + item).parent().append('<div class="errorCommentaire" >' + data.errors[item][0] + '</div>');
                }
            }
        },
        resetForm: function (element) {// param element --> form.parent()
            tabChildForm = ['input', 'textarea'];
            var form = $(element + ' form');
            for (i = 0; i < 2; i++) {

                $(element + ' ' + tabChildForm[i]).each(function (index) {
                    $(this).val('');
                });
            }
        },
        /**
         **  view : construction et affichage popup['s'inscrire','se connecter']
         **
         **/
        display: function (e) {

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
        hide: function () {

            $('#modale').hide('slow');
            $('#popup').hide('slow');
        },

        checkTypeImg: function () {

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
        cotationFormCommentaire: function (e) {

            event_id = e.currentTarget.id;
            var cote = $('#' + event_id).attr('data');

            cote++;

            for (var j = 0; j <= cote; j++) {
                $('#rating-' + j).removeAttr('class').attr('class', 'fa fa-star');
            }
            for (j = cote; j <= 10; j++) {
                $('#rating-' + j).removeAttr('class').attr('class', 'fa fa-star-o');
            }
            cote--;

            $('#commentaire_cote').val(cote / 2);
        },
        rightChangeService: function () {
            console.log('right');
        },
        leftChangeService: function () {
            console.log('left');
        },

    };



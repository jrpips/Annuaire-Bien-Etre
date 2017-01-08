/**
 ** Gestion de projet: Annuaire Bien-Être
 ** -------------------------------------
 **
 ** Controller
 **
 **/
$(function () {

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
     **  Event to display popup['s'inscrire','se connecter']
     **
     **  function(): GpAnnuaire.display
     **
     **/

    $('.gp_menu #subscribe').on('click', function (e) {
        GpAnnuaire.display(e)
    });

    $('#sub').on('click', function (e) {
        GpAnnuaire.display(e)
        console.log(e);
    });
    //$('.gp_menu #connection').on('click', GpAnnuaire.display());

    /**
     **  Event to submit data field's popup['s'inscrire','se connecter']
     **/

    $('form[name=sign_up]').on('submit', function (e) {
        GpAnnuaire_Ajax.ajaxPreSignup(e)
    });

    /**
     **  Event from form Internaute[code_postal] to find commune and localite
     **/

    $('#utilisateur_adresseUtilisateur_codePostal').on('change', function (e) {
        GpAnnuaire_Ajax.ajaxAutocompleteAdresse(e)
    });

    /**
     **  Events from form Prestataire[code_postal] to find commune and localite
     **/

    $('#prestataire_utilisateur_adresseUtilisateur_codePostal').on('change', function (e) {
        GpAnnuaire_Ajax.ajaxAutocompleteAdresse(e)
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
     **    Checkbox form[internaute][newsletter] -> hack construct mistake checkbok for field newsletter -> <label><input type=checkox/></label>
     **/

    //$('.checkbox').empty();

    //$('.checkbox').append('<input type="checkbox" id="utilisateur_internaute_newsletter" name="utilisateur[internaute][newsletter]" value="0"><label>Recevoir la newsletter</label>');

    /**
     **    Submit form contact Prestataire
     **/
    $('form[name=contact]').on('submit', function (e) {
        console.log('ok');
        GpAnnuaire_Ajax.ajaxContact(e);
    });
    /**
     **    Submit form contact Prestataire
     **/
   /* $('#contact form[name=contact]').on('submit', function (e) {
        console.log(e);
        GpAnnuaire_Ajax.ajaxContact(e);
    });*/
    /**
     **   Soumission du formulaire d'ajout de commentaire
     **/
    $('form[name=commentaire]').on('submit', function (e) {
        GpAnnuaire_Ajax.ajaxCommentaire(e)
    });

    /**
     **   Cotation star --> form ajout commentaire
     **/
    for (i = 1; i < 11; i++) {
        $('#rating-' + i).on('click', function (e) {
            GpAnnuaire.cotationFormCommentaire(e);
        });
    }

    /**
     **   Gestion listes services Prestataire
     **/
   /* $('#test select[name=right]').on('change',function(){
     $('button[name=droite]').on('click',GpAnnuaire.rightChangeService);
     })
     $('#test select[name=left]').on('change',function(){
     $('button[name=gauche]').on('click',GpAnnuaire.leftChangeService);
     })*/
});

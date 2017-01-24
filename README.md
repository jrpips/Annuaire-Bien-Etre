
<h1 >Gestion de projet</h1>
<h2>Annuaire Bien-Être</h2>
<br>

<h3>Sommaire</h3>
<ol>
<li><a href="#fixture">Fixtures</a></li>
<li><a href="#pdf">PDF</a></li>
<li><a href="#etat">Etat d'avancement</a></li>
</ol>

<h3 id="fixture">1. Fixtures</h3>
<table>
<tr>
<th>Nom utilisateur</th><th>Type</th><th>Mot de passe</th>
</tr>
<tr><td>user0</td><td>prestataire</td><td>1234</td></tr>
<tr><td>user1</td><td>prestataire</td><td>1234</td></tr>
<tr><td>user2</td><td>prestataire</td><td>1234</td></tr>
<tr><td>user3</td><td>prestataire</td><td>1234</td></tr>
<tr><td>user4</td><td>prestataire</td><td>1234</td></tr>
<tr><td>user5</td><td>internaute</td><td>1234</td></tr>
<tr><td>user6</td><td>internaute</td><td>1234</td></tr>
<tr><td>user7</td><td>internaute</td><td>1234</td></tr>
<tr><td>user8</td><td>ADMIN</td><td>1234</td></tr>
</table>

<h3 id="pdf">2. Pdf</h3>

<p>Utilisation du bundles <a href="https://packagist.org/packages/knplabs/knp-snappy">knp-snappy</a></p>
<p>Génération des pdf configurée pour un système Windows.<br>
Pour les serveurs Linux charger l'exécutable correspondant à votre serveur:
<ul>
<li><a href="https://packagist.org/packages/h4cc/wkhtmltopdf-amd64">wkhtmltopdf-amd64</a></li>
<li><a href="https://packagist.org/packages/h4cc/wkhtmltopdf-i386">wkhtmltopdf-i386</a></li>
</ul>
...et modifier la ligne suivante ( \src\AppBundle\Controller\AdminController\AdminAnnuaireController.php line 357 )<br>

<p><code>$snappy = new Pdf(__DIR__ . '\..\..\..\..<b>\vendor\wemersonjanuario\wkhtmltopdf-windows\bin\32bit\wkhtmltopdf.exe</b>');</code></p>


<h3 id="etat">3. Etat d'avancement:</h3>
<table>
    <tr><th>Itération</th><th>Cas d'utilisation</th><th>Etat</th><th>Remarque(s)</th></tr>
    <tr><th>Priorité 1.1</th></tr>
    <tr><td></td><td>Consulter la description d'un Service</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>Rechercher des Prestataires</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>Consulter la fiche signalétique d'un Prestataire</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>Consulter les catégories de Services </td><td>:+1:</td><td></td></tr>
    <tr><th>Priorité 1.2</th></tr>
    <tr><td></td><td>S'inscrire</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>Confirmer l'inscription</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>S'authentifier</td><td>:+1:</td><td></td></tr>
    <tr><th>Priorité 1.1</th></tr>
    <tr><td></td><td>Gérer fiche Internaute</td><td>:+1:</td><td><b>*</b></td></tr>
    <tr><td></td><td>Gérer fiche Prestataire</td><td>:+1:</td><td><b>*</b></td></tr>
    <tr><td></td><td>Tenir à jour sa liste de catégories de Services</td><td>:+1:</td><td>bug js lors de la première sélection d'un service</td></tr>
    <tr><td></td><td>Ajouter un Stage</td><td>:+1:</td><td>affichage sans respecter les dates</td></tr>
    <tr><th>Priorité 2</th></tr>
    <tr><td></td><td>Réécriture des URL</td><td>:+1:</td><td>merci symfony!</td></tr>
    <tr><td></td><td>Visualiser la localisation sur une carte</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>Contacter un Prestataire</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>Partager sur un site de socialisation</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>Gestion des catégories de Services</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>Gestion du Service du mois</td><td>:-1:</td><td></td></tr>
    <tr><td></td><td>Gérer fiche Prestataire</td><td>:+1:</td><td><b>*</b></td></tr>
    <tr><td></td><td>Ajouter une Promotion</td><td>:+1:</td><td>affichage sans respecter les dates</td></tr>
    <tr><th>Priorité 3</th></tr>
    <tr><td></td><td>Changer de mot de passe</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>Afficher Prestataires similaires</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>Ajouter à ses favoris</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>Contacter un Prestataire (admin)</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>Envoyer ue recommandation à un ami</td><td>:-1:</td><td></td></tr>
    <tr><td></td><td>Coter et laisser un commentaire</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>Signaler des commentaires abusifs</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>Gestion des Prestataires</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>Gestion des membres</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>Bannir un compte</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>Débloquer un compte</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>Gestion des commentaires et des abus</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>Gestion des images (admin)</td><td>:exclamation::</td><td>read delete</td></tr>
    <tr><td></td><td>Envoi d'une newsletter</td><td>:exclamation:</td><td>create read</td></tr>
    <tr><td></td><td>Organiser sa page d'accueil</td><td>:-1:</td><td></td></tr>
    <tr><td></td><td>S'inscrire à la newsletter</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>Consulter les newsletters précédentes</td><td>:-1:</td><td></td></tr>
    <tr><td></td><td>Consulter la page "A propos"</td><td>:-1:</td><td></td></tr>
    <tr><td></td><td>Contacter Bien-Être</td><td>:+1:</td><td></td></tr>
    <tr><td></td><td>Choisir sa langue</td><td>:-1:</td><td></td></tr>
</table>
<br>
<p><b>*</b> bug: la commune ne s'affiche pas dans son champ, il faut resélectionner un code postal pour charger la commune (Ajax)</p>

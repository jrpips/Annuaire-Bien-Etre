<h1>Gestion de projet</h1>
<h2>Annuaire Bien-Être</h2>
<h3>Etapes</h3>
<ol>
<li>Encodage des Entités
<li>Fixtures via Faker

</ol>

<code>
 public function loginAction(Request $request) {
       
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('home');
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('Public/form.login.html.twig', array(
                    'last_username' => $authenticationUtils->getLastUsername(),
                    'error' => $authenticationUtils->getLastAuthenticationError(),
        ));
    }
</code>

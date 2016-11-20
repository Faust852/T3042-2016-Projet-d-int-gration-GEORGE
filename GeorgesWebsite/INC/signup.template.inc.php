<div id="f_contact">
    <form method ='post' action="testForm.php">
        <fieldset>
            <span id="connectionFailed"></span>
            <h1 class="signLogP">Nouveau compte</h1>
            <p class="signLogP">
                <label for="pseudo"><i class="fa fa-user logSign" aria-hidden="true"></i> Pseudo : </label><br class="signupFields">
                <input type="text" name="pseudo" id="pseudo" class="formField" required>
            </p>

            <p class="signLogP">
                <label for="mdp"><i class="fa fa-lock logSign" aria-hidden="true"></i> Mot de passe : </label><br class="signupFields">
                <input type="password" name="mdp" id="mdp" class="formField" required>
            </p>

            <p class="signLogP">
                <label for="verifMdp"><i class="fa fa-lock logSign" aria-hidden="true"></i> Vérification du mot de passe : </label><br class="signupFields">
                <input type="password" name="verifMdp" id="verifMdp" class="formField" required>
            </p>

            <p class="signLogP">
                <label for="email"><i class="fa fa-envelope logSign" aria-hidden="true"></i> Email : </label><br class="signupFields">
                <input type="text" name="email" id="email" class="formField" required>
            </p>

            <p class="signLogP">
                <label for="verifEmail"><i class="fa fa-envelope logSign" aria-hidden="true"></i> Vérification d'Email : </label><br class="signupFields">
                <input type="text" name="verifEmail" id="verifEmail" class="formField" srequired>
            </p>

            <p class=soumission>
                <input type="submit" name="sendNewAccount" id="sendNewAccount" value="Envoyer" class="submitButton">
            </p>

        </fieldset>
    </form>
</div>
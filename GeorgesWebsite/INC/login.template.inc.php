<div id="f_login">
    <form method ='post' action="testForm.php" id="sendLogin">
        <fieldset>
            <h1 class="signLogP">Se connecter</h1>
            <span id="connectionFailed"></span>
            <p class="signLogP">
                <label for="username"><i class="fa fa-user logSign" aria-hidden="true"></i> Pseudo :  </label><br class="loginFields">
                <input type="text" name="username" id="username" class="formField" required>
            </p>

            <p class="signLogP">
                <label for="password"><i class="fa fa-lock logSign" aria-hidden="true"></i> Mot de passe :  </label><br class="loginFields">
                <input type="password" name="password" id="password" class="formField" required>
            </p>

            <p class=soumission>
                <input type="submit" name="sendLogin" id="sendLogin" value="Envoyer" class="submitButton">
                <!--<input type="submit" name="sendMdpPerdu" id="sendMdpPerdu" value="Mot de passe perdu">-->
            </p>
        </fieldset>

        <p>
        </p>
    </form>
</div>
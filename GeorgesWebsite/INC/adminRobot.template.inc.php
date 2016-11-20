<div id="f_admin">
    <form method ='post' action="testForm.php" id="sendRobot">
        <fieldset>
            <h1 class="signLogP">Lier un robot</h1>
            <span id="connectionFailed"></span>
            <p class="signLogP">
                <label for="robot_id">Numéro du Robot :  </label><br class="loginFields">
                <input type="text" name="robot_id" id="robot_id" class="formField" required>
            </p>

            <p class="signLogP">
                <label for="robot_password">Mot de passe du robot:  </label><br class="loginFields">
                <input type="password" name="robot_password" id="robot_password" class="formField" required>
            </p>

            <p class=soumission>
                <input type="submit" name="sendRobot" id="sendRobot" value="Envoyer" class="submitButton">
            </p>
        </fieldset>
        <p>
        </p>
    </form>
</div>
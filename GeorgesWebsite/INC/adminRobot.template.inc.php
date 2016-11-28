<div id="f_admin">
    <form method ='post' action="testForm.php" onsubmit="return sendForm(this)" id="sendRobot" class="w3-container w3-card-4 w3-light-grey w3-text-black w3-margin">
        <h2 class="w3-center">Link to your robot</h2>

        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" type="text" name="robot_id" id="robot_id" placeholder="Robot's id" required>
            </div>
        </div>

        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" type="password" name="robot_password" id="robot_password" placeholder="Robot's password" required>
            </div>
        </div>

        <p class="w3-center">
            <input type="submit" name="sendRobot" id="sendRobot" value="Send" class="w3-center w3-btn w3-white w3-border w3-round-large w3-light-grey">
        </p>
    </form>
</div>
<div id="f_login">
    <form method ='post' action="testForm.php" onsubmit="return sendForm(this)" id="sendAddRobots" class="w3-container w3-card-4 w3-light-grey w3-text-black w3-margin">
        <h2 class="w3-center">Add robots</h2><br>
        <h2 class="w3-center" id="actualId"><?php$actualId?></h2>
        <div id="addRobotsFields">
            <div class="w3-row w3-section addRobotsDivLeft">
                <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
                <div class="w3-rest">
                    <input class="w3-input w3-border" type="text" name="robotID0" id="robotID0" placeholder="robotID" required>
                </div>
            </div>

            <div class="w3-row w3-section addRobotsDivLeft">
                <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>
                <div class="w3-rest">
                    <input class="w3-input w3-border" type="password" name="robotPsw0" id="robotPsw0" placeholder="robotPsw" required>
                </div>
            </div>

            <div class="w3-row w3-section addRobotsDivLeft">
                <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>
                <div class="w3-rest">
                    <input class="w3-input w3-border" type="text" name="robotIP0" id="robotIP0" placeholder="robotIP" required>
                </div>
            </div>
        </div>

        <p class="w3-center">
            <input type="button" onClick="duplicateFields()" value="One more?" class="w3-margin-bottom w3-center w3-btn w3-white w3-border w3-round-large w3-light-grey"><br>
            <input type="submit" name="submitAddRobots" id="submitAddRobots" value="Send" class="w3-center w3-btn w3-white w3-border w3-round-large w3-light-grey">
        </p>
    </form>
</div>
<div id="f_contact">
    <form method ='post' action="testForm.php" onsubmit="return sendForm(this)" id="sendNewAccount" class="w3-container w3-card-4 w3-light-grey w3-text-black w3-margin">
        <h2 class="w3-center">Sign up</h2>

        <div id="connectionFailed" class="w3-center">
        </div>

        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" type="text" name="username" id="username" placeholder="Username" required>
            </div>
        </div>

        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" type="password" name="signupPassword" id="signupPassword" placeholder="Password" required>
            </div>
        </div>

        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" type="password" name="verifMdp" id="verifMdp" placeholder="Confirm your password" required>
            </div>
        </div>

        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" type="email" name="email" id="email" placeholder="Email" required>
            </div>
        </div>

        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" type="email" name="verifEmail" id="verifEmail" placeholder="Confirm your email" required>
            </div>
        </div>

        <p class="w3-center">
            <input type="submit" name="sendNewAccount" id="sendNewAccount" value="Send" class="w3-center w3-btn w3-white w3-border w3-round-large w3-light-grey">
        </p>
    </form>
</div>
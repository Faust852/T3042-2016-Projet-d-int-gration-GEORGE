<div id="f_contact">
    <form method ='post' action="testForm.php" onsubmit="return sendForm(this)" id="sendNewAccount" class="w3-container w3-card-4 w3-light-grey w3-text-black w3-margin">
        <h2 class="w3-center">Sign up</h2>

        <div id="connectionFailed" class="w3-center">
        </div>

        <h6 class="w3-center">All fields are required</h6>

        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" type="text" name="username" id="username" placeholder="Username" title="Username" required>
            </div>
        </div>

        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" type="password" name="signupPassword" id="signupPassword" placeholder="Password" title="Password" required>
            </div>
        </div>

        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" type="password" name="verifMdp" id="verifMdp" placeholder="Confirm your password" title="Confirm your password" required>
            </div>
        </div>

        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" type="email" name="email" id="email" placeholder="Email" title="Email" required>
            </div>
        </div>

        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" type="email" name="verifEmail" id="verifEmail" placeholder="Confirm your email" title="Confirm your email" required>
            </div>
        </div>

        <p class="w3-center">
            <input type="submit" name="sendNewAccount" id="sendNewAccount" value="Send" class="submitButton w3-center w3-btn w3-dark-grey w3-border w3-hover-white w3-round-large">
        </p>
    </form>
</div>
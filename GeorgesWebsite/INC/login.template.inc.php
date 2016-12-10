<div id="f_login">
    <form method ='post' action="testForm.php" onsubmit="return sendForm(this)" id="sendLogin" class="w3-container w3-card-4 w3-light-grey w3-text-black w3-margin">
        <h2 class="w3-center">Sign in</h2>

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
                <input class="w3-input w3-border" type="password" name="password" id="password" placeholder="Password" title="Password" required>
            </div>
        </div>

        <p class="w3-center">
            <input type="submit" name="sendLogin" id="sendLogin" value="Send" class="submitButton w3-center w3-btn w3-dark-grey w3-border w3-round-large">
        </p>
    </form>
</div>

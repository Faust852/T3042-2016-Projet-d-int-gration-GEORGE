	<div id="videoDiv">
		<img src="https://georgesecurity.me/#motionURL" alt="Georges is off. ">
	</div>

	<div class="desktopControls">
		<p class='signLogP'>Click at the center to stop Georges</p>
		<p class='signLogP'>Stay pressed to move in that direction then release to stop</p>
		<div id="divUpArrow"><button class="w3-btn submitButton crossButtons" onmousedown="sendKey('up');" onmouseup="sendStop();"><span class="spanArrow">&#8593;</span></button></div>
		<div style="width: 100%; text-align: center;">
			<button class="w3-btn submitButton crossButtons middleControls"	onmousedown="sendKey('left');" onmouseup="sendStop();""><span class="spanArrow">&#8592;</span></button>
			<button class="w3-btn submitButton crossButtons middleControls" onclick="sendStop();"><span class="spanArrow"><i class="fa fa-ban" aria-hidden="true"></i></span></button>
			<button class="w3-btn submitButton crossButtons middleControls" onmousedown="sendKey('right');" onmouseup="sendStop();"><span class="spanArrow">&#8594;</span></button>
		</div>
		<div id="divDownArrow"><button class="w3-btn submitButton crossButtons" onmousedown="sendKey('down');" onmouseup="sendStop();"><span class="spanArrow">&#8595;</span></button></div>
		<!--
		<div id="divUpArrow"><button class="crossButtons" onclick="sendStop();" onmousedown="sendKey('up');" onmouseup="sendStop();"><span class="spanArrow">&#8593;</span></button></div>
		<div id="divLeftArrow"><button id="buttonLeftArrow" class="crossButtons" onclick="sendStop();" onmousedown="sendKey('left');" onmouseup="sendStop();"><span class="spanArrow">&#8592;</span></button></div>
		<div id="divRightArrow"><button id="buttonRightArrow" class="crossButtons" onclick="sendStop();" onmousedown="sendKey('right');" onmouseup="sendStop();"><span class="spanArrow">&#8594;</span></button></div>
		<div id="divDownArrow"><button class="crossButtons" onclick="sendStop();" onmousedown="sendKey('down');" onmouseup="sendStop();"><span class="spanArrow">&#8595;</span></button></div>
		-->
	</div>
	<div class="mobileControls">
		<p class='signLogP'>Click on the direction, then on the middle to stop Georges</p>
		<div id="divUpArrow"><button class="submitButton crossButtons" onclick="sendKey('up');"><span class="spanArrow">&#8593;</span></button></div>
		<div style="width: 100%; text-align: center;">
			<button class="submitButton crossButtons middleControls" onclick="sendKey('left');"><span class="spanArrow">&#8592;</span></button>
			<button class="submitButton crossButtons middleControls" onclick="sendStop();"><span class="spanArrow"><i class="fa fa-ban" aria-hidden="true"></i></span></button>
			<button class="submitButton crossButtons middleControls" onclick="sendKey('right');"><span class="spanArrow">&#8594;</span></button>
		</div>
		<div id="divDownArrow"><button class="submitButton crossButtons" onclick="sendKey('down');"><span class="spanArrow">&#8595;</span></button></div>
	</div>

	<p class="soumission">
		<button id="autoButton" class="submitButton w3-center w3-btn w3-dark-grey w3-border w3-round-large" onclick="sendAuto();"><span>Auto mode</span></button>
	</p>


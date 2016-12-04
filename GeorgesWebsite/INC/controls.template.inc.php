	<div id="videoDiv">
		<img src="http://185.14.186.97/motion/" alt="Le raspberry est éteint. ">
	</div>

	<!--
	<div id="divUpArrow"><button class="crossButtons" onclick="sendStop();" onmousedown="sendKey('up');" onmouseup="sendStop();"><span class="spanArrow">&#8593;</span></button></div>
	<div id="divLeftArrow"><button id="buttonLeftArrow" class="crossButtons" onclick="sendStop();" onmousedown="sendKey('left');" onmouseup="sendStop();"><span class="spanArrow">&#8592;</span></button></div>
	<div id="divRightArrow"><button id="buttonRightArrow" class="crossButtons" onclick="sendStop();" onmousedown="sendKey('right');" onmouseup="sendStop();"><span class="spanArrow">&#8594;</span></button></div>
	<div id="divDownArrow"><button class="crossButtons" onclick="sendStop();" onmousedown="sendKey('down');" onmouseup="sendStop();"><span class="spanArrow">&#8595;</span></button></div>
	-->
	<p>Click </p>
	<div id="divUpArrow"><button class="crossButtons" onclick="sendKey('up');"><span class="spanArrow">&#8593;</span></button></div>
	<div style="width: 100%; text-align: center;">
		<button class="crossButtons middleControls" onclick="sendKey('left');"><span class="spanArrow">&#8592;</span></button>
		<button class="crossButtons middleControls" onclick="sendStop();"><span class="spanArrow"><i class="fa fa-ban" aria-hidden="true"></i></span></button>
		<button class="crossButtons middleControls" onclick="sendKey('right');"><span class="spanArrow">&#8594;</span></button>
	</div>
	<div id="divDownArrow"><button class="crossButtons" onclick="sendKey('down');"><span class="spanArrow">&#8595;</span></button></div>


	<p class="soumission">
		<button id="autoButton" class="w3-center w3-btn w3-white w3-border w3-round-large w3-light-grey" onclick="sendAuto();"><span>Mode automatique</span></button>
	</p>


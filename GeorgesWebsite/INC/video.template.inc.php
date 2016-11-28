	<div id="videoDiv">
		<img src="http://185.14.186.97/motion/" alt="Le raspberry est éteint. ">
		<p>
			Vous êtes sur un ordinateur ! Génial, utilisez les flèches du clavier pour déplacer Georges!
		</p>

	</div>

	<div id="divUpArrow"><button class="crossButtons" onclick="sendStop();" onmousedown="sendKey('up');" onmouseup="sendStop();"><span class="spanArrow">&#8593;</span></button></div>
	<div id="divLeftArrow"><button id="buttonLeftArrow" class="crossButtons" onclick="sendStop();" onmousedown="sendKey('left');" onmouseup="sendStop();"><span class="spanArrow">&#8592;</span></button></div>
	<div id="divRightArrow"><button id="buttonRightArrow" class="crossButtons" onclick="sendStop();" onmousedown="sendKey('right');" onmouseup="sendStop();"><span class="spanArrow">&#8594;</span></button></div>
	<div id="divDownArrow"><button class="crossButtons" onclick="sendStop();" onmousedown="sendKey('down');" onmouseup="sendStop();"><span class="spanArrow">&#8595;</span></button></div>


	<p class="soumission">
		<button class="submitButton" id="autoButton" onclick="sendAuto();"><span>Mode automatique</span></button>
	</p>


package pr1.main;

import java.awt.Component;

public class GameLoop extends IDGameLoop {

	GameStateManager gsm;
	public static Assets assets = new Assets();
	public static float xOffset;
	public static float yOffset;
	
	
	
	public GameLoop(int fwidth, int fheight) {
		super(fwidth, fheight);
	}
	
	@Override
	public void init() {
		assets.init();
		Vector2F.setWorldVariable(xOffset, yOffset);
		gsm = new GameStateManager();
		gsm.init();
	
		super.init();
	}
	
	@Override
	public void tick(double deltaTime) {
		Vector2F.setWorldVariable(xOffset, yOffset);
		gsm.tick(deltaTime);
	}
	
	@Override
	public void render() {
		super.render();
		gsm.render(graphics2D);
		clear();
	}
	
	@Override
	public void clear() {
		super.clear();
	}
	
}

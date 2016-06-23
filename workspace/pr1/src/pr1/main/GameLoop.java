package pr1.main;

import java.awt.Component;

public class GameLoop extends IDGameLoop {

	GameStateManager gsm;
	public static Assets assets = new Assets();
	public static Vector2F map = new Vector2F();
	
	
	
	public GameLoop(int fwidth, int fheight) {
		super(fwidth, fheight);
	}
	
	@Override
	public void init() {
		assets.init();
		Vector2F.setWorldVariable(map.xPos, map.yPos);
		gsm = new GameStateManager();
		gsm.init();
	
		super.init();
	}
	
	@Override
	public void tick(double deltaTime) {
		Vector2F.setWorldVariable(map.xPos, map.yPos);
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

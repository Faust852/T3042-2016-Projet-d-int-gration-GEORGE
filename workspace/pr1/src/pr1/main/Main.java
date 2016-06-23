package pr1.main;

import java.awt.GraphicsDevice;
import java.awt.GraphicsEnvironment;

public class Main {
	
	public static GraphicsDevice gd = GraphicsEnvironment.getLocalGraphicsEnvironment().getDefaultScreenDevice();
	public static int width = gd.getDisplayMode().getWidth();
	public static int height = gd.getDisplayMode().getHeight();
	
	static SpriteSheet blocks = new SpriteSheet();
	
	public static void main(String[] args) {
	 GameWindows frame = new GameWindows("pr1", width, height);
	 frame.setFullScreenMode(1);
	 frame.addKeyListener(new Player());
	 frame.add(new GameLoop(width,height));
	 frame.setVisible(true);
	}
}

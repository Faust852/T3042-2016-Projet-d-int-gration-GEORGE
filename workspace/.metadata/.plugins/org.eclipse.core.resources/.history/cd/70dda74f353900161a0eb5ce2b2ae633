package pr1.main;

import java.awt.GraphicsDevice;
import java.awt.GraphicsEnvironment;

public class Main {
	
	public static GraphicsDevice gd = GraphicsEnvironment.getLocalGraphicsEnvironment().getDefaultScreenDevice();
	public static int width = gd.getDisplayMode().getWidth();
	public static int height = gd.getDisplayMode().getHeight();
	
	static SpriteSheet blocks = new SpriteSheet();
	
	public static void main(String[] args) {
	 GameWindows frame = new GameWindows("pr1", 800, 600);
	 frame.setFullScreenMode(0);
	 frame.add(new GameLoop(width,height));
	 frame.setVisible(true);
	}
}

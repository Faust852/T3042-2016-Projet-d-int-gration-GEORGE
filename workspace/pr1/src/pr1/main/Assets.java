package pr1.main;

import java.awt.image.BufferedImage;

public class Assets {
	
	SpriteSheet blocks = new SpriteSheet();
	
	public  static BufferedImage stone_1;
	public  static BufferedImage wall_1;
	
	public void init() {
		blocks.setSpriteSheet(LoadImageFrom.loadImageFrom(Main.class, "spriteSheet.png"));
		
		stone_1 = blocks.getTile(0, 0, 16, 16);
		wall_1 = blocks.getTile(16, 0, 16, 16);
	}

	public static BufferedImage getStone_1() {
		return stone_1;
	}
	public static BufferedImage getWall_1() {
		return wall_1;
	}
}

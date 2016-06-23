package pr1.main;

import java.awt.Graphics2D;
import java.awt.image.BufferedImage;

import pr1.main.Block.BlockType;

public class Map {
	
	TileManager tiles = new TileManager();
	
	Player player = new Player();


	public Map() {
		
	}
	
	public void init(){
		player.init();
		
		BufferedImage map = null;
		
		try {
			map = LoadImageFrom.loadImageFrom(Main.class, "map.png");  
		} catch (Exception e) {
			e.printStackTrace();
		}
		
		for (int x = 0; x < 100; x++) {
			for (int y = 0; y < 100; y++) {
				int color = map.getRGB(x, y);
				switch (color & 0xffffff) {
				case 0x808080:
					tiles.blocks.add(new Block(new Vector2F(x*48,y*48), BlockType.STONE_1));
					break;
				case 0x707070:
					tiles.blocks.add(new Block(new Vector2F(x*48,y*48), BlockType.WALL_1).isSolid(true));
					break;

				default:
					break;
				}
			}
		}
		
	}
	
	public void tick(double deltaTime){
		tiles.tick(deltaTime);
		player.tick(deltaTime);
	}
	
	public void render(Graphics2D g){
		tiles.render(g);
		player.render(g);
	}

}

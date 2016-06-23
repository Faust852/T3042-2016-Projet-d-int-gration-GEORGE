package pr1.main;

import java.awt.Graphics2D;
import java.util.ArrayList;

public class TileManager {
	
	public ArrayList<Block> blocks= new ArrayList<>();

	public TileManager() {
		// TODO Auto-generated constructor stub
	}
	
	public void tick(double deltaTime){
		for(Block block : blocks) {
			block.tick(deltaTime);

		}
	}
	
	public void render(Graphics2D g){
		for(Block block : blocks) {
			block.render(g);
		}
	}
}

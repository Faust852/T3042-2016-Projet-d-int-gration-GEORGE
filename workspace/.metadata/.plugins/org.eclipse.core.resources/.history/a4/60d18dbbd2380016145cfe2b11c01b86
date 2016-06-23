package pr1.main;

import java.awt.Graphics2D;
import java.awt.Rectangle;
import java.awt.image.BufferedImage;

public class Block extends Rectangle{
	
	Vector2F pos = new Vector2F();
	private int blockSize = 48;
	private BlockType blocktype;
	private BufferedImage block;
	

	public Block(Vector2F pos, BlockType blockyype) {
		this.pos = pos;
		this.blocktype = blockyype;
		init();
	}
	
	public void init() {
		switch (blocktype) {
		case STONE_1:
			block = Assets.getStone_1();
			break;

		}
	}
	
	public void tick(double deltaTime){
		
	}
	
	public void render(Graphics2D g){
		//g.drawRect((int)pos.getWorldLocation().xPos, (int)pos.getWorldLocation().yPos, blockSize, blockSize);
		g.drawImage(block, (int)pos.getWorldLocation().xPos, (int)pos.getWorldLocation().yPos, blockSize, blockSize, null);
	}
	
	public enum BlockType{
		STONE_1
	}

	

}

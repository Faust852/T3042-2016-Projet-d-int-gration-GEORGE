package pr1.main;

import java.awt.Graphics2D;
import java.awt.Point;
import java.awt.event.KeyEvent;
import java.awt.event.KeyListener;

public class Player implements KeyListener {
	
	Vector2F pos;
	private int width = 42;
	private int height = 42;

	private static boolean up, down, left, right;
	
	private float maxSpeed = 3*32F;
	
	private float speedUp = 0;
	private float speedDown = 0;
	private float speedLeft = 0;
	private float speedRight = 0;
	
	private float slowDown = 4.093F;
	
	private float fixedDt = 1f/60F;
	
	private boolean mapMove = true;
	
	
	
	public Player() {
		pos = new Vector2F(Main.width / 2 - width / 2, Main.height / 2 - height / 2);
		}
	
	public void init() {
		// TODO Auto-generated method stub
		
	}

	public void tick(double deltaTime) {
		
		float moveAmountUp =(float) (speedUp * fixedDt);
		float moveAmountDown =(float) (speedDown * fixedDt);
		float moveAmountLeft =(float) (speedLeft * fixedDt);
		float moveAmountRight =(float) (speedRight * fixedDt);
		
		if(!mapMove) {
			if(up) {
				if(!Check.CollisionPlayerBlock(
						new Point(	(int)(pos.xPos + GameLoop.map.xPos),
									(int)(pos.yPos + GameLoop.map.yPos - moveAmountUp)),
						new Point(	(int)(pos.xPos + GameLoop.map.xPos + width),
									(int)(pos.yPos + GameLoop.map.yPos - moveAmountUp)) )) {
					
					if(speedUp < maxSpeed){
						speedUp += slowDown;
					}else{
						speedUp = maxSpeed;
					}
					pos.yPos-=moveAmountUp;
				}else {
					speedUp = 0;
				}

			}else {
				if(!Check.CollisionPlayerBlock(
						new Point(	(int)(pos.xPos + GameLoop.map.xPos),
									(int)(pos.yPos + GameLoop.map.yPos - moveAmountUp)),
						new Point(	(int)(pos.xPos + GameLoop.map.xPos + width),
									(int)(pos.yPos + GameLoop.map.yPos - moveAmountUp)) )) {
					if(speedUp != 0){
						speedUp -= slowDown;
						if (speedUp < 0) {
							speedUp = 0;
						}
					}
					pos.yPos-=moveAmountUp;
				}else {
					speedUp = 0;
				}
			}
			
			if(down) {
				if(!Check.CollisionPlayerBlock(
						new Point(	(int)(pos.xPos + GameLoop.map.xPos),
									(int)(pos.yPos + GameLoop.map.yPos + height + moveAmountDown)),
						new Point(	(int)(pos.xPos + GameLoop.map.xPos + width),
									(int)(pos.yPos + GameLoop.map.yPos + height + moveAmountDown)) )) {
					if(speedDown < maxSpeed){
						speedDown += slowDown;
					}else{
						speedDown = maxSpeed;
					}
					pos.yPos+=moveAmountDown;
				}else {
					speedDown=0;
				}
				
				
			}else {
				if(!Check.CollisionPlayerBlock(
						new Point(	(int)(pos.xPos + GameLoop.map.xPos),
									(int)(pos.yPos + GameLoop.map.yPos + height + moveAmountDown)),
						new Point(	(int)(pos.xPos + GameLoop.map.xPos + width),
									(int)(pos.yPos + GameLoop.map.yPos + height + moveAmountDown)) )) {
					if(speedDown != 0){
						speedDown -= slowDown;
						if (speedDown < 0) {
							speedDown = 0;
						}
					}
					pos.yPos+=moveAmountDown;
				}else {
					speedDown = 0;
				}
			}
			if(left) {
				if(!Check.CollisionPlayerBlock(
						new Point(	(int)(pos.xPos + GameLoop.map.xPos - moveAmountLeft),
									(int)(pos.yPos + GameLoop.map.yPos + height)),
						new Point(	(int)(pos.xPos + GameLoop.map.xPos - moveAmountLeft),
									(int)(pos.yPos + GameLoop.map.yPos)) )) {
					if(speedLeft < maxSpeed){
						speedLeft += slowDown;
					}else{
						speedLeft = maxSpeed;
					}
					pos.xPos-=moveAmountLeft;
				}else {
					speedLeft = 0;
				}
			}
			else {
				if(!Check.CollisionPlayerBlock(
						new Point(	(int)(pos.xPos + GameLoop.map.xPos - moveAmountLeft),
									(int)(pos.yPos + GameLoop.map.yPos + height)),
						new Point(	(int)(pos.xPos + GameLoop.map.xPos - moveAmountLeft),
									(int)(pos.yPos + GameLoop.map.yPos)) )) {
					if(speedLeft != 0){
						speedLeft -= slowDown;
						if (speedLeft < 0) {
							speedLeft = 0;
						}
					}
					pos.xPos-=moveAmountLeft;
				}else {
					speedLeft = 0;
				}
			}
			if(right) {
				if(!Check.CollisionPlayerBlock(
						new Point(	(int)(pos.xPos + GameLoop.map.xPos + width + moveAmountRight),
									(int)(pos.yPos + GameLoop.map.yPos)),
						new Point(	(int)(pos.xPos + GameLoop.map.xPos + width + moveAmountRight),
									(int)(pos.yPos + GameLoop.map.yPos + height)) )) {
					if(speedRight < maxSpeed){
						speedRight += slowDown;
					}else{
						speedRight = maxSpeed;
					}
					pos.xPos+=moveAmountRight;
				}else {
					speedRight = 0;
				}
			}
			else {
				if(!Check.CollisionPlayerBlock(
						new Point(	(int)(pos.xPos + GameLoop.map.xPos + width + moveAmountRight),
									(int)(pos.yPos + GameLoop.map.yPos)),
						new Point(	(int)(pos.xPos + GameLoop.map.xPos + width + moveAmountRight),
									(int)(pos.yPos + GameLoop.map.yPos + height)) )) {
					if(speedRight != 0){
						speedRight -= slowDown;
						if (speedRight < 0) {
							speedRight = 0;
						}
					}
					pos.xPos+=moveAmountRight;
				}else {
					speedRight = 0;
				}
			}
			
			
			
			


			
		}else {
			if(up) {
				if(!Check.CollisionPlayerBlock(
						new Point(	(int)(pos.xPos + GameLoop.map.xPos),
									(int)(pos.yPos + GameLoop.map.yPos - moveAmountUp)),
						new Point(	(int)(pos.xPos + GameLoop.map.xPos + width),
									(int)(pos.yPos + GameLoop.map.yPos - moveAmountUp)) )) {
					
					if(speedUp < maxSpeed){
						speedUp += slowDown;
					}else{
						speedUp = maxSpeed;
					}
					GameLoop.map.yPos-=moveAmountUp;
				}else {
					speedUp = 0;
				}

			}else {
				if(!Check.CollisionPlayerBlock(
						new Point(	(int)(pos.xPos + GameLoop.map.xPos),
									(int)(pos.yPos + GameLoop.map.yPos - moveAmountUp)),
						new Point(	(int)(pos.xPos + GameLoop.map.xPos + width),
									(int)(pos.yPos + GameLoop.map.yPos - moveAmountUp)) )) {
					if(speedUp != 0){
						speedUp -= slowDown;
						if (speedUp < 0) {
							speedUp = 0;
						}
					}
					GameLoop.map.yPos-=moveAmountUp;
				}else {
					speedUp = 0;
				}
			}

			if(down) {
				if(!Check.CollisionPlayerBlock(
						new Point(	(int)(pos.xPos + GameLoop.map.xPos),
									(int)(pos.yPos + GameLoop.map.yPos + height + moveAmountDown)),
						new Point(	(int)(pos.xPos + GameLoop.map.xPos + width),
									(int)(pos.yPos + GameLoop.map.yPos + height + moveAmountDown)) )) {
					if(speedDown < maxSpeed){
						speedDown += slowDown;
					}else{
						speedDown = maxSpeed;
					}
					GameLoop.map.yPos+=moveAmountDown;
				}else {
					speedDown=0;
				}
				
				
			}else {
				if(!Check.CollisionPlayerBlock(
						new Point(	(int)(pos.xPos + GameLoop.map.xPos),
									(int)(pos.yPos + GameLoop.map.yPos + height + moveAmountDown)),
						new Point(	(int)(pos.xPos + GameLoop.map.xPos + width),
									(int)(pos.yPos + GameLoop.map.yPos + height + moveAmountDown)) )) {
					if(speedDown != 0){
						speedDown -= slowDown;
						if (speedDown < 0) {
							speedDown = 0;
						}
					}
					GameLoop.map.yPos+=moveAmountDown;
				}else {
					speedDown = 0;
				}
			}
			if(left) {
				if(!Check.CollisionPlayerBlock(
						new Point(	(int)(pos.xPos + GameLoop.map.xPos - moveAmountLeft),
									(int)(pos.yPos + GameLoop.map.yPos + height)),
						new Point(	(int)(pos.xPos + GameLoop.map.xPos - moveAmountLeft),
									(int)(pos.yPos + GameLoop.map.yPos)) )) {
					if(speedLeft < maxSpeed){
						speedLeft += slowDown;
					}else{
						speedLeft = maxSpeed;
					}
					GameLoop.map.xPos-=moveAmountLeft;
				}else {
					speedLeft = 0;
				}
			}
			else {
				if(!Check.CollisionPlayerBlock(
						new Point(	(int)(pos.xPos + GameLoop.map.xPos - moveAmountLeft),
									(int)(pos.yPos + GameLoop.map.yPos + height)),
						new Point(	(int)(pos.xPos + GameLoop.map.xPos - moveAmountLeft),
									(int)(pos.yPos + GameLoop.map.yPos)) )) {
					if(speedLeft != 0){
						speedLeft -= slowDown;
						if (speedLeft < 0) {
							speedLeft = 0;
						}
					}
					GameLoop.map.xPos-=moveAmountLeft;
				}else {
					speedLeft = 0;
				}
			}
			
			}
		if(right) {
			if(!Check.CollisionPlayerBlock(
					new Point(	(int)(pos.xPos + GameLoop.map.xPos + width + moveAmountRight),
								(int)(pos.yPos + GameLoop.map.yPos)),
					new Point(	(int)(pos.xPos + GameLoop.map.xPos + width + moveAmountRight),
								(int)(pos.yPos + GameLoop.map.yPos + height)) )) {
				if(speedRight < maxSpeed){
					speedRight += slowDown;
				}else{
					speedRight = maxSpeed;
				}
				GameLoop.map.xPos+=moveAmountRight;
			}else {
				speedRight = 0;
			}
		}
		else {
			if(!Check.CollisionPlayerBlock(
					new Point(	(int)(pos.xPos + GameLoop.map.xPos + width + moveAmountRight),
								(int)(pos.yPos + GameLoop.map.yPos)),
					new Point(	(int)(pos.xPos + GameLoop.map.xPos + width + moveAmountRight),
								(int)(pos.yPos + GameLoop.map.yPos + height)) )) {
				if(speedRight != 0){
					speedRight -= slowDown;
					if (speedRight < 0) {
						speedRight = 0;
					}
				}
				GameLoop.map.xPos+=moveAmountRight;
			}else {
				speedRight = 0;
			}
		}
	}


	public void render(Graphics2D g) {
		g.fillRect((int)pos.xPos, (int)pos.yPos, width, height);		
	}

	@Override
	public void keyPressed(KeyEvent e) {
		int key = e.getKeyCode();
		
		if (key == KeyEvent.VK_Z){
			up = true;
		}
		if (key == KeyEvent.VK_S){
			down = true;
		}
		if (key == KeyEvent.VK_Q){
			left = true;
		}
		if (key == KeyEvent.VK_D){
			right = true;
		}
	}

	@Override
	public void keyReleased(KeyEvent e) {	
		int key = e.getKeyCode();
		
		if (key == KeyEvent.VK_Z){
			up = false;
		}
		if (key == KeyEvent.VK_S){
			down = false;
		}
		if (key == KeyEvent.VK_Q){
			left = false;
		}
		if (key == KeyEvent.VK_D){
			right = false;
		}
		
	}

	@Override
	public void keyTyped(KeyEvent e) {
		// TODO Auto-generated method stub
		
	}

}

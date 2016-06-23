package pr1.main;

import java.awt.Color;
import java.awt.Graphics2D;
import java.awt.Point;
import java.awt.event.KeyEvent;
import java.awt.event.KeyListener;
import java.awt.image.BufferedImage;
import java.util.ArrayList;

public class Player implements KeyListener {
	
	Vector2F pos;
	private int width = 42;
	private int height = 42;
	private int scale = 2;

	private static boolean up, down, left, right;
	
	private float maxSpeed = 3*32F;
	
	private float speedUp = 0;
	private float speedDown = 0;
	private float speedLeft = 0;
	private float speedRight = 0;
	
	private float slowDown = 4.093F;
	
	private float fixedDt = 1f/60F;
	
	//TODO
	private int animationState = 4;
	
	/*
	 * 0=up
	 * 1=down
	 * 2=right
	 * 3=left
	 * 4=idle
	 */
	
	private ArrayList<BufferedImage> listUp;
	Animator ani_up;
	private ArrayList<BufferedImage> listDown;
	Animator ani_down;
	private ArrayList<BufferedImage> listRight;
	Animator ani_right;
	private ArrayList<BufferedImage> listLeft;
	Animator ani_left;
	private ArrayList<BufferedImage> listIdle;
	Animator ani_idle;
	
	public Player() {
		pos = new Vector2F(Main.width / 2 - width / 2, Main.height / 2 - height / 2);
		}
	
	public void init() {
		listUp = new ArrayList<BufferedImage>();
		listDown = new ArrayList<BufferedImage>();
		listLeft = new ArrayList<BufferedImage>();
		listRight = new ArrayList<BufferedImage>();
		listIdle = new ArrayList<BufferedImage>();
		
		listUp.add(Assets.player.getTile(0, 32, 16, 16));
		listUp.add(Assets.player.getTile(16, 32, 16, 16));
		
		listDown.add(Assets.player.getTile(0, 16, 16, 16));
		listDown.add(Assets.player.getTile(16, 16, 16, 16));
		
		listRight.add(Assets.player.getTile(32, 16, 16, 16));
		listRight.add(Assets.player.getTile(32, 32, 16, 16));
		
		listLeft.add(Assets.player.getTile(48, 16, 16, 16));
		listLeft.add(Assets.player.getTile(48, 32, 16, 16));
		
		listIdle.add(Assets.player.getTile(0, 0, 16, 16));
		
		
		//up
		ani_up = new Animator(listUp);
		ani_up.setSpeed(180);
		ani_up.play();
		//down
		ani_down = new Animator(listDown);
		ani_down.setSpeed(180);
		ani_down.play();
		//left
		ani_left = new Animator(listLeft);
		ani_left.setSpeed(180);
		ani_left.play();
		//right
		ani_right = new Animator(listRight);
		ani_right.setSpeed(180);
		ani_right.play();	
		//idle
		ani_idle = new Animator(listIdle);
		ani_idle.setSpeed(180);
		ani_idle.play();
	}

	public void tick(double deltaTime) {
		
		float moveAmountUp =(float) (speedUp * fixedDt);
		float moveAmountDown =(float) (speedDown * fixedDt);
		float moveAmountLeft =(float) (speedLeft * fixedDt);
		float moveAmountRight =(float) (speedRight * fixedDt);
		
		if(up){
			moveMapUp(moveAmountUp);
			animationState = 0;
		}else{
			moveMapUpGlide(moveAmountUp);
		}	
		if(down){
			moveMapDown(moveAmountDown);
			animationState = 1;
		}else{
			moveMapDownGlide(moveAmountDown);
		}	
		if(right){
			moveMapRight(moveAmountRight);
			animationState = 2;
		}else{
			moveMapRightGlide(moveAmountRight);
		}	
		if(left){
			moveMapLeft(moveAmountLeft);
			animationState = 3;
		}else{
			moveMapLeftGlide(moveAmountLeft);
		}		
		if(!up && !down && !right && !left){
			animationState = 4;
		}
	}

	public void moveMapUp(float speed){
		if(!Check.CollisionPlayerBlock(
				
				new Point((int) (pos.xPos + GameLoop.map.xPos) ,
						  (int) (pos.yPos + GameLoop.map.yPos - speed)),
						  
				new Point((int) (pos.xPos + GameLoop.map.xPos + width) , 
						  (int) (pos.yPos + GameLoop.map.yPos - speed))  )){
			
			if(speedUp < maxSpeed){
				speedUp += slowDown;
			}else{
				speedUp = maxSpeed;
			}
			
			GameLoop.map.yPos-=speed;
			
		}else{
			speedUp = 0;
		}	
	}
	public void moveMapUpGlide(float speed){
		if(!Check.CollisionPlayerBlock(
				new Point(	(int)(pos.xPos + GameLoop.map.xPos),
							(int)(pos.yPos + GameLoop.map.yPos - speed)),
				new Point(	(int)(pos.xPos + GameLoop.map.xPos + width),
							(int)(pos.yPos + GameLoop.map.yPos - speed)) )) {
			
			if(speedUp != 0){
				speedUp -= slowDown;
				if(speedUp < 0){
					speedUp = 0;
				}	
			}
			GameLoop.map.yPos-=speed;
		}else {
			speedUp = 0;
		}
	}
	
	public void moveMapDown(float speed){
		if(!Check.CollisionPlayerBlock(
				new Point(	(int)(pos.xPos + GameLoop.map.xPos),
							(int)(pos.yPos + GameLoop.map.yPos + height + speed)),
				new Point(	(int)(pos.xPos + GameLoop.map.xPos + width),
							(int)(pos.yPos + GameLoop.map.yPos + height + speed)) )) {
			if(speedDown < maxSpeed){
				speedDown += slowDown;
			}else{
				speedDown = maxSpeed;
			}
			GameLoop.map.yPos+=speed;
		}else {
			speedDown=0;
		}
		
		
	}
	public void moveMapDownGlide(float speed){
		if(!Check.CollisionPlayerBlock(
				new Point(	(int)(pos.xPos + GameLoop.map.xPos),
							(int)(pos.yPos + GameLoop.map.yPos + height + speed)),
				new Point(	(int)(pos.xPos + GameLoop.map.xPos + width),
							(int)(pos.yPos + GameLoop.map.yPos + height + speed)) )) {
			if(speedDown != 0){
				speedDown -= slowDown;
				if (speedDown < 0) {
					speedDown = 0;
				}
			}
			GameLoop.map.yPos+=speed;
		}else {
			speedDown=0;
		}
	}
	
	public void moveMapRight(float speed){
		if(!Check.CollisionPlayerBlock(
				new Point(	(int)(pos.xPos + GameLoop.map.xPos + width + speed),
							(int)(pos.yPos + GameLoop.map.yPos)),
				new Point(	(int)(pos.xPos + GameLoop.map.xPos + width + speed),
							(int)(pos.yPos + GameLoop.map.yPos + height)) )) {
			if(speedRight < maxSpeed){
				speedRight += slowDown;
			}else{
				speedRight = maxSpeed;
			}
			GameLoop.map.xPos+=speed;
		}else {
			speedRight = 0;
		}
	}
	public void moveMapRightGlide(float speed){
		if(!Check.CollisionPlayerBlock(
				new Point(	(int)(pos.xPos + GameLoop.map.xPos + width + speed),
							(int)(pos.yPos + GameLoop.map.yPos)),
				new Point(	(int)(pos.xPos + GameLoop.map.xPos + width + speed),
							(int)(pos.yPos + GameLoop.map.yPos + height)) )) {
			if(speedRight != 0){
				speedRight -= slowDown;
				if (speedRight < 0) {
					speedRight = 0;
				}
			}
			GameLoop.map.xPos+=speed;
		}else {
			speedRight = 0;
		}
	}
	
	public void moveMapLeft(float speed){
		if(!Check.CollisionPlayerBlock(		
			new Point((int) (pos.xPos + GameLoop.map.xPos - speed) ,
					  (int) (pos.yPos + GameLoop.map.yPos + height)),
					  
			new Point((int) (pos.xPos + GameLoop.map.xPos - speed) , 
					  (int) (pos.yPos + GameLoop.map.yPos))  )){
			if(speedLeft < maxSpeed){
				speedLeft += slowDown;
			}else{
				speedLeft = maxSpeed;
			}
			GameLoop.map.xPos-=speed;
			
		}else{
			speedLeft = 0;
		}
	}	
	public void moveMapLeftGlide(float speed){
		if(!Check.CollisionPlayerBlock(
			new Point((int) (pos.xPos + GameLoop.map.xPos - speed) ,
					  (int) (pos.yPos + GameLoop.map.yPos + height)),
					  
			new Point((int) (pos.xPos + GameLoop.map.xPos - speed) , 
					  (int) (pos.yPos + GameLoop.map.yPos))  )){	
			if(speedLeft != 0){
				speedLeft -= slowDown;
				
				if(speedLeft < 0){
					speedLeft = 0;
				}
			}	
			GameLoop.map.xPos-=speed;			
		}else{
			speedLeft = 0;
		}
	}
	
	

	public void render(Graphics2D g) {
		g.fillRect((int)pos.xPos, (int)pos.yPos, width, height);
		
		g.setColor(Color.BLACK);
		g.fillRect(0, 0, Main.width, Main.height / 6);
		g.fillRect(0, 750, Main.width, Main.height / 6);
		g.setColor(Color.WHITE);
		
		g.clipRect(0, 0, Main.width, Main.height);
		
		if(animationState == 0) {
			g.drawImage(ani_up.sprite,(int)pos.xPos, (int)pos.yPos, width, height, null);
			if(up){
				ani_up.update(System.currentTimeMillis());
			}
		}
		if(animationState == 1) {
			g.drawImage(ani_down.sprite,(int)pos.xPos, (int)pos.yPos, width, height, null);
			if(down){
				ani_down.update(System.currentTimeMillis());
			}
		}
		if(animationState == 2) {
			g.drawImage(ani_right.sprite,(int)pos.xPos, (int)pos.yPos, width, height, null);
			if(right){
				ani_right.update(System.currentTimeMillis());
			}
		}
		if(animationState == 3) {
			g.drawImage(ani_left.sprite,(int)pos.xPos, (int)pos.yPos, width, height, null);
			if(left){
				ani_left.update(System.currentTimeMillis());
			}
		}

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

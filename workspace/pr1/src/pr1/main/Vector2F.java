package pr1.main;

public class Vector2F {
	
	public float xPos;
	public float yPos;

	public static float worldXPos;
	public static float worldYPos;
	
	public Vector2F() {
		this.xPos = 0.0F;
		this.yPos = 0.0F;
	}
	public Vector2F(float xPos, float yPos) {
		this.xPos = xPos;
		this.yPos = yPos;
	}
	
	public static Vector2F zero() {
		return new Vector2F(0,0);		
	}
	
	public void normalize() {
		double length = Math.sqrt(xPos * xPos + yPos * yPos);
		if (length != 0.0) {
			float s = 1.0F / (float) length;
			xPos = xPos*s;
			yPos = yPos*s;
		}
	}
	
	public Vector2F getScreenLocation() {
		return new Vector2F(xPos, yPos);
	}
	
	public Vector2F getWorldLocation() {
		return new Vector2F(xPos - worldXPos, yPos - worldYPos);
	}
	
	public boolean equals(Vector2F v) {
		return (this.xPos == v.xPos && this.yPos == v.yPos);
	}
	
	public Vector2F copy(Vector2F v) {
		xPos = v.xPos;
		yPos = v.yPos;
		return new Vector2F(xPos,yPos);
	}
	
	public Vector2F add(Vector2F v){
		xPos = xPos + v.xPos;
		yPos = yPos + v.yPos;
		return new Vector2F(xPos, yPos);
	}
	
	public static void setWorldVariable(float wx,float wy) {
		worldXPos = wx;
		worldYPos = wy;
	}
	
	public static double getDistanceOnScreen(Vector2F v1, Vector2F v2){
		float vec1 = v1.xPos - v2.xPos;
		float vec2 = v1.yPos - v2.yPos;
		return Math.sqrt(vec1*vec1 + vec2*vec2);
	}
	
	public double getDistanceBetweenWorldVectors(Vector2F v){
		float dx = Math.abs(getWorldLocation().xPos - v.getWorldLocation().xPos);
		float dy = Math.abs(getWorldLocation().yPos - v.getWorldLocation().yPos);
		return Math.abs(dx*dx - dy*dy);
	}
	
}






















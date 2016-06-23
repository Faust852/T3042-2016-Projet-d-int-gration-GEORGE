package pr1.main;

import java.awt.GraphicsDevice;
import java.awt.GraphicsEnvironment;

import javax.swing.JFrame;
import javax.swing.WindowConstants;

public class GameWindows extends JFrame{
	
	boolean fullScreenEnable = false;
	int fullScreenMod = 0;
	GraphicsDevice device = GraphicsEnvironment.getLocalGraphicsEnvironment().getScreenDevices()[0];
	
	public GameWindows(String title, int width, int height){
		setTitle(title);
		setSize(width, height);
		setLocationRelativeTo(null);
		setDefaultCloseOperation(DISPOSE_ON_CLOSE);
		setResizable(false);
	}
	
	private void setFullScreen(){
		switch (fullScreenMod) {
		case 0:
			System.out.println("No fullScreen");
			setUndecorated(false);
			break;
		case 1:
			setUndecorated(true);
			setExtendedState(JFrame.MAXIMIZED_BOTH);
			break;
		case 2:
			setUndecorated(true);
			device.setFullScreenWindow(this);
			break;
		}
	}
	
	public void setFullScreenMode(int fullScreenNewMod) {
		fullScreenEnable = true;
		if (fullScreenMod <= 2) {
			this.fullScreenMod = fullScreenNewMod;
			setFullScreen();
		}
		else{
			System.err.println("Error " + fullScreenNewMod + " not supported");
		}
	}
}







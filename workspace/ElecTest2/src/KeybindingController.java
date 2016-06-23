/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

import java.awt.event.ActionEvent;
import javax.swing.AbstractAction;
import javax.swing.Action;
import javax.swing.JButton;
import javax.swing.KeyStroke;

public class KeybindingController {
    GUI window = null;

    private int limit = 400;

    private static final int SPEED_INCREMENT = 5;

    private static char away = 'q';
    private static char close = 'a';

    public KeybindingController(GUI window)
    {
        this.window = window;
    }

    public void bindKeys()
    {
        //set input maps so that the program can read key bindings
        //putting something in the input map means to assign a key to an action name
        //action name is associated with a method in the action map
        window.btnFurther.getInputMap(JButton.WHEN_IN_FOCUSED_WINDOW).put(KeyStroke.getKeyStroke(away), "away");
        window.btnFurther.getInputMap(JButton.WHEN_IN_FOCUSED_WINDOW).put(KeyStroke.getKeyStroke(Character.toUpperCase(away)), "away");
        window.btnFurther.getActionMap().put("away", putAway);

        window.btnCloser.getInputMap(JButton.WHEN_IN_FOCUSED_WINDOW).put(KeyStroke.getKeyStroke(close), "close");
        window.btnCloser.getInputMap(JButton.WHEN_IN_FOCUSED_WINDOW).put(KeyStroke.getKeyStroke(Character.toUpperCase(close)), "close");
    }

    public void toggleControls()
    {
        if (window.communicator.getConnected() == true)
        {
            window.btnFurther.setEnabled(true);
            window.btnCloser.setEnabled(true);
            window.btnDisconnect.setEnabled(true);
            window.btnConnect.setEnabled(false);
            window.cboxPorts.setEnabled(false);
        }
        else
        {
            window.btnFurther.setEnabled(false);
            window.btnCloser.setEnabled(false);
            window.btnDisconnect.setEnabled(false);
            window.btnConnect.setEnabled(true);
            window.cboxPorts.setEnabled(true);
        }
    }

    //defining the action
    Action putAway = new AbstractAction()
    {
        public void actionPerformed(ActionEvent evt)
        {
        	limit = further(limit);
            updateLabels();
        }
    };

    Action putCloser = new AbstractAction()
    {
        public void actionPerformed(ActionEvent evt)
        {
        	limit = closer(limit);
            updateLabels();
        }
    };

    public void updateLabels()
    {
        window.lblLimit.setText(String.valueOf(limit));

        window.communicator.writeData(limit);
    }

    public int further(int limit)
    {
        if (limit < 999)
        {
        	limit += SPEED_INCREMENT;
        }
        return limit;
    }

    public int closer(int limit)
    {
        if (limit > 0)
        {
        	limit -= SPEED_INCREMENT;
        }
        return limit;
    }

    final public int getLimit()
    {
        return limit;
    }

    public void setLimit(int value)
    {
    	limit = value;
    }

}

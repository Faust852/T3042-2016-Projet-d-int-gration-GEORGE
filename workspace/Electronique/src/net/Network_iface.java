package net;

/**
 * An instance of a class implementing this interface has to be passed to the
 * constructor of {@link net.Network}. It will be used by {@link net.Network} to
 * forward received messages, write to a log and take action when the connection
 * is closed.
 * 
 * @see net.Network#Network(int, Network_iface, int)
 * 
 * @author Raphael Blatter (raphael@blatter.sg)
 */
public interface Network_iface {

	public void writeLog(int id, String text);

	public void parseInput(int id, int numBytes, int[] message);

	public void networkDisconnected(int id);
}

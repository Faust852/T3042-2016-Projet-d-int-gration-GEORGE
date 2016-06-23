package net;

import gnu.io.*;

import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.util.Enumeration;
import java.util.Vector;

public class Network {
	private InputStream inputStream;
	private OutputStream outputStream;

	private boolean connected = false;

	private Thread reader;
	private SerialPort serialPort;

	private boolean end = false;

	private Network_iface contact;

	private int divider;

	private int id;

	private int[] tempBytes;
	int numTempBytes = 0, numTotBytes = 0;

	public Network(int id, Network_iface contact, int divider) {
		this.contact = contact;
		this.divider = divider;
		if (this.divider > 255)
			this.divider = 255;
		if (this.divider < 0)
			this.divider = 0;
		this.id = id;
		tempBytes = new int[1024];
	}

	public Network(int id, Network_iface contact) {
		this(id, contact, 255);
	}

	public Network(Network_iface contact) {
		this(0, contact);
	}

	@SuppressWarnings("unchecked")
	public Vector<String> getPortList() {
		Enumeration<CommPortIdentifier> portList;
		Vector<String> portVect = new Vector<String>();
		portList = CommPortIdentifier.getPortIdentifiers();

		CommPortIdentifier portId;
		while (portList.hasMoreElements()) {
			portId = (CommPortIdentifier) portList.nextElement();
			if (portId.getPortType() == CommPortIdentifier.PORT_SERIAL) {
				portVect.add(portId.getName());
			}
		}
		contact.writeLog(id, "found the following ports:");
		for (int i = 0; i < portVect.size(); i++) {
			contact.writeLog(id, ("   " + (String) portVect.elementAt(i)));
		}

		return portVect;
	}

	public boolean connect(String portName) {
		return connect(portName, 115200);
	}

	public boolean connect(String portName, int speed) {
		CommPortIdentifier portIdentifier;
		boolean conn = false;
		try {
			portIdentifier = CommPortIdentifier.getPortIdentifier(portName);
			if (portIdentifier.isCurrentlyOwned()) {
				contact.writeLog(id, "Error: Port is currently in use");
			} else {
				serialPort = (SerialPort) portIdentifier.open("RTBug_network",
						2000);
				serialPort.setSerialPortParams(speed, SerialPort.DATABITS_8,
						SerialPort.STOPBITS_1, SerialPort.PARITY_NONE);

				inputStream = serialPort.getInputStream();
				outputStream = serialPort.getOutputStream();

				reader = (new Thread(new SerialReader(inputStream)));
				end = false;
				reader.start();
				connected = true;
				contact.writeLog(id, "connection on " + portName
						+ " established");
				conn = true;
			}
		} catch (NoSuchPortException e) {
			contact.writeLog(id, "the connection could not be made");
			e.printStackTrace();
		} catch (PortInUseException e) {
			contact.writeLog(id, "the connection could not be made");
			e.printStackTrace();
		} catch (UnsupportedCommOperationException e) {
			contact.writeLog(id, "the connection could not be made");
			e.printStackTrace();
		} catch (IOException e) {
			contact.writeLog(id, "the connection could not be made");
			e.printStackTrace();
		}
		return conn;
	}

	private class SerialReader implements Runnable {
		InputStream in;

		public SerialReader(InputStream in) {
			this.in = in;
		}

		public void run() {
			byte[] buffer = new byte[1024];
			int len = -1, i, temp;
			try {
				while (!end) {
					if ((in.available()) > 0) {
						if ((len = this.in.read(buffer)) > -1) {
							for (i = 0; i < len; i++) {
								temp = buffer[i];
								 // adjust from C-Byte to Java-Byte
								if (temp < 0)
									temp += 256;
								if (temp == divider) {
									if  (numTempBytes > 0) {
										contact.parseInput(id, numTempBytes,
												tempBytes);
									}
									numTempBytes = 0;
								} else {
									tempBytes[numTempBytes] = temp;
									++numTempBytes;
								}
							}
						}
					}
				}
			} catch (IOException e) {
				end = true;
				try {
					outputStream.close();
					inputStream.close();
				} catch (IOException e1) {
					e1.printStackTrace();
				}
				serialPort.close();
				connected = false;
				contact.networkDisconnected(id);
				contact.writeLog(id, "connection has been interrupted");
			}
		}
	}

	public boolean disconnect() {
		boolean disconn = true;
		end = true;
		try {
			reader.join();
		} catch (InterruptedException e1) {
			e1.printStackTrace();
			disconn = false;
		}
		try {
			outputStream.close();
			inputStream.close();
		} catch (IOException e) {
			e.printStackTrace();
			disconn = false;
		}
		serialPort.close();
		connected = false;
		contact.networkDisconnected(id);
		contact.writeLog(id, "connection disconnected");
		return disconn;
	}

	public boolean isConnected() {
		return connected;
	}

	public boolean writeSerial(String message) {
		boolean success = false;
		if (isConnected()) {
			try {
				outputStream.write(message.getBytes());
				success = true;
			} catch (IOException e) {
				disconnect();
			}
		} else {
			contact.writeLog(id, "No port is connected.");
		}
		return success;
	}

	public boolean writeSerial(int numBytes, int message[]) {
		boolean success = true;
		int i;
		for (i = 0; i < numBytes; ++i) {
			if (message[i] == divider) {
				success = false;
				break;
			}
		}
		if (success && isConnected()) {
			try {
				for (i = 0; i < numBytes; ++i) {
						outputStream.write(changeToByte(message[i]));
				}
				outputStream.write(changeToByte(divider));
			} catch (IOException e) {
				success = false;
				disconnect();
			}
		} else if (!success) {
			// message contains the divider
			contact.writeLog(id, "The message contains the divider.");
		} else {
			contact.writeLog(id, "No port is connected.");
		}
		return success;
	}

	private byte changeToByte(int num) {
		byte number;
		int temp;
		temp = num;
		if (temp > 255)
			temp = 255;
		if (temp < 0)
			temp = 0;
		number = (byte) temp;
		return number;
	}
}

import RPi.GPIO as GPIO
import socket
from threading import Thread
import sys


#Listener
s=socket.socket(socket.AF_INET,socket.SOCK_STREAM)
host= '127.0.0.1'
port=int(2000)
data={}   # {'speedM1':20, 'directionM1' : True,
          # 'speedM2':20, 'directionM2' : True }
s.bind((host,port))


# Controller
speedM1 = 0 # percentage of speed
speedM2 = 0

outputPinM1 = 11 #in1
outputPinM2 = 12 #in2

directionTPinM1 = 13
directionTPinM2 = 14

directionFPinM1 = 15
directionFPinM2 = 16

directionM1 = True # True -> forward
directionM2 = True # False -> backward


GPIO.setmode(GPIO.BOARD) # use the "pin number" mode

GPIO.setup(outputPinM1, GPIO.OUT) # set the pin as output pin
GPIO.setup(outputPinM2, GPIO.OUT)

hz = 500 # frequence
motor1 = GPIO.PWM(outputPinM1, hz)
motor2 = GPIO.PWM(outputPinM2, hz)

motor1.start()
motor2.start()



class Listener(Thread):
    #def __init__(self):
    #    Thread.__init__(self)
    def run(self):
        while 1:
            s.listen(1)


            conn,addr =s.accept()

            print (conn,addr)

            data=conn.recv(100000)
            data=data.decode("utf-8")

            print(data)


            # s.close

            # FILE = open("test.txt","w")
            # FILE.write(str(data))
            # FILE.close()


class Controller(Thread):
    def run(self):
        while 1:
            try:
                speedM1 = data['speedM1']
                directionM1 = data['directionM1']

                speedM2 = data['speedM2']
                directionM2 = data['directionM2']
            except:
                print("error syntax for 'data' \n 'data' must contain 'speedM1', 'directionM1', 'speedM2', 'directionM2'")

            motor1.CangeDutyCycle(speedM1)
            self.direction(directionM1, directionTPinM1, directionFPinM1)

            motor2.CangeDutyCycle(speedM2)
            self.direction(directionM2, directionTPinM2, directionFPinM2)

    def direction(self, sens, in1, in2):
        if directionM1:
            in1 = 1
            in2 = 0
        else:
            in1 = 0
            in2 = 1

if __name__=="__main__":
    list = Listener()
    control = Controller()

    list.start()
    control.start()

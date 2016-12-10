import RPi.GPIO as GPIO
import socket
from threading import Thread
import sys
import time
import smtplib
from email.MIMEMultipart import MIMEMultipart
from email.MIMEText import MIMEText

############################################################################			
#				-----Fonctions-----
############################################################################			

####################----SendMail----#####################
def SendMail():
	msg = MIMEMultipart()
	msg['From'] = 'info@georgesecurity.me'
	msg['To'] = 'simon@ponchau.eu'
	msg['Subject'] = 'Alerte' 
	message = 'Votre robot a detect\xe9 une alerte!!'
	msg.attach(MIMEText(message))
	mailserver = smtplib.SMTP('mail.privateemail.com', 587)
	mailserver.ehlo()
	mailserver.starttls()
	mailserver.ehlo()
	mailserver.login('info@georgesecurity.me', '')
	mailserver.sendmail('info@georgesecurity.me', 'simon@ponchau.eu', msg.as_string())
	mailserver.quit()



######################----Stop----#######################			

#permet de mettre toutes les pins au niveau bas et de stopper les moteurs
def Stop():
	GPIO.output(11, False)
	GPIO.output(13, False)
	GPIO.output(15, False)
	GPIO.output(12, False)

######################----auto----#######################
			
#mode automatique : permet au robot de se deplacer seul
def Auto():
	GPIO_TRIGGER = 23
	GPIO_ECHO    = 24
	GPIO.setup(GPIO_TRIGGER,GPIO.OUT)  # Trigger
	GPIO.setup(GPIO_ECHO,GPIO.IN)      # Echo
	GPIO.output(GPIO_TRIGGER, False)

	# temps afin de laisser le temps au module de s'activer
	time.sleep(0.5)

	# envoi d'un pulse de 10us au trigger
	GPIO.output(GPIO_TRIGGER, True)
	time.sleep(0.00001)
	GPIO.output(GPIO_TRIGGER, False)
	start = time.time()

	sortir =0
	distance = 300 #distance de 300 cm par defaut : le robot peut avancer

	while GPIO.input(GPIO_ECHO)==0:
		start = time.time()
		#si la variable sortir deviens plus grande que 5000, on considere que
		#le signal est perdu et on sort de la boucle
		sortir+=1
		if sortir > 5000 :
			break

	while GPIO.input(GPIO_ECHO)==1:
		stop = time.time()


	#on ne calcule la nouvelle distance que si on a bien recu un retour sur le echo
	if sortir < 5000 :
		# Calculer le temps du pulse
		elapsed = stop-start

		# calcul en fonction du temps et de la distance
		distance = elapsed * 34300

		# pour seulement l'aller
		distance = distance / 2

	#si la distance est plus petite que 65cm :
	#- le robot s'arrete
	#- il tourne pendant 0.1 seconde
	if distance < 65:
		Stop()
		time.sleep(2)
		GPIO.output(15, True)
		time.sleep(0.1)

	# si la distance devant lui est assez grande, il continue tout droit
	else:
		Stop()
		GPIO.output(11, True)
		GPIO.output(15, True)



############################################################################			
#				-----Initialisation-----
############################################################################	


s=socket.socket(socket.AF_INET,socket.SOCK_STREAM)

host= '127.0.0.1'
port=int(62900)

global data

distance=0
data = ''	#signal recu par le serveur web


s.bind(('',port))

GPIO.setmode (GPIO.BOARD)
#M1 Right Side

GPIO.setup (11, GPIO.OUT) #M1_AV
GPIO.setup (13, GPIO.OUT) #M1_AR
#M2 Left Side
GPIO.setup (15, GPIO.OUT) #M2_AV
GPIO.setup (12, GPIO.OUT) #M2_AR

hz = 500 # frequence


############################################################################			
#				-----Threads-----
############################################################################	

class Listener(Thread):
	
    def run(self):
		while 1:
			global data

			s.listen(1)
					
			conn,addr =s.accept()

			data=conn.recv(100000)
			data=data.decode("utf-8")
				

class Controller(Thread):
	
    def run(self):
		while 1:
			global data

		#MODE AUTO
			
			if data == 'auto':
				Auto()
			
		#MODE MANUEL
			else:				

				if data=='up':
					Stop()
					GPIO.output(11, True)
					GPIO.output(15, True)


				if data=='down':
					Stop()
					GPIO.output(13, True)
					GPIO.output(12, True)

				if data=='left':
					Stop()
					
					GPIO.output(15, True)
			

				if data=='right':
					Stop()
					
					GPIO.output(11, True)
				
					
				if data=='stop':
				
					Stop()
					
				s.close
				
				
class Alert(Thread):
    def run(self):
		liste = []
		j = 0
		
		while 1:
		
		
			GPIO_TRIGGER = 23
			GPIO_ECHO    = 24
			GPIO.setup(GPIO_TRIGGER,GPIO.OUT)  # Trigger
			GPIO.setup(GPIO_ECHO,GPIO.IN)      # Echo
			GPIO.output(GPIO_TRIGGER, False)

			# temps afin de laisser le temps au module de s'activer
			time.sleep(0.5)

			# envoi d'un pulse de 10us au trigger
			GPIO.output(GPIO_TRIGGER, True)
			time.sleep(0.00001)
			GPIO.output(GPIO_TRIGGER, False)
			start = time.time()

			sortir =0
			distance = 300 #distance de 300 cm par defaut : le robot peut avancer

			while GPIO.input(GPIO_ECHO)==0:
				start = time.time()
				#si la variable sortir deviens plus grande que 5000, on considere que
				#le signal est perdu et on sort de la boucle
				sortir+=1
				if sortir > 5000 :
					break

			while GPIO.input(GPIO_ECHO)==1:
				stop = time.time()

			if sortir < 5000 :
				# Calculer le temps du pulse
				elapsed = stop-start

				# calcul en fonction du temps et de la distance
				distance = elapsed * 34300
				distance = distance / 2


		
			#si les moteurs sont a l'arret
			if data=='stop' or data=='':
				#creation d'une liste afin de retrouver l'etat precedant
				liste.append(distance)
				#si le tableau possede au moins deux valeurs
				if j>0 :
					#envoi d'un mail si la distance a change d'au moins 20cm
					if (liste[j-1]-liste[j])>20 :
						SendMail()
				#remettre la liste a 0
				if j > 100 : 
					j=0
				
				j+=1
				
				
############################################################################			
#				-----activer les Threads-----
############################################################################				
				
			
list = Listener()
control = Controller()
alert = Alert()


list.start()
control.start()
alert.start()



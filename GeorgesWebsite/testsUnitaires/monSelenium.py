import os
from selenium import webdriver
from selenium.webdriver.common.keys import Keys
import time

bouton_accueil = '//a[@href="javascript:void(startPageViewed());"]'
bouton_login =  '//a[@href="login.html"]'
bouton_video =  '//a[@href="controls.html"]'
bouton_fleche_haut =  '//button[@onmousedown="sendKey(\'up\');"]'

driver = webdriver.Firefox()
driver.get("http://www.georgesecurity.me/")
assert "Georgesecuity" in driver.title

time.sleep(2)

button = driver.find_element_by_xpath(bouton_accueil)
button.click()

time.sleep(2)

button = driver.find_element_by_id("o_Contact")
button.click()

time.sleep(2)

button = driver.find_element_by_xpath(bouton_login)
button.click()
#driver.close()

time.sleep(2)

username = driver.find_element_by_id("username")
password = driver.find_element_by_id("password")

username.send_keys("simon")
password.send_keys("c3m3cq10")

time.sleep(2)

button = driver.find_element_by_name("sendLogin")
button.click()

time.sleep(2)

button = driver.find_element_by_class_name("fa")
button.click()

button = driver.find_element_by_xpath(bouton_video)
button.click()

button = driver.find_element_by_class_name("fa")
button.mouseOut()

time.sleep(2)

try :	
	driver.find_element_by_id("divUpArrow")
except : 
	print ('fleche non trouvee')



# Documentation Infrastructure


***

# Serveur Cloud
Digital Ocean
* RAM : 1Gb
* CPU : Xeon E5-2630L 2.40GHz
* Disque : 20 GB SSD
* IP : 185.14.186.97/24
* Localisation : Amsterdam
* Système d'exploitation : Ubuntu Server 16.04 LTS

# Virtualisation
Docker 1.12.1
IP Range 172.17.0.0/24

# Containers
* Stack Web
* Serveur MySQL
* Serveur DNS
* Serveur VPN

# Configuration de base
### Compte administrateur non-root
    adduser admin sudo
### Modifier accès SSH
    PermitRootLogin yes => no
    PasswordAuthentification yes => no
### Modifier accès UFW
    P = 22, 80/tcp, 443/tcp, 60000:65535/udp, 
		10000/tcp, 53/tcp, 53/udp
    sudo ufw allow P
    sudo ufw enable
### Installer Webmin
    sudo nano /etc/apt/sources.list
        deb http://download.webmin.com/download/repository sarge contrib
        deb http://webmin.mirror.somersettechsolutions.co.uk/repository sarge contrib
    wget -q http://www.webmin.com/jcameron-key.asc -O- | sudo apt-key add -
    sudo apt-get update
    sudo apt-get install webmin
### Installer fail2ban, log, etc... via webmin
    sur https://185.14.186.97

# Configuration de la stack web
le container Web Stack consiste principalement a faire tourner le serveur Apache2 ainsi que ses plugs-in PHP

### Countruire l'image et lancer le container :
    sudo docker build -t faust852/web .
    sudo docker run -idt --name WebStack faust852/web \
        -v /home/apache:/usr/local/apache2/htdocs \
        -v /home/apache/www:/var/www
        -idt fait tourner le container en mode deamon et interactif
        -v cree des volumes partager entre les containers et le VPS

### Confirmer que le container fonctionne :
    sudo docker ps
    netstat -tan : devrait afficher le port 80 et 443
    curl http://185.14.186.97 : devrait afficher la source

# Configuration du serveur Mysql
Le container MySQL contient la logique de la base de données
Toutes les informations (tables et relations) ne sont pas sauvegarder dans le container mais partagée dans un volume sur le VPS directement, ceci permet de préserver les données en cas de corruption du container, tout en relancant l'instance facilement et quasi-instantanément en cas de problème
# Configuration du DNS

# Configuration du VPN

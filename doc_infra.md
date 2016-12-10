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
    sudo docker run -idt --name WebStack \
        -v /home/apache:/usr/local/apache2/htdocs \
        -v /home/apache/www:/var/www faust852/web
        -idt fait tourner le container en mode deamon et interactif
        -v cree des volumes partager entre les containers et le VPS

### Confirmer que le container fonctionne :
    sudo docker ps
    netstat -tan : devrait afficher le port 80 et 443
    curl http://185.14.186.97 : devrait afficher la source

# Configuration du serveur Mysql
Le container MySQL contient la logique de la base de données
Toutes les informations (tables et relations) ne sont pas sauvegarder dans le container mais partagée dans un volume sur le VPS directement, ceci permet de préserver les données en cas de corruption du container, tout en relancant l'instance facilement et quasi-instantanément en cas de problème.

### Countruire l'image et lancer le container :
    sudo docker run -d --name=mysql -e \
    MYSQL_ROOT_PASSWORD='%MYPASSWORD%’\
    -v /storage/mysql/mysql-datadir:/var/lib/mysql mysql


# Configuration du DNS
Le container DNS consiste simplement en un serveur Bind9 qui permet d'accéder au site via une URL plutôt qu'une adresse IP.

### Countruire l'image et lancer le container :
    sudo docker run -d --name=dns -p 53:53/tcp -p 53:53/udp faust852/bind
    sudo docker attach dns
    nano /etc/bind/named.conf.local
    
    zone "georgesecurity.me"{
        type master;
        file "/etc/bind/zones/master/db.georgesecurity.me";
    };
    
    nano /etc/bind/zones/db.georgesecurity.me
    
    	;
	; BIND data file for georgesecurity.me
	;
	$TTL    3h
	@       IN      SOA     ns1.georgesecurity.me. georges.georgesecurity.me. (
					1       ; Serial
					3h      ; Refresh after 3 hours
					1h      ; Retry after 1 hour
					1w      ; Expire after 1 week
					1h )    ; Negative caching TTL of 1 day
	;
	@       IN      NS      ns1.georgesecurity.me.
		IN      MX      mail.georgesecurity.me.


	georgesecurity.me.      IN      A       185.14.186.97
	ns1     IN      A       185.14.186.97
	www     IN      A       185.14.186.97
	mail    IN      A       185.14.186.97




# Configuration du VPN

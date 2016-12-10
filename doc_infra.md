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

Souscrire un nom de domaine, par exemple chez namecheap, et leur fournir l'adresse IP externe du serveur sur lequel se trouve le DNS, ainsi que ns1.georgesecurity.me. comme resolveur.


# Configuration du VPN
Le container VPN est construit via les images Docker de M. Kyle Manna, kylemanna/docker-openvpn. Il suffit d'appliquer les directives indiquées sur la documentation fournie

### Countruire l'image et lancer le container :
    OVPN_DATA="ovpn-data"
    
    docker volume create --name $OVPN_DATA
    docker run -v $OVPN_DATA:/etc/openvpn --rm kylemanna/openvpn ovpn_genconfig -u udp://georgesecurity.me
    docker run -v $OVPN_DATA:/etc/openvpn --rm -it kylemanna/openvpn ovpn_initpki
    
    docker run -v $OVPN_DATA:/etc/openvpn -d -p 1194:1194/udp --cap-add=NET_ADMIN kylemanna/openvpn
    
### Generer les certificats de chaque robot (et administrateur) :
    docker run -v $OVPN_DATA:/etc/openvpn --rm -it kylemanna/openvpn easyrsa build-client-full CLIENTNAME nopass
    docker run -v $OVPN_DATA:/etc/openvpn --rm kylemanna/openvpn ovpn_getclient CLIENTNAME > CLIENTNAME.ovpn

# Configuration du routage entre le container VPN et le container de la stack Web :
Il faut configurer le routage entre les deux containers de façon à ce que le serveur Apache puisse accèder au flux video, et que le robot puisse recevoir les informations en provenance du site web.

### Sur l'OS parent :
Il faut d'abord ajouter une route du subnet VPN (192.168.255.0/24) passant par l'interface du container openVPN

    route add 192.168.255.0/24 via 172.17.0.X (X = l'ip du container vpn)
  
### Sur le container VPN :
Ensuite, il faut configurer les iptables dans le serveur VPN pour permettrre la liaison entre les deux subnets (celui du vpn, et celui de l'interface docker du même container. Nous utilisons le port 8082 pour le flux video.
192.168.255.X 	= l'ip du client
172.17.0.X 	= l'ip de l'interface Docker du container VPN

    iptables -t nat -A PREROUTING -j DNAT -d 172.17.0.X -p udp --dport 8082 --to 192.168.255.X:8082
    iptables -t nat -A PREROUTING -j DNAT -d 172.17.0.X -p tcp --dport 8082 --to 192.168.255.X:8082
    
    iptables -t nat -A POSTROUTING -j MASQUERADE
    
    sysctl net.ipv4.ip_forward=1

# Etapes à suivre pour faire fonctionner votre Georges

***

# Le connecter au Wi-Fi

* Branchez un écran, un clavier et une souris au Raspberry (le petit ordinateur qui se trouve sur votre robot)

* Mettez le Raspberry sur le courant

* Attendez une ou deux minutes le temps que le Raspberry initialise tout

* Quand les instructions se répêtent à l'écran, appuyez sur alt-sys-e (la touche sys correspond souvent à la touche PrtSc sur votre clavier)

* Introduisez l'identifiant et le mot de passe (fournis avec le robot)

### Tapez les instructions suivantes (appuyez sur enter entre chaque ligne):
    cd /etc/wpa_supplicant
    sudo nano wpa_supplicant.conf
    (si un mot de passe vous est demandé, introduisez celui que vous avez introduit plus haut)

### Ajoutez a la fin du fichier qui s'ouvre les lignes suivantes en remplacer par les bonnes valeurs :

    network={
	ssid="nomDeVotreWifi"
	psk="motDePasseDeVotreWifi"
	key_mgmt=WPA-PSK
    }

* Tapez ctrl-x puis y pour sauver

### Tapez :
  sudo halt

* Vous pouvez maintenant débrancher la souris, le clavier et l'écran, lorsque vous rebrancherez le Raspberry sur la batterie, il se connectera seul à votre wifi.

# L'inscription sur le site web
__________________________________

* Rendez-vous sur le site www.georgesecurity.me

* Cliquez sur "Go to portal" puis sur "Sign up" pour vous inscrire

* Une fois inscrit vous pouvez vous connecter en cliquant sur "Sign in"

* Cliquez sur "Georges/Link to your Georges"

* Introduisez les identifiants du robot que vous avez reçu (ils vous sont fournis)

* Vous pouvez désormais contrôler Georges dans "Georges/Controls"

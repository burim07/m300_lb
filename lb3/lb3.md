# **M300 LB03 Dokumentation - Webserver mit Website**  

##### Author: Burim Muharemi
##### Datum: 02.05.2021  

--------------------------------------------------------  

#### **INHALTSVERZEICHNIS:**  

- [1 Einleitung](#1-einleitung)
- [1.1 Service Beschreibung](#11-service-beschreibung)
- [1.2 Service Anwendung](#12-service-anwendung)
- [1.3 Grafische Uebersicht](#13-grafische-uebersicht)  
- [2 Code Dokumentation](#2-code-dokumentation)
- [2.1 PHP Script](#21-php-script)
- [2.2 Docker Compose File](#22-docker-compose-file)
- [2.3 Dockerfile](#23-dockerfile)
- [2.4 Sicherheitsmerkmale](#24-sicherheitsmerkmale)
- [3 Testing](#3-testing)
- [4 Quellenverzeichnis](#4-quellenverzeichnis)     
  
--------------------------------------------------------  


# **1 Einleitung**  

## **1.1 Service Beschreibung**

In dieser Dokumentation wird gezeigt, wie mit Docker verschiedene Services automatisiert werden.  
Mithilfe von PHP, Mysql und Apache werde ich eine Website aufzubauen, die Informationen via Mariadb holt und diese auf der Webseite anzeigt. Sobald alles aufgebaut ist, kann man sich über Mariadb anmelden, Datenbanken und darin Tabellen erstellen, die dann angezeigt werden. Wenn man die Tabellen anpassen möchte, muss man dafür das entsprechende PHP Script anpassen.

--------------------------------------------------------  

## **1.2 Service Anwendung**

Möchte man eine Webseite erstellen, kann man dia DB auslassen und auf das PHP Script konzentrieren. Möchte man aber, dass die Informationen via Mariadb geholt werden, dann sollte man am besten eine Umgebung mit PHP, Mysql und Apache verwenden und nach dieser Doku vorgehen. Es ist relativ nützlich, eine DB für die Infos zu benutzen, da die Informationen einfacher angepasst werden können, sobald neue Einträge in der DB reinkommen.

--------------------------------------------------------  

## **1.3 Grafische Uebersicht**

![Grafische Uebersicht](/Users/burim/Documents/Schuel/TBZ/M300/Repository/m300_lb/m300_lb/lb3/grafische_uebersicht.png "Graf") 

--------------------------------------------------------  

# **2 Code Dokumentation**  

## **2.1 PHP Script**  

```
# -*- mode: ruby -*-
# vi: set ft=ruby :

# Networking konfigurieren
Vagrant.configure("2") do |config|
  
 config.vm.box = "ubuntu/trusty64"

 config.vm.network "forwarded_port", guest: 80, host: 8080

# VM erstellen & konfigurieren  
 config.vm.provider "virtualbox" do |vb|

  vb.name = "Webserver-VM-M300-LB02-Muharemi"
  vb.gui = true
  vb.memory = "1024"

end

# Webserver installieren & konfigurieren
  config.vm.provision "shell", inline: <<-SHELL
  sudo apt-get update
  sudo apt-get -y upgrade
  sudo apt-get install -y apache2
  sudo apt-get update
  sudo apt-get install libcap2-bin wireshark
  sudo apt-get update
  sudo apt install software-properties-common
  sudo add-apt-repository ppa:deadsnakes/ppa
  sudo apt-get update
  sudo apt install python3.8
  sudo apt -y install apache2 php libapache2-mod-php

# Firewall rules erstellen
  sudo apt install ufw
  sudo ufw default deny incoming
  sudo ufw default allow outgoing
  sudo ufw allow ssh
  sudo ufw allow 80
  sudo ufw allow 8080
  sudo ufw allow 'Apache'
  sudo ufw --force enable
  sudo ufw --force status verbose

  SHELL

end
```

--------------------------------------------------------  

## **2.2 Docker Compose File**  

```
config.vm.box = "ubuntu/trusty64" 
``` 
>*Hier wird die Box für die VM ausgewählt (in diesem Fall trusty64)*  

```
config.vm.network "forwarded_port", guest: 80, host: 8080 
``` 
>*Ports werden geöffnet, die man später für den Zugriff aud die VM benötigt*  

```
config.vm.provider "virtualbox" do |vb|  
```
>*Provider wird definiert*  

```
vb.name = "Webserver-VM-M300-LB02-Muharemi"  
```
>*Name der VM*  

```
vb.gui = true  
```
>*GUI wird aktiviert*  

```
vb.memory = "1024"  
```
>*Hier wird Anzahl RAM definiert*  

--------------------------------------------------------

## **2.3 Dockerfile**  

```
config.vm.provision "shell", inline: <<-SHELL  
```
>*VM Konfig endet hier. Jetzt folgen nur noch Befehle, die durchgeführt werden, nachdem die VM gestartet ist.*

```
sudo apt-get update  
```
>*Paketlisten werden aktualisiert*

```
sudo apt-get -y upgrade  
```
>*Installiert werden hier alle neuen Versionen eines Paketes, falls Aktualisierungen vorhanden sind*

```
sudo apt-get install -y apache2  
```
>*Apache2 wird installiert (Website)*  

#### Falls alles korrekt installiert wurde, kann nun auf die Website zugegriffen werden, indem man localhost:8080 im Browser eingibt.    

--------------------------------------------------------  

## **2.4 Sicherheitsmerkmale**  

|Sicherheitsmerkmal |Begründung                                                             |
|-------------------|-----------------------------------------------------------------------|
|1. Passwort        |Zugriff wird auf Mariadb mit Passwort beschränkt.                      |
|2. Monitoring Tool |Tool "cadvisor" wurde für die Überwachung eingesetzt.                  |

Das Monitoring Tool wurde mit dem Befehl "docker run -d --name cadvisor -v /:/rootfs:ro -v /var/run:/var/run:rw -v /sys:/sys:ro -v /var/lib/docker/:/var/lib/docker:ro -p 8080:8080 google/cadvisor:latest" installiert. Da das cAdvisor Container bereits existiert, konnte ich mit dem simplen Befehl den Container installieren und laufen lassen in meiner Umgebung.

--------------------------------------------------------  

# **3 Testing**  

#### 1. VM starten mit "Vagrant up" 

Nachdem die VM im Vagrantfile korrekt konfiguriert wurde, wird ein Vagrant up durchgeführt.
>*Test wurde erfolgreich durchgeführt!*

#### 2. Auf Website mit Browser zugreifen

Sollte vagrant up geklappt haben, wird nun auf die Website zugegriffen. Im Browser wird Localhost:8080 eingegeben und es sollte die Website anzeigen.
>*Test wurde erfolgreich durchgeführt!* 
Beweis:![Apache Website](/Users/burim/Desktop/Apache_website.PNG "Website")  

--------------------------------------------------------  

# **4 QUELLENVERZEICHNIS:**
<https://hub.docker.com/_/mysql> "MySQL"  
<https://hub.docker.com/_/php> "PHP"  
<https://stackoverflow.com/questions/4567688/problems-with-a-php-shell-script-could-not-open-input-file> "Troubleshooting Part 1"  
<https://askubuntu.com/questions/949401/how-to-fix-could-not-open-input-file-in-php-cli-7-0> "Troubleshooting Part 2"
<https://magento.stackexchange.com/questions/257615/could-not-open-input-file-error-while-running-php-command-in-windows> "Troubleshooting Part 3"
<https://forums.cpanel.net/threads/could-not-open-input-file.606991/> "Troubleshooting Part 4"

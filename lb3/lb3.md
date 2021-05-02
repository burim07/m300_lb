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

![Grafische Uebersicht](/lb3/docker/images/grafische_uebersicht.png "Graf") 

--------------------------------------------------------  

# **2 Code Dokumentation**  

## **2.1 PHP Script**  

```
<?php

echo "Hello from Burim's Container";

$mysqli = new mysqli("db", "root", "example", "lb03b");

$sql = "INSERT INTO users (name, beruf) VALUES('Lil Float', 'rapper')";
$result = $mysqli->query($sql);
$sql = "INSERT INTO users (name, beruf) VALUES('XqcOw', 'streamer')";
$result = $mysqli->query($sql);
$sql = "INSERT INTO users (name, beruf) VALUES('EDP445', 'comedian')";
$result = $mysqli->query($sql);
$sql = "INSERT INTO users (name, beruf) VALUES('Burim Muharemi', 'informatiker')";
$result = $mysqli->query($sql);


$sql = 'SELECT * FROM users';

if ($result = $mysqli->query($sql)) {
    while ($data = $result->fetch_object()) {
        $users[] = $data;
    }
}

foreach ($users as $user) {
    echo "<br>";
    echo $user->name . " " . $user->beruf;
    echo "<br>";
}
```
Das echo wurde zu Beginn als Test verwendet. Dort habe ich überprüft, ob ich auf localhost zugreifen kann. Bei dem Test wird einfach ein Satz auf der Webseite abgebildet.
Die Zeile mit $mysqli ist das wichtigste im Skript. Sie erzeugt eine Verbindung zwischen MySQL und PHP. "db" ist der Name vom MySQL, "root" ist der user, "example" ist das Passwort (kann abgeändert werden) und "lb3" ist die Datenbank, auf der ich eine Verbindung herstellen möchte.
$sql $result sind die Informationen, die ich displayen lassen möchte.
Nach den Informationen kommen die Abfragen. Hier werden die einzelnen Informationen korrekt eingeordnet, sodass alles in der entsprechenden Reihenfolge bei der Ausgabe ausgegeben wird. 

--------------------------------------------------------  

## **2.2 Docker Compose File**  

```
version: '3.1'

services:
  php:
    build:
        context: .
        dockerfile: Dockerfile
    ports:
      - 80:80
    volumes:
      - ./src:/var/www/html/
  

  db:
    image: mysql
    command: --default-authentication-plugin=mysql_native_password
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: example
    volumes:
      - mysql-data:/var/lib/mysql
    
  adminer:
    image: adminer
    restart: always
    ports:
      - 8080:8080
    
volumes:
  mysql-data:
```

```
services:
``` 
>*Unter Services definieren wir die Container, die danach laufen werden.*  

```
build:
``` 
>*Beim Build wird auf das Dockerfile referenziert und dieses für den PHP Container verwendet.*  

```
ports:
```
>*Port mapping. Von meinem Port 80 zum Port 80 der Maschine.*  

```
volumes:
```
>*Inhalt von meinem src Folder in den ./src:/var/www/html/ Ordner des Containers.*  

```
db Teil  
```
>*In diesem Abschnitt wird der Container db definiert. Diesen Teil habe ich vom MySQL dockerhub kopiert und ein wenig angepasst. Es verwendet den MySQL Image und mit dem command wird ein user erstellt. Das passwort wurde als "example" eingestellt, kann aber angepasst werden.*  

```
adminer Teil
```
>*In diesem Abschnitt wird der Container adminer definiert. Diesen Teil habe ich ebenfalls vom MySQL dockerhub kopiert. Das gleiche wie bei db, ausser das Port 8080 enabled wird. Mit dem Port haben wir später Zugriff auf die Mariadb.*  

```
volumes:
  - mysql-data:/var/lib/mysql  
```
>*Hiermit werden persistente Volumes aktiviert. In diesem Code richten wir auf unserem System ein (von Docker verwaltetes) Volume namens "mysql-data" ein. Alle unsere Datenbanktabellen werden in "mysql-data" gespeichert. Dann mappen wir diese Daten auf /var/lib/mysql auf dem Container.*  

--------------------------------------------------------

## **2.3 Dockerfile**  

```
FROM php:7.4-apache
RUN docker-php-ext-install mysqli
```

```
FROM php:7.4-apache
```
>*Image 7.4-Apache wird für den Container verwendet.*

```
RUN docker-php-ext-install mysqli
```
>*MySQL Erweiterungen werden im Container heruntergeladen und ausgeführt.*  

--------------------------------------------------------  

## **2.4 Sicherheitsmerkmale**  

|Sicherheitsmerkmal |Begründung                                                             |
|-------------------|-----------------------------------------------------------------------|
|1. Passwort        |Zugriff wird auf Mariadb mit Passwort beschränkt.                      |
|2. Monitoring Tool |Tool "cadvisor" wurde für die Überwachung eingesetzt.                  |

Das Monitoring Tool wurde mit dem Befehl "docker run -d --name cadvisor -v /:/rootfs:ro -v /var/run:/var/run:rw -v /sys:/sys:ro -v /var/lib/docker/:/var/lib/docker:ro -p 8080:8080 google/cadvisor:latest" installiert. Da das cAdvisor Container bereits existiert, konnte ich mit dem simplen Befehl den Container installieren und laufen lassen in meiner Umgebung.

--------------------------------------------------------  

# **3 Testing**  

#### 1. Container werden gestartet mit docker-compose up -d 

docker-compose up -d wird in der Befehlszeile eingegeben und alle Container laufen automatisch
>*Test wurde erfolgreich durchgeführt!*
Beweis: ![Container](/lb3/docker/images/container.png "Container") 

#### 2. Login auf localhost:8080 funktioniert

Container müssen am Laufen sein für diesen Test. Im Browser wird localhost:8080 eingegeben und mit den Credentials root/example eingeloggt.
>*Test wurde erfolgreich durchgeführt!* 
Beweis: ![Login](/lb3/docker/images/login.png "Login") 

#### 3. Tabellen erfolgreich erstellt

Nachdem Login werden die Tabellen erstellt mit der entsprechenden Datenbank. Datenbank Name ist lb03b und Tabellenname ist users. Bei der Tabelle wurden zwei Einträge "name" und "beruf" erstellt.
>*Test wurde erfolgreich durchgeführt!* 
Beweis: ![Tabelle](/lb3/docker/images/tabelle.png "Tabelle") 

#### 4. Output auf localhost:80

Zuletzt wird überprüft, ob die Informationen korrekt angezeigt werden auf der Webseite. Mit localhost:80 via Browser wird darauf zugegriffen.
>*Test wurde erfolgreich durchgeführt!* 
Beweis: ![Output](/lb3/docker/images/output.jpeg "Output") 

--------------------------------------------------------  

# **4 QUELLENVERZEICHNIS:**
<https://hub.docker.com/_/mysql> "MySQL"  
<https://hub.docker.com/_/php> "PHP"  
<https://stackoverflow.com/questions/4567688/problems-with-a-php-shell-script-could-not-open-input-file> "Troubleshooting Part 1"  
<https://askubuntu.com/questions/949401/how-to-fix-could-not-open-input-file-in-php-cli-7-0> "Troubleshooting Part 2"
<https://magento.stackexchange.com/questions/257615/could-not-open-input-file-error-while-running-php-command-in-windows> "Troubleshooting Part 3"
<https://forums.cpanel.net/threads/could-not-open-input-file.606991/> "Troubleshooting Part 4"

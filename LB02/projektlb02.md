# H1
## H2
### H3
#### H4
##### H5
###### H6 (klein)

Man kann **fett** schreiben oder *kursiv* 

> block
>> Mit unterblock

- Liste1
- Liste2
    - Liste 2.1
    - Liste 2.2
- Liste 3

images  
![kek](C:\Users\burim\Desktop\b02.jpeg)

quellenverzeichnisse  
[code1](https://www.markdownguide.org/basic-syntax/)   
[code2](https://de.wikipedia.org/)    
<https://de.wikipedia.org/>

## Tables

| Left columns  | Right columns |
| ------------- |:-------------:|
| left foo      | right foo     |
| left bar      | right bar     |
| left baz      | right baz     |

## Blocks of code

```
let message = 'Hello world';
alert(message);
```




INHALTSVERZEICHNIS:
1.Einleitung
2.Vagrantfile
3.Apache konfiguration
4.Firewall konfiguration
5.Testing
6.Quellenverzeichnis

Sicherheiten:
  config.vm.provision "file", source: "../Website/index.php", destination: "/var/www/html/index.php"
  config.vm.provision "file", source: "../Website/.htpasswd", destination: "/var/www/html/.htpasswd"
  config.vm.provision "file", source: "../Website/.htaccess", destination: "/var/www/html/.htaccess"

QUELLENVERZEICHNIS:
https://app.vagrantup.com/ubuntu/boxes/trusty64
https://phoenixnap.com/kb/how-to-install-python-3-ubuntu
https://linuxize.com/post/how-to-install-php-on-ubuntu-18-04/
https://linuxize.com/post/how-to-install-php-on-ubuntu-18-04/


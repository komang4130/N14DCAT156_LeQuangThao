# N14DCAT156_LeQuangThao
Bài thi cuối kì môn KTGT

Install Apache2:
sudo apt-get update
sudo apt-get install apache2

Install php7.0:
sudo apt-get update
sudo apt-get install php7.0* -y

Install mysql:
sudo apt-get update
sudo apt-get install mysql-server

Any problem, follow this: https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-16-04
Import database file to mysql:
mysql -u steg -p steg < database.sql
Password is: 137946

User admin: thaodeptrai
pass: 123456

About the Service account for using google-api
First, create your service google account
Website: https://console.developers.google.com
Create your first project
Enable the google drive api service.
Second, hit the button create your credential and follow the instruction in this page https://o7planning.org/en/11917/create-credentials-for-google-drive-api
Third, setup the oauthclient correctly, choose Create OAuth client ID
Authorized JavaScript origins: http://localhost:80 ( local demo )
Authorized redirect URIs: http://localhost:80/project/file_upload.php

Then download the json file from OAUTH , and place it in conf folder.




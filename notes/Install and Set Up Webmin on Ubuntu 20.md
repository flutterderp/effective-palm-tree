# Install and Set Up Webmin on Ubuntu 20.04

## Initial server setup
1. Log in as root via SSH
2. Create a new user: `adduser USERNAME`
3. Add the new user to the sudo group: `usermod -aG sudo USERNAME`
4. Set up the basic firewall
    * `ufw app list` – check available profiles in UFW
    * `ufw allow OpenSSH`
    * `ufw enable`
    * `ufw status`
5. Enable external access for your regular user
    * `rsync --archive --chown=USERNAME:USERNAME ~/.ssh /home/USERNAME`

## Installing Apache
1. Run `sudo apt update`
2. Run `sudo apt install apache2`
3. Adjust the firewall: `sudo ufw allow 'Apache Full'`
4. Check the web server
    * `sudo systemctl status apache2`
    * `hostname -I`
5. Managing the web server
    * `sudo systemctl stop apache2`
    * `sudo systemctl start apache2`
    * `sudo systemctl restart apache2` (useful for simple configuration changes)
    * `sudo systemctl reload apache2`
    * `sudo systemctl disable apache2`
    * `sudo systemctl enable apache2`

### Setting up virtual hosts
1. Create a directory for the domain: `sudo mkdir /var/www/YOUR_DOMAIN`
2. Assign ownership of the directory: `sudo chown -R $USER:$USER /var/www/YOUR_DOMAIN`
    * `sudo chmod -R 755 /var/www/YOUR_DOMAIN`
3. Create a starter index page: `sudo nano /var/www/YOUR_DOMAIN/index.html`
    * `<html><head><title>Welcome to Your_domain!</title></head><body><h1>Success!  The your_domain virtual host is working!</h1></body></html>`
4. Create a host file: `sudo nano /etc/apache2/sites-available/YOUR_DOMAIN.conf`
```sh
<VirtualHost *:80>
  ServerAdmin webmaster@localhost
  ServerName YOUR_DOMAIN
  ServerAlias www.YOUR_DOMAIN
  DocumentRoot /var/www/YOUR_DOMAIN
  ErrorLog ${APACHE_LOG_DIR}/error.log
  CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
5. Enable the virtual host: `sudo a2ensite YOUR_DOMAIN.conf`
6. Disable the default site: `sudo a2dissite 000-default.conf`
7. Test the configuration: `sudo apache2ctl configtest`
8. Restart Apache: `sudo systemctl restart apache2`

## Installing Webmin
1. Run `sudo apt update`
2. Add the Webmin repository to the source list
    1. `sudo nano /etc/apt/sources.list`
    2. add `deb http://download.webmin.com/download/repository sarge contrib` to the bottom
3. Add the Webmin PGP key to the system keychain
    1. `wget -q -O- http://www.webmin.com/jcameron-key.asc | sudo apt-key add`
    2. [Check this stackexchange answer](https://askubuntu.com/a/1374609) if it complains about invalid PGP data
4. Update the package list again and install Webmin
    1. `sudo apt update`
    2. `sudo apt install webmin`
5. Add an exepction to ufw if necessary
    1. `sudo ufw allow 10000`

## Resources
* [How To Install Webmin on Ubuntu 20.04 – DigitalOcean](https://www.digitalocean.com/community/tutorials/how-to-install-webmin-on-ubuntu-20-04)
* [Initial Server Setup with Ubuntu 20.04](https://www.digitalocean.com/community/tutorials/initial-server-setup-with-ubuntu-20-04)
* [How To Install the Apache Web Server on Ubuntu 20.04](https://www.digitalocean.com/community/tutorials/how-to-install-the-apache-web-server-on-ubuntu-20-04)
* [UFW Essentials: Common Firewall Rules and Commands](https://www.digitalocean.com/community/tutorials/ufw-essentials-common-firewall-rules-and-commands)
 
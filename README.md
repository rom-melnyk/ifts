# ifts.if.ua v02 (restyled)
This version is made for basic PHP/Apache-powered server.

# Development
## Server setup
1. `sudo apt-get install apache2 php7.0 php7.0-mysql php7.0-curl php7.0-json php7.0-cgi libapache2-mod-php7.0`
1. Remap `ifts.if.ua` to `127.0.0.1` in `/etc/hosts`.
1. Go to the project directory.
1. Create the symlink from `apache2.conf` to the config file responsible for the project in Apache config directory (mind the correct path to the project dir):  
   `cd /etc/apache2/sites-available && sudo ln -s /home/rom/Prj/ifts.if.ua/apache2.conf ifts.if.ua.conf && cd -`
1. Adjust directories in `apache2.conf` by running `cat apache2.conf | sed "s:/home.*\.if\.ua:$(pwd):g" > apache2.conf`
1. Restart the Apache2: `sudo systemctl restart apache2.service`

## JS and CSS development
- `npm run dev` watches and compiles all the JS and CSS assets
- `npm run prod` does the same but generates uglified code for production.  
   **TODO this script!**

## Develop and deploy
1. `npm dev`: compiles all the client assets, copies them to **`depoy/`** folder.
1. `npm prod`: behaves similar but generates minified files (prod-friendly).
1. Upload the content of that folder to the server via FTP.

## Some tricks:
- `tail -f logs/error.log` to track the Apache/PHP errors.

## Directories and files
- **`develop/js`** and **`develop/css`** contains JS and CSS dev files. Should not be upoladed to the server!
- **`deploy/`** will contain everything you need to upload to the server.
- **`index.php`**
- **`.htaccess`**
- PHP scripts.
- all the XML or JSON files.
- static content like images.



---

# Credits
Roman Melnyk <email.rom.melnyk@gmail.com>


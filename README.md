# ifts.if.ua v02 (restyled)
This version is made for basic PHP/Apache-powered server.


# Development


## Server setup
1. `sudo apt-get install apache2 php7.0 php7.0-mysql php7.0-curl php7.0-json php7.0-cgi php7.0-mbstring libapache2-mod-php7.0`
1. Remap `ifts.if.ua` to `127.0.0.1` in `/etc/hosts`.
1. Go to the project directory.
1. Create the symlink from `apache2.conf` to the config file responsible for the project in Apache config directory (mind the correct path to the project dir):  
   `cd /etc/apache2/sites-available && sudo ln -s /home/rom/Prj/ifts.if.ua/apache2.conf ifts.if.ua.conf && cd -`
1. Adjust directories in `apache2.conf` by running `cat apache2.conf | sed "s:/home.*\.if\.ua:$(pwd):g" > apache2.conf`
1. Restart the Apache2: `sudo systemctl restart apache2.service`


## Facebook essentials
Facebook API v5 requires PHP v5.4+.

Create `develop/php/fb-app-credentials.php`:
```
<?php
$FB_APP_CREDENTIALS = [
    'app_id' => '...',
    'app_secret' => '...',
    'default_graph_version' => 'v2.8'
];
?>
```

## Develop and deploy
1. `npm run dev`: compiles all the client assets, copies them to **`depoy/`** folder.
1. `npm run prod`: behaves similar but generates minified files (prod-friendly).
1. Upload the content of **`deploy/`** to the server via FTP.
  - Make sure that folder is writable and `fb-cache/` is writable too.
  - Remove `.gitignore` from the server :)
  - Update `sitemap.xml` and `robots.txt` if needed (both are copied by `prod` task only).
  - Update Google site verification file.
1. Make sure there are following modules installed on server:
  - `mbstring` (required for Facebook);
  - `mod_rewrite` (required for `.htaccess`).


## Some tricks:
- `tail -f logs/error.log` to track the Apache/PHP errors.


# Architecture


## `content/tiles.json`
Is an array of objects responsible for every particular tile in the main page.
Props expected (all `String`):

- **title**;
- **description**;
- **icon-class** is the CSS class name to be passed to thr icon element,  
   or **icon-file** (the filename with extension; all icons reside in `gfx/icons/`);
- **link** (URL of the external page)  
   or **content-file** (the filename _without extension_ in `content/` responsible for appropriate area);
- **tile-content** stands for the PHP or HTML file _(without extension!)_ responsible for the content of the tile;
- **tile-class** is CSS classname(-s) assigned to tile.

## `index.php`
Main entry point; home page. Contains tiles according to `tiles.json`;

## `page.php`
Internal links (`content-file` in `tiles.json`) lead to `/page/<...>` which is redirected via `.htaccess` to `page.php?name=<...>`. The file from `content/` with appropriate name and extension `.php` or `.html` will be injected in the page.

## Facebook process

### On main page (`content/fb-backgrounds.php` + appropriate record in `content/tiles.json`):
1. Look for the posts cached in `fb-cache/fb-content.json`.
1. If any contetnt found, extract three first pictures.
1. If found, fout them to appropriate tile alongside with the icon.

### On _facebook_ page:

1. Look for the token in `fb-cache/fb-token.txt`.
1. If not found ot invalid, render login invitation.
  1. When user logs in successfully, the `/page/facebook?save-token&access_token=...` is called.
  1. It retrieves the token, extends it and tries to save in `fb-cache/fb-token.txt`.
  1. If successfully, page is been reloaded in 5 sec otherwise login innvitation is rendered.
1. If token is found and valid, look for posts in `content/fb-content.json`.
1. If not found or outdated, try to fetch Facebook contetnt from the network.
1. If successfully, try to save updated content locally and render it,
1. otherwise render login invitation.

---


# Credits
Roman Melnyk <email.rom.melnyk@gmail.com>


# TeamSpeak 3 Server Manager

[![Laravel Version](https://shield.with.social/cc/github/Taronyuu/Teamspeak3-server-manager/master.svg?style=flat-square)](https://packagist.org/packages/laravel/framework)

### What is it?
TeamSpeak 3 Server Manager is a simple web application built on Laravel to let users manage their own TeamSpeak servers.
It's been re-written in Laravel 5.5 LTS and still needs a lot of work done but the basics are there.

### What does it do?
Right now it lets you create, delete and edit servers. You can start, stop and restart them. Edit their configuration.
Create and delete tokens. And check how many people are online.

### Requirements
It's built on Laravel 5.5 LTS so check the requirements from their site [https://laravel.com/docs/5.5#server-requirements](https://laravel.com/docs/5.5#server-requirements), plus;
1. TeamSpeak 3 server
2. Web server (nginx, Apache, or similar)

### Installation
1. Clone or download this repo
    `git clone https://github.com/Taronyuu/Teamspeak3-server-manager.git`
2. Setup your environment vars using `.env` or similar (Apache vars, php-fpm vars). You can copy the `.env.example` file.
3. Run composer install
    `composer install`
4. Make sure `DB_CONNECTION` is set to sqlite!
5. Create an empty file named `database.sqlite` in the database folder. `database/database.sqlite`.
6. Run `php artisan migrate` to migrate the database
7. Install or make sure your TeamSpeak 3 server is running. Doing this is outside the scope of this readme file.
8. Run `php artisan teamspeak:sync` to sync the virtual servers and settings into the system.
9. Go to the URL you have setup and you should be able to register your new account.
10. Enjoy

### TeamSpeak Commands
We provide a small number of commands which you can use to complete your panel.

Command: `php artisan teamspeak:reset`
Description: **DANGEROUS** command, this will remove **all** your TeamSpeak server from the TeamSpeak 3 instance and database.

Command: `php artisan teamspeak:sync`   
Description: This command will synchronize all the servers with your database and the TeamSpeak 3 instance itself.

### Can you add....?
Of course! Please open an issue. we'll be more than happy to add/discuss features. :)

### Screens:
#### Log in:
![Log in](https://snapr.pw/i/59df643509.png "Log in")
#### Dashboard:
![Dashboard](https://snapr.pw/i/9054ea0fa0.png "Dashboard")
#### Servers list:
![Servers list](https://snapr.pw/i/d0c971ccf1.png "Servers list")
#### Server overview:
![Server overview v1](https://snapr.pw/i/14920dcb75.png "Server overview v1")
![Server overview v2](https://snapr.pw/i/b9db69baf5.png "Server overview v2")
#### Create server:
![Create server](https://snapr.pw/i/527944c590.png "Create server")

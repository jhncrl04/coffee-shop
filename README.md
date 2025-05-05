# Coffee Shop Online Ordering App

To run this project locally using XAMPP, follow the steps below:

1. Move the project folder to the `htdocs` directory inside your XAMPP installation, for example: `C:/xampp/htdocs/coffeeshop`.

2. Open the file `httpd-vhosts.conf` located at `C:/xampp/apache/conf/extra/httpd-vhosts.conf`, and add the following configuration at the bottom (make sure to replace the path if your drive or folder name is different):

<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/coffeeshop/"
    ServerName coffeeshop
    <Directory "C:/xampp/htdocs/coffeeshop/">
        Order allow,deny
        Allow from all
        Require all granted
    </Directory>
</VirtualHost>'


3. Open the hosts file located at `C:\Windows\System32\drivers\etc\hosts` using a text editor with administrator privileges, and add the following line at the bottom:


4. Restart Apache from the XAMPP Control Panel to apply the changes.

Once everything is set up, you can access the Coffee Shop Online Ordering App in your browser by going to: [http://coffeeshop](http://coffeeshop)

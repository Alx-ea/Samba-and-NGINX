# Samba-server

This Project utilises two devices on a LAN, one being the webserver and the other being a samba file server.

The webserver is accessable externally and has the files hosted on it
    - This version uses dataplicity on the webserver to create a wormwhole which essentially hosts the webserver on dataplicity server

The code in 'HTML' contains all of the .php and .css files on the webserver 
    - This contains a login page before accessing it (With a hardcoded login which needs to be updated as it is unsecure, implementation of a DB with logins is needed.)
    - This allows you to access the files and directories, view it's contents and also download each (update can adjust the php, to allow the download of whole directories)

The config files for the samba server and NGINX server can be found in config files
    - default is the nginx file, replace the contents of ~/nginx/sites-enabled/default/ with this
    - smb.conf is the samba config file, replace the contents of /etc/samba/config with this

Use the commmand 'sudo mount -t cifs //IPADDRESS/shared /mnt/share -o user=USER' on the webserver device to mount the fileserver on the webserver
    - Replace IPADDRESS and USER respectively
    

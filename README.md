# CurlSyncMP
Esse é um exemplo simples de um script que pode ser agendado no crontab para recuperar os dados do site via cUrl.

clone o script e adicione-o em seu crontab, no terminal digite:
<pre>
# cd /var/www/html
# git clone https://github.com/Unix-User/CurlSyncMP.git
# crontab -e
00 * * * * /usr/local/bin/php /var/www/html/index.php
</pre>

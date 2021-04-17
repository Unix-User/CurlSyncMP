# CurlSyncMP
Esse é um exemplo simples de um script que pode ser agendado no crontab para recuperar os dados do site via cUrl.

clone o script e renomeie o arquivo 'config-example.php' para 'config.php'
<pre>
# cd /var/www/html
# git clone https://github.com/Unix-User/CurlSyncMP.git
# mv /var/www/html/config-example.php /var/www/html/config.php
</pre>

edite o arquivo 'config.php' com as credenciais do site e do banco de dados do freeradius.

adicione-o em seu crontab, no terminal digite:
<pre>
# crontab -e


*/10 * * * * /usr/local/bin/php /var/www/html/index.php
</pre>
no exemplo acima o script sera executado a cada 10 minutos.

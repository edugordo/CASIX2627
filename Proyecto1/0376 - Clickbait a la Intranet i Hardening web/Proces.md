# Procés per completar la pràctica de clickbait pas a pas
## Edu Gordo Cebrià | CASIX 1 / 26 - 27
### Centre Estudis Politècnics - Barcelona

---

![Imatge1](Captures/1.png)

```bash
cat /etc/os-release
```

Mostra la informació de la distribució del sistema operatiu (aquí, Ubuntu 24.04.5 LTS, "Noble Numbat").

---

![Imatge2](Captures/2.png)

```bash
sudo apt install apache2 -y
```

Instal·la el servidor web Apache2 i les seves dependències. L'opció `-y` respon "sí" automàticament a la confirmació.

---

![Imatge3](Captures/3.png)

```bash
sudo systemctl enable --now apache2
```

Habilita Apache2 perquè s'iniciï automàticament amb el sistema (`enable`) i l'inicia en aquest moment (`--now`).

---

![Imatge4](Captures/4.png)

```bash
sudo systemctl status apache2
```

Mostra l'estat del servei Apache2: si està carregat i habilitat, si està actiu (`active (running)`) i des de quan, el PID principal, l'ús de memòria i les últimes línies del registre.

---

![Imatge5](Captures/5.png)

```bash
sudo ss -tlnp | grep ':80'
```

Llista els sockets TCP en escolta (`-t` TCP, `-l` escoltant, `-n` ports en format numèric, `-p` procés) i filtra amb `grep` el port 80, per comprovar que Apache2 hi està escoltant.

---

![Imatge6](Captures/6.png)

Sense comanda: des del navegador s'accedeix a la IP del servidor (`http://10.0.2.171`) i apareix la pàgina per defecte d'Apache2 («It works!»), que confirma que el servidor web funciona.

---

![Imatge7](Captures/7.png)

```bash
sudo apt install -y php libapache2-mod-php php-mysql php-gd php-curl php-mbstring php-intl php-gmp php-bcmath php-xml php-zip php-imagick php-apcu
```

Instal·la PHP, el mòdul que l'integra amb Apache (`libapache2-mod-php`) i diverses extensions habituals: connexió a MySQL/MariaDB, imatges (gd, imagick), cURL, cadenes multibyte, internacionalització, matemàtiques (gmp, bcmath), XML, ZIP i memòria cau APCu.

---

![Imatge8](Captures/8.png)

```bash
php -v
```

Mostra la versió de PHP instal·lada (aquí, PHP 8.3.6) i informació del motor Zend i d'OPcache.

---

![Imatge9](Captures/9.png)

```bash
sudo systemctl enable --now mariadb
```

Habilita MariaDB perquè s'iniciï automàticament amb el sistema (`enable`) i l'inicia en aquest moment (`--now`).

---

![Imatge10](Captures/10.png)

```bash
sudo systemctl status mariadb
```

Mostra l'estat del servei MariaDB: si està actiu (`active (running)`), des de quan, el PID, l'ús de memòria i les últimes línies del registre.

---

![Imatge11](Captures/11.png)

```bash
sudo mariadb
```

Obre el client de línia d'ordres de MariaDB amb privilegis d'administrador. Apareix el prompt `MariaDB [(none)]>`, on ja es poden executar sentències SQL.

---

![Imatge12](Captures/12.png)

```sql
CREATE DATABASE nextcloud
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;
CREATE USER 'nc_user'@'localhost'
IDENTIFIED BY 'usuari123!';
```

Dins de MariaDB, crea la base de dades `nextcloud` amb el joc de caràcters `utf8mb4` i la col·lació `utf8mb4_general_ci`, i crea l'usuari `nc_user`, que només pot connectar des de `localhost`, amb la contrasenya indicada.

---

![Imatge13](Captures/13.png)

```sql
GRANT ALL PRIVILEGES ON nextcloud.*
TO 'nc_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

Dona a `nc_user` tots els privilegis sobre totes les taules de la base de dades `nextcloud` (`nextcloud.*`), recarrega la taula de privilegis (`FLUSH PRIVILEGES`) i surt del client (`EXIT`).

---

![Imatge14](Captures/14.png)

```bash
cd /tmp/
wget https://download.nextcloud.com/server/releases/latest.zip
```

Entra al directori temporal `/tmp/` i descarrega amb `wget` l'última versió de Nextcloud (`latest.zip`, uns 282 MB).

---

![Imatge15](Captures/15.png)

```bash
sudo chown -R www-data:www-data /var/www/nextcloud/
sudo find /var/www/nextcloud/ -type d -exec chmod 750 {} \;
sudo find /var/www/nextcloud/ -type f -exec chmod 640 {} \;
```

El primer comanda fa que l'usuari i el grup `www-data` (els d'Apache) siguin propietaris de tot el directori de Nextcloud (`-R` és recursiu). Les altres dues, amb `find`, assignen permisos 750 als directoris (`-type d`) i 640 als fitxers (`-type f`).

---

![Imatge16](Captures/16.png)

```bash
sudo mkdir -p /var/ncdata
sudo chown -R www-data:www-data /var/ncdata/
sudo chmod 750 /var/ncdata/
```

Crea el directori `/var/ncdata` per a les dades de Nextcloud (`-p` evita l'error si ja existeix), en fa propietari l'usuari i el grup `www-data` (els d'Apache) i fixa els permisos a 750. A la captura es veu un error de tecleig (`suod`) i després la comanda corregida.

---

![Imatge17](Captures/17.png)

```bash
sudo nano /etc/apache2/sites-available/nextcloud.conf
```

```apache
<VirtualHost *:80>
        ServerName nextcloud.lab
        DocumentRoot /var/www/nextcloud

        <Directory /var/www/nextcloud>
                Require all granted
                AllowOverride All
                Options FollowSymlinks MultiViews
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/nextcloud_error.log
        CustomLog ${APACHE_LOG_DIR}/nextcloud_access.log combined
</VirtualHost>
```

Obre amb nano el fitxer de configuració del lloc virtual HTTP de Nextcloud. Defineix un `VirtualHost` al port 80 amb el nom `nextcloud.lab` i l'arrel `/var/www/nextcloud`. `AllowOverride All` permet fer servir fitxers `.htaccess` i es defineixen registres propis d'errors i d'accés.

---

![Imatge18](Captures/18.png)

```bash
sudo a2enmod rewrite headers env dir mime
sudo a2ensite nextcloud.conf
sudo a2dissite 000-default.conf
sudo apache2ctl configtest
sudo systemctl restart apache2
```

Activa els mòduls d'Apache que necessita Nextcloud (`a2enmod`), activa el lloc `nextcloud.conf` (`a2ensite`) i desactiva el lloc per defecte (`a2dissite`). Després `apache2ctl configtest` comprova la sintaxi de la configuració (`Syntax OK`; l'avís AH00558 és perquè no hi ha un `ServerName` global) i `systemctl restart apache2` reinicia el servei perquè s'apliquin els canvis.

---

![Imatge19](Captures/19.png)

Sense comanda: des del navegador s'accedeix a `http://10.0.2.171` i apareix l'assistent d'instal·lació de Nextcloud, encara buit: compte d'administració, carpeta de dades (`/var/www/nextcloud/data`) i configuració de la base de dades.

---

![Imatge20](Captures/20.png)

Sense comanda: a l'assistent d'instal·lació s'omple el nom del compte d'administració (`soc_admin`) i la seva contrasenya. Nextcloud avisa que la contrasenya té una complexitat mitjana.

---

![Imatge21](Captures/21.png)

Sense comanda: a la configuració de la base de dades s'indiquen l'usuari (`nc_user`), la contrasenya, el nom de la base de dades (`nextcloud`) i el host (`localhost`), i es fa clic a **Instalar**.

---

![Imatge22](Captures/22.png)

```bash
sudo a2enmod ssl
sudo systemctl restart apache2
```

Activa el mòdul SSL d'Apache (també activa la dependència `socache_shmcb`) i reinicia el servei perquè el canvi tingui efecte.

---

![Imatge23](Captures/23.png)

```bash
sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/nextcloud.key -out /etc/ssl/certs/nextcloud.crt -subj "/C=ES/ST=Barcelona/L=Barcelona/O=K-SIX Solutions/OU=SOC/CN=nextcloud.lab" -addext "subjectAltName=DNS:nextcloud.lab,IP:10.0.2.171"
```

Genera un certificat autosignat (`-x509`) vàlid 365 dies, amb una clau RSA de 2048 bits sense contrasenya (`-nodes`). La clau es desa a `/etc/ssl/private/nextcloud.key` i el certificat a `/etc/ssl/certs/nextcloud.crt`. `-subj` en defineix les dades (país, província, ciutat, organització, unitat i nom comú) i `-addext` afegeix els noms alternatius (`nextcloud.lab` i la IP `10.0.2.171`).

---

![Imatge24](Captures/24.png)

```bash
sudo chmod 600 /etc/ssl/private/nextcloud.key
```

Restringeix els permisos de la clau privada: només el propietari (root) pot llegir-la i escriure-hi.

---

![Imatge25](Captures/25.png)

```bash
sudo nano /etc/apache2/sites-available/nextcloud-ssl.conf
```

```apache
<VirtualHost *:443>
        ServerName nextcloud.lab
        DocumentRoot /var/www/nextcloud

        SSLEngine on
        SSLCertificateFile /etc/ssl/certs/nextcloud.crt
        SSLCertificateKeyFile /etc/ssl/private/nextcloud.key

        <Directory /var/www/nextcloud>
                Require all granted
                AllowOverride All
                Options FollowSymlinks MultiViews
        </Directory>

        Header always set X-Frame-Options "SAMEORIGIN"
        Header always set X-Contetn-Type-Options "nosniff"
        Header always set Referrer-Policy "same-origin"

        ErrorLog ${APACHE_LOG_DIR}/nextcloud_ssl_error_log
        CustomLog ${APACHE_LOG_DIR}/nextcloud_ssl_access.log combined
</VirtualHost>
```

Obre amb nano el fitxer del lloc virtual HTTPS de Nextcloud. Defineix un `VirtualHost` al port 443 amb SSL activat (`SSLEngine on`) i el certificat i la clau creats abans. Afegeix capçaleres de seguretat (`X-Frame-Options`, `X-Content-Type-Options` i `Referrer-Policy`) i registres propis.

---

![Imatge26](Captures/26.png)

```bash
sudo a2ensite nextcloud-ssl.conf
sudo apache2ctl configtest
```

Activa el lloc virtual HTTPS (`nextcloud-ssl.conf`); a la captura Apache indica que ja estava activat. Després `apache2ctl configtest` comprova la sintaxi de la configuració: `Syntax OK` (l'avís AH00558 és perquè no hi ha un `ServerName` global).

---

![Imatge27](Captures/27.png)

```bash
sudo a2ensite nextcloud-ssl.conf
sudo apache2ctl configtest
sudo systemctl restart apache2
```

Igual que l'anterior, però afegint el reinici d'Apache (`systemctl restart apache2`) perquè es carreguin els canvis.

---

![Imatge28](Captures/28.png)

```bash
sudo nano /etc/apache2/sites-available/nextcloud.conf
```

```apache
<VirtualHost *:80>
        ServerName nextcloud.lab

        Redirect permanent / https://nextcloud.lab/
</VirtualHost>
```

Edita amb nano el lloc virtual HTTP perquè només redirigeixi. Tot el trànsit del port 80 s'envia de manera permanent (codi 301) a `https://nextcloud.lab/`.

---

![Imatge29](Captures/29.png)

```bash
sudo apache2ctl configtest
sudo systemctl restart apache2
```

Comprova la sintaxi de la configuració (`Syntax OK`) i reinicia Apache per aplicar la redirecció a HTTPS.

---

![Imatge30](Captures/30.png)

```bash
curl -k -I https://localhost
curl -k -I http://localhost
```

Comprova el servidor amb `curl`. `-I` només demana les capçaleres i `-k` ignora la validació del certificat, que és autosignat. La primera ordre mostra una resposta `302 Found` cap al login de Nextcloud, amb les capçaleres de seguretat. La segona mostra `301 Moved Permanently` cap a `https://nextcloud.lab/`, cosa que confirma que la redirecció HTTP → HTTPS funciona.

---

![Imatge31](Captures/31.png)

```bash
sudo -u www-data php /var/www/nextcloud/occ config:system:set trusted_domains 1 --value=nextcloud.lab
sudo -u www-data php /var/www/nextcloud/occ config:system:set trusted_domains 2 --value=10.0.2.171
```

Amb `occ` (l'eina d'ordres de Nextcloud, executada com a `www-data`) afegeix dos dominis de confiança, `nextcloud.lab` i `10.0.2.171`. Nextcloud només respon a les peticions dirigides a aquests noms o adreces.

---

![Imatge32](Captures/32.png)

```bash
sudo -u www-data php /var/www/nextcloud/occ config:system:set overwriteprotocol --value=https
sudo -u www-data php /var/www/nextcloud/occ config:system:set secure_cookie --type=boolean --value=true
```

Obliga Nextcloud a generar els enllaços amb el protocol `https` (`overwriteprotocol`) i marca les galetes com a segures (`secure_cookie`), perquè només viatgin per HTTPS.

---

![Imatge33](Captures/33.png)

```bash
sudo -u www-data php /var/www/nextcloud/occ config:list system
```

Mostra la configuració de sistema de Nextcloud en format JSON (dominis de confiança, versió, tipus de base de dades, `overwriteprotocol`, `secure_cookie`...). Els valors sensibles, com contrasenyes o secrets, apareixen ocults com a `***REMOVED SENSITIVE VALUE***`.

---

![Imatge34](Captures/34.png)

```bash
sudo -u www-data php /var/www/nextcloud/occ group:add SOC_Analysts
sudo -u www-data php /var/www/nextcloud/occ group:add SOC_Investigators
sudo -u www-data php /var/www/nextcloud/occ group:add SOC_Admins
sudo -u www-data php /var/www/nextcloud/occ group:list
```

Crea tres grups d'usuaris a Nextcloud (`SOC_Analysts`, `SOC_Investigators` i `SOC_Admins`) i després els llista amb `group:list`. Al llistat també apareix el grup `admin`, amb l'usuari `soc_admin`.

---

![Imatge35](Captures/35.png)

```bash
sudo -u www-data php /var/www/nextcloud/occ user:add --group="SOC_Analysts" analyst01
sudo -u www-data php /var/www/nextcloud/occ user:add --group="SOC_Analysts" analyst02
```

Crea els comptes `analyst01` i `analyst02` i els afegeix directament al grup `SOC_Analysts` (`--group`). L'ordre demana la contrasenya i la seva confirmació. Els missatges `Fontconfig error: No writable cache directories` són avisos sense importància, perquè l'usuari `www-data` no té un directori de memòria cau on escriure, i no impedeixen que els comptes es creïn.

---

![Imatge36](Captures/36.png)

```bash
sudo -u www-data php /var/www/nextcloud/occ user:add --group="SOC_Investigators" Investigator01
```

Crea el compte `Investigator01` a Nextcloud i l'afegeix directament al grup `SOC_Investigators` (`--group`). L'ordre demana la contrasenya i la seva confirmació. Els avisos `Fontconfig error` són sense importància i no impedeixen que el compte es creï.

---

![Imatge37](Captures/37.png)

```bash
sudo -u www-data php /var/www/nextcloud/occ user:add --group="SOC_Investigators" Investigator02
```

Igual que l'anterior, però per al compte `Investigator02`, que també s'afegeix al grup `SOC_Investigators`.

---

![Imatge38](Captures/38.png)

```bash
sudo -u www-data php /var/www/nextcloud/occ user:list
```

Llista tots els usuaris de Nextcloud. Hi apareixen els quatre comptes creats (`analyst01`, `analyst02`, `Investigator01` i `Investigator02`) i l'administrador `soc_admin`.

---

![Imatge39](Captures/39.png)

```bash
sudo groupadd --system soc_evidence
sudo mkdir -p /srv/Quarantine_Evidences
sudo chown root:soc_evidence /srv/Quarantine_Evidences/
sudo chmod 2770 /srv/Quarantine_Evidences/
```

Crea un grup de sistema anomenat `soc_evidence` i el directori `/srv/Quarantine_Evidences`. En fa propietari `root` i assigna el grup `soc_evidence`. Amb `chmod 2770` el propietari i el grup tenen tots els permisos i els altres cap. El `2` activa el bit setgid, de manera que els fitxers nous heretin el grup del directori.

---

![Imatge40](Captures/40.png)

```bash
sudo setfacl -m u:www-data:rwx /srv/Quarantine_Evidences/
sudo setfacl -d -m u:www-data:rwx /srv/Quarantine_Evidences/
getfacl /srv/Quarantine_Evidences/
```

Amb ACL (llistes de control d'accés) dona a l'usuari `www-data` permisos de lectura, escriptura i execució sobre el directori (`-m`). Amb `-d` defineix la mateixa ACL per defecte, perquè la heretin els fitxers i els subdirectoris que es creïn. `getfacl` mostra les ACL per comprovar-ho.

---

![Imatge41](Captures/41.png)

```bash
sudo -u www-data php /var/www/nextcloud/occ app:enable files_external
```

Activa l'aplicació `files_external` de Nextcloud (emmagatzematge extern), que permet muntar carpetes externes, com el directori de proves en quarantena.

---

![Imatge42](Captures/42.png)

Sense comanda: a Nextcloud, a **Ajustes > Administración > Almacenamiento externo** (`https://10.0.2.171/index.php/settings/admin/externalstorages`), es fa clic a «Agregar almacenamiento externo» i s'omple el formulari: nom de carpeta `Quarantine_Evidences`, restringit als grups `SOC_Investigators` i `SOC_Admins`, tipus `Local (server storage)`, autenticació `Ninguno` i ubicació `/srv/Quarantine_Evidences`. Per acabar, es fa clic a **Crear**.

---

![Imatge43](Captures/43.png)

Sense comanda: l'emmagatzematge extern ja apareix a la llista. Carpeta `/Quarantine_Evidences`, tipus `Local (server storage)`, sense autenticació i restringit als grups `SOC_Investigators` i `SOC_Admins`.

---

![Imatge44](Captures/44.png)

```bash
sudo systemctl is-active apache2
sudo systemctl is-active mariadb
```

Comprova si els serveis Apache2 i MariaDB estan en marxa. Si ho estan, cada ordre respon `active`.

---

![Imatge45](Captures/45.png)

```bash
sudo curl -k -I https://localhost
sudo -u www-data php /var/www/nextcloud/occ status
```

El primer comando demana les capçaleres de `https://localhost` (`-I`) ignorant la validació del certificat autosignat (`-k`). Respon `302 Found` cap a la pàgina de login de Nextcloud. El segon, `occ status`, mostra l'estat de la instal·lació: instal·lada (`installed: true`), versió 35.0.2.2, sense mode de manteniment (`maintenance: false`) i sense necessitat d'actualitzar la base de dades (`needsDbUpgrade: false`).

---

![Imatge46](Captures/46.png)

```bash
sudo -u www-data php /var/www/nextcloud/occ group:list
sudo -u www-data php /var/www/nextcloud/occ user:list
sudo getfacl /srv/Quarantine_Evidences/
```

Comprova la configuració feta fins ara. `group:list` mostra els grups de Nextcloud amb els seus membres: `SOC_Analysts` (`analyst01` i `analyst02`), `SOC_Investigators` (`Investigator01` i `Investigator02`), `SOC_Admins` (buit) i `admin` (`soc_admin`). `user:list` mostra els usuaris, i `getfacl` mostra els permisos i les ACL del directori `/srv/Quarantine_Evidences/`.

---

![Imatge47](Captures/47.png)

```sql
CREATE DATABASE soc_honeypot
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

Dins de MariaDB, crea la base de dades `soc_honeypot` amb el joc de caràcters `utf8mb4` i la col·lació `utf8mb4_unicode_ci`.

---

![Imatge48](Captures/48.png)

```sql
CREATE USER 'soc_honeypot'@'localhost' IDENTIFIED BY 'usuari123!';
```

Crea l'usuari `soc_honeypot`, que només pot connectar des de `localhost`, amb la contrasenya indicada.

---

![Imatge49](Captures/49.png)

```sql
GRANT SELECT, INSERT ON soc_honeypot.*
TO 'soc_honeypot'@'localhost';
FLUSH PRIVILEGES;
```

Dona a l'usuari `soc_honeypot` només els permisos de lectura (`SELECT`) i d'inserció (`INSERT`) sobre totes les taules de la base de dades indicada, i recarrega la taula de privilegis amb `FLUSH PRIVILEGES`.

---

![Imatge50](Captures/50.png)

```sql
CREATE TABLE eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    direccion_ip VARCHAR(45) NOT NULL,
    user_agent TEXT,
    identificador_prueba VARCHAR(100),
    tipo_evento VARCHAR(50) NOT NULL
);
SHOW TABLES;
DESCRIBE eventos;
```

Crea la taula `eventos`: un `id` autoincremental com a clau primària, la data i hora (`fecha_hora`, per defecte el moment actual), l'adreça IP (`direccion_ip`, fins a 45 caràcters, prou per a IPv6), el `user_agent`, un identificador de prova i el tipus d'esdeveniment. Després `SHOW TABLES` llista les taules i `DESCRIBE eventos` en mostra l'estructura.

---

![Imatge51](Captures/51.png)

```bash
sudo mariadb -u soc_honeypot -p soc_honeypot
```

```sql
SHOW TABLES;
EXIT;
```

Connecta a MariaDB amb l'usuari `soc_honeypot` (`-u`), demana la contrasenya (`-p`) i selecciona la base de dades `soc_honeypot`. Dins del client, `SHOW TABLES` comprova que la taula `eventos` existeix i `EXIT` surt del client.

---

![Imatge52](Captures/52.png)

```bash
sudo systemctl is-active apache2 mariadb
sudo mariadb -u soc_honeypot -p soc_honeypot -e "DESCRIBE eventos;"
```

El primer comando comprova que Apache2 i MariaDB estan en marxa (responen `active`). El segon executa una sola sentència SQL (`-e`) amb l'usuari `soc_honeypot` i mostra l'estructura de la taula `eventos`. A la captura hi ha un error de tecleig (`mariadb-u`) i després la comanda corregida.

---

![Imatge53](Captures/53.png)

```bash
sudo mkdir -p /var/www/soc_honeypot
sudo chown -R www-data:www-data /var/www/soc_honeypot/
sudo chmod 750 /var/www/soc_honeypot/
```

Crea el directori web `/var/www/soc_honeypot`, en fa propietari `www-data` (l'usuari d'Apache) i fixa els permisos a 750.

---

![Imatge54](Captures/54.png)

```bash
sudo nano /etc/soc-honeypot.php
```

```php
<?php

$host = 'localhost';
$dbname = 'soc_honeypot';
$username = 'soc_honeypot';
$password = 'usuari123!';

$connexion = new mysqli(
        $host,
        $username,
        $password,
        $dbname
);

if ($connexion->connect_error) {
        error_log('Error de conexión con MariaDB');
        http_response_code(500);
        exit('Servicio temporalmente no disponible.');
}

$connexion->set_charset('utf8mb4');
```

Crea amb nano el fitxer PHP de connexió a la base de dades, desat a `/etc` (fora de l'arrel web). Defineix les credencials i es connecta amb `mysqli`. Si la connexió falla, registra l'error, respon amb el codi 500 i mostra un missatge genèric. Si va bé, configura el joc de caràcters `utf8mb4`.

---

![Imatge55](Captures/55.png)

```bash
sudo chown root:www-data /etc/soc-honeypot.php
sudo chmod 640 /etc/soc-honeypot.php
```

Fa que `root` sigui el propietari del fitxer de connexió i `www-data` el grup. Amb permisos 640, `root` pot llegir-lo i escriure-hi, Apache només el pot llegir i la resta d'usuaris no hi tenen accés. Així es protegeixen les credencials.

---

![Imatge56](Captures/56.png)

![Imatge57](Captures/57.png)

![Imatge58](Captures/58.png)

![Imatge59](Captures/59.png)

![Imatge60](Captures/60.png)

```bash
sudo nano /var/www/soc_honeypot/index.php
```

```php
<?php

require_once '/etc/soc-honeypot.php';

$mensaje = '';
$tipo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $identificador = trim($_POST['identificador'] ?? '');

        if ($identificador === '' || strlen($identificador) > 100) {
                $mensaje = 'Introduce un identificador de prueba válido.';
                $tipo = 'error';

        } else {

                $ip  =$_SERVER['REMOTE_ADDR'] ?? 'desconocida';
                $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'deconocido';

                $tipoEvento = 'simulacion_portal';

                $consulta = $conexion->prepare(
                        "INSERT INTO eventos
                        (direccion_ip, user_agent, identificador_prueba, tipo_evento)
                        VALUES (?,?,?,?)"
                );

                $consulta->bind_param(
                        "ssss",
                        $ip,
                        $userAgent,
                        $identificador,
                        $tipoEvento
                );

                if ($consulta->execute()) {
                        $mensaje = 'Evento registrado correctamente en el laboratorio SOC.';
                        $tipo = 'correcto';
                } else {
                        $mensaje = 'No se ha podido registrar el evento.';
                        $tipo = 'error';
                        error_log('Error al insertar evento SOC');

                }

                $consulta->close();

        }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
        <meta charset="UTF8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <tittle>Northstar - Simulación SOC</tittle>

        <style>
                body {
                        font-family: Arial, sans-serif;
                        background: #101827;
                        display: flex;
                        justify-content: center;
                        align-items:center;
                        min-height: 100vh;
                        margin: 0;
                }

                .contenedor {
                        background: #1e293b;
                        witdh: 90%;
                        max-width: 420px;
                        padding: 35px;
                        border-radius: 12px;
                        box-sizing: border-box;
                }

                h1 {
                        text-align: center;
                        color: #38bdf8;
                }

                p {
                        line-height: 1.5;
                }

                input {
                        width: 100%;
                        padding: 12px;
                        margin: 12px 0;
                        box-sizing: border-box;
                        border-radius: 6px;
                        border: 1px solid #64748b;
                }

                button {
                        width: 100%;
                        padding: 12px;
                        background: #0284c7;
                        color: white;
                        border: none;
                        border-radius: 6px;
                        cursor: pointer;
                }

                .aviso {
                        background: #713f12;
                        color: #fef3c7;
                        padding: 12px;
                        border-radius: 6px;
                        fons-size: 13px;
                }

                .correcto {
                        color: #86efac;
                }

                .error {
                        color: #fca5a5;
                }

                .pie {
                        text-align: center;
                        font-size: 12px;
                        color: #94a3b8;
                        margin-top: 20px;
                }
        </style>
</head>

<body>

<div class="contenedor">

        <h1>NORTHSTAR</h1>

        <p><strong>Portal de acceso corporativo</strong></p>

        <div class="aviso">
                SIMULACIÓN DE SEGURIDAD SOC.
                No introduzcas contraseñas ni datos personales reales.
        </div>

        <form method="POST">

                <label for="identificador">
                        Identificador ficticio de prueba
                </label>

                <input
                        type="text"
                        id="identificador"
                        name="identificador"
                        maxlenght="100"
                        placeholder="Ejemplo: usuario_prueba01"
                        required

                >

                <button type="submit">
                        Enviar evento de prueba
                </button>

        </form>

        <?php if ($mensaje !== ''): ?>">

                <p> class="<?= htmlspecialchars($tipo) ?>">
                        <?= htmlspecialchars($mensaje) ?>
                </p>

        <?php endif; ?>

        <div class="pie">
                K-SIX Solutions · Laboratorio SOC
        </div>

</div>

</body
</html>
```

Obre amb nano i escriu el fitxer `index.php`, la pàgina de simulació «Northstar», que barreja PHP i HTML.

**Part PHP (la lògica):**
- Carrega la connexió a la base de dades des de `/etc/soc-honeypot.php` (`require_once`).
- Quan arriba un formulari per POST, neteja l'identificador (`trim`) i comprova que no estigui buit i no passi de 100 caràcters. Si no és vàlid, prepara un missatge d'error.
- Si és vàlid, recull l'adreça IP i el `user-agent` del visitant i el tipus d'esdeveniment (`simulacion_portal`).
- Insereix aquestes dades a la taula `eventos` amb una sentència preparada (`prepare` i `bind_param`), que evita la injecció SQL.
- Segons el resultat, prepara un missatge de confirmació o d'error (i registra l'error amb `error_log`) i tanca la consulta.

**Part HTML i CSS (l'aspecte):**
- Defineix l'estructura de la pàgina i uns estils (`<style>`) amb tema fosc: fons, targeta central, títol, camp de text, botó, quadre d'avís ambre, colors dels missatges de resultat i peu de pàgina.
- Mostra el títol «NORTHSTAR», un avís que és una simulació de seguretat on no s'han d'introduir dades reals, i un formulari POST amb un únic camp obligatori: l'identificador fictici de prova.
- Un bloc PHP mostra el missatge de resultat només si n'hi ha, escapant-lo amb `htmlspecialchars`.
- Acaba amb un peu de pàgina («K-SIX Solutions · Laboratorio SOC») i tanca el document.

---

![Imatge61](Captures/61.png)

```bash
sudo php -l /var/www/soc_honeypot/index.php
```

Comprova la sintaxi del fitxer PHP sense executar-lo (`-l` de *lint*). La resposta `No syntax errors detected` indica que no hi ha errors de sintaxi.

---

![Imatge62](Captures/62.png)

```bash
sudo chown www-data:www-data /var/www/soc_honeypot/index.php
sudo chmod 640 /var/www/soc_honeypot/index.php
```

Fa que `www-data` (l'usuari d'Apache) sigui propietari del fitxer `index.php` i fixa els permisos a 640: el propietari el pot llegir i escriure, el grup només el pot llegir i els altres no hi tenen accés.

---

![Imatge63](Captures/63.png)

```bash
sudo nano /etc/apache2/ports.conf
```

```apache
# If you just change the port or add more ports here, you will likely also
# have to change the VirtualHost statement in
# /etc/apache2/sites-enabled/000-default.conf

Listen 80

Listen 8080

<IfModule ssl_module>
        Listen 443
</IfModule>

<IfModule mod_gnutls.c>
        Listen 443
</IfModule>
```

Edita amb nano el fitxer que defineix els ports on escolta Apache. S'hi afegeix `Listen 8080`, a més del 80 (HTTP) i el 443 (HTTPS), perquè el servidor també atengui peticions pel port 8080, que s'utilitzarà per a la pàgina `soc_honeypot`.

---

![Imatge64](Captures/64.png)

```bash
sudo apache2ctl configtest
```

Comprova la sintaxi de la configuració d'Apache. Respon `Syntax OK` (l'avís AH00558 és perquè no hi ha un `ServerName` global).

---

![Imatge65](Captures/65.png)

```bash
sudo nano /etc/apache2/sites-available/soc_honeypot.conf
```

```apache
<VirtualHost *:8080>

        ServerName soc-honeypot.lab

        DocumentRoot /var/www/soc-honeypot

        <Directory /var/www/soc-honeypot>
                Require all granted
                AllowOverride None
                Options -Indexes
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/soc-honeypot-error.log
        CustomLog ${APACHE_LOG_DIR}/soc-honeypot-access.log combined

</VirtualHost>
```

Crea amb nano el lloc virtual de la pàgina de simulació, que escolta al port 8080 amb el nom `soc-honeypot.lab`. Permet l'accés al directori (`Require all granted`), desactiva els `.htaccess` (`AllowOverride None`) i impedeix llistar-ne el contingut (`Options -Indexes`). A més, defineix registres propis d'errors i d'accés.

---

![Imatge66](Captures/66.png)

```bash
sudo a2ensite soc_honeypot.conf
sudo apache2ctl configtest
sudo systemctl restart apache2
sudo systemctl is-active apache2
```

Activa el lloc virtual `soc_honeypot.conf` (`a2ensite`), comprova la configuració (`configtest`), reinicia Apache i verifica que està actiu (`active`). `configtest` avisa (AH00112) que el `DocumentRoot` `/var/www/soc-honeypot` no existeix, a més de l'avís habitual AH00558, però acaba amb `Syntax OK`.

---

![Imatge67](Captures/67.png)

```bash
sudo cat /etc/apache2/sites-enabled/soc_honeypot.conf
```

Mostra el contingut del lloc virtual activat (a `sites-enabled`) per revisar-ne la configuració: port 8080, `ServerName soc-honeypot.lab`, `DocumentRoot`, permisos del directori i registres propis.

---

![Imatge68](Captures/68.png)

```bash
ls -ld /var/www/soc_honeypot/ /var/www/soc_honeypot/
sudo find /var/www/ -maxdepth 3 -name index.php
```

`ls -ld` mostra els permisos i el propietari del propi directori (no el seu contingut): `drwxr-x---`, propietari i grup `www-data`. `find` busca fitxers `index.php` fins a 3 nivells dins de `/var/www/`, i confirma que n'hi ha un a `/var/www/soc_honeypot/`, a més dels de Nextcloud.

---

![Imatge69](Captures/69.png)

```bash
sudo tail -n 40 /var/log/apache2/soc-honeypot-error.log
php -m | grep -i mysqli
sudo ls -l /etc/soc-honeypot.php
sudo systemctl is-active apache2
```

Diagnostica un error de la pàgina. `tail -n 40` mostra les últimes 40 línies del registre d'errors del lloc, on apareix un error fatal de PHP: no troba la classe `mysql` a `/etc/soc-honeypot.php` (línia 8). `php -m | grep -i mysqli` comprova que l'extensió `mysqli` està carregada, `ls -l` mostra els permisos del fitxer de connexió (640, propietari `root` i grup `www-data`) i `is-active` confirma que Apache continua actiu.

---

![Imatge72](Captures/72.png)

Sense comanda: des del navegador s'accedeix a `http://10.0.0.121:8080` i apareix la pàgina «NORTHSTAR» amb l'avís de simulació, el camp de l'identificador fictici i el botó **Enviar evento de prueba**, encara sense cap missatge de resultat.

---

![Imatge70](Captures/70.png)

Sense comanda: després d'enviar un identificador de prova des del formulari, la pàgina mostra el missatge en verd «Evento registrado correctamente en el laboratorio SOC.», que confirma que la inserció a la base de dades ha funcionat.

---

![Imatge71](Captures/71.png)

```sql
SELECT * FROM eventos ORDER BY id DESC LIMIT 10
;
```

Dins de MariaDB, mostra els últims 10 esdeveniments de la taula `eventos`, del més nou al més antic (`ORDER BY id DESC LIMIT 10`). Apareix un únic registre: data i hora, adreça IP del visitant (`10.0.3.17`), `user-agent` del navegador, identificador de prova i tipus `simulacion_portal`.

---

![Imatge73](Captures/73.png)

```bash
ip -br addr
```

Mostra, en format breu (`-br`), les interfícies de xarxa del servidor i les seves adreces. La interfície `enp0s3` està `UP` amb la IP `10.0.0.121/22`, la que s'utilitza per accedir a la pàgina.

---

![Imatge74](Captures/74.png)

```bash
exit
```

```powershell
ipconfig
```

`exit` tanca la sessió SSH amb el servidor (`Connection to 10.0.0.121 closed`). Ja des del PowerShell de Windows, `ipconfig` mostra la configuració de xarxa de l'ordinador client. L'adaptador Wi-Fi té la IPv4 `10.0.3.17`, màscara `255.255.252.0` i porta d'enllaç `10.0.0.1`, que és la IP registrada a l'esdeveniment.

---

![Imatge75](Captures/75.png)

```powershell
ping 10.0.0.121
```

Comprova la connectivitat des de Windows cap al servidor. Envia 4 paquets i els 4 tornen (0 % perduts) amb temps inferior a 1 ms, així que el servidor és accessible per xarxa.

---

![Imatge76](Captures/76.png)

```bash
sudo systemctl status apache2
```

Mostra l'estat del servei Apache2: està actiu (`active (running)`) i habilitat, porta unes 3 hores en marxa (des del 6 de novembre a les 08:55), mostra el PID principal, els processos fills, l'ús de memòria i les últimes línies del registre, entre les quals l'avís habitual AH00558 (sense `ServerName` global).

---

![Imatge77](Captures/77.png)

```bash
sudo systemctl status mariadb
```

Mostra l'estat del servei MariaDB: actiu (`active (running)`), amb el missatge «Taking your SQL requests now...», memòria i processos. Al registre apareixen diversos avisos `Access denied for user 'soc_honeypot'@'localhost' (using password: YES)`, que són intents d'autenticació fallits d'aquest usuari entre les 11:43 i les 11:46.

---

![Imatge78](Captures/78.png)

```bash
sudo ls -la /var/www/soc_honeypot/
```

Llista, amb detall i inclosos els fitxers ocults (`-la`), el contingut del directori de la pàgina: `index.php` (propietari `www-data`, permisos 640) i `prueba.html` (propietari `root`, permisos 644).

---

![Imatge79](Captures/79.png)

```bash
sudo apache2ctl -S
```

Mostra com ha interpretat Apache la configuració dels llocs virtuals i els paràmetres principals. Hi apareixen el lloc HTTPS `nextcloud.lab` (port 443), els llocs del port 80 (el per defecte i `nextcloud.lab`) i `soc-honeypot.lab` al port 8080, a més de l'arrel principal (`/var/www/html`) i l'usuari i grup que executen Apache (`www-data`).

---

![Imatge80](Captures/80.png)

```bash
sudo mariadb
```

```sql
USE soc_honeypot;
DESCRIBE eventos;
SELECT COUNT(*) FROM eventos;
EXIT;
```

Obre el client de MariaDB com a administrador, selecciona la base de dades `soc_honeypot` (`USE`), mostra l'estructura de la taula `eventos` (`DESCRIBE`), compta quants registres té (`COUNT(*)`, en aquest cas 3) i surt del client (`EXIT`).

---

![Imatge81](Captures/81.png)

```sql
CREATE TABLE IF NOT EXISTS callback_hito3 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    test_id VARCHAR(64) NOT NULL,
    source_ip VARCHAR(45) NOT NULL,
    user_agent VARCHAR(512),
    request_method VARCHAR(10),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Dins de MariaDB, crea la taula `callback_hito3` (només si encara no existeix) per guardar les trucades rebudes: un `id` autoincremental, l'identificador de la prova, la IP d'origen, el `user-agent`, el mètode HTTP i la data i hora (per defecte el moment actual).

---

![Imatge82](Captures/82.png)

![Imatge83](Captures/83.png)

```bash
sudo nano /var/www/soc_honeypot/callback.php
```

```php
<?php

header('Content-Type: application/json; charset=utf-8');

// Solo aceptamos peticiones POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Metodo no permitido']);
    exit;
}

// Recoger el identificador de la simulación.
$testId = trim($_POST['test_id'] ?? '');

if (!preg_match('/^[A-Za-z0-9_-]{1,64}$/', $testId)) {
    http_response_code(400);
    echo json_encode(['error' => 'Identificador no valido']);
    exit;
}

// Utilizar la conexión existente del proyecto.
require_once '/etc/soc-honeypot.php';

$ip = $_SERVER['REMOTE_ADDR'] ?? 'desconocida';
$userAgent = substr(
    $_SERVER['HTTP_USER_AGENT'] ?? 'desconocido',
    0,
    512
);
$method = $_SERVER['REQUEST_METHOD'];

$sql = "INSERT INTO callbacks_hito3
        (test_id, source_ip, user_agent, request_method)
        VALUES (?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    error_log('Error preparando callback H3: ' . $conexion->error);
    http_response_code(500);
    echo json_encode(['error' => 'Error interno']);
    exit;
}

$stmt->bind_param(
    'ssss',
    $testId,
    $ip,
    $userAgent,
    $method
);

if (!$stmt->execute()) {
    error_log('Error insertando callback H3: ' . $stmt->error);
    http_response_code(500);
    echo json_encode(['error' => 'No se pudo registrar']);
    exit;
}

$stmt->close();

http_response_code(200);

echo json_encode([
    'status' => 'registered',
    'test_id' => $testId
]);
```

Crea amb nano el fitxer `callback.php`, un petit punt d'entrada que respon en format JSON i registra les trucades rebudes durant la simulació.

- Només accepta peticions POST. Si el mètode és un altre, respon amb el codi 405 (`Metodo no permitido`).
- Llegeix l'identificador de la prova (`test_id`) i el valida amb una expressió regular: només lletres, números, guió i guió baix, d'1 a 64 caràcters. Si no és vàlid, respon amb el codi 400.
- Carrega la connexió a la base de dades existent (`/etc/soc-honeypot.php`) i recull la IP d'origen, el `user-agent` (limitat a 512 caràcters) i el mètode de la petició.
- Insereix aquestes dades a la taula de callbacks amb una sentència preparada (`prepare` i `bind_param`). Si falla la preparació o l'execució, registra l'error amb `error_log` i respon amb el codi 500.
- Si tot va bé, respon amb el codi 200 i un JSON amb `status: registered` i l'identificador rebut.

---

![Imatge84](Captures/84.png)

```bash
sudo php -l /var/www/soc_honeypot/callback.php
```

Comprova la sintaxi del fitxer `callback.php` sense executar-lo (`-l` de *lint*). La resposta `No syntax errors detected` indica que no hi ha errors de sintaxi.

---

![Imatge85](Captures/85.png)

```bash
sudo php -l /etc/soc-honeypot.php
```

Fa la mateixa comprovació de sintaxi sobre el fitxer de connexió a la base de dades `/etc/soc-honeypot.php`, i no detecta cap error.

---

![Imatge91](Captures/91.png)

```bash
sudo ls -l /var/www/soc_honeypot/callback.php
sudo ls -l /var/www/soc_honeypot/
```

Comprova que el fitxer `callback.php` existeix i en mostra els permisos: propietari `root`, grup `root` i permisos 644 (lectura per a tothom, escriptura només per a `root`). La segona ordre llista el directori complet, amb `callback.php`, `index.php` (propietari `www-data`, permisos 640) i `prueba.html`.

---

![Imatge86](Captures/86.png)

```bash
sudo apache2ctl configtest
```

Comprova la sintaxi de la configuració d'Apache. Respon `Syntax OK` (l'avís AH00558 és perquè no hi ha un `ServerName` global) i ja no apareix l'avís del `DocumentRoot` que sortia a la captura 66.

---

![Imatge92](Captures/92.png)

```bash
sudo apache2ctl -S
```

Mostra com ha interpretat Apache els llocs virtuals i els paràmetres principals. Hi apareixen el lloc HTTPS `nextcloud.lab` (port 443), els llocs del port 80 (el per defecte i `nextcloud.lab`) i `soc-honeypot.lab` al port 8080, carregat des de `soc_honeypot.conf`, a més de l'usuari i el grup que executen Apache (`www-data`).

---

![Imatge87](Captures/87.png)

```bash
sudo ss -ltnp | grep ':8080'
```

Llista els sockets TCP en escolta (`-l` escoltant, `-t` TCP, `-n` ports en format numèric, `-p` procés) i filtra el port 8080. Mostra que Apache hi està escoltant (`LISTEN` a `*:8080`, amb els processos `apache2`).

---

![Imatge88](Captures/88.png)

```powershell
Test-NetConnection 10.0.0.121 -Port 8080
```

Des del PowerShell de Windows, comprova que es pot arribar al port 8080 del servidor `10.0.0.121`. El resultat `TcpTestSucceeded : True` indica que la connexió TCP funciona. L'origen és l'adaptador Wi-Fi amb la IP `10.0.3.17`.

---

![Imatge93](Captures/93.png)

```powershell
Invoke-RestMethod `
  -Uri "http://10.0.0.121:8080/callback.php" `
  -Method POST `
  -ContentType "application/x-www-form-urlencoded" `
  -Body "test_id=NORTHSTAR-H3-TEST01"
```

Des de Windows, envia una petició POST a `callback.php` amb l'identificador de prova `NORTHSTAR-H3-TEST01`, simulant una trucada de retorn (*callback*). El servidor respon amb un JSON amb `status: registered` i l'identificador rebut, cosa que confirma que la trucada s'ha registrat.

---

![Imatge94](Captures/94.png)

```bash
sudo mariadb
```

```sql
USE soc_honeypot;
SELECT * FROM callback_hito3 ORDER BY id DESC LIMIT 5;
```

Obre el client de MariaDB, selecciona la base de dades `soc_honeypot` i mostra els últims 5 registres de la taula `callback_hito3`, del més nou al més antic. Apareix el registre de la prova: identificador `NORTHSTAR-H3-TEST01`, IP d'origen `10.0.3.17`, `user-agent` de PowerShell, mètode `POST` i la data i hora.

---

![Imatge95](Captures/95.png)

```bash
sudo tail -n 1 /var/log/apache2/soc-honeypot-access.log
```

Mostra l'última línia del registre d'accés d'Apache. Apareix la petició `POST /callback.php` des de `10.0.3.17` amb codi de resposta `200`, que confirma que el servidor ha atès la trucada correctament.

---

![Imatge96](Captures/96.png)

```powershell
Test-NetConnection 10.0.1.202 -Port 8080
```

Des del PowerShell de Windows, comprova que es pot arribar al port 8080 d'un altre servidor, `10.0.1.202`. El resultat `TcpTestSucceeded : True` confirma que la connexió TCP funciona, des de l'adaptador Wi-Fi amb la IP d'origen `10.0.3.17`.

---

![Imatge97](Captures/97.png)

```powershell
Invoke-RestMethod `
  -Uri "http://10.0.1.202:8080/callback.php" `
  -Method POST `
  -ContentType "application/x-www-form-urlencoded" `
  -Body "test_id=NORTHSTAR-H3-TEST01"
```

Envia una petició POST a `callback.php` del servidor `10.0.1.202`, amb el mateix identificador de prova. El servidor respon amb un JSON amb `status: registered`, cosa que confirma que la trucada s'ha registrat correctament.

---

![Imatge98](Captures/98.png)

```sql
SELECT * FROM callback_hito3 LIMIT 10;
```

Dins de MariaDB, mostra fins a 10 registres de la taula `callback_hito3`. Ja n'hi ha dos amb el mateix identificador (`NORTHSTAR-H3-TEST01`), des de la mateixa IP (`10.0.3.17`) i amb el mateix `user-agent` de PowerShell, enviats en dates diferents (6 i 9 de novembre).

---

![Imatge99](Captures/99.png)

Sense comanda: finestra **Macros** de Microsoft Word, amb una macro anomenada `EnviarCallback` seleccionada, a punt d'executar-se amb el botó **Ejecutar**.

---

![Imatge100](Captures/100.png)

Aquesta captura no mostra cap comanda ni terminal, sinó el resultat d'executar la macro `EnviarCallback` des d'un document de Word creat expressament per a aquesta pràctica.

**Com arribar-hi:**
1. Al document de Word, activa la pestanya **Programador** (si no hi és): **Archivo > Opciones > Personalizar cinta de opciones**, i marca la casella **Programador** (*Developer*) a la llista de pestanyes principals.
2. A la pestanya **Programador**, fes clic a **Visual Basic** (o prem `Alt + F11`) per obrir l'editor de Visual Basic for Applications (VBA).
3. Dins l'editor, s'insereix un mòdul (**Insertar > Módulo**) amb el codi de la macro `EnviarCallback`, escrit en VBA. Aquest codi és el que fa la petició HTTP POST a `callback.php` (de manera equivalent al que abans es feia amb `Invoke-RestMethod` des de PowerShell), simulant que la trucada de retorn es dispara des d'un document ofimàtic en lloc de la línia d'ordres.
4. Es tanca l'editor i es torna al document. A la pestanya **Programador**, es fa clic a **Macros** (o `Alt + F8`), se selecciona `EnviarCallback` a la llista (com es veu a la captura 99) i es prem **Ejecutar**.
5. En acabar, apareix un quadre de diàleg (`MsgBox`) amb el títol **Northstar SOC** i el resultat de la petició: `Resultado HTTP: 200` i el cos de la resposta, `{"status":"registered","test_id":"NORTHSTAR-H3-001"}`.

Això demostra que la trucada es pot disparar també des d'una macro de Word, no només des de la terminal o PowerShell, cosa habitual en escenaris de phishing on un document ofimàtic executa codi en obrir-se o en prémer un botó.

---

![Imatge101](Captures/101.png)

```sql
SELECT * FROM callback_hito3
ORDER BY id DESC
LIMIT 10;
```

Dins de MariaDB, mostra els últims 10 registres de la taula `callback_hito3`, del més nou al més antic. Ja apareixen els tres intents: el de la macro de Word (`NORTHSTAR-H3-001`, amb el `user-agent` `WinHttp.WinHttpRequest.5`, típic de VBA) i els dos anteriors fets amb PowerShell (`NORTHSTAR-H3-TEST01`).

---

![Imatge102](Captures/102.png)

```bash
sudo tail -n 10 /var/log/apache2/soc-honeypot-access.log
```

Mostra les últimes 10 línies del registre d'accés del lloc del port 8080. Hi apareixen les dues últimes peticions `POST /callback.php`, totes dues amb codi de resposta `200`: una des de PowerShell i l'altra des del `user-agent` de WinHttp (la macro de Word).

---

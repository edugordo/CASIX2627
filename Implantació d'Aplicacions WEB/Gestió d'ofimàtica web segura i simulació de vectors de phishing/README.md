
# 🔐 Gestió d'ofimàtica web segura i simulació de phishing

## 📌 Objectiu

Desplegar un servidor web segur en un entorn de proves aïllat mitjançant **VirtualBox, Ubuntu, Apache, MariaDB i PHP**, entenent com funciona una aplicació web i com protegir-la davant d'atacs com el phishing.

## 🛠️ 1. Preparació de l'entorn

Tecnologies utilitzades:

- **VirtualBox:** virtualització de la màquina de proves.
- **Ubuntu Linux:** sistema operatiu del servidor.
- **Apache:** servidor web.
- **MariaDB:** sistema gestor de bases de dades.
- **PHP:** execució de codi dinàmic al servidor.

Instal·lació dels serveis:

```bash
sudo apt update
sudo apt install apache2 mariadb-server php php-mysql -y
```

Comprovació dels serveis:

```bash
sudo systemctl status apache2
sudo systemctl status mariadb
```

## 🌐 2. Arquitectura client-servidor

El funcionament d'una aplicació web es basa en la comunicació entre el navegador i el servidor.

1. El client envia una petició HTTP/HTTPS.
2. Apache rep la petició.
3. PHP executa el codi necessari.
4. MariaDB consulta o emmagatzema les dades.
5. El servidor retorna una resposta al navegador.

**Important:** el navegador gestiona la interfície de l'usuari, mentre que el servidor processa la lògica de l'aplicació i les dades.

## 🗄️ 3. Seguretat de la base de dades

Cal aplicar el principi de **mínim privilegi (PoLP)**: cada usuari ha de tenir únicament els permisos necessaris.

Exemple de creació d'una base de dades i un usuari específic:

```sql
CREATE DATABASE nextcloud_db;

CREATE USER 'nc_user'@'localhost'
IDENTIFIED BY 'ContrasenyaSegura';

GRANT SELECT, INSERT, UPDATE, DELETE
ON nextcloud_db.*
TO 'nc_user'@'localhost';
```

Això evita que l'aplicació utilitzi directament l'usuari `root` i limita els permisos sobre la base de dades.

## 🔒 4. Protecció del servidor web

### HTTPS

- **HTTP (port 80):** no xifra les dades transmeses.
- **HTTPS (port 443):** utilitza TLS per protegir la comunicació.

En un laboratori es poden utilitzar certificats autofirmats per fer proves de xifratge.

### Capçaleres de seguretat HTTP

| Capçalera | Funció |
|---|---|
| `X-Frame-Options: SAMEORIGIN` | Redueix el risc d'atacs de *clickjacking*. |
| `X-Content-Type-Options: nosniff` | Evita la interpretació incorrecta dels tipus de contingut. |

### Permisos de fitxers

- `chmod 755`: permisos habituals per a directoris.
- `chmod 644`: permisos habituals per a fitxers no executables.
- `chown`: modifica el propietari i el grup dels fitxers.

Els permisos s'han d'adaptar a les necessitats de l'aplicació, sense donar més privilegis dels necessaris.

## 🎣 5. Phishing i gestió de sessions

El phishing consisteix a enganyar un usuari perquè reveli informació confidencial, com ara les seves credencials.

Mesures de protecció principals:

- **Autenticació multifactor (2FA):** afegeix un segon factor de verificació.
- **Rate limiting:** limita els intents d'inici de sessió per dificultar els atacs de força bruta.
- **Revocació de sessions:** permet tancar les sessions actives després d'un possible compromís.
- **Contrasenyes segures:** redueixen el risc d'accés no autoritzat.

Les simulacions de phishing s'han de fer en un entorn controlat, amb comptes de prova i sense recollir credencials reals.

## 🔎 6. Anàlisi dels registres

Els logs d'Apache permeten investigar les peticions rebudes pel servidor.

Fitxers principals:

```text
/var/log/apache2/access.log
/var/log/apache2/error.log
```

Per consultar les últimes peticions:

```bash
sudo tail -f /var/log/apache2/access.log
```

Cal identificar:

- **IP d'origen:** adreça des de la qual arriba la petició.
- **Mètode HTTP:** `GET` per consultar recursos i `POST` per enviar dades.
- **Codi de resposta:** `200` (correcte), `302` (redirecció) o `403` (accés prohibit).
- **Data i hora:** moment en què s'ha produït la petició.
- **User-Agent:** informació sobre el client o navegador.

## 🧪 7. Aïllament i recuperació de l'entorn

Per evitar riscos durant les proves:

1. Configurar la xarxa de VirtualBox perquè l'entorn de laboratori no tingui accés a Internet ni a xarxes no autoritzades.
2. Comprovar que només els equips necessaris poden comunicar-se amb el servidor.
3. Crear una *snapshot* de la màquina virtual en un estat net.
4. Restaurar la snapshot si una prova provoca errors o modifica l'entorn.

## ✅ 8. Llista de verificació

- [ ] Ubuntu instal·lat i actualitzat.
- [ ] Apache i MariaDB instal·lats i en funcionament.
- [ ] PHP configurat correctament.
- [ ] Base de dades i usuari específic creats.
- [ ] Permisos de fitxers revisats.
- [ ] HTTPS configurat i provat.
- [ ] Entorn de xarxa aïllat.
- [ ] Snapshot de recuperació creada.
- [ ] Logs consultats i interpretats.
- [ ] Proves realitzades amb comptes ficticis.

## 📝 Conclusions

Aquesta pràctica permet comprendre el funcionament d'una infraestructura web i aplicar mesures bàsiques de ciberseguretat. La combinació de permisos mínims, comunicacions xifrades, autenticació multifactor, anàlisi de logs i aïllament de la xarxa ajuda a reduir els riscos i facilita la investigació d'incidents de seguretat.


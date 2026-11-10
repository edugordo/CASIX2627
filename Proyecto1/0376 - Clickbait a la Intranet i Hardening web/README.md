<div align="center">

# 🛡️ CLICKBAIT A LA INTRANET I HARDENING WEB

### NORTHSTAR SOC · K-SIX SOLUTIONS

![Cybersecurity](https://img.shields.io/badge/CYBERSECURITY-SOC-0B1020?style=for-the-badge&labelColor=075985)
![Hardening](https://img.shields.io/badge/WEB-HARDENING-0B1020?style=for-the-badge&labelColor=008F76)
![Infrastructure](https://img.shields.io/badge/INFRASTRUCTURE-LAMP-0B1020?style=for-the-badge&labelColor=6D28D9)

**Memòria tècnica del repte**

</div>

---

# 📋 PRESENTACIÓ DEL REPTE

## 🎯 Què aprendràs?

Muntar des de zero un servidor web segur amb base de dades dins d'un entorn de proves aïllat.

Durant el desenvolupament del repte es treballaran els següents objectius:

| Apartat | Objectiu d'aprenentatge |
|:---:|---|
| **1.1** | Triar el programari necessari (VirtualBox, Linux, Apache, MariaDB i PHP) per crear la infraestructura. |
| **1.2** | Comprendre com es comuniquen el navegador i el servidor mitjançant peticions HTTP i consultes SQL. |
| **1.3** | Instal·lar i activar el servidor web (Apache) i la base de dades (MariaDB) des de la terminal. |
| **1.4** | Distingir les tasques que executa el navegador de l'usuari de les que fa el servidor. |
| **1.5** | Configurar el motor de PHP perquè el servidor pugui executar codi programat i pàgines dinàmiques. |
| **1.6** | Preparar la base de dades i crear les taules on es guardaran les dades de l'aplicació. |
| **1.7** | Tallar la connexió a Internet i aïllar la xarxa per fer proves de seguretat sense riscos. |
| **1.8** | Utilitzar fotos del sistema (snapshots) per reiniciar la màquina al seu estat net si hi ha cap fallada. |
| **1.9** | Documentar el procés i comprovar que tot funciona correctament mitjançant una llista de verificació. |

## ⏱️ Informació general

| Característica | Descripció |
|---|---|
| **Temps estimat** | 12 hores |
| **Nivell de dificultat** | Alt |
| **Autoria del repte** | Héctor Arranz |
| **Darrera revisió** | Octubre de 2026 |

---

# 🌐 1. CONTEXT DE L'ESCENARI

K-SIX Solutions és una multinacional de ciberseguretat i consultoria tecnològica que ha inaugurat recentment el seu nou centre operatiu i Security Operations Center (SOC) a Barcelona.

La companyia ofereix serveis de monitorització de xarxa, anàlisi d'amenaces i infraestructura segura tant per als seus propis laboratoris com per a clients corporatius.

Un dels seus clients més importants és **Northstar Office Supplies Ltd.**, una empresa proveïdora de material d'oficina que està finalitzant el seu desplegament operatiu.

Per a aquesta posada en marxa, Northstar ha contractat K-SIX Solutions amb un doble objectiu:

1. Implementar la seva plataforma web de treball col·laboratiu i intralogística sota estrictes estàndards de seguretat.
2. Auditar la seva exposició a atacs d'enginyeria social i vectors d'ofimàtica maliciosa.

## ⚠️ Incident de seguretat detectat

Durant la fase prèvia d'obertura, el departament d'administració de Northstar va rebre un correu electrònic suposadament emès per un dels seus proveïdors habituals.

El missatge adjuntava un document de factura en format de full de càlcul o processador de textos i incloïa un enllaç per confirmar les credencials del portal corporatiu.

L'equip de ciberseguretat de K-SIX va detectar que es tractava d'un atac combinat:

### 🎣 Enginyeria social (Phishing)

Un formulari clonat que intenta capturar credencials d'accés dels empleats de Northstar.

### 📄 Document d'ofimàtica maliciós

Un arxiu amb codi incrustat que, en obrir-se a la màquina client, executa un HTTP Callback per connectar de manera encoberta amb un servidor extern i registrar informació del sistema de la víctima.

---

# 🎯 2. L'ENCÀRREC

Com a enginyers/es i consultors/es junior del SOC de K-SIX Solutions, la direcció us assigna la resposta tècnica a aquesta amenaça.

Per fer-ho, heu de treballar en un **entorn virtualitzat aïllat** i executar quatre fases interconnectades.

## 2.1. Enfortir la plataforma corporativa (Nextcloud)

Securitzar la instància de Nextcloud instal·lada al servidor Linux del SOC mitjançant HTTPS, certificats SSL i capçals de seguretat.

S'hi configurarà la carpeta protegida `/Quarantine_Evidences` per custodiar evidències i mostres sense risc de fuga.

## 2.2. Desplegar un simulador de Phishing

Convertir la infraestructura LAMP (Apache, MySQL, PHP) en un entorn de simulació que reprodueixi la pàgina d'accés de Northstar.

El servidor ha de capturar automàticament la telemetria de l'atacant:

- IP d'origen.
- Data i hora.
- User-Agent.
- Dades enviades.

## 2.3. Simular la infecció per ofimàtica

Generar un document de prova que executi un callback HTTP contra el servidor LAMP des de la màquina víctima aïllada (Windows 10).

La petició s'ha de registrar a la base de dades MySQL i als fitxers de registre (`access.log`).

## 2.4. Auditoria i redacció d'incidents

Redactar en equip l'Informe Oficial d'Incidents del SOC directament dins de la plataforma Nextcloud.

---

# 🐛 3. FITA 1 — HARDENING DE NEXTCLOUD I MAGATZEM D'EVIDÈNCIES

## 3.1. Securització del canal i capçals web (HTTPS)

Activar el mòdul SSL d'Apache (`a2enmod ssl`) i forçar la redirecció de HTTP (port 80) a HTTPS (port 443) mitjançant un certificat.

Configurar capçals de seguretat HTTP defensius:

- `X-Frame-Options "SAMEORIGIN"`
- `X-Content-Type-Options "nosniff"`
- `Content-Security-Policy`

## 3.2. Control d'accés basat en rols (RBAC)

Crear la gestió d'usuaris del SOC dividida en els grups següents:

| Grup | Funció |
|---|---|
| `SOC_Analysts` | Analistes del SOC |
| `SOC_Investigators` | Investigadors del SOC |
| `SOC_Admins` | Administradors del SOC |

Aplicar el principi de mínim privilegi i establir contrasenyes complexes.

## 3.3. Magatzem aïllat d'evidències

Crear el directori protegit:

```text
/Quarantine_Evidences
```

Aquest directori servirà per custodiar:

- Mostres.
- Captures de xarxa.
- Registres.

L'accés s'ha de restringir mitjançant permisos i ACLs exclusivament al personal autoritzat.

---

# 🐝 4. FITA 2 — EVOLUCIÓ DEL SERVIDOR LAMP A SIMULADOR DE PHISHING I HONEYPOT

## 4.1. Desenvolupament del simulador web (Phishing/Honeypot)

Dissenyar un formulari web funcional en HTML/PHP que simuli la interfície d'inici de sessió de l'entorn d'ofimàtica corporatiu de Northstar Office Supplies.

## 4.2. Disseny i configuració de la base de dades MySQL

Crear la base de dades i la taula de telemetria amb camps específics:

| Camp | Informació emmagatzemada |
|---|---|
| **IP d'origen** | Adreça IP de la connexió |
| **Data i hora** | Moment de la connexió |
| **User-Agent** | Sistema operatiu i navegador detectats |
| **Dades enviades** | Informació rebuda del formulari |

Crear un usuari específic a MySQL aplicant privilegis acotats per a la connexió des de l'script PHP.

## 4.3. Programació de la lògica de servidor (PHP)

Extreure les capçaleres de les peticions HTTP (GET/POST) i gestionar la inserció segura de dades a MySQL.

---

# 🗂️ 5. FITA 3 — SIMULACIÓ DE VECTOR D'ATAC D'OFIMÀTICA

## 5.1. Disseny del vector d'atac ofimàtic

Crear un document d'ofimàtica de prova (Word o Excel) que inclogui un script o macro benigna de prova.

Configurar l'script perquè, en obrir el document, realitzi una petició automàtica en segon pla (HTTP Callback) cap a l'aplicació PHP del servidor LAMP.

## 5.2. Execució en entorn de proves aïllat

Obrir el document des de la màquina víctima Windows 10 dins de la xarxa privada (Host-Only), sense connexió a Internet.

La configuració de proves descrita a l'enunciat preveu l'ús d'una màquina sense antivirus ni tallafocs actius.

## 5.3. Verificació de la telemetria i registres

Comprovar que la petició callback ha quedat enregistrada correctament a la taula de la base de dades MySQL.

Confirmar que l'accés i les capçaleres de la petició han quedat gravats al fitxer de registres d'Apache (`access.log`).

---

# 📦 6. EL LLIURAMENT

El projecte requereix quatre blocs principals de lliurament.

## 6.1. Memòria tècnica de desplegament i Hardening

**Configuració de seguretat web**

Documentació del procés d'activació d'HTTPS i la implementació de les capçaleres de seguretat HTTP.

**Matriu d'usuaris i permisos**

Taula detallada dels usuaris i grups creats a Nextcloud i la configuració dels permisos d'accés a la carpeta d'evidències.

## 6.2. Codi font i script de base de dades

**Script PHP del simulador**

Codi font del formulari web que simula el portal d'ofimàtica corporatiu.

**Script SQL**

Fitxer de creació de la base de dades i de la taula de telemetria per emmagatzemar les IPs, dates, capçaleres User-Agent i credencials d'accés.

## 6.3. Evidències tècniques i d'auditoria de xarxa

**Captures de registre**

Proves visuals dels registres guardats a la taula de MySQL i de les entrades gravades al fitxer `access.log` del servidor Apache.

## 6.4. Informe oficial d'incidents del SOC

**Contingut de l'informe**

- Resum executiu de l'incident.
- Anàlisi del vector d'atac d'ofimàtica.
- Evidències de tràfic.
- Recomanacions de seguretat (Hardening).

---

# 🏁 7. OBJECTIU FINAL DEL PROJECTE

El repte consisteix a desplegar i documentar un entorn de ciberseguretat que permeti treballar sobre quatre àmbits principals:

1. **Protecció de la infraestructura:** securització de Nextcloud mitjançant HTTPS, capçals web i control d'accés.
2. **Simulació de phishing:** desplegament d'un formulari web i una base de dades per registrar telemetria.
3. **Simulació d'ofimàtica:** verificació d'un HTTP Callback dins d'un entorn de proves aïllat.
4. **Auditoria i documentació:** recopilació d'evidències i elaboració de l'informe oficial d'incidents del SOC.

El lliurament final ha de reunir la memòria tècnica, el codi font, els scripts de base de dades, les evidències tècniques i l'informe d'incidents.

---

<p align="center">
  <a href="Memoria.md">
    <img src="https://img.shields.io/badge/📄_CONSULTAR-MEMORIA-0B1020?style=for-the-badge&labelColor=075985" alt="Consultar Memoria"/>
  </a>
</p>

<p align="center">
  <sub>NORTHSTAR SOC · INFRASTRUCTURE · HARDENING · PHISHING SIMULATION · INCIDENT RESPONSE</sub>
</p>

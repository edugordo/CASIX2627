
<!-- ==================== CABECERA ==================== -->

<p align="center">
  <img src="https://capsule-render.vercel.app/api?type=waving&color=0:0B1020,50:075985,100:00D4AA&height=220&section=header&text=OPERACI%C3%93%20DATA%20SHIELD&fontSize=34&fontColor=FFFFFF&fontAlignY=38&animation=fadeIn" width="100%" alt="Operació Data Shield"/>
</p>

<p align="center">
  <img src="https://readme-typing-svg.demolab.com?font=Fira+Code&weight=600&size=18&duration=2800&pause=900&color=00D4AA&center=true&vCenter=true&width=700&lines=DATABASE+SECURITY.;XML+%7C+JSON+DATA+EXCHANGE.;SECURE.+ANALYZE.+PROTECT." alt="Project slogan"/>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PROJECT-DATA%20SHIELD-0B1020?style=for-the-badge&labelColor=075985" alt="Data Shield"/>
  <img src="https://img.shields.io/badge/DATABASE-MYSQL-0B1020?style=for-the-badge&labelColor=008F76" alt="MySQL"/>
  <img src="https://img.shields.io/badge/DATA%20EXCHANGE-XML%20%7C%20JSON-0B1020?style=for-the-badge&labelColor=6D28D9" alt="XML and JSON"/>
</p>

<p align="center">
  <strong>NAHUEL G · EDU G · MARC J · ALEXIS T</strong>
</p>

---

## 📑 Índex

- [🎯 Introducció](#-introducció)
- [📌 Objectius del projecte](#-objectius-del-projecte)
- [🗄️ 1. Creació de la base de dades](#️-1-creació-de-la-base-de-dades)
  - [Model relacional](#model-relacional)
  - [Implementació amb MySQL](#implementació-amb-mysql)
  - [Control d'accés i privilegis](#control-daccés-i-privilegis)
  - [Verificació dels permisos](#verificació-dels-permisos)
- [🔄 2. Intercanvi d'informació amb XML i JSON](#-2-intercanvi-dinformació-amb-xml-i-json)
- [⚙️ 3. Instal·lació de SGBD](#️-3-installació-de-sgbd)
- [📦 Lliurament](#-lliurament)
- [👥 Equip de treball](#-equip-de-treball)

---

## 🎯 Introducció

El laboratori de ciberseguretat de **K-Six Solutions** necessita una base de dades per gestionar el cicle de vida de les mostres sospitoses de malware, conservar informació sobre el seu origen i context, i documentar els resultats de les proves realitzades.

Per desenvolupar aquesta infraestructura, crearem una base de dades relacional amb MySQL, configurarem diferents perfils d'usuari i establirem els privilegis necessaris per protegir la informació.

A més, elaborarem fitxes d'investigació en XML i JSON per facilitar l'intercanvi de dades amb altres sistemes i instal·larem dos sistemes gestors de bases de dades (SGBD) addicionals per ampliar els entorns de prova del laboratori.

## 📌 Objectius del projecte

- Gestionar les mostres de malware, els seus hashes i les atribucions de família.
- Organitzar les investigacions, les execucions i els entorns de sandbox.
- Documentar les evidències, els processos, les connexions, els IOC i les tècniques identificades.
- Conservar els informes i l'historial de conclusions.
- Configurar usuaris, rols i privilegis segons les responsabilitats de cada perfil.
- Preparar documents XML i JSON amb informació equivalent.
- Instal·lar, configurar i verificar dos SGBD addicionals a MySQL.

---

## 🗄️ 1. Creació de la base de dades

### 📐 Model relacional

El primer pas consisteix a transformar el diagrama entitat-relació proporcionat en un model relacional coherent.

Cal identificar les entitats, els atributs, les claus primàries, les claus foranes i les relacions existents abans d'implementar la base de dades.

El disseny ha de permetre conservar l'historial de les mostres i les investigacions. Una mateixa mostra pot tenir diversos hashes, múltiples execucions i diferents atribucions de família al llarg del temps.

**Tasques:**

- [ ] Analitzar el diagrama entitat-relació i el material de suport.
- [ ] Identificar les entitats, els atributs i les claus primàries.
- [ ] Definir les claus foranes i les relacions entre taules.
- [ ] Elaborar el model relacional.
- [ ] Validar el model abans de començar la implementació.

**Documentació del model relacional:**  
Afegir aquí l'enllaç al document o full de càlcul.

### 🗃️ Implementació amb MySQL

Una vegada validat el model relacional, implementarem la base de dades mitjançant SQL.

La implementació haurà de garantir la integritat de les dades i permetre consultar les mostres, les investigacions, les execucions i les evidències registrades.

**Tasques:**

- [ ] Crear la base de dades.
- [ ] Crear les taules amb els atributs i tipus de dades adequats.
- [ ] Definir les claus primàries, les claus foranes i les restriccions d'integritat.
- [ ] Preparar les instruccions SQL per inserir les dades de mostra.
- [ ] Executar l'script complet i verificar-ne el funcionament.
- [ ] Comprovar les relacions i les consultes principals.

**Fitxers del projecte:**

| Fitxer | Contingut |
|---|---|
| `model_relacional` | Model relacional validat. |
| `creacio_base_dades.sql` | Creació de la base de dades i les taules. |
| `insercio_dades.sql` | Inserció de dades de mostra. |

### 🔐 Control d'accés i privilegis

La informació de les investigacions pot ser sensible. Per aquest motiu, cada usuari i rol tindrà únicament els permisos necessaris per desenvolupar les seves funcions.

#### Usuaris individuals

| Usuari | Permisos i restriccions |
|---|---|
| `superadministrador` | Consultar, inserir, modificar i eliminar dades de totes les taules. Contrasenya amb caducitat mensual i sense reutilitzar les dues darreres. |
| `adminMostres` | Consultar i modificar mostres, hashes i atribucions de famílies. No podrà inserir mostres noves ni eliminar dades. Canvi de contrasenya obligatori en el primer accés. |
| `adminAnalisis` | Consultar, inserir i modificar anàlisis, execucions, resultats, observacions, IOC i tècniques associades. No podrà eliminar dades i tindrà un límit de dues modificacions per hora. |
| `tecnicExtern` | Només podrà consultar les dades. El compte es bloquejarà durant un dia després de tres intents consecutius d'autenticació fallits. |
| `consultaAuditoria` | Només podrà consultar les dades, amb un màxim de 30 consultes per hora i dues connexions simultànies. |
| `consultorExtern` | Només podrà consultar l'identificador de l'execució, la data i hora d'inici i el resultat obtingut de la taula `EXECUCIO`. No podrà consultar la resta de columnes ni modificar dades. |
| `capAnalistes` | Podrà consultar les dades i concedir permisos de consulta a altres usuaris. Caldrà verificar quins privilegis pot delegar. |

#### Rols

| Rol | Permisos |
|---|---|
| `analista` | Consultar totes les taules, sense modificar-ne el contingut. |
| `gestorExecucions` | Consultar i inserir execucions i observacions associades, sense modificar ni eliminar dades existents. |
| `responsableSeguretat` | Consultar tota la base de dades i modificar les dades relacionades amb les atribucions de famílies de malware. |
| `inseridorExecucions` | Inserir registres a la taula `EXECUCIO`. |

**Usuaris que cal associar als rols:**

- `analistaAna`, `analistaPol` i `analistaLaia`: rol `analista`.
- Crear un usuari per al rol `gestorExecucions`.
- Crear un usuari per al rol `responsableSeguretat`.
- Crear l'usuari `analistaTemporal` i assignar-li els rols `analista` i `inseridorExecucions`, amb aquest últim activat per defecte.

#### 🔄 Revocació de privilegis

Amb l'usuari `analistaTemporal`, caldrà comprovar el funcionament dels privilegis i la revocació d'accessos.

1. Verificar que pot consultar les dades i inserir registres a `EXECUCIO`.
2. Revocar el rol `inseridorExecucions`.
3. Consultar els privilegis dels rols i els rols assignats a l'usuari.
4. Verificar que conserva el rol `analista` i els permisos de consulta, però ja no pot inserir execucions mitjançant el rol revocat.

#### ✅ Verificació dels permisos

- [ ] Crear els usuaris i els rols necessaris.
- [ ] Assignar els privilegis corresponents.
- [ ] Verificar les operacions permeses per a cada perfil.
- [ ] Comprovar que les operacions prohibides són rebutjades.
- [ ] Verificar les restriccions de contrasenya, connexions i freqüència de consultes.
- [ ] Comprovar la delegació de privilegis de `capAnalistes`.
- [ ] Verificar la revocació del rol `inseridorExecucions`.
- [ ] Documentar les proves, els resultats i les incidències.

**Evidències:**  
Afegir aquí les captures de les proves i l'enllaç a l'script SQL de control d'accés.

---

## 🔄 2. Intercanvi d'informació amb XML i JSON

K-Six Solutions col·labora amb altres empreses i equips d'anàlisi que necessiten consultar informació sobre les mostres investigades. Per facilitar l'intercanvi de dades, elaborarem dues fitxes d'investigació equivalents: una en XML i una altra en JSON.

Els documents han d'incloure informació de **3 o 4 mostres** i representar les mateixes dades.

### 📄 Informació de les mostres

Cada mostra haurà d'incloure:

- Identificador únic de la mostra.
- Nom i tipus de fitxer.
- Mida en bytes.
- Data de recepció al laboratori.
- Informació addicional sobre l'origen o el context, quan estigui disponible.
- Llista de hashes disponibles, amb l'algorisme corresponent com a atribut.

### 🧬 Atribucions de família

Per cada atribució de família de malware, caldrà documentar:

- Família proposada.
- Data de l'atribució.
- Identificador de l'analista com a atribut, nom i cognom.
- Nivell de confiança.
- Estat de l'atribució com a atribut: `provisional`, `confirmada`, `rebutjada` o `retirada`.

Una mateixa mostra pot tenir diverses atribucions, ja que les conclusions poden evolucionar a mesura que s'obtenen noves evidències.

### 🧪 Execucions i observacions

Cada execució haurà d'incloure:

- Identificador de l'execució.
- Data i hora d'inici.
- Sandbox utilitzat.
- Sistema operatiu.
- Resultat obtingut.

Les observacions detectades durant una execució hauran de contenir:

- IOC (*Indicator of Compromise*).
- Tipus d'IOC, com ara una adreça IP, un domini o una URL, representat com a atribut.
- Tècnica associada.
- Grau de confiança de la detecció.

> **Important:** si una execució no genera observacions, l'element `observacions` haurà d'existir igualment i contenir una llista buida.

### Tasques d'intercanvi

- [ ] Crear el document XML amb informació de 3 o 4 mostres.
- [ ] Representar correctament els hashes, les atribucions, les execucions i les observacions.
- [ ] Crear el document JSON amb informació estrictament equivalent.
- [ ] Utilitzar els tipus de dades adequats per a cada camp.
- [ ] Incloure llistes amb més d'un element quan correspongui.
- [ ] Representar correctament les llistes buides d'observacions.
- [ ] Validar que tots dos documents estan ben formats.
- [ ] Comprovar que la informació de l'XML i del JSON és equivalent.

**Fitxers del projecte:**

| Fitxer | Contingut |
|---|---|
| `fitxa_mostres.xml` | Fitxes d'investigació en XML. |
| `fitxa_mostres.json` | Fitxes d'investigació equivalents en JSON. |

**Evidències:**  
Afegir aquí les captures dels documents i les comprovacions de validació.

---

## ⚙️ 3. Instal·lació de SGBD

El laboratori ja disposa de MySQL com a gestor principal. Per ampliar els coneixements sobre altres tecnologies, cal investigar, instal·lar i documentar **dos SGBD addicionals**.

### 🔎 3.1. Recerca i planificació

Per a cadascun dels dos gestors, cal documentar:

- Nom del SGBD, desenvolupador i versió.
- Tipus de llicència i cost, si escau.
- Model de dades i característiques principals.
- Usos habituals i tipus de projectes adequats.
- Sistemes operatius compatibles.
- Requisits mínims i recomanats de maquinari i programari, quan estiguin documentats.

També cal identificar les característiques de l'equip on es farà la instal·lació i comparar-les amb els requisits del gestor, justificant si disposa dels recursos necessaris.

> Es proposa instal·lar un dels dos SGBD en un sistema operatiu diferent de Windows, sempre que sigui viable.

### 💻 3.2. Instal·lació

La instal·lació es podrà fer en un ordinador físic amb Windows, Linux o macOS, o bé en una màquina virtual.

Durant el procés caldrà documentar:

- Les opcions de configuració més importants.
- El nom del servei o procés del gestor.
- El procediment per comprovar-ne l'estat.
- Les incidències detectades i les solucions aplicades.

No és necessari documentar cada clic de l'instal·lador. Cal explicar els passos rellevants perquè una altra persona pugui entendre i reproduir el procediment.

### ✅ 3.3. Verificació del funcionament

Per a cada SGBD instal·lat, caldrà:

- [ ] Verificar la versió instal·lada.
- [ ] Comprovar que el servei o procés està actiu, si escau.
- [ ] Establir una connexió mitjançant una eina client.
- [ ] Crear una base de dades de prova.
- [ ] Crear una taula senzilla o l'equivalent en sistemes NoSQL.
- [ ] Documentar les ordres utilitzades.
- [ ] Aportar evidències dels resultats.

### 📝 3.4. Fitxa tècnica d'instal·lació

Cal elaborar una fitxa tècnica per a cadascun dels dos gestors.

| Apartat | Informació que cal documentar |
|---|---|
| Identificació | SGBD, versió, data d'instal·lació i responsables. |
| Màquina | Nom de l'equip, sistema operatiu, versió, entorn físic o virtual i maquinari. |
| Xarxa | Adreça IP, nom DNS si escau i ports utilitzats. |
| Instal·lació | Procedència del programari, directoris d'instal·lació i fitxers de configuració. |
| Emmagatzematge | Ubicació dels fitxers de dades i de les bases de dades, si es pot identificar. |
| Administració | Eina client, procediment de connexió i forma d'accedir al compte administrador. |
| Servei | Nom del servei o procés i procediment per comprovar-ne l'estat. |
| Registres | Ubicació dels logs i utilitat que tenen. |
| Incidències | Problemes detectats, diagnòstic i solucions aplicades. |

> **Seguretat:** no s'han d'incloure contrasenyes ni credencials reals a la documentació. Si alguna dada no és aplicable o no es pot determinar, cal indicar-ho i justificar-ne el motiu.

**Evidències:**  
Afegir aquí les captures de les instal·lacions, les comprovacions de funcionament i les fitxes tècniques.

---

## 📦 Lliurament

El lliurament final ha d'incloure la documentació i els materials generats en cadascuna de les tres parts del repte.

### 🗄️ Creació de la base de dades

- [ ] Model relacional en full de càlcul o PDF.
- [ ] Script SQL executable amb la creació de la base de dades, les taules i les insercions corresponents.
- [ ] Script SQL amb les instruccions de control d'accés.
- [ ] Documentació de les proves de control d'accés.

### 🔄 Intercanvi d'informació

- [ ] Fitxer XML.
- [ ] Fitxer JSON equivalent.

### ⚙️ Instal·lació dels SGBD

- [ ] Documentació de la recerca i comprovació dels requisits previs dels dos SGBD.
- [ ] Dues fitxes tècniques d'instal·lació, una per cada gestor.
- [ ] Evidències de les instal·lacions i de les proves de funcionament.

---

## 👥 Equip de treball

<p align="center">
  <strong>NAHUEL G · EDU G · MARC J · ALEXIS T</strong>
</p>

<!-- ==================== PEU DE PÀGINA ==================== -->

---

<p align="center">
  <img src="https://capsule-render.vercel.app/api?type=waving&color=0:00D4AA,50:075985,100:0B1020&height=120&section=footer" width="100%" alt="K-SIX Solutions footer"/>
</p>

<p align="center">
  <strong>K-SIX SOLUTIONS</strong>
</p>

<p align="center">
  <sub>CYBERSECURITY · DATABASE SECURITY · DATA EXCHANGE</sub>
</p>

<p align="center">
  <sub>0372-0373-0377 · OPERACIÓ DATA SHIELD</sub>
</p>

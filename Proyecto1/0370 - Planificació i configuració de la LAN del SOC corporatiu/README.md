
<!-- ==================== CABECERA ==================== -->

<p align="center">
  <img src="https://capsule-render.vercel.app/api?type=waving&color=0:0B1020,50:075985,100:00D4AA&height=220&section=header&text=OPERACI%C3%93%20DATA%20SHIELD&fontSize=34&fontColor=FFFFFF&fontAlignY=38&animation=fadeIn" width="100%" alt="Operació Data Shield"/>
</p>

<p align="center">
  <img src="https://readme-typing-svg.demolab.com?font=Fira+Code&weight=600&size=18&duration=2800&pause=900&color=00D4AA&center=true&vCenter=true&width=700&lines=NETWORK+INFRASTRUCTURE.;LAN+DESIGN+%7C+IPV4+ADDRESSING.;OSI+%7C+TCP%2FIP+%7C+TROUBLESHOOTING.;SECURE.+CONNECT.+PROTECT." alt="Project slogan"/>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PROJECT-DATA%20SHIELD-0B1020?style=for-the-badge&labelColor=075985" alt="Data Shield"/>
  <img src="https://img.shields.io/badge/NETWORK-LAN%20DESIGN-0B1020?style=for-the-badge&labelColor=008F76" alt="LAN Design"/>
  <img src="https://img.shields.io/badge/ADDRESSING-IPV4-0B1020?style=for-the-badge&labelColor=6D28D9" alt="IPv4"/>
  <img src="https://img.shields.io/badge/TOOLS-GNS3%20%7C%20PACKET%20TRACER-0B1020?style=for-the-badge&labelColor=075985" alt="GNS3 and Packet Tracer"/>
</p>

<p align="center">
  <strong>NAHUEL G · EDU G · MARC J · ALEXIS T</strong>
</p>

<p align="center">
  <a href="./Memoria.md">
    <img src="https://img.shields.io/badge/📄_Consultar-Memoria_Técnica-075985?style=for-the-badge&logo=readthedocs&logoColor=white" alt="Consultar Memoria Técnica">
  </a>
</p>

---

# 📑 ÍNDEX

- [1. El context](#-1-el-context)
- [2. L'encàrrec](#-2-lencàrrec)
- [3. Fase 1 — Disseny de la infraestructura i topologia](#-3-fase-1--disseny-de-la-infraestructura-i-topologia)
- [4. Fase 2 — Adreçament lògic de la LAN](#-4-fase-2--adreçament-lògic-de-la-lan)
- [5. Fase 3 — L'encapsulat de la informació en acció](#-5-fase-3--lencapsulat-de-la-informació-en-acció)
- [6. Fase 4 — Resolució d'incidències](#-6-fase-4--resolució-dincidències)
- [7. Fase 5 — Construcció de cable Ethernet](#-7-fase-5--construcció-de-cable-ethernet)
- [8. El lliurament](#-8-el-lliurament)
- [9. Recursos](#-9-recursos)

---

# 🌐 1. EL CONTEXT

L'empresa multinacional **K-SIX Solutions** està muntant el seu nou SOC local (*Security Operations Center*) per analitzar programes potencialment maliciosos i amenaces de xarxa.

La companyia ha llogat una planta exclusiva per a aquest equip d'enginyers i ens ha encarregat dissenyar i configurar la seva xarxa local.

Com a tècnics d'infraestructura, hem de:

- Dissenyar el mapa físic i lògic de la sala tècnica.
- Assignar un adreçament IPv4 sense sortir del rang de xarxa assignat.
- Garantir la connectivitat entre els equips.
- Diagnosticar i resoldre les incidències que apareguin després de connectar els dispositius.
- Construir els cables Ethernet necessaris per connectar els equips de la Sandbox.

L'objectiu és disposar d'una infraestructura de xarxa organitzada, funcional i preparada per al treball del SOC.

---

# 🎯 2. L'ENCÀRREC

L'empresa ens ha facilitat un plànol de la planta on es vol instal·lar el SOC.

<p align="center">
  <a href="https://drive.google.com/file/d/1dHEl90D-iooUSAlq0izbVFYayOBj9RMn/view?usp=sharing">
    <img src="https://img.shields.io/badge/OBRIR-PL%C3%80NOL%20DEL%20SOC-00D4AA?style=for-the-badge&labelColor=0B1020" alt="Obrir el plànol del SOC"/>
  </a>
</p>

El projecte es divideix en **cinc fases**, que permeten treballar des del disseny inicial de la infraestructura fins a la resolució d'incidències i la construcció física del cablejat.

## Requisits de maquinari

| Àrea | Equips | Funció |
|---|---|---|
| Sandbox | 1 servidor principal d'alta densitat | Executar el programari Sandbox |
| Analistes de sobretaula | 30 ordinadors | Treball dels enginyers de guàrdia |
| Recerca amb mobilitat | Fins a 20 ordinadors portàtils | Treball sense fils a la sala de crisis |
| Suport | 1 servidor d'emulació de xarxa | Executar les funcions d'emulació |
| Connexió exterior | 1 router de capçalera | Connectar la planta amb el node central d'Internet de l'empresa |

---

# 🖧 3. FASE 1 — DISSENY DE LA INFRAESTRUCTURA I TOPOLOGIA

Cal dissenyar l'esquema físic i lògic de tota la xarxa mitjançant una eina de representació de xarxes, com ara **Cisco Packet Tracer** o **GNS3**.

El disseny ha de tenir en compte el volum d'equips de la planta i intentar utilitzar el menor nombre possible de switches sense comprometre la connectivitat.

## 3.1. Topologia de xarxa

Cal decidir i justificar:

- Quina topologia física i lògica s'utilitzarà per interconnectar més de 50 terminals.
- Com es connectaran els switches, els servidors, el router i els punts d'accés.
- Com s'organitzaran les connexions per facilitar el manteniment.
- Com es reduirà el nombre de switches necessaris.

## 3.2. Mitjans de transmissió

Cal especificar els mitjans de transmissió que s'utilitzaran per connectar els dispositius.

S'haurà de justificar:

- El tipus de cablejat i la categoria.
- Els connectors utilitzats.
- La connexió dels ordinadors de sobretaula.
- L'enllaç cap al servidor principal de la Sandbox.
- L'ample de banda estimat i les necessitats de transmissió de cada connexió.

## 3.3. Connectivitat sense fils

Per a la sala de crisis, on treballaran fins a 20 investigadors amb ordinadors portàtils, cal definir:

- El nombre de punts d'accés necessaris.
- La ubicació dels punts d'accés per cobrir la zona de treball.
- La connexió dels punts d'accés amb la infraestructura cablejada.
- El procés d'associació dels adaptadors sense fils.
- El sistema bàsic d'autenticació per permetre l'accés a la xarxa.

### Resultat esperat

Un esquema físic i lògic complet de la planta del SOC, elaborat amb Packet Tracer o GNS3, acompanyat de la justificació tècnica de les decisions preses.

---

# 🔢 4. FASE 2 — ADREÇAMENT LÒGIC DE LA LAN

El departament de TI central ha assignat exclusivament a la planta del SOC el rang IPv4 següent:

<p align="center">
  <img src="https://img.shields.io/badge/NETWORK-172.20.0.0%2F24-0B1020?style=for-the-badge&labelColor=075985" alt="Xarxa IPv4 assignada"/>
</p>

Tots els equips conviuran en el mateix domini de difusió (*broadcast*). Per tant, cal planificar correctament les adreces IP per evitar conflictes.

## 4.1. Pla d'adreçament

Per a cada dispositiu o conjunt de dispositius, cal definir:

- Rang d'adreces IP reservat o adreça exacta.
- Màscara de xarxa.
- Porta d'enllaç (*gateway*).
- Tipus d'adreçament: estàtic o DHCP.

## 4.2. Configuració del servidor DHCP

També cal especificar el rang exacte d'adreces configurat al *pool* DHCP de la LAN.

Aquesta configuració ha d'evitar conflictes amb les adreces reservades als ordinadors de sobretaula i a la resta d'equips amb adreçament estàtic.

### Resultat esperat

Una taula d'adreçament IPv4 completa i justificada, amb les adreces assignades, la màscara, el *gateway*, el tipus d'adreçament i el rang del *pool* DHCP.

---

# 📦 5. FASE 3 — L'ENCAPSULAT DE LA INFORMACIÓ EN ACCIÓ

La xarxa del laboratori ja està configurada. Durant una prova, una instància del servidor Sandbox ha d'enviar un paquet de dades al servidor d'emulació de la mateixa LAN.

Cal explicar el recorregut de la informació des del moment en què es genera fins que es transmet pel medi físic, utilitzant com a referència els models **OSI i TCP/IP**.

## 5.1. Procés d'encapsulació

Cal descriure:

- L'ordre en què la informació baixa per les capes del model.
- El moment en què la informació rep el nom de PDU corresponent a cada capa.
- La diferència entre les dades, el segment o datagrama, el paquet i la trama.

## 5.2. Informació afegida a cada capa

Cal identificar quina informació s'afegeix durant el procés d'encapsulació:

- **Capa de xarxa:** adreces IP d'origen i destinació.
- **Capa d'enllaç:** adreces MAC d'origen i destinació, a més de la informació necessària per transportar la trama per la xarxa local.

## 5.3. Funcionament del switch

Cal explicar què fa el switch quan rep la trama:

- Com aprèn les adreces MAC a partir de les trames rebudes.
- Com consulta la seva taula d'adreces MAC.
- Com determina el port de sortida corresponent al servidor d'emulació.
- Com reenvia la trama pel port adequat quan coneix la MAC de destinació.
- Com es redueix el trànsit innecessari en comparació amb l'enviament indiscriminat a tots els ports.

També cal diferenciar el reenviament de trames, el domini de col·lisió i el domini de difusió.

### Resultat esperat

Una explicació tècnica del procés d'encapsulació i transmissió de dades, relacionant les capes OSI i TCP/IP amb el funcionament real dels dispositius de xarxa.

---

# 🛠️ 6. FASE 4 — RESOLUCIÓ D'INCIDÈNCIES

Una vegada muntada i posada en funcionament la xarxa, les aplicacions de monitoratge basades en SNMP comencen a detectar alertes relacionades amb els adaptadors i la connectivitat.

Com a tècnics de suport, cal diagnosticar cada incidència seguint aquesta metodologia:

| Etapa | Què cal fer? |
|---|---|
| 1. Diagnòstic | Identificar què podria estar passant i quina és la causa probable. |
| 2. Comprovació | Determinar quines proves, ordres o eines permeten confirmar el problema. |
| 3. Solució | Proposar les accions necessàries per recuperar el funcionament correcte. |

Les incidències concretes d'aquesta fase es resoldran **presencialment a la taula d'orientació**, un cop finalitzades les fases anteriors.

---

# 🔌 7. FASE 5 — CONSTRUCCIÓ DE CABLE ETHERNET

Com a part del muntatge físic de la infraestructura, cal construir un cable Ethernet per connectar dos ordinadors.

Durant aquesta fase es treballarà amb el cablejat i els connectors necessaris per obtenir una connexió funcional.

Caldrà tenir en compte:

- El tipus de cable i els connectors utilitzats.
- La norma de connexió aplicada als extrems.
- La correcta terminació dels conductors.
- La comprovació final del cable i de la connectivitat.

Aquesta fase es durà a terme **al taller**.

---

# 📤 8. EL LLIURAMENT

Al Classroom s'obrirà un apartat específic per lliurar els materials de l'activitat.

## Materials que s'han de lliurar

- [ ] **Memòria tècnica del disseny:** documentació de la infraestructura, la topologia, l'adreçament i les justificacions tècniques.
- [ ] **Fitxer del disseny físic i lògic:** projecte de xarxa implementat amb GNS3 o Cisco Packet Tracer.
- [ ] **Fase 4 — Resolució d'incidències:** es realitzarà presencialment a la taula d'orientació.
- [ ] **Fase 5 — Construcció del cable Ethernet:** es realitzarà al taller.

---

# 📚 9. RECURSOS

| Recurs | Utilitat |
|---|---|
| [Plànol del SOC](https://drive.google.com/file/d/1dHEl90D-iooUSAlq0izbVFYayOBj9RMn/view?usp=sharing) | Consultar la distribució prevista de la planta. |
| [Cisco Packet Tracer](https://www.netacad.com/cisco-packet-tracer) | Dissenyar i simular la infraestructura de xarxa. |
| [GNS3](https://www.gns3.com/) | Crear i provar topologies de xarxa. |

---

<!-- ==================== PEU DE PÀGINA ==================== -->

<p align="center">
  <strong>K-SIX SOLUTIONS</strong>
</p>

<p align="center">
  <em>NETWORK INFRASTRUCTURE · CYBERSECURITY · CONNECTIVITY</em>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/OPERACI%C3%93%20DATA%20SHIELD-0B1020?style=for-the-badge&labelColor=075985" alt="Operació Data Shield"/>
  <img src="https://img.shields.io/badge/LAN-DESIGN%20%26%20TROUBLESHOOTING-0B1020?style=for-the-badge&labelColor=008F76" alt="LAN Design and Troubleshooting"/>
</p>

<p align="center">
  <strong>NAHUEL G · EDU G · MARC J · ALEXIS T</strong>
</p>

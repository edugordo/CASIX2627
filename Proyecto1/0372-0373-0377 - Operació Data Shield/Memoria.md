<!-- ==================== CABECERA ==================== -->

<p align="center">
  <img src="https://capsule-render.vercel.app/api?type=waving&color=0:0B1020,50:075985,100:00D4AA&height=220&section=header&text=OPERACI%C3%93%20DATA%20SHIELD&fontSize=34&fontColor=FFFFFF&fontAlignY=38&animation=fadeIn" width="100%" alt="Operació Data Shield"/>
</p>

<p align="center">
  <img src="https://readme-typing-svg.demolab.com?font=Fira+Code&weight=600&size=18&duration=2800&pause=900&color=00D4AA&center=true&vCenter=true&width=700&lines=MEM%C3%92RIA+T%C3%88CNICA.;DATABASE+SECURITY.;XML+%7C+JSON+DATA+EXCHANGE.;SECURE.+ANALYZE.+PROTECT." alt="Memòria tècnica del projecte"/>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/DOCUMENT-MEM%C3%92RIA%20T%C3%88CNICA-0B1020?style=for-the-badge&labelColor=075985" alt="Memòria tècnica"/>
  <img src="https://img.shields.io/badge/DATABASE-MYSQL-0B1020?style=for-the-badge&labelColor=008F76" alt="MySQL"/>
  <img src="https://img.shields.io/badge/DATA%20EXCHANGE-XML%20%7C%20JSON-0B1020?style=for-the-badge&labelColor=6D28D9" alt="XML and JSON"/>
</p>

<p align="center">
  <strong>NAHUEL G · EDU G · MARC J · ALEXIS T</strong>
</p>

<p align="center">
  <a href="README.md">
    <img src="https://img.shields.io/badge/←%20TORNAR%20AL%20README-00D4AA?style=for-the-badge&labelColor=0B1020" alt="Tornar al README principal"/>
  </a>
</p>

---

## 📑 Índex

- [1. Introducció i context de negoci](#1-introducció-i-context-de-negoci)
- [2. Objectius](#2-objectius)
- [3. Esquema i estructura de la fitxa](#3-esquema-i-estructura-de-la-fitxa)
- [4. Correspondència amb el model relacional](#4-correspondència-amb-el-model-relacional)
- [5. Justificació dels tipus de dades i formats](#5-justificació-dels-tipus-de-dades-i-formats)
- [6. Casos de prova i integritat estructural](#6-casos-de-prova-i-integritat-estructural)
- [7. Verificació i validació tècnica](#7-verificació-i-validació-tècnica)
- [8. Fitxers relacionats](#8-fitxers-relacionats)

---

## 1. Introducció i context de negoci

El laboratori de ciberseguretat de **K-Six Solutions** rep, analitza i documenta el cicle de vida de mostres sospitoses de malware. Com a part de les seves operacions, el laboratori col·labora amb empreses externes i altres equips d'anàlisi compartint informació sobre les amenaces investigades.

Com que cada organització externa pot utilitzar plataformes i gestors de bases de dades diferents, no és viable proporcionar accés directe a la base de dades relacional MySQL del laboratori.

Per solucionar aquest repte d'interoperabilitat, s'ha dissenyat una **fitxa d'investigació estandarditzada** en dos dels formats d'intercanvi de dades més estesos: **XML i JSON**.

Aquests fitxers actuen com un llenguatge comú que permet integrar aplicacions i sistemes heterogenis sense haver de donar accés directe a la base de dades interna.

---

## 2. Objectius

Els objectius principals d'aquesta part del projecte són:

- Estandarditzar la informació de les mostres de malware.
- Facilitar l'intercanvi d'informació amb sistemes externs.
- Mantenir la traçabilitat entre mostres, hashes, atribucions i execucions.
- Representar les dades mitjançant XML i JSON.
- Garantir que tots dos formats continguin informació equivalent.
- Permetre que els sistemes receptors interpretin les dades de manera coherent.
- Representar correctament els casos en què una execució no genera observacions.

---

## 3. Esquema i estructura de la fitxa

L'estructura jeràrquica de la fitxa reflecteix les entitats i les relacions del model relacional del laboratori.

| Element / camp | Tipus de dada | Atributs XML | Descripció |
|---|---|---|---|
| `mostra` | Objecte / contenidor | `id` | Fitxa principal de la mostra investigada. |
| `nom_fitxer` / `tipus_fitxer` | Text | — | Nom original i classificació del fitxer. |
| `mida_bytes` | Numèric | — | Mida exacta del fitxer en bytes. |
| `data_recepcio` / `context_origen` | Data / text | — | Data de recepció i possible vector d'entrada. |
| `hash` | Text | `alg` | Empremta digital calculada amb un algorisme específic. |
| `atribucio` | Objecte / contenidor | `estat` | Historial de classificació de la família de malware. |
| `analista` | Objecte / text | `id` | Identificador de l'analista responsable. |
| `execucio` | Objecte / contenidor | `id` | Informació de l'anàlisi en un entorn controlat. |
| `observacio` | Objecte / contenidor | `tipus` | Indicador de compromís (IOC) i tècnica associada. |

### 3.1. Consideracions de l'estructura

- Cada mostra té un identificador únic.
- Una mostra pot tenir diversos hashes.
- Les atribucions permeten conservar l'historial de classificacions.
- Una mostra pot tenir diverses execucions en diferents entorns.
- Les observacions documenten indicadors i evidències detectades durant l'anàlisi.
- Els atributs XML identifiquen algorismes, estats, analistes i tipus d'indicador.

---

## 4. Correspondència amb el model relacional

Els fitxers d'intercanvi organitzen la informació mantenint la coherència amb les taules de la base de dades.

### 4.1. Mostres (`mostra`)

És el node principal de cada fitxa. Conté les metadades bàsiques del fitxer sospitós, com ara el nom, el tipus, la mida, la data de recepció i el context d'origen.

### 4.2. Hashes múltiples (`hashes`)

Una mostra pot disposar de diverses empremtes criptogràfiques, com ara MD5, SHA1 i SHA256.

- **XML:** l'algorisme s'indica mitjançant l'atribut `alg`.
- **JSON:** l'algorisme es representa mitjançant la propietat `algorisme`.

Això permet identificar una mostra amb diferents algorismes sense limitar la fitxa a un únic hash.

### 4.3. Atribucions de família (`atribuccions`)

Les atribucions permeten registrar l'evolució de les conclusions d'una investigació.

Cada atribució inclou:

- La família de malware proposada.
- La data de l'atribució.
- L'identificador de l'analista responsable.
- El nom i els cognoms de l'analista.
- El nivell de confiança.
- L'estat de l'atribució.

Els estats possibles són:

- `provisional`
- `confirmada`
- `retirada`
- `rebutjada`

Aquesta estructura permet conservar l'historial de les classificacions, incloent-hi les atribucions que posteriorment s'han descartat.

### 4.4. Execucions en sandbox (`execucions`)

Les execucions documenten les anàlisis dinàmiques realitzades en entorns controlats.

Cada execució pot incloure:

- Identificador de l'execució.
- Data i hora d'inici.
- Sandbox utilitzada.
- Sistema operatiu de l'entorn de prova.
- Resultat general de l'anàlisi.

Aquesta informació permet relacionar cada anàlisi amb el seu entorn d'execució.

### 4.5. Observacions i IOCs (`observacions`)

Les observacions registren evidències del comportament detectat durant l'anàlisi.

Cada observació pot incloure:

- Indicador de compromís (IOC).
- Tipus d'indicador, com ara `IP`, `URL` o `Domini`.
- Tècnica associada del marc MITRE ATT&CK.
- Nivell de confiança de la detecció.

Les observacions permeten documentar les evidències identificades sense confondre-les amb les interpretacions o conclusions de la investigació.

---

## 5. Justificació dels tipus de dades i formats

### 5.1. Identificadors únics

S'utilitza una nomenclatura unificada per identificar els elements del sistema.

| Element | Exemple |
|---|---|
| Mostra | `SMP-2026-001` |
| Execució | `EXEC-2026-001` |
| Analista | `AN-102` |

Aquests identificadors faciliten la traçabilitat entre la base de dades i les aplicacions externes.

### 5.2. Estàndard temporal ISO 8601

Les dates i les marques de temps segueixen el format ISO 8601.

| Tipus | Format | Exemple |
|---|---|---|
| Data | `YYYY-MM-DD` | `2026-10-28` |
| Data i hora | `YYYY-MM-DDTHH:MM:SS` | `2026-10-28T14:30:00` |

L'ús d'un format estandarditzat facilita la interpretació temporal de les dades en diferents sistemes.

### 5.3. Tipatge de les dades

XML i JSON representen les dades de manera diferent.

En XML, els valors dels elements es representen com a contingut textual, mentre que els atributs aporten informació addicional.

En JSON, els valors poden tenir tipus específics, com ara cadenes de text, nombres, valors booleans, objectes o llistes.

Per exemple, la propietat `mida_bytes` es representa com un nombre enter en JSON. Això permet que el sistema receptor compari o processi directament la mida del fitxer sense haver de convertir prèviament una cadena de text.

### 5.4. Equivalència entre XML i JSON

Tots dos formats han de representar les mateixes dades, encara que utilitzin estructures sintàctiques diferents.

Per garantir aquesta equivalència:

- Els identificadors han de coincidir.
- Les dates han de representar els mateixos moments.
- Els hashes han de conservar els seus algorismes.
- Les atribucions han de mantenir els seus estats.
- Les execucions han de conservar la informació de l'entorn.
- Les observacions han de contenir els mateixos IOCs i tècniques.
- Els camps sense observacions han de continuar presents.

---

## 6. Casos de prova i integritat estructural

Per validar que la fitxa admet diferents escenaris d'investigació, s'han definit quatre casos de prova.

### 6.1. Multiplicitat d'elements

Es contemplen mostres amb múltiples signatures hash —MD5, SHA1 i SHA256— i diverses execucions en diferents plataformes sandbox.

Aquest cas comprova que l'estructura admet diversos elements relacionats amb una mateixa mostra.

### 6.2. Evolució de les atribucions

La mostra `SMP-2026-003` representa l'evolució d'una investigació amb dues atribucions:

1. Una atribució inicial a la família Emotet, posteriorment marcada com a `retirada`.
2. Una atribució posterior a Qakbot, marcada com a `confirmada`.

Aquest exemple permet conservar l'historial de la investigació sense perdre les conclusions anteriors.

### 6.3. Entorns i IOCs

La mostra `SMP-2026-004` representa una mostra executada en un entorn Linux, concretament amb un script de shell POSIX, i permet registrar indicadors de compromís específics de xarxa.

Aquest cas amplia la representació a entorns diferents de Windows.

### 6.4. Execucions sense observacions

Una execució pot completar-se sense generar activitat sospitosa. En aquest cas, el sistema ha de distingir entre una anàlisi realitzada sense resultats rellevants i una anàlisi que no s'ha arribat a efectuar.

Per evitar aquesta ambigüitat, el camp `observacions` es manté present encara que no contingui elements.

**Representació XML:**

```xml
<observacions></observacions>
```

Representació JSON:

```json
"observacions": []
```

Aquesta representació indica explícitament que no hi ha observacions registrades per a aquella execució.

---

## 7. Verificació i validació tècnica

Els dos fitxers d'intercanvi s'han de validar per comprovar que estan correctament formats (*well-formed*) i que representen la mateixa informació.

### 7.1. Fitxer XML

**Fitxer:** `fitxa_mostres.xml`

Les comprovacions inclouen:

- L'existència d'una única etiqueta arrel: `investigacio_laboratori`.
- El correcte anidament de les etiquetes.
- El tancament de tots els elements.
- La sintaxi correcta dels atributs i les cometes.
- La presència dels contenidors necessaris, inclosos els d'observacions buides.

### 7.2. Fitxer JSON

**Fitxer:** `fitxa_mostres.json`

Les comprovacions inclouen:

- La sintaxi correcta de claus i claudàtors.
- L'absència de comes finals sobrants.
- La representació correcta dels tipus de dades.
- La correspondència de les dades amb la versió XML.
- La presència de llistes buides quan no hi ha observacions.

### 7.3. Resultat esperat

La validació ha de garantir que els dos fitxers siguin sintàcticament correctes i que mantinguin una correspondència de dades d'1:1.

Això permet que diferents aplicacions consumeixin la mateixa informació independentment del format utilitzat.

> **Nota de verificació:** cal executar les validacions sobre els fitxers reals abans d'afirmar que han superat totes les comprovacions.

---

## 8. Fitxers relacionats

| Fitxer | Descripció |
|---|---|
| [`fitxa_mostres.xml`](<Fitxers/fitxa_mostres.xml>) | Fitxer d'intercanvi de dades en format XML. |
| [`fitxa_mostres.json`](<Fitxers/fitxa_mostres.json>) | Fitxer d'intercanvi de dades en format JSON. |
| [`README.md`](README.md) | Documentació principal de l'activitat. |

---

<!-- ==================== PEU DE PÀGINA ==================== -->

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

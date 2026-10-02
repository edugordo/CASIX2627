# Desplegament de l'entorn aïllat de contenció

Benvinguts a aquesta sessió pràctica de **Ciberseguretat i Arquitectura Web**! 🔐

En aquesta píndola ens endinsarem en els conceptes fonamentals de la **seguretat informàtica**, la **gestió de servidors** i l'**arquitectura web**, combinant teoria i pràctica en un entorn de laboratori segur i completament aïllat.

L'objectiu és construir i configurar el nostre propi **laboratori d'atac i defensa**, treballant amb eines i tecnologies reals dins d'un entorn controlat.

---

## 🎯 Objectius de la sessió

Al llarg de la pràctica aprendrem a:

- 🖥️ Crear i configurar un **entorn virtualitzat i aïllat**.
- 🌐 Desplegar una **pila LAMP** funcional.
- ⚙️ Administrar serveis web i bases de dades des de la terminal.
- 🔍 Implementar mecanismes bàsics de **captura i anàlisi d'evidències**.
- 🛡️ Treballar amb snapshots per poder restaurar l'estat inicial del laboratori.
- 📊 Emmagatzemar i consultar dades generades pel servidor.

---

## 🖥️ 1. Virtualització i xarxa

Començarem preparant un **sandbox segur i aïllat** mitjançant un hipervisor.

Durant aquesta fase aprendrem a:

- Crear i configurar màquines virtuals.
- Establir una xarxa interna i controlada.
- Aïllar el laboratori de l'entorn de producció.
- Crear **snapshots** per conservar diferents estats de la màquina.
- Restaurar el laboratori al seu **estat inicial (*Zero State*)** quan sigui necessari.

> 💡 **Important:** totes les proves es realitzaran exclusivament dins de l'entorn de laboratori proporcionat.

---

## 🌐 2. Desplegament de la pila LAMP

A continuació configurarem un servidor web utilitzant la coneguda pila **LAMP**:

| Component | Tecnologia | Funció |
|-----------|------------|--------|
| **L** | Linux | Sistema operatiu |
| **A** | Apache | Servidor web |
| **M** | MariaDB | Sistema de gestió de bases de dades |
| **P** | PHP | Llenguatge de programació del costat del servidor |

La instal·lació i configuració es realitzarà principalment des de la **línia de comandes**, familiaritzant-nos amb les tasques bàsiques d'administració d'un servidor web.

---

## 🔍 3. Auditoria i recopilació d'evidències

Un cop el servidor estigui operatiu, desenvoluparem un petit **script d'auditoria**.

Aquest script permetrà:

1. Detectar la IP dels clients que accedeixen al servidor.
2. Recollir la informació necessària.
3. Emmagatzemar les dades en una base de dades MariaDB.
4. Consultar posteriorment la informació recopilada.

Aquesta part de la pràctica ens permetrà introduir-nos en conceptes relacionats amb la **traçabilitat, els logs i l'anàlisi forense digital**.

---

## 🛡️ 4. Laboratori segur i controlat

Tot el treball es realitzarà en un **entorn virtualitzat, aïllat i controlat**, dissenyat específicament per a finalitats educatives.

Les instantànies ens permetran experimentar, modificar la configuració i realitzar proves amb la possibilitat de **tornar ràpidament a un estat conegut i segur**.

> ⚠️ **Recordatori de seguretat:** no realitzeu proves d'atac, escanejos o activitats similars contra sistemes, xarxes o serveis que no siguin explícitament part del laboratori autoritzat.

---

## 🚀 Comencem!

Prepareu l'hipervisor, inicieu les màquines virtuals i obriu la terminal.

Avui passarem de la **teoria a la pràctica**, construint pas a pas un entorn web funcional i aprenent a analitzar-lo des d'una perspectiva de **ciberseguretat i administració de sistemes**.

> 🔐 **La seguretat s'aprèn practicant, però sempre en entorns controlats i responsables.**

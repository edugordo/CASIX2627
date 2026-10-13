# Pràctica: Gestió d'usuaris, grups i perfils

Pràctica guiada sobre comptes d'usuari, grups, privilegis, perfils i seguretat de comptes en **Windows 10** i **Kali Linux**.

---

## Índex

1. [Investiga els usuaris existents](#apartat-1-investiga-els-usuaris-existents)
2. [Investiga els grups predeterminats](#apartat-2-investiga-els-grups-predeterminats)
3. [Crea un usuari de treball](#apartat-3-crea-un-usuari-de-treball)
4. [Crea un grup local](#apartat-4-crea-un-grup-local)
5. [Separa el compte de treball del compte d'administració](#apartat-5-separa-el-compte-de-treball-del-compte-dadministració)
6. [Comprova el principi de mínim privilegi](#apartat-6-comprova-el-principi-de-mínim-privilegi)
7. [Investiga els perfils locals de Windows](#apartat-7-investiga-els-perfils-locals-de-windows)
8. [Investiga els directoris personals de Kali Linux](#apartat-8-investiga-els-directoris-personals-de-kali-linux)
9. [Protegeix informació del perfil](#apartat-9-protegeix-informació-del-perfil)
10. [Configura la seguretat dels comptes de Windows](#apartat-10-configura-la-seguretat-dels-comptes-de-windows)

---

## Convenció de noms

Els comptes que es creïn durant la pràctica han de portar el **nom de l'alumne** com a prefix:

| Compte | Format | Exemple |
|---|---|---|
| Usuari de treball (sense privilegis) | `<nom>client` | `isaacclient` |
| Usuari d'administració | `<nom>admin` | `isaacadmin` |

> En aquest document, `client` i `admin` fan referència als comptes amb el prefix corresponent.

---

## Apartat 1. Investiga els usuaris existents

### Windows 10

- [ ] Identifica l'usuari amb què has iniciat sessió.
- [ ] Obtingues una llista de tots els usuaris locals existents.
- [ ] Localitza aquests mateixos comptes utilitzant les eines gràfiques d'administració de Windows.
- [ ] Identifica quins comptes has creat tu i quins han estat creats pel sistema.
- [ ] Comprova si hi ha comptes desactivats.
- [ ] Localitza el **SID** (identificador) del teu usuari.
- [ ] Anota quins comptes consideres que són comptes predeterminats de Windows.

### Kali Linux

- [ ] Identifica l'usuari amb què has iniciat sessió.
- [ ] Consulta el seu **UID**.
- [ ] Identifica els grups als quals pertany.
- [ ] Consulta la llista d'usuaris existents al sistema.
- [ ] Localitza el compte `root`.
- [ ] Identifica alguns comptes que no corresponen a persones que utilitzen l'ordinador.

---

## Apartat 2. Investiga els grups predeterminats

### Windows 10

- [ ] Consulta tots els grups locals existents.
- [ ] Localitza el grup d'administradors.
- [ ] Comprova quins usuaris en formen part.
- [ ] Localitza el grup d'usuaris estàndard.
- [ ] Localitza el grup relacionat amb l'accés mitjançant Escriptori Remot.
- [ ] Identifica els grups als quals pertany el teu usuari actual.
- [ ] Comprova si el teu usuari té privilegis administratius.

### Kali Linux

- [ ] Consulta els grups existents.
- [ ] Identifica els grups als quals pertany el teu usuari.
- [ ] Localitza el grup que permet als usuaris obtenir temporalment privilegis administratius.
- [ ] Comprova quins usuaris pertanyen a aquest grup.
- [ ] Identifica almenys **tres grups** del sistema que no hagis creat tu.

---

## Apartat 3. Crea un usuari de treball

Es crearà un compte que s'utilitzarà com a **usuari de treball sense privilegis**. El nom de l'usuari serà el teu nom seguit de `client` (per exemple, `isaacclient`).

### Windows 10

- [ ] Crea l'usuari local `client`.
- [ ] Assigna-li una contrasenya.
- [ ] Comprova que el compte està habilitat.
- [ ] Verifica que no disposa de privilegis administratius.
- [ ] Identifica el **SID** assignat al nou compte.
- [ ] Comprova a quins grups pertany.

### Kali Linux

- [ ] Crea també l'usuari `client`.
- [ ] Assigna-li una contrasenya.
- [ ] Comprova que disposa d'un directori personal.
- [ ] Identifica el seu **UID**.
- [ ] Identifica el seu grup principal.
- [ ] Comprova els altres grups als quals pertany.
- [ ] Verifica que inicialment no disposa de privilegis administratius.

---

## Apartat 4. Crea un grup local

### Windows 10

- [ ] Crea un grup local anomenat `GrupClients`.
- [ ] Afegeix-hi l'usuari `client`.

### Kali Linux

- [ ] Crea un grup anomenat `ClientsLinux`.
- [ ] Afegeix-hi `client`.
- [ ] Comprova que l'usuari apareix com a membre del grup.
- [ ] Inicia una nova sessió amb `client` i verifica que la nova pertinença al grup s'ha aplicat.

---

## Apartat 5. Separa el compte de treball del compte d'administració

Treballar habitualment amb privilegis administratius no és una bona pràctica. Es crearà un **segon compte destinat a tasques d'administració**, també amb el teu nom com a prefix (per exemple, `isaacadmin`).

### Windows 10

- [ ] Crea l'usuari `admin`.
- [ ] Assigna-li una contrasenya **diferent** de la de `client`.
- [ ] Concedeix-li privilegis administratius.
- [ ] Comprova a quins grups pertany.

### Kali Linux

- [ ] Crea l'usuari `admin`.
- [ ] Concedeix-li la possibilitat de realitzar tasques administratives mitjançant el mecanisme d'elevació de privilegis de Linux.
- [ ] Comprova els seus grups.

---

## Apartat 6. Comprova el principi de mínim privilegi

En aquest apartat es comprova a la pràctica que els dos comptes **no tenen les mateixes capacitats**.

### Windows 10

- [ ] Inicia sessió amb `client`.
- [ ] Intenta modificar una configuració del sistema que requereixi privilegis administratius.
- [ ] Intenta obrir una eina del sistema amb privilegis d'administrador i cancel·la l'elevació de privilegis.
- [ ] Comprova que pots continuar fent tasques normals amb `client`.
- [ ] Repeteix l'operació utilitzant `admin` i compara el comportament dels dos comptes.

### Kali Linux

- [ ] Inicia sessió amb `client`.
- [ ] Intenta realitzar una operació que requereixi privilegis de `root`.
- [ ] Comprova que l'operació no es pot completar amb els privilegis actuals.
- [ ] Inicia sessió amb `admin`.
- [ ] Repeteix l'operació utilitzant el mecanisme d'elevació de privilegis.
- [ ] Verifica que `admin` pot executar temporalment una operació com a `root`.

---

## Apartat 7. Investiga els perfils locals de Windows

Es treballa ara la diferència entre **compte d'usuari** i **perfil d'usuari**.

- [ ] Inicia sessió a Windows amb `client`.
- [ ] Localitza el directori corresponent al seu perfil.
- [ ] Identifica les carpetes **Escriptori**, **Documents**, **Descàrregues** i **Imatges**.
- [ ] Activa la visualització dels elements ocults.
- [ ] Localitza `AppData`.
- [ ] Tanca la sessió.
- [ ] Inicia sessió com a `admin`.
- [ ] Comprova que disposa del seu propi Escriptori, Documents i altres directoris de perfil.
- [ ] Localitza el perfil de `client` des del compte `admin`.

---

## Apartat 8. Investiga els directoris personals de Kali Linux

- [ ] Inicia sessió amb `client`.
- [ ] Identifica quin és el seu directori personal.
- [ ] Mostra també els fitxers i directoris ocults.
- [ ] Localitza els directoris personals dels altres usuaris.
- [ ] Inicia sessió amb `admin`.
- [ ] Identifica el seu directori personal.
- [ ] Compara'l amb el de `client`.

---

## Apartat 9. Protegeix informació del perfil

### Windows 10

- [ ] Inicia sessió amb `client`.
- [ ] Crea una carpeta anomenada `Privat`.
- [ ] Crea-hi un document.
- [ ] Consulta les propietats de seguretat de la carpeta.
- [ ] Identifica el propietari.
- [ ] Identifica quins usuaris i grups disposen de permisos.
- [ ] Observa els permisos de `client`.
- [ ] Comprova si els permisos provenen de la carpeta superior.

### Kali Linux

- [ ] Inicia sessió amb `client`.
- [ ] Crea una carpeta anomenada `privat`.
- [ ] Crea-hi un document.
- [ ] Consulta el propietari, el grup i els permisos de la carpeta.
- [ ] Configura-la perquè **només el propietari** pugui accedir-hi.
- [ ] Inicia sessió amb un altre usuari estàndard.
- [ ] Intenta accedir al contingut de la carpeta.
- [ ] Torna a `client` i comprova que continua tenint-hi accés.

---

## Apartat 10. Configura la seguretat dels comptes de Windows

- [ ] Obre l'eina de Windows destinada a configurar les **directives de seguretat local**.
- [ ] Localitza les directives de compte.
- [ ] Accedeix a la política de contrasenyes.
- [ ] Consulta la longitud mínima configurada.
- [ ] Consulta l'historial de contrasenyes.
- [ ] Consulta els requisits de complexitat.
- [ ] Localitza la política de bloqueig de comptes.
- [ ] Comprova que la configuració ha quedat aplicada.
- [ ] Revisa els comptes `client` i `admin` per assegurar-te que tots dos compleixen la nova política.

---

## Resum de comptes i elements creats

| Element | Windows 10 | Kali Linux |
|---|---|---|
| Usuari de treball | `<nom>client` | `<nom>client` |
| Usuari d'administració | `<nom>admin` | `<nom>admin` |
| Grup local | `GrupClients` | `ClientsLinux` |
| Carpeta protegida | `Privat` | `privat` |

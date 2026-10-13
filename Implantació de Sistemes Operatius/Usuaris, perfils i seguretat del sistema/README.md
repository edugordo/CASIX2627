# RA2 · Configuració del programari de base

> Configura el programari de base, atenent les necessitats d'explotació del sistema informàtic.

![Temps](https://img.shields.io/badge/Temps%20estimat-6%20hores-blue)
![Dificultat](https://img.shields.io/badge/Dificultat-baixa-green)
![Autoria](https://img.shields.io/badge/Autoria-Isaac%20Reixach-lightgrey)

---

## 📌 Resum del repte

| | |
|---|---|
| **Temps estimat** | 6 hores |
| **Nivell de dificultat** | Baix |
| **Autoria** | Isaac Reixach |

### 🎓 Què s'aprèn?

- Com gestionar usuaris, grups i contrasenyes.
- Com funcionen els serveis del sistema.
- Com configurar la xarxa i la resolució de noms.
- Com utilitzar màquines virtuals.
- Com documentar configuracions.

### 🛠️ Què es fa?

- Crear usuaris i grups.
- Configurar serveis i protocols de xarxa.
- Configurar DNS i altres serveis bàsics.
- Fer proves amb màquines virtuals.
- Documentar les configuracions realitzades.

---

## 📑 Índex

1. [Comptes d'usuari](#-comptes-dusuari)
2. [Usuaris locals](#-usuaris-locals)
3. [Grups locals](#-grups-locals)
4. [Administrador, root i mínim privilegi](#-administrador-root-i-principi-de-mínim-privilegi)
5. [Elevació de privilegis](#-elevació-de-privilegis)
6. [Seguretat dels comptes](#-seguretat-dels-comptes)
7. [Perfils locals d'usuari](#-perfils-locals-dusuari)

---

## 👤 Comptes d'usuari

Un **compte d'usuari** permet accedir als serveis d'un sistema mitjançant la combinació d'un nom d'usuari i una contrasenya. Compleix dues funcions principals:

| Funció | Descripció |
|---|---|
| **Autenticació** | Comprovar la identitat d'un usuari i determinar com es demostrarà de manera segura. |
| **Autorització** | Determinar què pot fer l'usuari una vegada autenticat: a quins recursos pot accedir, quines accions pot realitzar i quins fitxers i configuracions li pertanyen. |

---

## 🖥️ Usuaris locals

Un **usuari local** és un compte gestionat pel mateix ordinador.

> 💡 Més endavant al curs veurem els **comptes de domini**, que són gestionats per un servidor que s'encarrega de l'autenticació i l'autorització per a tota una xarxa.

### Nom d'usuari i identificador

Habitualment identifiquem un usuari pel seu nom, per exemple `root` (el nom habitual de l'usuari amb privilegis d'administrador a Linux).

Tanmateix, tant a Linux com a Windows el sistema crea internament un **identificador numèric** que referencia l'usuari:

| Sistema | Identificador |
|---|---|
| Windows | **SID** (Security Identifier) |
| Linux | **UID** (User Identifier) |

> ⚠️ Si s'esborra un usuari i se'n torna a crear un amb el mateix nom, el sistema li assignarà un identificador **nou**, que no correspondrà amb l'anterior.

---

## 👥 Grups locals

Administrar individualment els permisos de centenars d'usuaris seria poc eficient. Per això existeixen els **grups**.

Un **grup** és un conjunt d'usuaris als quals podem aplicar conjuntament determinats permisos o privilegis.

**Exemple:** podem tenir un grup anomenat `administradors` on col·loquem diversos usuaris, com Marc i Anna, als quals volem assignar els mateixos privilegis.

---

## 🛡️ Administrador, root i principi de mínim privilegi

Quan instal·lem un sistema operatiu, aquest ja incorpora determinats comptes i grups necessaris per al seu funcionament. Alguns comptes s'utilitzen perquè serveis i components del sistema puguin executar-se amb una identitat i uns privilegis determinats.

### 🪟 A Windows

Alguns dels grups incorporats:

| Grup | Descripció |
|---|---|
| `Administrators` | Els seus membres disposen de privilegis elevats per administrar el sistema. |
| `Users` | Usuaris que poden treballar normalment amb el sistema, però no haurien de poder modificar-ne lliurement la configuració global. |
| `Guests` | Relacionat amb accessos temporals o molt limitats. |
| `Remote Desktop Users` | Permet concedir drets d'accés mitjançant Escriptori Remot sense convertir necessàriament l'usuari en administrador. |

### 🐧 A Linux

També existeixen usuaris i grups creats pel sistema. El compte més important és **`root`**, el superusuari, que disposa de control pràcticament total sobre el sistema.

> ⚠️ Per aquest motiu **no és recomanable treballar habitualment com a root**.

### 🔐 Principi de mínim privilegi

Un dels principis fonamentals de la seguretat informàtica és el **principi de mínim privilegi** (*Principle of Least Privilege*):

> Un usuari, procés o servei només hauria de disposar dels privilegis **estrictament necessaris** per realitzar la seva funció.

Per exemple, un alumne que només necessita navegar, editar documents i executar determinades eines **no necessita ser administrador**. Això redueix l'impacte d'un error o d'una aplicació compromesa.

#### 🦠 Relació amb el malware

Suposem que executem un programa maliciós:

- Si el procés disposa només dels privilegis d'un **usuari estàndard**, determinades operacions privilegiades haurien d'estar restringides.
- Si aconsegueix executar-se amb **privilegis administratius**, el potencial impacte és molt superior.

Per això, una de les preguntes clau durant una anàlisi és:

> **Amb quina identitat i amb quins privilegis s'està executant aquest procés?**

---

## ⬆️ Elevació de privilegis

Treballar habitualment amb un compte estàndard no significa que mai puguem realitzar tasques administratives. Els sistemes operatius proporcionen mecanismes per **elevar temporalment els privilegis**.

### Windows: UAC

Windows utilitza **User Account Control (UAC)**. Quan una aplicació necessita realitzar operacions administratives, el sistema pot sol·licitar una elevació de privilegis amb el conegut missatge:

> *"Vols permetre que aquesta aplicació faci canvis al dispositiu?"*

Així s'evita que totes les aplicacions s'executin permanentment amb privilegis elevats.

### Linux: `sudo`

A Linux és habitual afegir `sudo` davant de qualsevol ordre que requereixi permisos d'administrador:

```bash
sudo apt update
```

L'ordre s'executa amb privilegis elevats **només si l'usuari està autoritzat**. Això és preferible a mantenir una sessió permanent com a `root`.

---

## 🔑 Seguretat dels comptes

La protecció d'un sistema comença protegint-ne les **identitats**.

### Contrasenyes

Una contrasenya ha de ser difícil de descobrir, però viable d'utilitzar de manera segura. Cal considerar aspectes com:

- **Longitud**
- **Caducitat:** obligar a canviar-la cada cert temps.
- **Reutilització:** comprovar que no es repeteix la mateixa contrasenya que en altres llocs.
- **Historial:** que la contrasenya nova no coincideixi amb anteriors ni amb el nom d'usuari.
- **Intents d'autenticació fallits**
- **Bloqueig del compte**

> 💡 La **longitud** és especialment important. Una *frase de pas* llarga pot ser més resistent i més fàcil de recordar que una contrasenya curta basada únicament en substituir lletres per símbols.

#### 🔗 Eines útils

- [How secure is my password?](https://www.security.org/how-secure-is-my-password/): calcula quant de temps es trigaria a obtenir una contrasenya provant a l'atzar (**força bruta**).
- [Password list check](https://binsec.tools/passwordlistcheck/): comprova si una contrasenya apareix en llistes filtrades en atacs a bases de dades.

### Bloqueig de comptes

Un atacant podria intentar repetidament diferents contrasenyes. Una **política de bloqueig** pot establir, per exemple:

> Nombre màxim d'intents fallits (p. ex. **3**) → **bloqueig del compte**

Això dificulta els atacs automatitzats contra un compte, tot i que la política s'ha de dissenyar amb cura perquè també pot afectar la **disponibilitat**.

---

## 📁 Perfils locals d'usuari

**Compte** i **perfil** no són el mateix:

| Concepte | Què representa |
|---|---|
| **Compte** | La identitat de l'usuari. |
| **Perfil** | L'entorn i les dades associades a aquesta identitat. |

A Windows, els perfils es troben habitualment a:

```text
C:\Users\<nom_usuari>
```

Per exemple:

```text
C:\Users\cepmati
```

Dins del perfil trobem directoris com l'**escriptori**, les **descàrregues** o els **documents**. D'aquesta manera, dos usuaris del mateix ordinador poden tenir la mateixa estructura de carpetes però amb continguts diferents.

---

<p align="center"><sub>Autoria del repte: <b>Isaac Reixach</b></sub></p>

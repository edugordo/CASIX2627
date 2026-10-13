# Guia pas a pas: administració d'usuaris i permisos

Aquesta guia pas a pas permet completar tots els apartats de la pràctica d'administració d'usuaris i permisos en **Windows 10** i **Kali Linux**. Substitueix `elteunom` pel teu nom real en totes les ordres i usuaris (per exemple, `isaacclient` i `isaacadmin`).

---

## Apartat 1. Investiga els usuaris existents

### Windows 10

1. **Identifica l'usuari actual:** Obre la consola de comandes (`cmd`) i executa:

```cmd
whoami
```

![Imatge1](Captures/1.png)

2. **Llista tots els usuaris locals:**

```cmd
net user
```

![Imatge2](Captures/2.png)

3. **Localitza els comptes gràficament:** Prem `Win + R`, escriu `lusrmgr.msc` i prem Enter. A la carpeta **Usuarios** veuràs tots els comptes.

![Imatge3](Captures/3.png)
![Imatge4](Captures/4.png)

4. **Diferencia usuaris creats i del sistema:**
   - *Creats per tu:* Els que tenen el teu nom o els utilitzats per a la instal·lació.
   - *Creats pel sistema:* Comptes com `Administrador`, `Invitado`, `DefaultAccount`, `WDAGUtilityAccount`.

![Imatge2](Captures/2.png)

5. **Comprova comptes desactivats:** A `lusrmgr.msc`, fes doble clic sobre qualsevol compte. Si la casella *"La cuenta está deshabilitada"* està marcada (o té una fletxa cap avall a la icona), el compte està desactivat.

![Imatge5](Captures/5.png)

6. **Localitza el teu SID:** Executa a la consola:

```cmd
wmic useraccount where name='%username%' get name,sid
```

![Imatge6](Captures/6.png)

7. **Comptes predeterminats:** `Administrador`, `Invitado`, `DefaultAccount`, `WDAGUtilityAccount`.

### Kali Linux

1. **Identifica l'usuari actual:**

```bash
whoami
```

![Imatge7](Captures/7.png)

2. **Consulta el seu UID:**

```bash
id -u
```

![Imatge8](Captures/8.png)

3. **Identifica els grups de l'usuari:**

```bash
groups
```

![Imatge9](Captures/9.png)

4. **Llista tots els usuaris existents:**

```bash
cut -d: -f1 /etc/passwd
```

![Imatge10](Captures/10.png)

5. **Localitza el compte root:** Executa `grep '^root:' /etc/passwd`. Veuràs que té UID `0`.

![Imatge12](Captures/12.png)

6. **Comptes de sistema (no persones):** Comptes com `daemon`, `bin`, `sys`, `nobody`, `www-data` s'utilitzen per a serveis i dimonis del sistema.

---

## Apartat 2. Investiga els grups predeterminats

### Windows 10

1. **Consulta tots els grups locals:**

```cmd
net localgroup
```

![Imatge13](Captures/13.png)

2. **Localitza i comprova el grup d'Administradors:**

```cmd
net localgroup Administradores
```

![Imatge14](Captures/14.png)

3. **Localitza el grup d'usuaris estàndard:**

```cmd
net localgroup Usuarios
```

![Imatge15](Captures/15.png)

4. **Localitza el grup d'Escriptori Remot:**

```cmd
net localgroup "Usuarios de escritorio remoto"
```

5. **Identifica els grups del teu usuari:** Executa `whoami /groups`.

6. **Verifica privilegis administratius:** Si a la sortida de `whoami /groups` veus el grup `BUILTIN\Administradores`, l'usuari disposa de privilegis d'administració.

![Imatge16](Captures/16.png)

### Kali Linux

1. **Consulta els grups existents:**

```bash
cut -d: -f1 /etc/group
```

![Imatge17](Captures/17.png)
![Imatge18](Captures/18.png)

2. **Identifica els grups del teu usuari:**

```bash
id
```

![Imatge18](Captures/18.png)

3. **Grup d'elevació de privilegis (sudo):** El grup `sudo` és el que permet executar comandes com a root.

4. **Membres del grup sudo:**

```bash
getent group sudo
```

![Imatge20](Captures/20.png)

5. **Altres grups del sistema:** Exemples: `audio`, `video`, `cdrom`, `dialout`.

---

## Apartat 3. Crea un usuari de treball

### Windows 10

*Suposem que l'usuari es diu `isaacclient`.*

1. **Crea l'usuari local i assigna contrasenya:** Obre PowerShell/CMD com a Administrador i executa:

```cmd
net user isaacclient Contrasenya123! /add
```

![Imatge21](Captures/21.png)

2. **Comprova que està habilitat:**

```cmd
net user isaacclient
```

*Verificació:* Comprova que a la sortida posi `Cuenta activa: Sí`.

![Imatge22](Captures/22.png)

3. **Verifica que no té privilegis administratius:** Executa `net localgroup Administradores`. L'usuari `isaacclient` no hi ha de figurar.

![Imatge23](Captures/23.png)

4. **Identifica el seu SID:**

```cmd
wmic useraccount where name='isaacclient' get sid
```

![Imatge24](Captures/24.png)

5. **Comprova els seus grups:** Executa `net user isaacclient` i revisa la secció "Pertenencias a grupos locales" (per defecte només serà `*Usuarios`).

![Imatge25](Captures/25.png)

### Kali Linux

1. **Crea l'usuari client i assigna contrasenya:**

```bash
sudo adduser isaacclient
```

*(Introdueix la contrasenya quan la demani i confirma la informació).*

![Imatge26](Captures/26.png)

2. **Comprova el directori personal:** Executa `ls -ld /home/isaacclient`. Ha d'existir el directori `/home/isaacclient`.

![Imatge27](Captures/27.png)

3. **Identifica el seu UID i grup principal:**

```bash
id isaacclient
```

![Imatge28](Captures/28.png)

4. **Comprova altres grups i privilegis:** Veuràs el seu UID (normalment ≥ 1000) i el seu GID principal. Executa `groups isaacclient` per confirmar que no pertany al grup `sudo`.

---

## Apartat 4. Crea un grup local

### Windows 10

1. **Crea el grup local:**

```cmd
net localgroup GrupClients /add
```

![Imatge29](Captures/29.png)

2. **Afegeix l'usuari client al grup:**

```cmd
net localgroup GrupClients isaacclient /add
```

*Verificació:* Executa `net localgroup GrupClients` per veure que `isaacclient` apareix com a membre.

![Imatge30](Captures/30.png)
![Imatge31](Captures/31.png)

### Kali Linux

1. **Crea el grup:**

```bash
sudo groupadd ClientsLinux
```

![Imatge32](Captures/32.png)

2. **Afegeix l'usuari client:**

```bash
sudo usermod -aG ClientsLinux isaacclient
```

![Imatge33](Captures/33.png)

3. **Comprova la pertinença:**

```bash
getent group ClientsLinux
```

![Imatge34](Captures/34.png)

4. **Verifica en una nova sessió:** Obre un terminal, canvia d'usuari amb `su - isaacclient` i executa `groups`. Confirmaràs que `ClientsLinux` apareix a la llista.

![Imatge35](Captures/35.png)

---

## Apartat 5. Separa el compte de treball del compte d'administració

### Windows 10

1. **Crea l'usuari admin:**

```cmd
net user isaacadmin ContrasenyaAdmin456! /add
```

![Imatge36](Captures/36.png)

2. **Concedeix privilegis administratius:**

```cmd
net localgroup Administradores isaacadmin /add
```

![Imatge37](Captures/37.png)

3. **Comprova a quins grups pertany:** Executa `net user isaacadmin`. Ha de figurar a `*Administradores` i `*Usuarios`.

![Imatge38](Captures/38.png)

### Kali Linux

1. **Crea l'usuari admin:**

```bash
sudo adduser isaacadmin
```

![Imatge39](Captures/39.png)

2. **Concedeix capacitats d'elevació (sudo):**

```bash
sudo usermod -aG sudo isaacadmin
```

![Imatge40](Captures/40.png)

3. **Comprova els seus grups:** Executa `groups isaacadmin`. Ha de mostrar el grup `sudo`.

---

## Apartat 6. Comprova el principi de mínim privilegi

### Windows 10

1. **Inicia sessió amb `isaacclient`.**

![Imatge41](Captures/41.png)

2. **Intenta canviar una configuració:** Intenta obrir la directiva de seguretat (`secpol.msc`) o instal·lar un programa. Veuràs una finestra d'UAC que demana credencials d'administrador.

![Imatge42](Captures/42.png)
![Imatge45](Captures/45.png)

3. **Cancel·la l'elevació de privilegis:** Fes clic a "Cancelar". Veuràs que l'acció es denega, però pots continuar utilitzant l'equip per a tasques diàries (navegar, crear documents).

![Imatge44](Captures/44.png)

4. **Repeteix amb `isaacadmin`:** Tanca sessió i entra amb `isaacadmin`. Quan intentis fer la mateixa operació, només caldrà confirmar el diàleg d'UAC (o introduir la contrasenya d'admin) per poder realitzar el canvi.

![Imatge46](Captures/46.png)
![Imatge42](Captures/42.png)
![Imatge47](Captures/47.png)

### Kali Linux

1. **Inicia sessió/canvia a `isaacclient`:** `su - isaacclient`.

![Imatge48](Captures/48.png)

2. **Intenta executar una tasca de root:**

```bash
apt update
```

*Verificació:* El sistema retornarà un error de permisos (`Permission denied` / `Could not open lock file`).

![Imatge48](Captures/48.png)

3. **Inicia sessió/canvia a `isaacadmin`:** `su - isaacadmin`.

![Imatge49](Captures/49.png)

4. **Executa l'operació amb elevació:**

```bash
sudo apt update
```

Introdueix la contrasenya de `isaacadmin`. L'operació s'executarà correctament.

![Imatge50](Captures/50.png)

---

## Apartat 7. Investiga els perfils locals de Windows

1. **Inicia sessió com a `isaacclient`.**

![Imatge41](Captures/41.png)

2. **Localitza el perfil:** La ruta és `C:\Users\isaacclient`.

![Imatge51](Captures/51.png)

3. **Identifica les carpetes principals:** Dins trobaràs `Escritorio`, `Documentos`, `Descargas` i `Imágenes`.

![Imatge51](Captures/51.png)

4. **Activa elements ocults:** A l'Explorador de fitxers, ves a la pestanya **Vista** i marca la casella **Elementos ocultos**.

![Imatge52](Captures/52.png)

5. **Localitza AppData:** Veuràs la carpeta amagada `C:\Users\isaacclient\AppData`.

![Imatge52](Captures/52.png)

6. **Tanca la sessió i entra com a `isaacadmin`.**

![Imatge46](Captures/46.png)

7. **Comprova el seu propi perfil:** Revisa `C:\Users\isaacadmin` (té les seves pròpies carpetes independents).

![Imatge53](Captures/53.png)

8. **Localitza el perfil de client:** Des de l'administrador, navega fins a `C:\Users\isaacclient`. Quan intentis entrar-hi, el sistema et demanarà confirmació per obtenir permisos d'accés.

![Imatge54](Captures/54.png)

---

## Apartat 8. Investiga els directoris personals de Kali Linux

1. **Inicia sessió com a `isaacclient`.**

![Imatge56](Captures/56.png)

2. **Identifica el directori personal:**

```bash
echo $HOME
```

*(Retorna `/home/isaacclient`)*.

![Imatge57](Captures/57.png)

3. **Mostra fitxers i directoris ocults:**

```bash
ls -la ~
```

*(S'observaran fitxers com `.bashrc` o `.profile`)*.

![Imatge58](Captures/58.png)

4. **Explora els altres directoris personals:** Executa `ls -l /home` per veure les carpetes dels altres usuaris.

![Imatge59](Captures/59.png)

5. **Inicia sessió com a `isaacadmin` / root:**
   - El directori de `isaacadmin` és `/home/isaacadmin`.
   - Si entres com a `root`, el seu directori personal no està a `/home`, sinó directament a `/root`.

![Imatge60](Captures/60.png)

---

## Apartat 9. Protegeix informació del perfil

### Windows 10

1. **Sessió amb `isaacclient`.**

![Imatge41](Captures/41.png)

2. **Crea la carpeta i el fitxer:**

```cmd
mkdir C:\Users\isaacclient\Documents\Privat
echo "Hola" > C:\Users\isaacclient\Documents\Privat\document.txt
```

![Imatge61](Captures/61.png)

3. **Propietats de seguretat:** Fes clic dret sobre la carpeta `Privat` > **Propiedades** > pestanya **Seguridad**.

![Imatge62](Captures/62.png)

4. **Identifica propietari i permisos:** Fes clic a **Opciones avanzadas**.
   - *Propietari:* `isaacclient`.
   - *Permisos:* Observa si els permisos indiquen "Heredado de" (`C:\Users\isaacclient\Documents`).
   - Veuràs que `isaacclient` té *Control total*, però els usuaris del grup *Administradores* també hi tenen accés.

![Imatge62](Captures/62.png)

### Kali Linux

1. **Sessió amb `isaacclient`.**

![Imatge56](Captures/56.png)

2. **Crea carpeta i document:**

```bash
mkdir ~/privat
echo "Text privat" > ~/privat/document.txt
```

![Imatge63](Captures/63.png)

3. **Consulta els permisos actuals:**

```bash
ls -ld ~/privat
```

![Imatge64](Captures/64.png)

4. **Restringeix l'accés només al propietari:**

```bash
chmod 700 ~/privat
```

*Verificació:* `ls -ld ~/privat` ha de mostrar permisos `drwx------`.

![Imatge65](Captures/65.png)
![Imatge66](Captures/66.png)

5. **Comprova amb un altre usuari estàndard:** Obre un terminal i canvia a un altre usuari normal:

```bash
cd /home/isaacclient/privat
```

*(El sistema denegarà l'accés amb un error `Permission denied`)*.

![Imatge67](Captures/67.png)

6. **Torna a `isaacclient`:** Comprova que pots continuar accedint-hi (`ls -l ~/privat`).

---

## Apartat 10. Configura la seguretat dels comptes de Windows

1. **Obre les Directives de Seguretat Local:** Prem `Win + R`, escriu `secpol.msc` i prem Enter. *(Cal executar-ho com a administrador)*.

2. **Navega fins a les directives de compte:**
   - Fes clic a **Directivas de cuenta** > **Directiva de contraseñas**.

3. **Configura la política de contrasenyes:**

   ![Imatge68](Captures/68.png)

   - **Longitud mínima de la contraseña:** Fes-hi doble clic i estableix, per exemple, `10` caràcters.
   - **Historial de contraseñas:** Estableix un valor (ex. recordar les últimes `5` contrasenyes).
   - **Las contraseñas deben cumplir los requisitos de complejidad:** Configura-ho com a **Habilitado**.

4. **Configura la política de bloqueig de comptes:**

   ![Imatge69](Captures/69.png)

   - Navega a **Directivas de cuenta** > **Directiva de bloqueo de cuentas**.
   - **Umbral de bloqueo de cuentas:** Estableix, per exemple, `3` intents fallits.
   - *(El sistema s'oferirà a ajustar automàticament la durada del bloqueig i la finestra de restabliment).*

5. **Comprova que s'aplica la configuració:** Obre la consola (`cmd`) com a Administrador i executa:

```cmd
gpupdate /force
```

*Verificació:* El missatge de la consola ha d'indicar que la directiva de l'usuari i de l'equip s'han actualitzat correctament.

![Imatge70](Captures/70.png)

6. **Revisa els comptes `isaacclient` i `isaacadmin`:** Intenta canviar la contrasenya d'un d'ells per una de simple (ex. `1234`) des de la consola o la configuració i comprova que Windows la rebutja per no complir els requisits de complexitat o longitud.

![Imatge71](Captures/71.png)

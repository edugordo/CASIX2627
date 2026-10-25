# 💿 Instal·lació de programari de propòsit general i clonació de sistemes

**RA2. Instal·la programari de propòsit general avaluant-ne les característiques i els entorns d'aplicació.**

- **Autoria del repte:** Isaac Reixach
- **Última revisió:** maig de 2026
- **Temps estimat:** 4 hores
- **Nivell de dificultat:** baix

---

## 📑 Índex

1. [🎯 Objectius del repte](#-objectius-del-repte)
2. [🖥️ Creació de la imatge del sistema](#️-creació-de-la-imatge-del-sistema)
3. [🧹 Preparació de la màquina model](#-preparació-de-la-màquina-model)
4. [📦 Inventari del programari](#-inventari-del-programari)
5. [💽 Clonació d'una màquina física amb Clonezilla](#-clonació-duna-màquina-física-amb-clonezilla)
6. [🔄 Conversió d'una màquina virtual a RAW](#-conversió-duna-màquina-virtual-a-raw)
7. [🔐 Verificació de la integritat](#-verificació-de-la-integritat)
8. [🛠️ Restauració de la imatge RAW en un disc físic](#️-restauració-de-la-imatge-raw-en-un-disc-físic)
9. [✅ Verificacions finals](#-verificacions-finals)
10. [⚠️ Precaucions de seguretat](#️-precaucions-de-seguretat)
11. [📝 Conclusions](#-conclusions)

---

## 🎯 Objectius del repte

L'objectiu d'aquesta activitat és aprendre a preparar, configurar i clonar sistemes operatius per facilitar la instal·lació de programari en diferents equips.

Durant el repte es treballen les tasques següents:

- Instal·lar aplicacions i utilitats.
- Configurar eines de manteniment i seguretat.
- Actualitzar o eliminar programari quan sigui necessari.
- Comparar diferents aplicacions.
- Elaborar un inventari del programari instal·lat.
- Verificar que les aplicacions funcionen correctament.
- Crear una màquina model preparada per reproduir-la en altres ordinadors.
- Crear i restaurar imatges de discs amb Clonezilla i eines de Linux.
- Comprovar la integritat de les imatges mitjançant sumes de verificació.

---

## 🖥️ Creació de la imatge del sistema

Abans de clonar equips dins d'una organització, és convenient preparar una **màquina model** amb el sistema operatiu, les aplicacions i les configuracions necessàries.

Aquesta màquina servirà com a base per generar altres instal·lacions amb una configuració equivalent.

El procés general és el següent:

1. Instal·lar el sistema operatiu.
2. Aplicar les actualitzacions disponibles.
3. Instal·lar el programari necessari.
4. Configurar les aplicacions i les eines de seguretat.
5. Eliminar les dades temporals i les credencials de prova.
6. Verificar que el sistema funciona correctament.
7. Crear una imatge del disc per utilitzar-la en altres equips.

---

## 🧹 Preparació de la màquina model

Abans de generar la imatge, cal revisar el sistema per evitar que es reprodueixin dades sensibles o identificadors que haurien de ser únics.

### Windows

En sistemes Windows, es pot utilitzar l'eina `Sysprep` per preparar la instal·lació abans de clonar-la.

Des d'una terminal amb permisos d'administrador:

```cmd
C:\Windows\System32\Sysprep\sysprep.exe /generalize /oobe /shutdown
```

- `/generalize`: elimina informació específica de la instal·lació perquè es pugui preparar per a altres equips.
- `/oobe`: configura el següent inici perquè mostri l'experiència inicial de Windows.
- `/shutdown`: apaga l'equip quan finalitza el procés.

**Important:** cal comprovar que la versió de Windows, les llicències i el programari instal·lat permeten aquest procediment.

### Linux

En sistemes Linux, si la imatge s'ha de distribuir a diferents màquines, és necessari revisar els identificadors i la configuració específica de l'equip.

Per exemple, les claus d'amfitrió SSH es poden regenerar perquè cada màquina tingui una identitat pròpia.

En sistemes compatibles amb OpenSSH:

```bash
sudo rm -f /etc/ssh/ssh_host_*
sudo ssh-keygen -A
```

Aquest exemple elimina les claus existents i en genera de noves immediatament. Si es volen generar durant el primer arrencament, cal configurar un mecanisme d'inicialització adequat.

**Important:** no s'han d'eliminar les claus d'amfitrió d'un servidor en producció sense planificar-ne la substitució, ja que es pot interrompre la confiança dels clients SSH.

També cal:

- Eliminar les credencials temporals.
- Revisar els usuaris i permisos.
- Eliminar els fitxers temporals innecessaris.
- No incloure claus privades o contrasenyes dins de la imatge.
- Comprovar la configuració de xarxa i els serveis actius.

---

## 📦 Inventari del programari

Abans de crear la imatge, cal documentar les aplicacions instal·lades i les que s'han d'incloure a la màquina model.

| Aplicació | Finalitat | Versió | Estat |
|---|---|---|---|
| Sistema operatiu | Gestionar els recursos de l'equip | Per indicar | Per verificar |
| Navegador web | Navegació per Internet | Per indicar | Per verificar |
| Suite ofimàtica | Crear documents i fulls de càlcul | Per indicar | Per verificar |
| Antivirus o eina de seguretat | Protegir el sistema | Per indicar | Per verificar |
| Eina de compressió | Comprimir i descomprimir fitxers | Per indicar | Per verificar |
| Eina de clonació | Crear i restaurar imatges de disc | Per indicar | Per verificar |

*Nota: aquesta taula és una plantilla d'exemple. Cal substituir les versions i els estats pels de les aplicacions que realment s'hagin instal·lat.*

### 🔍 Verificació del programari

Abans de generar la imatge, cal comprovar que:

- Les aplicacions s'obren correctament.
- Les actualitzacions s'han aplicat.
- No hi ha errors importants en el sistema.
- Els permisos dels usuaris són correctes.
- Les eines de seguretat estan configurades.
- No s'inclouen dades personals innecessàries.

---

## 💽 Clonació d'una màquina física amb Clonezilla

Clonezilla és una eina que permet crear imatges de discs i particions i restaurar-les en altres dispositius.

Aquest procediment és útil quan es vol preparar un ordinador i reproduir-ne la instal·lació en altres equips.

### 1. Preparar els dispositius USB

Es necessiten:

- Un USB d'arrencada amb Clonezilla Live.
- Un segon USB amb espai suficient per emmagatzemar la imatge del sistema.

Es recomana fer servir un dispositiu d'emmagatzematge diferent del disc que es vol copiar.

### 2. Crear l'USB d'arrencada

1. Descarregar la ISO des de la pàgina oficial de [Clonezilla](https://clonezilla.org/clonezilla-live.php).
2. Connectar l'USB que s'utilitzarà per arrencar.
3. Obrir una eina com [Rufus](https://rufus.ie/).
4. Seleccionar la ISO descarregada.
5. Comprovar que el dispositiu seleccionat és l'USB correcte.
6. Iniciar la creació del dispositiu d'arrencada.

**Atenció:** crear un USB d'arrencada normalment esborra el contingut que hi havia abans.

### 3. Arrencar l'ordinador d'origen

1. Apagar completament l'ordinador.
2. Connectar l'USB de Clonezilla.
3. Encendre l'equip i obrir el menú d'arrencada.
4. Seleccionar l'USB corresponent.
5. Iniciar Clonezilla Live i seguir les opcions inicials.

### 4. Guardar la imatge del sistema

Seguir aquest ordre pels menús:

1. Seleccionar `device-image` per treballar amb una imatge.
2. Seleccionar `local_dev` per utilitzar un dispositiu local.
3. Connectar l'USB d'emmagatzematge quan el programa ho indiqui.
4. Esperar que aparegui el dispositiu i, quan Clonezilla ho demani, utilitzar `Ctrl+C` per continuar.
5. Seleccionar la partició de l'USB i la carpeta on es guardarà la imatge.
6. Seleccionar `Beginner`.
7. Seleccionar `savedisk` per guardar el disc complet.
8. Escriure un nom identificable, per exemple:

```text
equip-aula-2026-10-20
```

9. Seleccionar el disc intern d'origen comprovant-ne el model i la capacitat.
10. Acceptar les opcions de compressió proposades.
11. Activar la verificació de la imatge si està disponible.
12. Revisar el resum de l'operació i confirmar-la.

Esperar que finalitzin tant la còpia com les verificacions abans d'apagar l'ordinador.

El resultat serà una carpeta amb diversos fitxers que formen part de la imatge. **Cal conservar tota la carpeta sense modificar-ne el contingut.**

### 5. Restaurar la imatge en un altre ordinador

**Atenció:** la restauració sobreescriu les dades del disc de destinació.

1. Arrencar l'ordinador de destinació amb l'USB de Clonezilla.
2. Seleccionar `device-image` i després `local_dev`.
3. Connectar l'USB que conté la imatge.
4. Seleccionar la partició i la carpeta on està guardada.
5. Seleccionar `Beginner`.
6. Seleccionar `restoredisk`.
7. Triar la imatge creada anteriorment.
8. Seleccionar el disc intern de destinació.
9. Revisar les opcions de particionament i seleccionar la distribució de particions de la imatge quan sigui apropiat.
10. Activar la comprovació d'integritat si està disponible.
11. Revisar els avisos i confirmar únicament després d'identificar correctament el disc que s'esborrarà.
12. Esperar que el procés finalitzi sense desconnectar els USB ni interrompre l'alimentació.

Quan acabi la restauració:

- Apagar l'equip.
- Retirar els USB.
- Encendre l'ordinador des del disc intern.
- Comprovar que el sistema operatiu arrenca correctament.
- Verificar les aplicacions i els controladors.

**Nota:** si el maquinari de destinació és diferent, pot ser necessari ajustar els controladors, l'arrencada, la xarxa o altres configuracions.

---

## 🔄 Conversió d'una màquina virtual a RAW

VirtualBox permet treballar amb discs virtuals, habitualment en format `.vdi`.

Amb l'eina `VBoxManage`, es pot convertir un disc virtual en una imatge RAW amb extensió `.img`. Aquest format representa el contingut del disc sense la compressió pròpia del format d'imatge virtual.

### 1. Localitzar el disc virtual

Primer, cal identificar la ruta del fitxer `.vdi` de la màquina virtual i la carpeta on es guardarà la imatge.

Per exemple:

```text
D:\VMs\Origen.vdi
E:\Imatges\Desti.img
```

Cal comprovar que la unitat de destinació disposa d'espai suficient.

### 2. Convertir el disc a format RAW

Des de Windows, obrir una terminal i executar:

```cmd
"C:\Program Files\Oracle\VirtualBox\VBoxManage.exe" clonemedium disk "D:\VMs\Origen.vdi" "E:\Imatges\Desti.img" --format RAW
```

**Explicació de la comanda:**

- `VBoxManage.exe`: eina de línia de comandes de VirtualBox.
- `clonemedium disk`: crea una còpia del disc virtual.
- `Origen.vdi`: disc virtual d'origen.
- `Desti.img`: fitxer de destinació.
- `--format RAW`: indica que el format de sortida serà RAW.

Les rutes són exemples i s'han d'adaptar a la ubicació real dels fitxers.

Durant el procés, es mostrarà el progrés de la conversió fins que finalitzi.

### 3. Comprovar l'espai necessari

El format RAW no utilitza la compressió pròpia d'alguns formats de disc virtual. Per això, el fitxer de sortida pot ser considerablement més gran que el fitxer `.vdi` original.

Per exemple, un disc virtual amb una capacitat màxima de 40 GB pot generar una imatge RAW d'aproximadament 40 GB, encara que el fitxer VDI original ocupi menys espai.

La mida final depèn de les característiques del disc virtual i de les dades emmagatzemades.

---

## 🔐 Verificació de la integritat

Abans de transferir o restaurar la imatge, es recomana calcular-ne una suma de comprovació SHA-256.

Aquesta suma permet detectar canvis o corrupcions del fitxer quan es compara amb una suma calculada posteriorment.

### A Windows

```cmd
CertUtil -hashfile "E:\Imatges\Desti.img" SHA256
```

### A Linux

```bash
sha256sum /ruta/imatge/Desti.img
```

Cal guardar el resultat i comparar-lo amb el valor calculat després de copiar o transferir el fitxer.

Si els dos valors coincideixen, el fitxer no ha canviat respecte de la versió amb què es va calcular la suma original.

**Important:** SHA-256 comprova la integritat del fitxer, però no garanteix per si sol que la imatge contingui un sistema operatiu funcional o que estigui lliure de programari maliciós.

---

## 🛠️ Restauració de la imatge RAW en un disc físic

Per restaurar una imatge RAW en un disc físic, es pot utilitzar un sistema Linux i l'ordre `dd`.

Hi ha diverses opcions per preparar l'entorn:

- **Ubuntu ja instal·lat:** és preferible utilitzar un segon disc per evitar modificar accidentalment el disc del sistema.
- **Ubuntu Live:** permet iniciar un sistema temporal des d'un USB sense instal·lar-lo.
- **Una altra distribució Linux portable:** també pot servir si disposa de les eines necessàries.

En qualsevol cas, cal disposar del fitxer `.img` en un dispositiu accessible i identificar correctament el disc de destinació.

### 1. Identificar els discs

Executar:

```bash
lsblk -o NAME,SIZE,MODEL,FSTYPE,MOUNTPOINTS
```

També es pot consultar la informació de les particions amb:

```bash
sudo fdisk -l
```

Cal identificar:

- El disc que conté el sistema Linux.
- L'USB d'arrencada.
- L'USB o disc que conté la imatge.
- El disc físic on es vol restaurar la imatge.

No s'ha de deduir que el disc de destinació és `/dev/sdb` o qualsevol altre dispositiu sense comprovar-ne el model i la capacitat.

### 2. Desmuntar les particions de destinació

Si alguna partició del disc de destinació està muntada, cal desmuntar-la abans de restaurar la imatge.

Per exemple, només si la partició identificada és realment la correcta:

```bash
sudo umount /dev/sdX1
```

En aquesta comanda, `sdX1` és un marcador que s'ha de substituir per la partició real. Si hi ha altres particions muntades al mateix disc, també s'han de desmuntar.

No s'ha de desmuntar una partició del sistema que s'està utilitzant.

### 3. Escriure la imatge al disc físic

La comanda utilitzada és:

```bash
sudo dd if="/ruta/de/la/imatge/Desti.img" of=/dev/sdX bs=64M status=progress conv=fsync
```

**Significat dels paràmetres:**

- `if=`: ruta del fitxer d'imatge d'origen.
- `of=`: dispositiu físic de destinació.
- `bs=64M`: mida del bloc de dades utilitzat durant la còpia.
- `status=progress`: mostra el progrés de l'operació.
- `conv=fsync`: demana que les dades se sincronitzin amb el dispositiu abans de finalitzar.

`/dev/sdX` és només un marcador. S'ha de substituir pel dispositiu complet identificat prèviament, per exemple `/dev/sdb`, sense afegir-hi el número d'una partició si es vol restaurar el disc sencer.

**⚠️ ADVERTIMENT CRÍTIC**

L'ordre `dd` sobreescriu les dades del dispositiu de destinació. Una selecció incorrecta pot destruir el sistema operatiu, els USB o altres dades importants.

Abans d'executar-la:

1. Comprovar de nou el model i la capacitat del disc.
2. Verificar que el fitxer d'imatge és correcte.
3. Assegurar-se que el disc de destinació té prou capacitat.
4. Confirmar que no hi ha dades necessàries al disc que s'esborrarà.
5. No interrompre el procés ni apagar l'equip mentre s'està escrivint la imatge.

### 4. Finalitzar la restauració

Quan `dd` finalitzi:

1. Esperar que la comanda retorni el control de la terminal.
2. Comprovar que no s'han produït errors.
3. Apagar el sistema de manera segura.
4. Retirar els dispositius USB quan sigui adequat.
5. Arrencar l'ordinador des del disc restaurat.
6. Comprovar que el sistema operatiu s'inicia correctament.

Si el sistema no arrenca, pot ser necessari revisar la configuració UEFI/BIOS, el carregador d'arrencada, la compatibilitat del maquinari o la distribució de particions.

---

## ✅ Verificacions finals

Després de crear o restaurar una imatge, cal verificar que el sistema és funcional.

### Llista de comprovació

- [ ] La imatge s'ha creat sense errors.
- [ ] La verificació d'integritat ha finalitzat correctament.
- [ ] El fitxer d'imatge s'ha conservat complet.
- [ ] El disc de destinació té capacitat suficient.
- [ ] L'ordinador arrenca des del disc correcte.
- [ ] El sistema operatiu inicia sessió correctament.
- [ ] Les aplicacions instal·lades funcionen.
- [ ] Les actualitzacions i les eines de seguretat estan operatives.
- [ ] La xarxa funciona correctament.
- [ ] No hi ha errors importants de maquinari o controladors.
- [ ] S'han revisat els identificadors únics i les credencials de la màquina clonada.

### 📸 Evidències recomanades

Per documentar el treball al repositori de GitHub, es poden afegir captures de pantalla de:

1. L'inventari del programari instal·lat.
2. La configuració de Clonezilla.
3. La creació de la imatge del disc.
4. La conversió del fitxer VDI a RAW.
5. La suma de comprovació SHA-256.
6. La identificació dels discs amb `lsblk`.
7. La restauració de la imatge.
8. L'arrencada correcta del sistema restaurat.

Les captures s'han de fer durant la realització real de la pràctica. No s'han d'afegir evidències que no corresponguin a operacions executades.

---

## ⚠️ Precaucions de seguretat

Durant el procés de clonació i restauració, cal tenir presents aquestes mesures:

- Fer una còpia de seguretat de les dades importants abans de modificar els discs.
- Identificar els dispositius pel model, la mida i les particions.
- No executar ordres destructives sense revisar-ne els paràmetres.
- No compartir contrasenyes, claus privades ni informació personal a les captures.
- Eliminar o regenerar les dades específiques de la màquina model quan sigui necessari.
- Revisar les llicències del sistema operatiu i de les aplicacions.
- Verificar la imatge abans de distribuir-la.
- Provar la imatge en un entorn controlat abans d'utilitzar-la en equips de producció.

---

## 📝 Conclusions

Amb aquesta activitat es treballa la preparació d'una màquina model i la creació d'imatges de discs per facilitar la instal·lació de sistemes operatius en diferents ordinadors.

Clonezilla permet guardar i restaurar imatges de discs, mentre que VirtualBox i `VBoxManage` faciliten la conversió de discs virtuals a format RAW. En Linux, l'ordre `dd` permet escriure una imatge en un dispositiu físic, però s'ha d'utilitzar amb molta precaució perquè pot eliminar totes les dades del disc seleccionat.

També és important verificar la integritat de les imatges, documentar el programari instal·lat i comprovar que el sistema restaurat funciona correctament.

En conclusió, la clonació de sistemes pot estalviar temps en la preparació de diversos equips, sempre que es faci una bona planificació, es protegeixin les dades i es verifiqui el resultat final.

---

**Autor de les evidències:** *Edu Gordo Cebrià*

**Mòdul:** Fonaments de Maquinàri (CASIX)

# Seguretat en l'Arrencada
## Fonaments de Maquinàri | Edu Gordo Cebrià | CASIX 1

# 📋 Evidències

![Imatge](Captures/unnamed.png)
## - Fes un esquema de l'ordre d'arrencada amb BIOS/UEFI sense TPM i amb TPM.

## - Fes un esquema de l'ordre d'arrencada amb BIOS/UEFI sense TPM i amb TPM

## Esquema de l'ordre d'arrencada amb BIOS/UEFI sense TPM i amb TPM

<table>
<tr>
<td width="50%" valign="top">

### Sense TPM

```mermaid
flowchart TD
    A["Engegada de l'ordinador"] --> B["BIOS / UEFI"]
    B --> C["Comprovació del maquinari (POST)"]
    C --> D["Selecció del dispositiu d'arrencada"]
    D --> E["Carregador d'arrencada"]
    E --> F["Inici del sistema operatiu"]
```

</td>
<td width="50%" valign="top">

### Amb TPM

```mermaid
flowchart TD
    A["Engegada de l'ordinador"] --> B["BIOS / UEFI"]
    B --> C["Comprovació del maquinari (POST)"]
    C --> D["TPM: registre de mesures i protecció de claus"]
    D --> E["Secure Boot: verificació de signatures (si està activat)"]
    E --> F["Carregador d'arrencada"]
    F --> G["Inici del sistema operatiu"]
```

</td>
</tr>
</table>

## - Fes fotos de les diferents parts del procés d'arrencada al teu ordinador (que no tingui TPM, és a dir, el del taller) i explica en què consisteix cada part:
###  1. En el cas de MBR, cal explicar en què es diferencia de GPT.
###  2. Comprova si el teu ordinador portàtil té UEFI o BIOS i fes el mateix amb l'ordinador del taller que tens assignat.


---

# ⚙️ Configuració de BIOS/UEFI

## Entra a la BIOS/UEFI i localitza amb fotografies:

### - Data i hora.

![Imatge](Captures/3.jpg)

- Boot Order.

![Imatge](Captures/4.jpg)
![Imatge](Captures/5.jpg)

### - Virtualització.

![Imatge](Captures/6.jpg)

### - Contrasenya de BIOS/UEFI.

![Imatge](Captures/7.jpg)

### - TPM (UEFI): Intel Platform Trust Technology als portàtils. Tingues en compte que els PC de sobretaula del taller no tenen TPM.

![Imatge](Captures/9.jpg)

### - Secure Boot (UEFI).

![Imatge](Captures/11.jpg)

### - IOMMU (estarà sota el nom Intel: Intel VT-d, *Virtualization Technology for Directed I/O*).

![Imatge](Captures/12.jpg)

- Hyper-Threading.

![Imatge](Captures/13.jpg)

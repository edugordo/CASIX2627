
## Evidència 1: Desplegament d'entorn aïllat

**Aïllament de xarxa:** Canviar l'adaptador de xarxa de la VM Servidor i la VM Víctima a Xarxa Interna o Només-Anfitrió (Host-Only).

![imatge](Captures/1.1.png) 
![imatge](Captures/1.2.png)

### Verificació de seguretat:

Executar ``ping 8.8.8.8`` des de la màquina víctima i comprovar que falla (sense eixida ni accés a Internet).

Executar ``ping [IP_del_Servidor]`` i comprovar qoue respon (comunicació interna correcta entre les VMs).

**Congelació ("Estat Zero"):** Crear la primera instantània (snapshot) de la màquina víctima amb el nom Estado_Cero_Limpio.

**Simulacre de fallada:** Modifica o esborra un fitxer de sistema a la VM Víctima per simular un desastre, fallada de configuració o infecció per programari maliciós.

**Prova de restauració:** Aplicar la instantània *Estado_Cero_Limpio* i comprovar que la VM torna al seu estat funcional original en menys de 2 minuts.

**Checklist de sortida:** Validació en parelles per comprovar que la xarxa es manté aïllada, el servidor respon correctament i la instantània s'ha executat sense errors.

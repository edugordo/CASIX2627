# Guía paso a paso: SOC K-SIX Solutions (Packet Tracer 5.3.3)

Red asignada: **172.20.0.0/24** · Máscara: **255.255.255.0** · Gateway: **172.20.0.1**

## 1. Colocar dispositivos
- Router **2811** (principal) y otro **1841** o una nube como "Internet".
- Switch **2960-24TT**.
- 2 **Access Point-PT**.
- 2 **Server-PT** (renómbralos SANDBOX y EMULACIO).
- 3 **PC-PT** (representan a los 30; pon una nota "x30").
- 3 **Laptop-PT** (representan a los 20; pon una nota "x20").

## 2. Cablear (cable de cobre directo)
- Router `fa0/0` → switch `fa0/1`.
- Router `fa0/1` → Internet.
- EMULACIO, PCs y APs → puertos `fa0/x` del switch.
- SANDBOX → puerto **Gi1/1** del switch. Rotula el enlace "Cat6A 10 Gbps".

## 3. Nombres y zonas
- Renombra los equipos: R-SOC, SW-SOC, AP1, AP2...
- Añade notas de texto con las zonas: Sala Sandbox, Sobremesa y Sala de crisis.

## 4. Router (CLI)
```
enable
conf t
hostname R-SOC
interface fa0/0
 ip address 172.20.0.1 255.255.255.0
 no shutdown
exit
ip dhcp excluded-address 172.20.0.1 172.20.0.99
ip dhcp excluded-address 172.20.0.200 172.20.0.254
ip dhcp pool WIFI
 network 172.20.0.0 255.255.255.0
 default-router 172.20.0.1
end
write memory
```
El pool real es **172.20.0.100 – 172.20.0.199**.

## 5. Switch (CLI)
```
enable
conf t
hostname SW-SOC
interface vlan 1
 ip address 172.20.0.2 255.255.255.0
 no shutdown
exit
ip default-gateway 172.20.0.1
end
write memory
```

## 6. IPs estáticas
Desktop → IP Configuration, máscara 255.255.255.0, gateway 172.20.0.1.
- SANDBOX: 172.20.0.10
- EMULACIO: 172.20.0.11
- PC1, PC2, PC3: 172.20.0.50, .51, .52
- APs: 172.20.0.20 y .21 (si te deja)

## 7. Wi-Fi
1. En cada AP, entra en Config → Port 1 y pon el SSID **SOC-K6**.
2. Seguridad **WPA2-PSK** con contraseña (si no aparece, usa WPA-PSK).
3. AP1 en canal 1 y AP2 en canal 11.
4. En cada portátil: apágalo, quita el módulo cableado, mete el **WPC300N** y enciéndelo.
5. Desktop → PC Wireless → conecta al SSID con la clave.
6. Pon el portátil en DHCP.

## 8. Verificar
- `ipconfig` en un portátil: la IP debe estar entre .100 y .199.
- Ping SANDBOX → EMULACIO.
- Ping PC → router.
- Ping portátil → servidor.

## 9. Fase 3 (encapsulado)
1. Pasa al modo **Simulation** y filtra por ICMP.
2. Envía un ping de SANDBOX a EMULACIO.
3. Haz clic en el sobre en cada dispositivo para ver las capas OSI (IP y MAC).
4. Haz capturas.

## 10. Entrega
- Guarda el archivo `.pkt`.
- Haz capturas de la topología, las IPs, el DHCP y la simulación para la memoria técnica.

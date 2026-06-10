



## Broadcast Electronics Inc.
## 4100 North 24
th
Street, Quincy, Illinois 62305 USA • Phone (217) 224-9600 • Fax (217) 224-9607 • www.bdcast.com • bdcast@bdcast.com




























RDi 20 RDS Subcarrier Generator
## Quick Installation Guide
Firmware v0.152


## 597-9170 Revision D
## 12/04/06





























RDi 20 RDS Subcarrier Generator
## Quick Installation Guide

©2006 Broadcast Electronics Inc. All rights reserved.

The information in this publication is subject to improvement and change without notice. Although
every effort is made to ensure the accuracy of the information in this manual, Broadcast Electronics
Inc. accepts no responsibility for any errors or omissions. Broadcast Electronics Inc. reserves the right
to modify and improve the design and specifications of the equipment in this manual without notice.
Any modifications shall not adversely affect performance of the equipment so modified.

## Proprietary Notice
This document contains proprietary data of Broadcast Electronics Inc. No part of this publication may
be reproduced, transmitted, transcribed, stored in a retrieval system, translated into any other
language in any form or by any means, electronic or mechanical, including photocopying or
recording, for any purpose, without the express written permission of Broadcast Electronics Inc.

## Trademarks
Broadcast Electronics and the BE logo are registered trademarks of Broadcast Electronics Inc.

All other trademarks are property of their respective owners.

i


i
## ©2006 Broadcast Electronics Inc.
Table of Contents

- Overview........................................................................................................... - 1 -

- Prepare the Installation of the RDi 20 .............................................................. - 2 -
2.1.   Verify Contents of Shipment ........................................................................... - 2 -
2.2.   Tools / Items Needed For Installation (not supplied) ........................................ - 2 -
2.3.   Mounting Considerations ............................................................................... - 2 -
2.4.   Estimated Time for Installation / Setup ............................................................ - 2 -

- RDi 20 Rear Panel Connections / Features ........................................................ - 3 -

- RDi 20 Front Panel Features .............................................................................. - 5 -

- Installation ........................................................................................................ - 7 -
5.1.   AC Voltage Configuration............................................................................... - 7 -
5.2.   Install into Equipment Rack ............................................................................ - 8 -
5.3.   Connect AC Power ......................................................................................... - 8 -
5.4.   Connect the Data Input Cable (Serial or Ethernet) ........................................... - 8 -
5.5.   MPX and AUX Data Ports ............................................................................... - 8 -
5.6.   SYNC IN & RDS OUT Connections for “SIDE” & “LOOP” Modes ....................... - 9 -

- RDi 20 Front Panel Programming...................................................................- 10 -
6.1.   Overview ...................................................................................................... - 10 -
6.2.   RDi 20 Front Panel Programming Parameters ................................................ - 11 -
6.3.   Exiting the Programming Menu Set Without Saving ...................................... - 11 -
6.4.   Saving Settings............................................................................................. - 11 -
6.5.   Restarting the RDi 20 After Saving Settings ................................................... - 11 -

- Configure the RDi 20 via the Front Panel .......................................................- 12 -
7.1.   Set the IP Address ........................................................................................ - 12 -
7.2.   Set the Subnet Mask .................................................................................... - 12 -
7.3.   Set the Gateway (if applicable) ..................................................................... - 12 -
7.4.   Set DNS (if applicable) .................................................................................. - 12 -
7.5.   Save the Settings .......................................................................................... - 12 -
7.6.   Frequency ID ................................................................................................ - 12 -
7.7.   Set UDP Input 1 ........................................................................................... - 12 -
7.8.   Save the Settings .......................................................................................... - 13 -
7.9.   Configure the MPX Port................................................................................ - 13 -
7.10.   Save the Settings ....................................................................................... - 13 -
7.11.   Enabling RDS Group Generation................................................................. - 13 -
7.12.   PS Group Type ........................................................................................... - 14 -
7.13.   Enabling RDS Subcarrier Output ................................................................. - 14 -
7.14.   Save the Settings ....................................................................................... - 14 -
7.15.   Configure Composite Sync ......................................................................... - 14 -

ii


## ©2006 Broadcast Electronics Inc.
7.16.   Configure Composite Phase ....................................................................... - 14 -
7.17.   RDS Output Level Settings .......................................................................... - 15 -
7.18.   Save the Settings ....................................................................................... - 15 -
7.19.   Set the Stations PI, PTY, PS, and DI Codes................................................... - 15 -
7.19.1  Set the PI Code (Call letters).. .................................................................... - 15 -
7.19.2  Set the PTY Code ...................................................................................... - 15 -
7.19.3  Set the PS Code ........................................................................................ - 16 -
7.19.4  Set Decoder Identification (DI) Flags .......................................................... - 16 -
7.20.   Save the Settings ....................................................................................... - 16 -
7.21.   Set Date and Time (UTC) ............................................................................ - 16 -
7.22.   Set Local Offset from UTC .......................................................................... - 16 -
7.23.   Set Music/Speech (MS) Flag........................................................................ - 16 -
7.24.   Set the Traffic Program (TP) Flag................................................................. - 16 -
7.25.   Enable MPX Back-Channel.......................................................................... - 17 -
7.26.   Broadcast Time of Day ............................................................................... - 17 -
7.27.   Save the Settings ....................................................................................... - 17 -
7.28.   Software Restart ........................................................................................ - 17 -

- Using TRE in Conjunction with the RDi 20......................................................- 17 -
8.1.   DPS White Space .......................................................................................... - 17 -
8.2.   Short Radiotext ............................................................................................ - 17 -
8.3.   Radiotext Normal Blocks ............................................................................... - 18 -
8.4.   Radiotext Burst Blocks................................................................................... - 18 -
8.5.   Radiotext Burst Cycles................................................................................... - 18 -
8.6.   PS Normal Blocks.......................................................................................... - 18 -
8.7.   PS Blanking Cycles ........................................................................................ - 18 -
8.8.   DPS Scroll Advance....................................................................................... - 18 -
8.9.   DPS Scroll Cycles........................................................................................... - 18 -
8.10.   DPS Scroll Delay ......................................................................................... - 18 -

- Configure the RDi 20 using a Serial Connection ............................................- 19 -
9.1.   Turn AC Power ON ....................................................................................... - 19 -
9.2.   Connect a Personal Computer to the RDi 20 ................................................. - 19 -
9.3.   Setting the I.P. Address of the RDi 20 ........................................................... - 22 -
9.4.   Setting the Subnet Mask of the RDi 20 ......................................................... - 22 -
9.5.   Setting the Gateway of the RDi 20................................................................ - 23 -
9.6.   Save the Settings .......................................................................................... - 23 -
9.7.   Set the UDP Port .......................................................................................... - 23 -
9.8.   Save the Settings .......................................................................................... - 23 -
9.9.   MPX IN and MPX THRU Port Configuration ................................................... - 24 -
9.10.   Save the Settings ....................................................................................... - 24 -
9.11.   Enabling RDS Group Generation................................................................. - 24 -
9.12.   Enabling RDS Subcarrier Output ................................................................. - 25 -
9.13.   Save the Settings ....................................................................................... - 25 -
9.14.   Configure Composite Sync ......................................................................... - 25 -
9.15.   Configure Composite Phase ....................................................................... - 25 -

iii


iii
## ©2006 Broadcast Electronics Inc.
9.16.   RDS Output Level Settings .......................................................................... - 26 -
9.17.   Save the Settings ....................................................................................... - 26 -
9.18.   Set the Station’s PI, PTY, PS, and DI Codes.................................................. - 26 -
9.19.   Save the Settings ....................................................................................... - 27 -
9.20.   Restart the RDi ........................................................................................... - 27 -
9.21.   Point the Device Providing RDS Data to the RDi 20 ..................................... - 27 -
9.22.   Configure the Device Providing RDS Data to the RDi 20 .............................. - 27 -

-    A Note on System Settings............................................................................- 27 -

-    RDi 20 Hyper Terminal Commands ...............................................................- 28 -

-    Firmware Upgrades .......................................................................................- 30 -

-    RF Customer Service Contact Information ....................................................- 35 -

-    Terms and Definitions ...................................................................................- 36 -

-    Schematics.....................................................................................................- 37 -





















## - 1 -


## - 1 -
## ©2006 Broadcast Electronics Inc.
## 1. Overview

The RDi 20 Radio Data System (RDS) Generator adds text to FM programming in the form of
station branding, Program Associated Data (PAD) and other information.

Listeners want to know “what’s happening now”. To improve the immediacy of PAD, the RDi 20
RDS generator increases the rate at which receiver RadioText is refreshed. RadioText is the 64-
character message display available on more sophisticated receivers. When an event occurs, such
as a new song starting, the RDi will decrease the time necessary for new information to be
displayed.




## Figure 1 – Typical 2
nd
Generation HD Radio™ System with the RDi 20





## - 2 -


## ©2006 Broadcast Electronics Inc.
- Prepare the Installation of the RDi 20

2.1. Verify Contents of Shipment


808-9170, RDi 20 RDS Subcarrier Generator

597-9170, RDi 20 RDS Subcarrier Generator, Quick Install Guide (this document)

978-9170, RDi Installation Kit

682-0001, AC Power Cord

947-0020, Assy, Cable, BNC, Qty (2)

417-0910, Kit Backshell for 9 Pin D-sub Connector, Qty (4)

## 550-111, Connector D-sub 9 Pin Female, Qty (3)

## 550-112, Connector D-sub 9 Pin Male, Qty (1)

## 418-1550-008, Connector Plug, 8 Pin Terminal Block


2.2. Tools / Items Needed For Installation (not supplied)

## Small Flat Blade Screwdriver
## Wire Strippers
Solder and Soldering Iron (if planning to use MPX IN - Serial Data Input port)
Cable for 9 Pin Connectors (if planning to use MPX IN - Serial Data Input port)
Heat Shrink for 9 Pin Cable (if planning to use MPX IN - Serial Data Input port)
## Standard Rack Mounting Hardware
Appropriate Tool for Rack Hardware
Standard Ethernet Cable to connect from RDi to STL
## Straight Thru Serial Cable (for Firmware Upgrades)
## Personal Computer (for Firmware Upgrades)


## 2.3. Mounting Considerations

The RDi 20 is designed to mount in a standard 19” E.I.A. rack or cabinet and is a
1 rack unit in height.


2.4. Estimated Time for Installation / Setup

Providing that you have the proper materials and tools listed above, the
installation and setup of the RDi 20 will take approximately 1 hour.







## - 3 -


## - 3 -
## ©2006 Broadcast Electronics Inc.
- RDi 20 Rear Panel Connections / Features











Figure 2 – RDi 20 Rear Panel Connections / Features

1) MPX IN – Serial data input from B.E.’s TRE or competing product. This input data may be
multiplexed for feeding additional RDi’s in the future.  The “MPX In” is a D9F connector
with “DCE” pin-out (see Figures 5 and 5A).  Both the MPX IN and MPX THRU connectors
have a passive bypass relay such that multiplex data will pass thru to the next device in the
chain even if the RDi 20 is powered off.

2) MPX THRU – Used for connecting multiple RDi’s together (cable connectors supplied).  The
“MPX Thru” is a D9M with “DTE” pin-out (see Figures 5 and 5A).  Both the MPX IN and
MPX THRU connectors have a passive bypass relay such that multiplex data will pass thru to
the next device in the chain even if the RDi 20 is powered off.

3) ACTIVITY LED – The MPX Activity LED is lit green when the MPX input is active.  The
Activity LED will blink momentarily (green-off-green) to indicate an incoming data packet
or switch momentarily red to indicate an error in the incoming data.

4) AUX 1 – The “Aux 1” port has the same “DTE” pin-out as the “MPX Thru” (see Figures 5
and 5A).  This connection will be used for future use.

5) AUX 2 – The “Aux 2” port has the same “DTE” pin-out as the “MPX Thru” (see Figures 5
and 5A).  This connection will be used for future use.

6) APPLICATION CARD – For future use.

7) TCP / IP NETWORK – RJ45 ethernet data input connection from B.E.’s TRE, Now Playing,
or competing product via a Studio to Transmitter Link (STL).

8) SPEED INDICATOR – This is the ethernet speed indicator (lit for 100 base, extinguished
for 10-base).

9) LINK / ACTIVITY INDICATOR – This is the ethernet activity indicator (will blink
green-off -green during activity).
## 1 4
## 2 5 6
## 7
## 11
## 13
## 1416
## 15
## 17
## 3
## 12
## 89
## 10

## - 4 -


## ©2006 Broadcast Electronics Inc.

10) GPIO – General Purpose Input / Output Connections for future use.

11) RDS OUT – Subcarrier RF Output to be connected to the Exciter at the Transmitter Site
## (see Section 5.6).

12) SIDE CHAIN / LOOP THRU SWITCH – The Side/Loop switch selects the mode of
operation for the Composite IO section.

In “SIDE CHAIN” operation the 19kHz pilot is applied to a sync input and only the RDS
waveform appears at the RDS output.  (The RDS waveform is locked in phase to the
applied pilot reference.)

In “LOOP THRU” operation the complete composite signal (including audio and the
19kHz pilot) is applied to a sync input and a precision summing amplifier (internal to the
RDi 20) adds the incoming composite signal to the internally generated RDS waveform
and the sum of these signals is presented at the RDS output.  Note that in “loop thru”
operation a passive bypass relay is present to pass the composite signal if the RDi 20 is
powered off.

13) SYNC IN 1 – 19 kHz Pilot Signal IN from Exciter (see Section 5.6).

14) SYNC IN 2 – 19 kHz Pilot Signal IN from Exciter (see Section 5.6).

15) AC POWER – AC Line cord connection.

16) ON / OFF – Main AC ON / OFF switch.

17) VOLTAGE – Voltage selection (115V or 230V) fuse block.























## - 5 -


## - 5 -
## ©2006 Broadcast Electronics Inc.
- RDi 20 Front Panel Features













Figure 3 – RDi 20 Front Panel Features

1) TEXT DISPLAY – In normal operation the date and time (UTC) is displayed along with
the selected sync input (upper right), the 8 character PS code (lower left) and current
radio text (scrolling area, lower right).

With release of the firmware v0.152 it is now possible to configure common features of
the RDi 20 from the front panel using a combination of menus on the text display and
the encoder (item 9).

2) RDS LOGO – This is the RDS Logo (not a status indicator).

3) 57 kHz (SUBCARRIER) STATUS INDICATOR – Lit blue for normal operation, lit red if
the unit is in the bypass state (XEBP=Enabled).

4) 19 kHz (STEREO PILOT) STATUS INDICATOR – Lit blue when a 19 kHz reference
(stereo pilot) is present at a sync input and the corresponding sync input is selected
(XESS=Input 1 or XESS=Input 2).  This is the normal state for a stereo broadcast with
the RDS subcarrier phase locked to the stereo pilot.  Lit red if a reference is not detected
or if the unit is in the bypass state.  Indicator is dark for monophonic broadcast with a
"free running" subcarrier (XESS=Disabled).

5) MPX ACTIVITY INDICATOR – Lit blue for normal operation.  Blinks momentarily (blue-
off-blue) on reception and successful processing of new data on the MPX port.  Blinks
red momentarily to indicate reception of corrupt data on the MPX port.



## 1
## 2
## 3
## 5
## 10
## 11
## 4
## 7
## 6
## 8
## 9

## - 6 -


## ©2006 Broadcast Electronics Inc.
6) ETHERNET ACTIVITY INDICATOR – Lit blue for normal operation.  Blinks momentarily
(blue-off-blue) on reception and successful processing of new data on the Ethernet port.
Indicator is dark if no link detected (no Ethernet cable attached or other connectivity
issue).

7) FAULT INDICATOR – Lit red for hardware fault.  (Note that it is normal for this
indicator to light red for several seconds on power up or CPU reset.)  Future versions of
the firmware may define additional states for this indicator.

8) NUMERIC DISPLAY – The numeric display cycles through a set of three device ID codes.
This includes the PI code in hexidecimal and ASCII form as well as the station broadcast
frequency.

9) ENCODER – With release of the firmware v0.152 it is now possible to configure
common features of the RDi 20 from the front panel using menus (on the text display,
item 1) and this control.  The encoder is rotated left or right to scroll through menu
items and pressed in (clicked) to make selections.

10) HARDWARE RESET BUTTON – This pushbutton triggers a hardware reset.  (Note that
the button is recessed into the panel and a small flat screwdriver or similar tool is
required to actuate it.)  This control is normally not used.  It is part of a hardware
interlock to force access to the CPU ROM monitor (press and hold encoder in while
momentarily pressing the reset button).

11) CONSOLE PORT –  A serial communications port used for initial device configuration
using a terminal emulator as well as installation "uploading" of new firmware.  This port
is "DCE" wired and is always configured for 115200 baud, 8 bits, no parity, 1 stop bit.



























## - 7 -


## - 7 -
## ©2006 Broadcast Electronics Inc.
## 5. Installation

5.1. AC Voltage Configuration

The RDi 20 can be quickly configured for either 115V (factory default) or 230V
operation.  On the rear of the RDi unit there is a fuse block the can be removed,
rotated 180 ̊, and reinstalled to quickly change from 115V to 230V.
























Figure 4 – RDi 20 AC Configuration (115V or 230V)




Step 1 – Using a small flat blade
screwdriver, gently pry the fuse block
door open.
Step 2 – Next, gently pry the
fuse block out.
Step 3 – Rotate the fuse block
180 ̊ (so that 230V is on the
right side) and re-install.
Step 4 – Close the fuse block
door until it snaps shut.

## - 8 -


## ©2006 Broadcast Electronics Inc.
5.2. Install into Equipment Rack

Install the RDi 20 into a standard 19” E.I.A. equipment rack at the transmitter site.

5.3. Connect AC Power

Connect the AC Power Cord (supplied in kit) to the RDi 20.

5.4. Connect the Data Input Cable (Serial or Ethernet)

The RDi 20 will accept either serial data to the MPX IN port, or ethernet data via
the TCP / IP NETWORK port.  Most installations will connect a standard ethernet
cable (not supplied) from the RDi 20 to the STL at the transmitter site.

NOTE:  Communication across the STL may be either UDP or TCP/IP protocol.

If the serial data MPX IN port is going to be used, terminate the serial input cable
with the appropriate connector from the kit.  See the following section for pinout.

5.5. MPX and AUX Data Ports

The “MPX” and “AUX” data ports are capable of operating with RS232 or RS422
signaling.  (The signal names change depending on the type of electrical signaling
selected for the port.)

The “MPX IN” is the serial data input port and is a DB9F connector with “DCE”
pin-out.

The “MPX THRU” is a DB9M with “DTE” pin-out and is used if connecting to
another RDi 20.

The “AUX 1” and “AUX 2” ports are also DB9Ms and have the same “DTE” pin-out
as the “MPX THRU.”

## MPX
## IN
## (DB9F)
## RS232 (DCE) RS422
## MPX THRU,
## AUX 1, AUX 2
## (DB9M)
## RS232 (DTE) RS422
1        DCD        (out)                         1
2 RD (out) TXD-  2 RD (in) RXD-
3 TD (in) RXD-  3 TD (out) TXD-
4                                4        DTR        (out)
5        Ground        Ground                   5        Ground           Ground
6        DSR        (out)                         6
7        RTS        (in)        RXD+                7        RTS        (out)         TXD+
8 CTS (out) TXD+  8 CTS (in) RXD+
## 9                                9

Figure 5 – MPX IN, MPX THRU, AUX 1, and AUX 2 Connector Pinouts

## - 9 -


## - 9 -
## ©2006 Broadcast Electronics Inc.

Figure 5A – MPX IN, MPX THRU, AUX 1, and AUX 2 Connector Pinouts


5.6. SYNC IN & RDS OUT Connections for “SIDE” & “LOOP” Modes

The RDi 20 subcarrier generator offers two methods for connection into the FM
composite chain known as “Side Chain” and “Loop Thru”.

“Side Chain” is normally the preferred method of connection.  The mode switch
must be set to the “Side” position for this connection method.  The 19kHz pilot
reference from the stereo generator is connected (via BNC Cable 947-0020
supplied in kit) to one of the sync inputs on the RDi 20.  This allows the RDi 20 to
phase lock the 57kHz RDS subcarrier to the 19kHz stereo pilot.  The RDS output
of the RDi 20 is then connected (via BNC Cable 947-0020 supplied in kit) to a
Subcarrier (SCA) or Aux Input on the FM Exciter.  In this mode of operation, only
the RDS waveform is present at the RDi 20 RDS Output and this signal is mixed
into the final composite by a summing amplifier within the Exciter.

“Loop Thru” is an alternate method of connection that is required in some
composite chains.  The mode switch must be set to the “Loop” position for this
connection method.  In “Loop Thru” operation the composite signal from the
stereo generator (containing audio and the 19kHz pilot) is connected (via BNC
Cable 947-0020 supplied in kit) to a Sync Input on the RDi 20.  A precision
summing amplifier (internal to the RDi 20) combines the incoming composite
signal with the internally generated RDS waveform to produce the final output.
The RDi 20 RDS Output (which is now the full composite signal including audio
and the RDS subcarrier) is connected (via BNC Cable 947-0020 supplied in  kit) to
the main program input on the FM Exciter.  In “Loop Thru” operation, a passive
bypass relay internal to the RDi 20 allows the composite signal to pass thru to the
Exciter should the RDi 20 be powered off.

In either case, it is necessary to adjust the RDS signal level to produce an
appropriate (approximately 3%) final injection level.  See the RDS Output Level
Settings section of this manual for further information on adjusting signal levels.


## - 10 -


## ©2006 Broadcast Electronics Inc.
- RDi 20 Front Panel Programming

## 6.1. Overview

With firmware release v0.152, the RDi 20 has the capability of “Front Panel
Setup” using the Encoder Wheel and the Display.



Figure 6 – RDi 20 Status Display


Once the RDi 20 comes up, depress the Encoder Wheel once to enter the
programming menu set.



Figure 7 – RDi 20 Programming Menu Set


Next, rotate the Encoder Wheel (right or left) to go to the desired programming
menu.  There are 38 programming menus available for front panel setup that are
numbered [00] through [37] .  This number is displayed in the upper left corner of
the display in the programming menus.  Please note that the menu selections
"wrap around" from item [37] to item [00] and vice versa.



Figure 8 – Rotate the RDi 20’s Encoder Wheel to Scroll Through the Programming Menus


Once you are in the desired programming menu, depress the Encoder Wheel.  The
brackets will now move from the menu number in the upper left corner of the
display to the first programmable selection.  Next, rotate the Encoder Wheel (right
or left) to make the desired entry.  Depress the Encoder Wheel again, the brackets
will go to either the next programmable selection or back to the menu number.
Rotate the Encoder Wheel to go to next desired menu.

Once all changes are made, go to programming menu [01] and depress
the Encoder Wheel to save all changes.

Next, go to menu [02] and depress the Encoder Wheel to reset the RDi 20.



## - 11 -


## - 11 -
## ©2006 Broadcast Electronics Inc.
6.2. RDi 20 Front Panel Programming Parameters

Please note that most of the RDi 20’s system parameters may be programmed via
the front panel.  However, there are a few that may only be changed via a serial
connection using Hyper Terminal (see Sections 9 and 11).

6.3. Exiting the Programming Menu Set Without Saving

If at anytime during the programming process you wish to exit without saving
changes, navigate to the [00] programming menu and depress the encoder
wheel.  The RDi 20 will then return to the Status Display screen.

The front panel programming menu may also be used to view the current state of
the RDi 20's system parameters.  To exit the menu system after browsing the
system parameters, select item [00] to return to the status display.

[00] Exit to status display
## ----

## 6.4. Saving Settings

Navigate to the [01] programming menu,

[01] Save parameters to NVRAM
## XSAV

Next, depress the encoder wheel to save all settings to NVRAM.

6.5. Restarting the RDi 20 After Saving Settings

Certain system parameters (such as the TCP/IP configuration) only take effect
when the RDi-20 CPU starts up.  As such, use option [02] to restart the CPU after
all desired changes have been made and saved to NVRAM."

Navigate to the [02] programming menu,

[02] Software restart
## XRES

Next, depress the encoder wheel to restart the RDi 20 software.








## - 12 -


## ©2006 Broadcast Electronics Inc.
- Configure the RDi 20 via the Front Panel

7.1. Set the IP Address

[18] IP Address
## XIPA = * . * . *.  *

7.2. Set the Subnet Mask

## [19] Subnet
## XIPS = * . * . *.  *

7.3. Set the Gateway (if applicable)

## [20] Gateway
## XIPG = * . * . *.  *

7.4. Set DNS (if applicable)

## [21] DNS
## XIPD = * . * . *.  *

7.5. Save the Settings

Navigate to the [01] programming menu,

[01] Save parameters to NVRAM
## XSAV

Next, depress the encoder wheel to save all settings to NVRAM.

7.6. Frequency ID

[37] Frequency ID
## XIDF = ???.?

7.7. Set UDP Input 1

It is necessary to set the UDP port that the RDi 20 listens to for incoming data.
This value must also be set on the controlling software.

[22] UDP input 1
XIPP=n :n.n.n.n

Where the first “n” selects the UDP port number.  The presence of the “:” and
four additional numbers n.n.n.n sets a mask such that the RDi 20 will only listen
to UDP packets from a specific address or range of addresses.


## - 13 -


## - 13 -
## ©2006 Broadcast Electronics Inc.
To listen to port 16550 from any address starting with “192.168” enter
“XIPP=16550:192.168.*.*”  The “*” is a “match any” wildcard.

The more digits specified, the more restricted the range.  As such,
“XIPP=16550:192.168.1.137” sets the RDi 20 to listen to port 16550 but only
if the UDP packet originated at 192.168.1.137

7.8. Save the Settings

Navigate to the [01] programming menu,

[01] Save parameters to NVRAM
## XSAV

Next, depress the encoder wheel to save all settings to NVRAM.

7.9. Configure the MPX Port

[17] MPX port
XMCP = mpx : sig : baud : bits : par : stop

## Where:
"mpx" = "--" for non-multiplexed data
- or -
"mpx" = "00-99" (a channel number) for multiplexed data

"sig" = "RS232 or RS422" to select the type of electrical signaling

"baud" = "300 to 115200" to select the baud rate (typically "9600")

"bits" = "5 to 8" to select the number of data bits (typically "8")

"par" = "N,O,E" to select none, odd, or even parity (typically "N")

"stop" = "1 or 2" to select the number of stop bits (typically "1")

7.10. Save the Settings

[01] Save parameters to NVRAM
## XSAV

7.11. Enabling RDS Group Generation

[07] Group generation
XENA = (setting may be Enabled or Disabled; will default to Enabled if using TRE)

When “XENA = Enabled” group generation is enabled and the actual RDS data
appears at the output.

When “XENA = Disabled” group generation is disabled and an “all zero”
modulation appears at the output.  (That is to say, the subcarrier waveform is

## - 14 -


## ©2006 Broadcast Electronics Inc.
present but no group data is being generated.  The RDS /RBDS standards consider
"all zero" modulation as the reference waveform for use when setting the RDS
injection level.)

7.12. PS Group Type

[36] PS group type
XPSG = (setting may be Group OA or Group OB)

7.13. Enabling RDS Subcarrier Output

[03] Output bypass
XEBP = (Disabled or Enabled; default is Enabled which is to say that the output is
bypassed / no signal present.)

7.14. Save the Settings

[01] Save parameters to NVRAM
## XSAV

## 7.15. Configure Composite Sync

[06] Sync Select / PLL
XESS = (settings may be Disabled, Input 1, or Input 2; default is ????)

The active sync input is selected using the “XESS” command.  “XESS=Input 1”
selects sync input 1, “XESS=Input 2” selects sync input 2.  A third case
“XESS=Disabled” is provided for monophonic broadcast (no stereo pilot.)
When “XESS=Disabled” the RDi 20 phase lock loop is disabled and the RDS
subcarrier is generated using an accurate free running oscillator.  If there is no
sync signal applied to the RDi 20 set “XESS=Disabled”.  With the appropriate
sync input selected, the “19” indicator on the front panel is lit blue to indicate
detection of the 19kHz pilot reference.  If “19” is lit red no sync signal is present
or the incorrect sync input is selected.

## 7.16. Configure Composite Phase

## [05] Output Phase
XEPH = n deg (setting range 0 - 359 deg; default is 0 deg)

The angle of phase lock between the pilot (sync) input and the RDS subcarrier
output is set using the “XEPH = n” command.  The full 360 degree range is
allowed.  This value is normally set to “0” (in phase operation) or sometimes “90”
(quadrature operation).






## - 15 -


## - 15 -
## ©2006 Broadcast Electronics Inc.
7.17. RDS Output Level Settings

[04] Output attenuation
XEDB = ?.? dB (setting range is 0 to 60 dB in 0.5 dB steps; default is 33.0 dB)

The RDS output level is adjusted using the “XEDB” command.  This command
sets the amount of attenuation (in 0.5 dB steps) applied to the RDS waveform.
The maximum output level of ~4.096 Vpp is achieved with zero attenuation:
“XEDB=0.0”  The larger the attenuation value the lower the resulting output
level.  The output defaults to a relatively low level of ~100mVpp achieved at
“XEDB=33.0” (33dB attenuation).  The output level is normally adjusted to
achieve a 3% injection level for the RDS subcarrier.

7.18. Save the Settings

[01] Save parameters to NVRAM
## XSAV

7.19. Set the Stations PI, PTY, PS, and DI Codes

7.19.1  Set the PI Code (Call letters)

Set the station PI code (Program Identification) using either “XPIC=xxxx” to enter
the 4 digit hexdecimal representation or “XPIT=text” to have the RDi 20
generate the hexdecimal representation using the station call sign (for US / RBDS
standard).

[10] PI code (by hexidecimal equivalent of call letters)
## XPIC = ????
- or -
[11] PI code (by call letters)
## XPIT = ????

7.19.2  Set the PTY Code

Set the PTY code (Programming Type) using the program types for RBDS (US standard).

[13] Program Type (PTY)
XPTY = ?? (see chart below; will default to 5 if using TRE)

## 1 = News 12 = Soft 23 = College
## 2 = Information 13 = Nostalgia 24 = Unassigned
## 3 = Sports 14 = Jazz 25 = Unassigned
## 4 = Talk 15 = Classical 26 = Unassigned
5 = Rock 16 = Rhythm and Blues 27 = Unassigned
6 = Classic Rock 17 = Soft R&B 28 = Unassigned
## 7 = Adult Hits 18 = Foreign Language 29 = Weather
## 8 = Soft Rock 19 = Religious Music 30 = Emergency Test
## 9 = Top 40 20 = Religious Talk 31 = Emergency
## 10 = Country 21 = Personality
## 11 = Oldies 22 = Public

Figure 9 – PTY Codes

## - 16 -


## ©2006 Broadcast Electronics Inc.

7.19.3  Set the PS Code

Set the static PS code (Program Service) limited to 8 characters.  Generally set as a
station’s slogan or other simple identifier.


[12] Program Service (PS)
XPSS = ???? (typically a station’s slogan or other simple identifier; may use up to
8 characters)

7.19.4  Set Decoder Identification (DI) Flags

Set the “DI” flags (Decoder Identification). “XFDI = Stereo” for stereo broadcasts
or “XFDI = Mono” otherwise.  (See RBDS standard for the description of
additional flag.)


[14] Decoder Identification (DI) flags
XFDI = (Stereo or Mono)  AH: (0 or 1)  CMP: (0 or 1)  (Static PTY or Dynamic PTY)

XFDI = Stereo   AH:0  CMP:0   Static PTY  (Defaults if using TRE)

7.20. Save the Settings

Navigate to the [01] programming menu,

[01] Save parameters to NVRAM
## XSAV

Next, depress the encoder wheel to save all settings to NVRAM.

7.21. Set Date and Time (UTC)

[08] Set date and time (UTC)
XUTC = mm/dd/yyyy   hh:mm.ss

7.22. Set Local Offset from UTC

[09] Set local offset from UTC
XOFS = ?.? hours

7.23. Set Music/Speech (MS) Flag

[15] Music/Speech (MS) flag
XFMS = Music (or Speech)

7.24. Set the Traffic Program (TP) Flag

[16] Program Type (TP) flag
XFTP = (settings may be Disabled or Enabled)


## - 17 -


## - 17 -
## ©2006 Broadcast Electronics Inc.
7.25. Enable MPX Back-Channel

[24] MPX back-channel
XFBC = (setting may be Disabled or Enabled)

7.26. Broadcast Time of Day

[25] Broadcast Time of Day
XFBT = (setting may be Disabled or Enabled; default is disabled)

7.27. Save the Settings

Navigate to the [01] programming menu,

[01] Save parameters to NVRAM
## XSAV

Next, depress the encoder wheel to save all settings to NVRAM.

## 7.28. Software Restart

After all desired programming changes have been made and saved to NVRAM.

Navigate to the [02] programming menu,

[02] Software restart
## XRES

Next, depress the encoder wheel to restart the RDi 20 software.

- Using TRE in Conjunction with the RDi 20

If you are using TRE (The Radio Experience) in conjunction with the RDi 20, certain
RDi 20 parameters will automatically be set by TRE upon initial power up.  These
default parameters are listed in this section.  If it desired, any of these parameters
may also be changed.

8.1. DPS White Space

[26] DPS white space
XFPW = (setting may be Disabled or Enabled; will default to Enabled if using TRE)

## 8.2. Short Radiotext

[27] Short radiotext
XFST = (setting may be Disabled or Enabled; will default to Disabled if using TRE)



## - 18 -


## ©2006 Broadcast Electronics Inc.
## 8.3. Radiotext Normal Blocks

[28] Radiotext normal blocks
XTNB = (setting may be 0 – 8; will default to 1 if using TRE)

## 8.4. Radiotext Burst Blocks

[29] Radiotext burst blocks
XTBB = (setting may be 0 – 8; will default to 8 if using TRE)

## 8.5. Radiotext Burst Cycles

[30] Radiotext burst cycles
XTBC = (setting may be 1 – 4; will default to 2 if using TRE)

8.6. PS Normal Blocks

[31] PS normal blocks
XPSN = (setting may be 1 – 16; will default to 4 if using TRE)

8.7. PS Blanking Cycles

[32] PS blanking cycles
XPSB = (setting may be 0 – 8; will default to 0 if using TRE)

8.8. DPS Scroll Advance

[33] DPS scroll advance
XPSA = (setting may be 0 – 8; will default to 8 if using TRE)

8.9. DPS Scroll Cycles

[34] DPS scroll cycles
XPSC = (setting may be 1 – 99; will default to 4 if using TRE)

8.10. DPS Scroll Delay

[35] DPS scroll delay
XPST = (setting may be 0 – 99; will default to 4 if using TRE)










## - 19 -


## - 19 -
## ©2006 Broadcast Electronics Inc.
- Configure the RDi 20 using a Serial Connection

You may also set RDi 20 system parameters via a serial connection using Hyper
Terminal if so desired.

9.1. Turn AC Power ON

Turn the AC Power Switch ON (located on the rear of the unit).

9.2. Connect a Personal Computer to the RDi 20

Step 1 - Connect a serial cable (not supplied) to the RDi 20 front panel Console
port and then to the serial port on a personal computer.

Step 2 – Launch Hyper Terminal by going to START -> ALL PROGRAMS ->
## ACCESSORIES -> COMMUNICATIONS -> HYPERTERMINAL.

Step 3 – The default telnet questions box will appear.  Select Yes if you want
Hyper Terminal to be your default telnet program.  Select No if you do
not want it to be.



## Figure 10 – Default Telnet Program Menu


Step 4 – Name the Connection, choose the Desktop Icon, then select OK.



## Figure 11 – Connection Description Menu



## - 20 -


## ©2006 Broadcast Electronics Inc.
Step 5 – Select the appropriate connection port (COM1 is the most common)
from the pull down.



## Figure 12 – Connect To Menu



Step 6 – Configure the port setting as shown below, select Apply, then OK.



## Figure 13 – Port Settings Menu





## - 21 -


## - 21 -
## ©2006 Broadcast Electronics Inc.
Step 7 – The Hyper Terminal window will appear.  Next, select
## FILE -> PROPERTIES.



## Figure 14 – Hyper Terminal Command Screen


Step 8 – The Connection Properties Menu will now appear.  Select the settings
tab.


## Figure 15 – Properties Menu



## - 22 -


## ©2006 Broadcast Electronics Inc.
Step 9 – The Settings Menu will now appear.  Next, select ASCII Setup and then
select OK.



## Figure 16 – Setting Menu

The Hyper Terminal is now ready to send commands to the RDi 20.

9.3. Setting the I.P. Address of the RDi 20

From the Hyper Terminal Screen, the command for entering the I.P. Address of
the RDi 20 is XIPA=

Example: An I.P. Address of 193.168.0.3, would be entered as

XIPA=193.168.0.3 <return>

Note: If the I.P. Address is accepted, a “+” will then appear on the next line.
If the I.P. Address is NOT accepted, a “!“ will appear on the next line.

To query the I.P. Address of the RDi 20 from Hyper Terminal, enter

XIPA? <return>

9.4. Setting the Subnet Mask of the RDi 20

From the Hyper Terminal Screen, the command for entering the I.P. Address of
the RDi 20 is XIPS=

Example: A Subnet Mask of 255.255.255.0, would be entered as

XIPS=255.255.255.0 <return>

Note: If the Subnet Mask is accepted, a “+” will then appear on the next line.
If the Subnet Mask is NOT accepted, a “!“ will appear on the next line.


## - 23 -


## - 23 -
## ©2006 Broadcast Electronics Inc.
To query the Subnet Mask of the RDi 20 from Hyper Terminal, enter

XIPS? <return>


9.5. Setting the Gateway of the RDi 20

If using a Gateway, from the Hyper Terminal Screen, the command for entering
the Gateway Address of the RDi 20 is XIPG=

Example: A Gateway Address of 10.10.10.2, would be entered as

XIPG=10.10.10.2 <return>

Note: If the Gateway Address is accepted, a “+” will then appear on the next line.
If the Gateway Address is NOT accepted, a “!“ will appear on the next line.

To query the Gateway Address of the RDi 20 from Hyper Terminal, enter

XIPG? <return>

9.6. Save the Settings

To save the settings made to the RDi, from the Hyper Terminal Screen enter

XSAV <return>

9.7. Set the UDP Port

It is necessary to set the UDP port that the RDi 20 listens to for incoming data.
This value must also be set on the controlling software.


The command form is as follows:

XIPP=n(:n.n.n.n)

Where the first “n” selects the UDP port number.  The presence of the “:” and
four additional numbers n.n.n.n sets a mask such that the RDi 20 will only listen
to UDP packets from a specific address or range of addresses.

To listen to port 16550 from any address starting with “192.168” enter
“XIPP=16550:192.168.*.*”  The “*” is a “match any” wildcard.

The more digits specified, the more restricted the range.  As such,
“XIPP=16550:192.168.1.137” sets the RDi 20 to listen to port 16550 but only
if the UDP packet originated at 192.168.1.137

9.8. Save the Settings

To save the settings made to the RDi, from the Hyper Terminal Screen enter

XSAV <return>



## - 24 -


## ©2006 Broadcast Electronics Inc.
9.9. MPX IN and MPX THRU Port Configuration

For installations where the RDi 20 will receive PAD as serial data at the MPX IN
port, it is necessary to configure the MPX port (using the XMCP command) to
match the configuration (baud rate, data bits, etc) of the STL or other source of
serial data.

This command simultaneously configures the MPX IN and MPX THRU ports.
The command also allows a variable number of parameters to be specified.  That
is to say, if only the first 3 parameters (mpx:sig,baud) are specified, only those 3
parameters will be altered.  Any unspecified parameters remain in their previous
state.

XMCP=(mpx:sig,baud,bits,par,stop)

## Where:

"mpx" = "-" for non-multiplexed data

## OR

"mpx" = "0-99" (a channel number) for multiplexed data


"sig" = "232 or 422" to select the type of electrical signaling

"baud" = "300 to 115200" to select the baud rate (typically "9600")

"bits" = "5 to 8" to select the number of data bits (typically "8")

"par" = "N,O,E" to select none, odd, or even parity (typically "N")

"stop" = "1 or 2" to select the number of stop bits (typically "1")


9.10. Save the Settings

To save the settings made to the RDi, from the Hyper Terminal Screen enter

XSAV <return>



9.11. Enabling RDS Group Generation

From the Hyper Terminal Screen, the command to enable group generation from
the RDI 20 is XENA= n <enter> (where “n” is either 1 or 0; see below for
explanation)

When “XENA=1” group generation is enabled and the actual RDS data appears
at the output.

When “XENA=0” group generation is disabled and an “all zero” modulation
appears at the output.  (That is to say, the subcarrier waveform is present but no

## - 25 -


## - 25 -
## ©2006 Broadcast Electronics Inc.
group data is being generated.  The RDS /RBDS standards consider "all zero"
modulation as the reference waveform for use when setting the RDS injection
level.)

Note:   If the command is accepted, a “+” will then appear on the next line.
If the command is NOT accepted, a “!“ will appear on the next line.

To query the RDS Group Generation setting, enter

XENA? <return>


9.12. Enabling RDS Subcarrier Output

The "XEBP" command defaults to the "1" state.  (That is to say that by default the
output is bypassed / no signal is present.)

To enable the RDS subcarrier output, set “XEBP=0”  The “57” indicator on the
front panel is lit blue when the RDS output is active.

Once this setting is made and the "XSAV" (save) command is issued, the unit now
defaults to the output enabled state.

If it is desired to fully disable the RDS subcarrier output of the RDi 20, set
“XEBP=1”  The “57” indicator on the front panel is lit red in the bypass (output
disabled) state.

9.13. Save the Settings

To save the settings made to the RDi, from the Hyper Terminal Screen enter

XSAV <return>


## 9.14. Configure Composite Sync

The active sync input is selected using the “XESS” command.  “XESS=1” selects
sync input 1, “XESS=2” selects sync input 2.  A third case “XESS=0” is provided
for monophonic broadcast (no stereo pilot.)  When “XESS=0” the RDi 20 phase
lock loop is disabled and the RDS subcarrier is generated using an accurate free
running oscillator.  If there is no sync signal applied to the RDi 20 set “XESS=0”.
With the appropriate sync input selected, the “19” indicator on the front panel is
lit blue to indicate detection of the 19kHz pilot reference.  If “19” is lit red no sync
signal is present or the incorrect sync input is selected.


## 9.15. Configure Composite Phase

The angle of phase lock between the pilot (sync) input and the RDS subcarrier
output is set using the “XEPH=n” command.  The full 360 degree range is
allowed.  This value is normally set to “0” (in phase operation) or sometimes “90”
(quadrature operation).



## - 26 -


## ©2006 Broadcast Electronics Inc.
9.16. RDS Output Level Settings

The RDS output level is adjusted using the “XEDB” command.  This command
sets the amount of attenuation (in 0.5 dB steps) applied to the RDS waveform.
The maximum output level of ~4.096 Vpp is achieved with zero attenuation:
“XEDB=0.0”  The larger the attenuation value the lower the resulting output
level.  The output defaults to a relatively low level of ~100mVpp achieved at
“XEDB=33.0” (33dB attenuation).  The output level is normally adjusted to
achieve a 3% injection level for the RDS subcarrier.


9.17. Save the Settings

To save the settings made to the RDi, from the Hyper Terminal Screen enter

XSAV <return>


9.18. Set the Station’s PI, PTY, PS, and DI Codes

Step 1 – Set the station PI code (Program Identification) using either
“XPIC=xxxx” to enter the 4 digit hexdecimal representation or “XPIT=text” to
have the RDi 20 generate the hexdecimal representation using the station call sign
(for US / RBDS standard).

Step 2 – Set the PTY code (Programming Type) using “XPTY=n”  The program
types for RBDS (US standard) are as follows:

## 1 = News 12 = Soft 23 = College
## 2 = Information 13 = Nostalgia 24 = Unassigned
## 3 = Sports 14 = Jazz 25 = Unassigned
## 4 = Talk 15 = Classical 26 = Unassigned
5 = Rock 16 = Rhythm and Blues 27 = Unassigned
6 = Classic Rock 17 = Soft R&B 28 = Unassigned
## 7 = Adult Hits 18 = Foreign Language 29 = Weather
## 8 = Soft Rock 19 = Religious Music 30 = Emergency Test
## 9 = Top 40 20 = Religious Talk 31 = Emergency
## 10 = Country 21 = Personality
## 11 = Oldies 22 = Public

Figure 17 – Program Identification (PTY) Codes

Step 3 – Set the static PS code (Program Service) using “XPSS=text”  (Limited to
8 characters.  Generally set as a station’s slogan or other simple identifier.)

Step 4 – Set a default radiotext message using “XTXT=text”

Step 5 – Set the “DI” flags (Decoder Identification) using the “XFDI=n”
command.  Normally, “XFDI=1” for stereo broadcasts or “XFDI=0” otherwise.
(See RBDS standard for additional flag values.)


## - 27 -


## - 27 -
## ©2006 Broadcast Electronics Inc.
9.19. Save the Settings

To save the settings made to the RDi, from the Hyper Terminal Screen enter

XSAV <return>

9.20. Restart the RDi

After completing the initial configuration and saving your changes, issue the
“XRES” command to restart the RDi 20 CPU.  Certain settings (such as the TCP/IP
configuration) only take effect when the RDi 20 CPU starts up.  As such, issuing
the “XRES” command will make these changes active.

From the Hyper Terminal screen, enter

XRES <return>

9.21. Point the Device Providing RDS Data to the RDi 20

Configure the device (B.E.’s TRE or Now Playing are examples) that is going to be
providing RDS data with the I.P. Address of the RDi 20.

9.22. Configure the Device Providing RDS Data to the RDi 20

The device providing data (B.E.’s TRE or Now Playing are examples) to the RDi 20
must be configured in order to send the desired text strings.  See the instruction
manual of your device for this configuration.


- A Note on System Settings

All of the system parameters are stored in a battery backed NVRAM.  The Lithium
battery that holds these parameters has a life of about 10 years.  The battery is
replaceable and the RDi 20 will enter a warning/fault state at power up if the
backup battery needs replacement.  In this state, the system parameters are
considered unreadable and the unit must "fail safe".  The default configuration is
therefore to bypass (disable) the RDS output.  (In addition to the low battery
signal, a CRC is also used to verify the NVRAM contents and thereby prevent the
RDi 20 from reading potentially corrupt system parameters.)













## - 28 -


## ©2006 Broadcast Electronics Inc.
- RDi 20 Hyper Terminal Commands

XVER?  (See RDi-20 Firmware versions)

Xnnn=value (to set a parameter)

Xnnn? (to query a parameter)

XCMD  (List Commands)

XVER  (display firmware version)

XRES   (reset CPU)

XSAV  (save parameters to NVRAM)

XENA=(0 or 1) enable data output

XEBP=(0 or 1) enable output bypass

XESS=(0 to 2) sync select (0=Disabled; 1=Input 1; 2=Input 2)

XEPH=(n) output phase, 1 degree step

XEDB=(n) output attenuation, 0.5dB step

XMCP=(mpx:sig,baud,bits,par,stop)
## Where:
"mpx" = "-" for non-multiplexed data
- or -
"mpx" = "0-99" (a channel number) for multiplexed data
"sig" = "232 or 422" to select the type of electrical signaling
"baud" = "300 to 115200" to select the baud rate (typically "9600")
"bits" = "5 to 8" to select the number of data bits (typically "8")
"par" = "N,O,E" to select none, odd, or even parity (typically "N")
"stop" = "1 or 2" to select the number of stop bits (typically "1")

XUTC=(yyyymmdd-hhmmss) set time as UTC

XOFS=(n.n) set local offset in hours

XIPA=(n.n.n.n) set IP address

XIPS=(n.n.n.n) set subnet mask

XIPG=(n.n.n.n) set gateway

XIPD=(n.n.n.n) set DNS server

XIPC=(n) set Telnet port

XIPH=(n) set HTTP port


## - 29 -


## - 29 -
## ©2006 Broadcast Electronics Inc.
XFDI=(0 - 15) set DI flags

XIPP=n(:n.n.n.n) whereas the first “n” selects the UDP Input 1 port number.  The
presence of the “:” and four additional numbers n.n.n.n sets a mask such that
the RDi 20 will only listen to UDP packets from a specific address or range of
addresses.

XIPX=n(:n.n.n.n) whereas the first “n” selects the UDP Input 2 port number.  The
presence of the “:” and four additional numbers n.n.n.n sets a mask such that
the RDi 20 will only listen to UDP packets from a specific address or range of
addresses.

XFMS=(0 or 1) set speech/music

XFTP=(0 or 1) set traffic program

XFBT=(0 or 1) enable time of day group

XFPW=(0 or 1) enable DPS white space

XFTA=(0 or 1) set traffic announcement

XPIC=( xxxx ) set PI code (hexdecimal)

XPIT=( text ) set PI code by call sign

XPTY=(0 - 31) set program type

XTXT=( text ) set radiotext

XTNB=(0 - 8) set RT normal blocks

XTBB=(0 - 16) set RT burst blocks

XTBC=(1 - 4) set RT burst cycles

XITD=(ch.xxxx.yyyy) insert transparent

XFST=(0 or 1) enable short RT groups

XPSS=( text ) set 8 character static PS

XPSD=( text ) set dynamic PS text

XPSN=(1 - 16) set PS normal blocks

XPSB=(0 - 8) set PS blanking cycles

XPSA=(0 - 8) set DPS scroll advance

XPSC=(1 - 99) set DPS scroll cycles

XPST=(0 - 99) set DPS scroll delay

## - 30 -


## ©2006 Broadcast Electronics Inc.
## 12. Firmware Upgrades

Step 1 – Locate the Upgrade CD or download the upgrade files from the B.E. website.  Copy
the files to the hard drive “C:\” of the PC you will be using to perform the upgrade.

Step 2 – Turn the AC Power Switch on the rear panel of the RDi 20 to OFF.

Step 3 – Next, establish communication via Hyper Terminal.  Connect a straight thru serial
cable (not supplied) to the RDi 20 front panel Console port and then to the serial
port on a personal computer.

Step 4 – Launch Hyper Terminal by going to START -> ALL PROGRAMS ->ACCESSORIES ->
## COMMUNICATIONS -> HYPERTERMINAL.

Step 5 – The default telnet question box may appear.  Select Yes if you want Hyper Terminal
to be your default telnet program.  Select No if you do not want it to be.



## Figure 18 – Default Telnet Program Menu


Step 6 – Name the Connection, choose the Desktop Icon, then select OK.



## Figure 19 – Connection Description Menu






## 1
## 2

## - 31 -


## - 31 -
## ©2006 Broadcast Electronics Inc.
Step 7 – Select the appropriate connection port (COM1 is the most common) from the
pull down, then select OK.



## Figure 20 – Connect To Menu



Step 8 – Configure the Port Settings as shown below, then select OK.



## Figure 21 – Port Settings Menu






## 1
## 2
## 1
## 2

## - 32 -


## ©2006 Broadcast Electronics Inc.
Step 9 – Next, turn the AC Power Switch on the rear panel of the RDi 20 to ON.  As
the RDi 20 comes up, the Hyper Terminal window will fill in as shown below.



Figure 22 – Hyper Terminal Screen after RDi 20 Power UP.



Step 10 – Type XRES <enter>, then type A <enter> (within 2 seconds) to go to into
programming mode (all typed commands must be UPPER case).  The nb>
prompt will appear as shown below.



Figure 23 – nb> Prompt


Step 11 – Next, at the nb> prompt, type FLA <enter> (to go the flash mode).



## - 33 -


## - 33 -
## ©2006 Broadcast Electronics Inc.
Step 12 – Select Transfer -> Send Text File from the pull down menu.




Figure 24 – Send Text File from Hyper Terminal



Step 13 – Browse to the directory where you copied the upgrade file, set file type filter to All files
(*.*), select the upgrade (.s19) file, then select Open.



Figure 25 – Browse to the Upgrade File



Step 14 – The upgrade file will now be downloaded to the RDi 20.  The Hyper Terminal screen
should now look as shown on the next page in Figure 26.  Characters will scroll
across the screen indicating download progress.  Please note that the download may
take several minutes.
## 2
## 3
## 1
## 2
## 1

## - 34 -


## ©2006 Broadcast Electronics Inc.


## Figure 26 – Download Started


Step 15 – When the upgrade is complete, the RDi 20 will automatically reset.  After the RDi 20
resets, the Hyper Terminal screen will look as shown below.



## Figure 27 – Firmware Upgrade Complete



Step 16 – Type XVER <enter>, as shown in Figure 28 on the next page, to verify that the
firmware was in fact upgraded.

In the example shown, the RDi 20 was upgraded to v0.152.

## - 35 -


## - 35 -
## ©2006 Broadcast Electronics Inc.


## Figure 28 – Firmware Upgrade Complete


Step 17 – Disconnect the serial cable from the RDi 20.




-  RF Customer Service Contact Information
RF Customer Service -
## Telephone:  (217) 224-9617
E-Mail:  rfservice@bdcast.com

## Fax:  (217) 224-9607



















## - 36 -


## ©2006 Broadcast Electronics Inc.
- Terms and Definitions

AAS Advanced Application Services
AES/EBU Audio Engineers Society/European Broadcast Union
AM                                              Amplitude                                              Modulation
CRC Cyclic Redunancy Code
DI Decoder Identification Setting
DPS Dynamic Program Service
EASU Exciter Auxiliary Service Unit
EOC Ensemble Operations Center
FM                                               Frequency                                               modulation
IBOC                                                In-Band                                                On-Channel
MF                                                  Medium                                                  Frequency
MPA Main Program Audio
MPS Main Program Service
NVRAM Non Volatile Random Access Memory
PS                                                     Program                                                     Service
PAD Program Associated Data
PTY                                                     Program                                                     Type
PTYN Program Type Name
PI                                                Program                                                Identification
QoS Quality of Service
SIS Station Information Service
SPS Supplemental Program Service
UTC Coordinated Universal Time
VHF                                                Very                                                High                                                Frequency
WAN                                                Wide                                                Area                                                Network
LAN                                                 Local                                                 Area                                                 Network
CM                                                Connection                                                Manager
LP                                                   Logistics                                                   Processor
RDi Broadcast Electronics’ RDS Subcarrier Generator
RDS Radio Data System (European Standard)
RBDS Radio Broadcast Data System (U.S. Standard)
IDi Broadcast Electronics’ brand name for an Importer
FSi Broadcast Electronics’ IBOC Signal Generator
FXi Broadcast Electronics’ Digital Exciter
XPi Broadcast Electronics’ Digital Exporter

Figure 29 - Terms and Definitions





## - 37 -


## - 37 -
## ©2006 Broadcast Electronics Inc.
## 15. Schematics


TXARTSADTRACTSADSRADCDARIARXATXBRTSBDTRBCTSBDSRBDCDBRIBRXBTXCRTSCDTRCCTSCDSRCDCDCRICRXCTXDRTSDDTRDCTSDDSRDDCDDRIDRXDU0TXU0RTSU0CTSU0RXU1TXU1RTSU1CTSU1RXRTSDCTSDDTRDU1TXU1RTSU1CTSU1RX
## RIARIBRICRIDDTRC
## DTRB
## TXC
## TXB
## RTSC
## RTSB
## CTSC
## CTSB
## RXC
## RXB
## DTRATXA
## U0TX
## RTSA
## U0RTS
## CTSA
## U0CTS
## RXA
## U0RX
## TXDRXD
CTDOCTDICTCKCTMSCFC0CFC1CFC2CFC3CFC4CFC5CFC6CFC7CFC8CFC9CFC10CFC11CFC12CFC13CFC14CFC15
## MGRNMREDCFC4
## AIOE
## CFC5CFC6
## RESO
## CFC7RESO
## CFC15GPO
## CFC10
## MGRN
## CFC11
## MRED
## CFC12CFC13
## CFC9
## CFC14
## CFC8
## CFC0CFC1AIOE
## GPO
## CTDICTCKCTMSCTDORESOCFC3CFC2
## HD0HD1HD2HD3HD4HD5HD6HD7HA1HA2HCSHRDHWRHRQDGPODTODTI
## HD0HD1HD2HD3HD4HD5HD6HD7RESOHA0HA1HA2HCSHRDHWRHRQDTIDTODGPOCFIGO
## CFIGO
## DSRADCDADSRBDCDBDSRCDCDCDSRDDCDD
## HA0FCON
## FCON
## LN
## E
## ABCD
## 115
## 230
Corcom "Chameleon" Power Entry ModulePS0SXDS60
## POWERCCT001
AC-AAC-BAC-CAC-DEarth
## +5D
## +3.3D
## +5A
## +15A
## -15A
## -5A
## FPROCCCT002
## MPROCCCT003
## AIOCCT004
## MPXIOCCT007
## SYNC5SYNC3
## Chassis
Green / YellowBlueWhiteBlackBrown
## PLLCCT005
## PPCLK
## NPCLK
## PDET
## AIOENA
## FPRST
## FPPGM
## FPSI
## FPSO
## FPIRQ
## FAD9FAD8RDSCLK
## FPLEDCCT008
## DSPCCT010
## AUXIOCCT011
## MCLK
## MCLKNPCLKPPCLK
## PLLEATTD
## RDSCLK
## SYRST
## SYNC3SYNC5
## +VUR
## MPXENAMPXINTXMPXINRTSMPXINRXMPXINCTSMPXINMD
## MPXTHMD
## MPXINTE
## MPXTHTX
## MPXTHRTS
## MPXTHRX
## MPXTHCTS
## RGENCCT012
## CONTX
## CONRTS
## CONRX
## CONCTS
## QBTN
## WDTICKDSRST
## MPXTHTEMPXREDMPXGRN
## AUX1MDAUX1RTSAUX1TXAUX1RXAUX1CTS
## AUX2TX
## AUX2RTS
## AUX2MD
## AUX2RX
## AUX2CTS
## GPOGPI1GPI2GPI3GPI4
## QBTN
## CONEN
## AIOENA
## MPXENA
## GPO
## DIOD
## DIOEAIOD
## AIOE
## RESO
## DGPO
## DGPI
## MPXGRN
## MPXRED
## S2RYS1RY
## DACCCT013
## SDAC[0..8]
## SDAC
## RDSRDS
## PDETPLLE
## PSYNCPSYNC
## FPWLED
## A2RTSXA2CTSX
## SYRST
## SDZRSDZLSDZRSDZLPCKE
## PCKE
## +1.8D
## SYRST
## TXA
## RTSA
## DTRA
## CTSA
## DSRA
## DCDA
## RIA
## RXA
## TXB
## RTSB
## DTRB
## CTSB
## DSRB
## DCDB
## RIB
## RXB
## TXC
## RTSC
## DTRC
## CTSC
## DSRC
## DCDC
## RIC
## RXC
## TXD
## RTSD
## DTRD
## CTSD
## DSRD
## DCDD
## RID
## RXD
## U0TX
## U0RTSU0CTS
## U0RX
## U1TX
## U1RTSU1CTS
## U1RX
CTDOCTDICTCKCTMSCFC0CFC1CFC2CFC3CFC4CFC5CFC6CFC7CFC8CFC9CFC10CFC11CFC12CFC13CFC14CFC15
## CTDOCTDICTCKCTMS
## HD0HD1HD2HD3HD4HD5HD6HD7
## HA0HA1HA2
## HCS
## HRD
## HWR
## HRQ
## DTI
## DTO
## HD0HD1HD2HD3HD4HD5HD6HD7HA0HA1HA2HCSHRDHWRHRQTOUTTINDGPOCFIGO
## CFIGO
## +3.3D
## TSEN
## FCON
## FCON

## 1
## J41BNC
## 1
## J43BNC
Sync / MPXInput 2RDS / MPXOutput
C41100pFC43100pF
## K42TQ2-5V
## SW41DPDT
## D46MMBD4448
## 1
## Q43VN10LF
## +5A
## R30100
## 56
## 7
## U41:BOP285
## R2710kx
## R2410kx
## R2310kx
## R35100
R2510kxR2610kx
C48100nF
## -15A
C4622uF
## +15A
C4722uF
C49100nF
## 32
## 1
## U41:A
## OP285
## G=1
## 2
## 4
## U42
## BUF634
R421.5kR32100
C4522pF
## R2810kx
## R431.5k
C4422pF
R401.5kR411.5k
C501uF
## R381k
## R2910k
## AIOENA
## PSYNC
## TP12AOUT
## TP11AIN
RDS Output Trim
## TP10AREF
## RDS
## 1
## J42BNC
Sync / MPXInput 1
C42100pF
## K41TQ2-L2-5V
## R2110kx
## R2210kx
## +5A
## D44MMBD4448D45MMBD4448
## 1
## Q41VN10LF
## S1RY
## 1
## Q42VN10LF
## S2RY
## D41SMBJ14CAD42SMBJ14CAD43SMBJ14CA
## 12
## 3
## U509:A74HCT08VCC=+5D
## 1213
## 11
## U509:D74HCT08VCC=+5D
R54910kR55010k
## R33100
## R34100
## R31100
## R36249
R37500R391.5k
Note: (no trim option)Omit R36, R37 and R38Install R39
## +5D
## Z10FBEADZ9FBEAD
C891uF
C102100nFC103100nF

## DTEDTE
## FGND
## 10
## LDCD
## 11
## LRD
## 12
## LTD
## 13
## LDTR
## 14
## LGND
## 15
## LDSR
## 16
## LRTS
## 17
## LCTS
## 18
## LRI
## 19
## UDCD
## 1
## URD
## 2
## UTD
## 3
## UDTR
## 4
## UGND
## 5
## UDSR
## 6
## URTS
## 7
## UCTS
## 8
## URI
## 9
## J602232-DTE9/DTE9
## C1+
## 1
## C1-
## 2
## C2+
## 28
## C2-
## 27
## VCC
## 26
## V+
## 3
## V-
## 15
## GND
## 14
## A1
## 4
## Y1
## 6
## Y2
## 11
## A2
## 13
## B1
## 5
## Z1
## 7
## Z2
## 10
## B2
## 12
## RA1
## 24
## DY1
## 22
## DY2
## 19
## RA2
## 17
## RB1
## 25
## DZ1/DE1
## 23
## DZ2/DE2
## 18
## RB2
## 16
## SEL1
## 8
## SEL2
## 9
## LB
## 21
## ON/OFF
## 20
## U602LTC1334
C610100nFC613100nF
## C612
100nF
## C611
100nF
## C614
100nF
## LC611
## EMI
## LC613
## EMI
## LC614
## EMI
## LC612
## EMI
## LC618
## EMI
## LC616
## EMI
## LC615
## EMI
## LC617
## EMI
## +5D
## +5D
## 12
## 3
## U603:A74HCT08VCC=+5D
## 45
## 6
## U603:B74HCT08VCC=+5D
## AUX1RXAUX1CTS
## AUX2CTS
## AUX2RX
## AUX1RTS
## AUX2RTS
## AUX2MD
R61910kR62010k
## AUX1MD
## +5D
Aux 1Aux 2
## 12
## 3
## U607:A74HCT08VCC=+5D
## 910
## 8
## U607:C74HCT08VCC=+5D
## 1213
## 11
## U607:D74HCT08VCC=+5D
## 45
## 6
## U607:B74HCT08VCC=+5D
## AUX1TXAUX2TX
## R615332
## R616332R613332
## R614332
## +5D
C61510uF
## K43TQ2-5V
## D47
## MMBD4448
## GPO
## 1
## Q44
## VN10LF
## R4910k
## 12345678
## J44CONN-SIL8
## GPI1GPI2GPI3GPI4
## GPI4GPI3GPI2GPI1GNDCOMNONC
R6171kR6181k
## R451k
## R461k
## R471k
## R481k
## 135
## 246
## J603CDIL6
## A2RTSX
## A2CTSX
## 4321
## 5678
RN60210k
## 1615
## 12
## 1413
## 34
## 1211
## 56
## 10
## 9
## 78
## U43PC847
## 165432
## RN412.2K
## +5A
## LC42
## EMI
## LC43
## EMI
## LC44
## EMI
## LC41
## EMI
C40100nF
## Z18FBEAD
C10110uF
## Z19FBEAD
## CFQU

## SDAC0SDAC1SDAC2SDAC3SDAC4SDAC5SDAC6SDAC7SDAC8
## 32
## 6
## U57NE5534
C651.8nF
## R61392
## R65475
C661.8nF
## R62392
## R66475
## 32
## 6
## U54NE5534
C5322pF
## R69750
C612.2nF
C73100nF
## -15A
## 32
## 6
## U55NE5534
C5422pF
## R70750
C622.2nF
C74100nF
## +15A
## DSDL
## 1
## DSDR
## 2
## DBCK
## 3
## PLRCK
## 4
## PDATA
## 5
## PBCK
## 6
## SCK
## 7
## MS
## 10
## MDI
## 11
## MC
## 12
## MDO
## 13
## RST
## 14
## VDD
## 9
## VCC2L
## 28
## DGND
## 8
## VCC2R
## 15
## AGND3L
## 27
## IOUTL-
## 26
## IOUTL+
## 25
## AGND2
## 24
## VCC1
## 23
## VCOML
## 22
## VCOMR
## 21
## IREF
## 20
## AGND1
## 19
## IOUTR-
## 18
## IOUTR+
## 17
## AGND3R
## 16
## U51DSD1796
C8210uF
C70100nF
## +3.3D
## SDAC[0..8]
C8010uF
C68100nF
C7910uF
C67100nF
## +5A
## R7110kx
C8110uF
C8710uF
C8810uF
C77100nF
C5833pF
C5622pF
C78100nF
Omit for LT1028
Omit for 5534
## RDS
## TP22COS
C8610uF
## R5810
C8510uF
## R5710
## 32
## 6
## U56NE5534
C631.8nF
## R59392
## R63475
C641.8nF
## R60392
## R64475
## 32
## 6
## U52NE5534
C5122pF
## R67750
C592.2nF
C71100nF
## -15A
## 32
## 6
## U53NE5534
C5222pF
## R68750
C602.2nF
C72100nF
## +15A
C75100nF
C5733pF
C5522pF
C76100nF
Omit for LT1028
Omit for 5534
## TP21RDS
C8410uF
## R5610
C8310uF
## R5510
C69100nF
## SDZL
## SDZR
## +5A
## +5A
## Z14FBEAD
## Z15FBEAD
## Z17FBEAD
## Z16FBEAD

## DSA[0..17]
## HAD[0..7]
## DSD[0..23]
## DSD7DSD6DSD5DSD4DSD3DSD2DSD1DSD0DSFCSDSWRDSRD
## DSA18DSFCSDSRDDSWRDSTADSBGDSBB
## DSA18
## DSRDDSFCSDSA18DSBG
## HAD0HAD1HAD2HAD3HAD4HAD5HAD6HAD7
DSA17DSA16DSA15DSA14DSA13DSA12DSA11DSA10DSA9DSA8DSA7DSA6DSA5DSA4DSA3DSA2DSA1DSA0
## SDAC5SDAC7SDAC6SDAC8SDAC4SDAC3SDAC2SDAC0SDAC1
## DSWRDSBBDSTA
## DSD[0..23]
## VCCD
## 129
## VCCD
## 119
## VCCD
## 111
## VCCD
## 103
## GNDD
## 130
## GNDD
## 120
## GNDD
## 112
## GNDD
## 104
## DSA[0..17]
## VCCA
## 86
## VCCA
## 80
## VCCA
## 74
## GNDA
## 96
## GNDA
## 87
## GNDA
## 81
## GNDA
## 75
## AA0
## 70
## AA1
## 69
## AA2
## 51
## CAS
## 52
## RD
## 68
## WR
## 67
## TA
## 62
## BR
## 63
## BG
## 71
## BB
## 64
## MODA/IRQA
## 137
## MODB/IRQB
## 136
## MODC/IRQC
## 135
## MODD/IRQD
## 134
## RESET
## 44
## VCCC
## 65
## VCCC
## 57
## EXTAL
## 55
## PINIT/NMI
## 61
## PCAP
## 46
## VCCP
## 45
## VCCQL
## 126
## VCCQL
## 91
## VCCQL
## 56
## VCCQL
## 18
## GNDP
## 47
## GNDQ
## 127
## GNDQ
## 90
## GNDQ
## 54
## GNDQ
## 19
## TDI
## 140
## TCK
## 141
## TDO
## 139
## TMS
## 142
## HAD[0..7]HAS/HA0
## 33
## HA8/HA1
## 32
## HA9/HA2
## 31
## HRW/HRD
## 22
## HDS/HWR
## 21
## HCS/HA10
## 30
## HOREQ/HTQR
## 24
## HACK/HRRQ
## 23
## GNDC
## 66
## GNDC
## 58
## MISO/SDA
## 144
## MOSI/HA0
## 143
## SS/HA2
## 2
## SCK/SCL
## 1
## HREQ
## 3
## VCCQH
## 20
## VCCQH
## 49
## VCCQH
## 95
## VCCH
## 38
## VCCS
## 8
## VCCS
## 25
## GNDH
## 39
## GNDS
## 9
## GNDS
## 26
## SCKT
## 14
## FST
## 12
## HCKT
## 16
## SCKR
## 15
## FSR
## 13
## HCKR
## 17
## SDO0/1SDO0
## 4
## SDO1/1SDO1
## 5
## SDO2/SDI3
## 6
## SDO3/SDI2
## 7
## SDO4/SDI1
## 10
## SDO5/SDI0
## 11
## 1SCKT
## 53
## 1FST
## 50
## 1SCKR
## 60
## 1FSR
## 59
## 1SDO4/1SDI1
## 138
## 1SDO5/1SDI0
## 48
## ADO
## 27
## ACI
## 28
## TIO0
## 29
## U201DSPB56367
C203100nF
C204100nF
C205100nF
C206100nF
C207100nF
C208100nF
C22110uF
## A0
## 12
## A1
## 11
## A2
## 10
## A3
## 9
## A4
## 8
## A5
## 7
## A6
## 6
## A7
## 5
## A8
## 27
## A9
## 26
## A10
## 23
## A11
## 25
## A12
## 4
## CE
## 22
## WE
## 31
## OE
## 24
## D0
## 13
## D1
## 14
## D2
## 15
## D3
## 17
## D4
## 18
## D5
## 19
## D6
## 20
## D7
## 21
## A13
## 28
## A14
## 29
## A15
## 3
## A16
## 2
## A17
## 30
## A18
## 1
## U202SST39SF040
## VCC=+3.3D
## +3.3D
## 1MC1
## 2
## 1MC2
## 3
## 1MC3/GCK1
## 5
## 1MC4
## 4
## 1MC5
## 6
## 1MC6/GCK2
## 8
## 1MC7/GCK3
## 7
## 1MC8
## 9
## 1MC9
## 11
## 1MC10
## 12
## 1MC11
## 13
## 1MC12
## 14
## 1MC13
## 18
## 1MC14
## 19
## 1MC15
## 20
## 1MC16
## 22
## 1MC17
## 24
## 2MC1
## 1
## 2MC2
## 44
## GTS1/2MC3
## 42
## 2MC4
## 43
## GTS2/2MC5
## 40
## GSR/2MC6
## 39
## 2MC7
## 38
## 2MC8
## 37
## 2MC9
## 36
## 2MC10
## 35
## 2MC11
## 34
## 2MC12
## 33
## 2MC13
## 29
## 2MC14
## 28
## 2MC15
## 27
## 2MC16
## 26
## 2MC17
## 25
## TCK
## 17
## TDI
## 15
## TDO
## 30
## TMS
## 16
## VCC
## VCC
## VCCIO
## GND
## GND
## GND
## U203
## XC9572XL-PC
## MCLK
## NPCLKPPCLK
## RDSCLK
## 1357
## 2468
## 9
## 10
## 11
## 12
## 13
## 14
## J201CDIL14
## R20510k
## R20710k
## R20610k
DSP JTAG / OnCE
## 12
## 3
## U204:A74VHC08VCC=+3.3D
## SYRST
C216100nF
C215100nF
C214100nF
## +3.3D
## SYNC3SYNC5
## 1213
## 11
## U204:D74VHC08VCC=+3.3D
## DSRST
## PCKE
## R203249
## DGPI
## 123
## J203CONN-SIL3
## +3.3D
## DGPO
## D201LED
## R204249
## 910
## 8
## U204:C74VHC08VCC=+3.3D
## R202249
## +3.3D
## +3.3D
## R20810k
## R20910k
## CPLD JTAG
C20115nF
## +1.8D
## 45
## 6
## U204:B74VHC08VCC=+3.3D
## +3.3D
## +3.3D
## 4321
## 5678
RN20410k
## 4321
## 5678
RN20510k
## +3.3D+3.3D
## HA0HA1HA2
## HCS
## HWR
## HRD
## HD7HD6HD5HD4HD3HD2HD1HD0
C21810uF
C21910uF
C22010uF
C209100nF
C210100nF
C212100nF
C217100nF
C213100nF
## JORST
## 4321
## 5678
RN20310k
## JOTRSJODEZ
## R21210k
## HRQ
## 4321
## 5678
RN20210k
## MODDMODCDTIDTO
## +3.3D
## +3.3D
## 4321
## 5678
RN20110k
## +3.3D
## TP7SMS
## R20110
## R21010k
## DSCLK
## DSCLK
## DSTIO
## DSTIO
## J202CONN-SIL6
## DNMI
## DNMI
C211100nF
## CFIGO
## MODBMODA
## ACI
## ADO
## 4321
## 5678
RN20610k
HostROM
## DSP

## J401CDIL34
C403100nF
C402100nF
C40110uF
## D407PDA54-12GWA
## D408PDA54-12GWA
## 3
## 2
## Q401MMBT3906
## 3
## 2
## Q402MMBT3906
## 3
## 2
## Q403MMBT3906
## 3
## 2
## Q404MMBT3906
## 3
## 2
## Q405MMBT3906
## 3
## 2
## Q406MMBT3906
## 3
## 2
## Q407MMBT3906
## 3
## 2
## Q408MMBT3906
## 3
## 2
## Q412VN10LF
## 3
## 2
## Q411VN10LF
## 3
## 2
## Q410VN10LF
## 3
## 2
## Q409VN10LF
## 3
## 2
## Q416VN10LF
## 3
## 2
## Q415VN10LF
## 3
## 2
## Q414VN10LF
## 3
## 2
## Q413VN10LF
## 4321
## 5678
RN40110k
## 4321
## 5678
RN40210k
## D401NSTM515ASD404NSTM515AS
Warning LEDMPX LEDRDS LEDLogo LEDEthernet LEDPilot LED
## R401392
## R402249
## R403475R408392
## R409249
## R410475R413392
## R414249
## R406392
## R407249
## R411392
## R412249
## R404392
## R405249
Note:LED circuit board is a break-awaysection of the main circuit board
## R41956.2
## R42056.2
## R42156.2
## R42256.2
## R41556.2
## R41656.2
## R41756.2
## R41856.2
## R4231k
## R4271k
## R4241k
## R4281k
## R4251k
## R4291k
## R4261k
## R4301k
## +5D
## D405NSTM515ASD402NSTM515ASD406NSTM515ASD403NSTM515AS

## LD7
## LD7
## LD6
## LD6
## LD5
## LD5
## LD4
## LD4
## LD3
## LD3
## LD2
## LD2
## LD1
## LD1
## LD0
## LD0
## LD7LD6LD5LD4LD3LD2LD1LD0
## LD0LD1LD2LD3LD4LD5LD6LD7
## LD7LD6LD5LD4LD3LD2LD1LD0
## LCDW
## FAD8
## LDELDC
## LDELDR
## LDELDD
## LCD0LCD1LCD2LCD3LCD4LCD5LCD6LCD7
## SC0SC1SC2SC3SC4SC5SC6SC7
## SR7SR6SR5SR4SR3SR2SR1SR0
## RDRPDRRDGPDGMPRENRMPGENG
## LCDR
LDEDPCSFPC4WLGWLBWLRRLGRLBRLRFPD6FPD5FPD4FPD3FPD2FPD1FPD0FPC3FPC2FAD9FPA7LDCLDRLDDLCDELCDRLCDWFPA0
## LCDELCD7
## DPSODPSIDPSSDPCKQEBQEAQBTNRBCKFPE3FPE2FPE1FPE0
## DPSIDPCKDPCS
## FRXDFTXD
## FPA0L
## FAD9FAD8
## FPE3FPE2FPE1FPE0DPCKDPSSDPSIDPSO
## LDCLDRLDDLCDRFPC2LFPA0LLDEFPD6FPD5FPD4DPCSFPD3FPD2FPD1FPD0
## FRSTFIRQFPA0FPC2FPC3FPC4
## FIRQFRST
## FRSTLFIRQLFPA0LFPC2LFPC3L
## MPRMPG
## QEBQEAQBTN
## FPD3
## FPE3FPE1FPE0
## LCDELCDW
## FPC3L
## FRSTL
## FPE2
## OSC1
## 52
## OSC2
## 53
## RST
## 49
## IRQ
## 48
## VDD
## 40
## VSSAD
## 10
## IS3/PTD6
## 24
## IS2/PTD5
## 23
## IS1/PTD4
## 22
## FAULT4/PTD3
## 21
## FAULT3/PTD2
## 20
## FAULT2/PTD1
## 19
## FAULT1/PTD0
## 18
## PTA0
## 55
## PTA1
## 56
## PTA2
## 57
## PTA3
## 58
## PTA4
## 59
## PTA5
## 60
## PTA6
## 61
## PTA7
## 62
## ATD0/PTB0
## 63
## ATD1/PTB1
## 64
## ATD2/PTB2
## 1
## ATD3/PTB3
## 2
## ATD4/PTB4
## 3
## ATD5/PTB5
## 4
## ATD6/PTB6
## 5
## ATD7/PTB7
## 6
## ATD8/PTC0
## 7
## ATD9/PTC1
## 8
## PTC2
## 13
## PTC3
## 14
## PTC4
## 15
## PTC5
## 16
## PTC6
## 17
## TCLKB/PTE0
## 32
## TCH0B/PTE1
## 33
## TCH1B/PTE2
## 34
## TCLKA/PTE3
## 35
## TCH0A/PTE4
## 36
## TCH1A/PTE5
## 37
## TCH2A/PTE6
## 38
## TCH3A/PTE7
## 39
PTF5/TxD
## 47
PTF4/RxD
## 46
## PTF3/MISO
## 45
## PTF2/MOSI
## 44
## PTF1/SS
## 43
## PTF0/SPSCK
## 42
## PWM6
## 31
## PWM5
## 30
## PWM4
## 28
## PWM3
## 27
## PWM2
## 26
## PWM1
## 25
## PWMGND
## 29
## VSS
## 41
## VSSCG
## 54
## CGMXFC
## 51
## VREFL
## 11
## VREFH
## 12
## VDDAD
## 9
## VDDCG
## 50
## U501MC68HC908MR16
## X5014.9152M
## R50110M
C50122pFC50222pF
C50415nF
C52210uF
C514100nF
C52110uF
C513100nF
C52010uF
C512100nF
## +5D
## D0
## 2
## D1
## 3
## D2
## 4
## D3
## 5
## D4
## 6
## D5
## 7
## D6
## 8
## D7
## 9
## Q0
## 19
## Q1
## 18
## Q2
## 17
## Q3
## 16
## Q4
## 15
## Q5
## 14
## Q6
## 13
## Q7
## 12
## LE
## 11
## OE
## 1
## U50274HC573VCC=+5D
## D0
## 2
## D1
## 3
## D2
## 4
## D3
## 5
## D4
## 6
## D5
## 7
## D6
## 8
## D7
## 9
## Q0
## 19
## Q1
## 18
## Q2
## 17
## Q3
## 16
## Q4
## 15
## Q5
## 14
## Q6
## 13
## Q7
## 12
## LE
## 11
## OE
## 1
## U50574HC573VCC=+5D
## D0
## 2
## D1
## 3
## D2
## 4
## D3
## 5
## D4
## 6
## D5
## 7
## D6
## 8
## D7
## 9
## Q0
## 19
## Q1
## 18
## Q2
## 17
## Q3
## 16
## Q4
## 15
## Q5
## 14
## Q6
## 13
## Q7
## 12
## LE
## 11
## OE
## 1
## U50474HC573VCC=+5D
## D0
## 2
## D1
## 3
## D2
## 4
## D3
## 5
## D4
## 6
## D5
## 7
## D6
## 8
## D7
## 9
## Q0
## 19
## Q1
## 18
## Q2
## 17
## Q3
## 16
## Q4
## 15
## Q5
## 14
## Q6
## 13
## Q7
## 12
## LE
## 11
## OE
## 1
## U50374HC573VCC=+5D
J502CDIL16C515100nF
## C523
10uF
## +5D
## R5173.0
## +5D
## J501CDIL34
## C524
10uF
## +5D
## C516
100nF
## R51010k
## CS
## 1
## SCK
## 2
## SI
## 3
## VSS
## 4
## PA0
## 5
## PW0
## 6
## PB0
## 7
## VDD
## 8
## U506MCP41010
C518100nF
## R51210k
## +5D
## R51610
## 1
## Q504VN10LF
## R51310k
## FPWLED
## R50510k
## D503SD101AWS
## FPRST
## 135
## 246
## J503CZIL6
C510100nF
## R5022k
## R5032k
## R5042k
C50510nF
C50610nF
C50710nF
Quadrature EncoderGH62A11-02-030C
To 40x2 LCD ModuleDMC-40202NY-LY-AFE
To LED board
## 12
## 11
## 13
## U507:D74HC125VCC=+5D
## 5
## 6
## 4
## U507:B74HC125VCC=+5D
## 2
## 3
## 1
## U507:A74HC125VCC=+5D
## 9
## 8
## 10
## U507:C74HC125VCC=+5D
## 1
## 2
## U508:A74HCT04VCC=+5D
## 5
## 6
## U508:C74HCT04VCC=+5D
## 13
## 12
## U508:F74HCT04VCC=+5D
## 9
## 8
## U508:D74HCT04VCC=+5D
## 11
## 10
## U508:E74HCT04VCC=+5D
## 3
## 4
## U508:B74HCT04VCC=+5D
## FPPGM
## 1
## Q501VN10LF
## FPSI
## FPSO
## R50910k
## +5D
## 1
## Q502VN10LF
## D501BZT52C4V7-7
## 1
## Q503VN10LF
## FPIRQ
## D502BZT52C8V2-7
## R51410k
## +VUR
## FAD9FAD8
## RDSCLK
## +5D
## R51510k
## 4321
## 5678
RN50110k
## 4321
## 5678
RN50210k
## 4321
## 5678
RN50510k
## 4321
## 5678
RN50610k
## +5D
## R50810k
## 4321
## 5678
RN50310k
## 4321
## 5678
RN50410k
## 1357
## 2468
## 9
## 10
## 11
## 12
## 13
## 14
## 15
## 16
## J505CDIL16
## 123
## J504CONN-SIL3
## MON08
## 4.912M9.824M
## QBTN
## 4321
## 5678
RN50710k
## MPXRED
## MPXGRN
## PDETPLLE
## 45
## 6
## U509:B74HCT08VCC=+5D
## SYRST
## 9
## 10
## 8
## U509:C74HCT08VCC=+5D
## R50610k
## SDZLSDZR
## PCKE
C508100nF
C509100nF
C51910uF
## R51110k
## D504SD101AWS
## R518332
## +VUR
## 1234
## J500MTA100-4
## FANG
C5032.2nF

## CFC[0..15]
## CFD[16..31]CFA[0..15]
## CFA0CFA1CFA2CFA3CFA4CFA5CFA6CFA7CFA8CFA9CFA10CFA11CFA12CFA13CFA14CFA15
CFD16CFD17CFD18CFD19CFD20CFD21CFD22CFD23CFD24CFD25CFD26CFD27CFD28CFD29CFD30CFD31
## A0A1A2A3A4A5A6A7A8A9A10A11A12A13A14A15D31
## A10A9A8A7A6A5A4A3A2A1A0
## A14A13A12A11A10A9
## D31
## A7
## D30
## A6
## D29
## A5
## D28
## A4
## D27
## A3
## D26
## A2
## D25
## A1
## D24
## A0
## D16D17D18D19D20D21D22D23D24D25D26D27D28D29D30
## A8
## D31
## D31
## D30
## D30
## D29
## D29
## D28
## D28
## D27
## D27
## D26
## D26
## D25
## D25
## D24
## D24A2A1A0
## XIORALECFRWCFCS2CFCS1CFOEFCD2
## CFCS3CFCS2CFCS1CFTIPCFCLKCFRWCFBS3CFBS2CFOECFTACFRO
## UCSAUCSBUCSCUCSDUINTAUINTBUINTCUINTD
## RTCE
## CFTIP
## A15
## ALE
## FCE1FCE2XIOWXIORFREG
## XIOW
## XIOR
## XIOR
## XIOW
## CFCLK
## FRES
## URES
## CFIR1CFIR3
## CFROA14
## A15
## A12
## A13
## A10
## A11
## XIOR
## XIOWA9
## A6
## A7
## A4
## A5
## A2
## A3
## A0
## A1
## D24
## D31
## D25D26
## D29D28
## A8D27
## CFIR3XPCSD30
## CFC15CFC14CFC13CFC12CFC11CFC10CFC9CFC8CFC7CFC6CFC5CFC4CFC3CFC2CFC1CFC0
## FRESURESCFIGOCFRWCFCS1CFCS2CFOECFBS2CFBS3CFTACFCS3
## CFRW
## XIOWCFTIPCFTAA14A13CFIR1
## CFIGO
## D28
## HCS
## D29
## UCSA
## D30
## UCSB
## D31
## UCSCUCSDRTCEUINTAUINTBUINTCUINTD
## XRCS
## CFROFREGXPCSFWAIXRCSFCE1
## D31D24D30D25D29D26D28D27HCSXIORXIOWA0A1A2D24D25D26D27
## UINTDFCD2UINTCFRDYUINTBFVS1UINTAFCD1
## XRCSFCE1XIOWXIOR
## FRDYFWAI
## UCSDUCSCUCSBUCSAHCSXPCSRTCEFCE2
## FCD2FCD1FVS1
## FCD1
## CFIR6
## CFIR6
## 1B0
## 2
## 1B1
## 3
## 1B2
## 5
## 1B3
## 6
## 1B4
## 8
## 1B5
## 9
## 1B6
## 11
## 1B7
## 12
## 1A0
## 47
## 1A1
## 46
## 1A2
## 44
## 1A3
## 43
## 1A4
## 41
## 1A5
## 40
## 1A6
## 38
## 1A7
## 37
## DIR1
## 1
## DIR2
## 24
## VCCVCC
## 2B0
## 13
## 2B1
## 14
## 2B2
## 16
## 2B3
## 17
## 2B4
## 19
## 2B5
## 20
## 2B6
## 22
## 2B7
## 23
## OE1
## 48
## OE2
## 25
## 2A0
## 36
## 2A1
## 35
## 2A2
## 33
## 2A3
## 32
## 2A4
## 30
## 2A5
## 29
## 2A6
## 27
## 2A7
## 26
## VCCVCC
## U303SN74ALVCH16245
## 1Q0
## 2
## 1Q1
## 3
## 1Q2
## 5
## 1Q3
## 6
## 1Q4
## 8
## 1Q5
## 9
## 1Q6
## 11
## 1Q7
## 12
## 1D0
## 47
## 1D1
## 46
## 1D2
## 44
## 1D3
## 43
## 1D4
## 41
## 1D5
## 40
## 1D6
## 38
## 1D7
## 37
## OE1
## 1
## OE2
## 24
## VCCVCC
## 2Q0
## 13
## 2Q1
## 14
## 2Q2
## 16
## 2Q3
## 17
## 2Q4
## 19
## 2Q5
## 20
## 2Q6
## 22
## 2Q7
## 23
## LE1
## 48
## LE2
## 25
## 2D0
## 36
## 2D1
## 35
## 2D2
## 33
## 2D3
## 32
## 2D4
## 30
## 2D5
## 29
## 2D6
## 27
## 2D7
## 26
## VCCVCC
## U302SN74ALVCH16373
## CFD[16..31]
## CFA[0..15]
## TIP
## 11
## R/W
## 4
## OE
## 8
## TA
## 13
## BS2
## 9
## BS3
## 10
## CS1
## 5
## CS2
## 6
## CS3
## 7
## RSTI
## 28
## RSTO
## 30
## CLK
## 31
## VCC
## GND
## GND
## VCC
## CFC[0..15]U0RX
## 53
## U0TX
## 54
## U1RX
## 71
## U1TX
## 72
## QSPICLK
## 75
## QSPIDO
## 78
## QSPIDI
## 77
## QSPICS0
## 80
## QSPICS1
## 90
## QSPICS2
## 85
## QSPICS3
## 76
## PWM1
## 82
## PWM2
## 84
## USBD-
## 91
## USBD+
## 94
## IRQ1
## 93
## IRQ3
## 95
## IRQ5
## 97
## PB2/TIN2
## 79
## PB3/TIN3
## 88
## PB4/TIN0
## 81
## TOUT0
## 86
## TIN1
## 87
## PA0
## 89
## PA1
## 92
## PA5
## 83
## IRQ6/PA15
## 98
## VCC
## GND
## GND
## VCC
## U301MOD5272
## RXA
## 7
## TXA
## 17
## RTSA
## 14
## CTSA
## 11
## DTRA
## 12
## DSRA
## 10
## DCDA
## 9
## RIA
## 8
## RXB
## 29
## TXB
## 19
## RTSB
## 22
## CTSB
## 25
## DTRB
## 24
## DSRB
## 26
## DCDB
## 27
## RIB
## 28
## RXC
## 41
## TXC
## 51
## RTSC
## 48
## CTSC
## 45
## DTRC
## 46
## DSRC
## 44
## DCDC
## 43
## RIC
## 42
## RXD
## 63
## TXD
## 53
## RTSD
## 56
## CTSD
## 59
## DTRD
## 58
## DSRD
## 60
## DCDD
## 61
## RID
## 62
## INTD
## 55
## INTC
## 49
## INTB
## 21
## INTA
## 15
## D0
## 66
## D1
## 67
## D2
## 68
## D3
## 1
## D4
## 2
## D5
## 3
## D6
## 4
## D7
## 5
## A0
## 34
## A1
## 33
## A2
## 32
## CSA
## 16
## CSB
## 20
## CSC
## 50
## CSD
## 54
## IOR
## 52
## IOW
## 18
## TXRDY
## 39
## RXRDY
## 38
## XTAL1
## 35
## XTAL2
## 36
## RESET
## 37
## INTN
## 65
## VCC
## VCC
## VCC
## VCC
## GND
## GND
## GND
## GND
## U305TL16C554
## A0
## 10
## A1
## 9
## A2
## 8
## A3
## 7
## A4
## 6
## A5
## 5
## A6
## 4
## A7
## 3
## A8
## 25
## A9
## 24
## A10
## 21
## A11
## 23
## A12
## 2
## CE
## 20
## WE
## 27
## OE
## 22
## D0
## 11
## D1
## 12
## D2
## 13
## D3
## 15
## D4
## 16
## D5
## 17
## D6
## 18
## D7
## 19
## VCC
## GND
## A13
## 26
## A14
## 1
## U304M48T35AV
## D0
## 21
## D1
## 22
## D2
## 23
## D3
## 2
## D4
## 3
## D5
## 4
## D6
## 5
## D7
## 6
## D8
## 47
## D9
## 48
## D10
## 49
## D11
## 27
## D12
## 28
## D13
## 29
## D14
## 30
## D15
## 31
## A0
## 20
## A1
## 19
## A2
## 18
## A3
## 17
## A4
## 16
## A5
## 15
## A6
## 14
## A7
## 12
## A8
## 11
## A9
## 10
## A10
## 8
## CE1
## 7
## CE2
## 32
## WE
## 36
## OE
## 9
## RESET
## 41
## REG
## 44
## CSEL
## 39
## IORD
## 34
## IOWR
## 35
## WP
## 24
## CD1
## 26
## CD2
## 25
## VS1
## 33
## READY
## 37
## VS2
## 40
## WAIT
## 42
## INPACK
## 43
## BVD2
## 45
## BVD1
## 46
## GND
## GND
## VCC
## VCC
## J301
## CFCARD
## +3.3D
C305100nF
C306100nF
## +3.3D
C303100nF
## +3.3D
## +3.3D
C304100nF
C307100nF
C308100nF
C32210uF
## +3.3D
C309100nF
C32310uF
## +3.3D
C310100nF
C311100nF
## +3.3D
C302100nF
C32010uF
## +3.3D
C301100nF
C31910uF
## 1MC1
## 2
## 1MC2
## 3
## 1MC3/GCK1
## 5
## 1MC4
## 4
## 1MC5
## 6
## 1MC6/GCK2
## 8
## 1MC7/GCK3
## 7
## 1MC8
## 9
## 1MC9
## 11
## 1MC10
## 12
## 1MC11
## 13
## 1MC12
## 14
## 1MC13
## 18
## 1MC14
## 19
## 1MC15
## 20
## 1MC16
## 22
## 1MC17
## 24
## 2MC1
## 1
## 2MC2
## 44
## GTS1/2MC3
## 42
## 2MC4
## 43
## GTS2/2MC5
## 40
## GSR/2MC6
## 39
## 2MC7
## 38
## 2MC8
## 37
## 2MC9
## 36
## 2MC10
## 35
## 2MC11
## 34
## 2MC12
## 33
## 2MC13
## 29
## 2MC14
## 28
## 2MC15
## 27
## 2MC16
## 26
## 2MC17
## 25
## TCK
## 17
## TDI
## 15
## TDO
## 30
## TMS
## 16
## VCC
## VCC
## VCCIO
## GND
## GND
## GND
## U307XC9572XL-PC
C316100nF
C317100nF
C32510uF
## R30310k
## R30110
## +3.3D
## D0
## 2
## D1
## 3
## D2
## 4
## D3
## 5
## D4
## 6
## D5
## 7
## D6
## 8
## D7
## 9
## Q0
## 18
## Q1
## 17
## Q2
## 16
## Q3
## 15
## Q4
## 14
## Q5
## 13
## Q6
## 12
## Q7
## 11
## OE1
## 1
## OE2
## 19
## U30874AC541VCC=+3.3D
## D301SD101AWS
C314100nF
C32410uF
## +3.3D
## R30210
## +3.3D
## SYRST
## 1357
## 2468
## 9
## 10
## 11
## 12
## 13
## 14
## 15
## 16
## 17
## 18
## 19
## 20
## 21
## 22
## 23
## 24
## 25
## 26
## 27
## 28
## 29
## 30
## 31
## 32
## 33
## 34
## 35
## 36
## 37
## 38
## 39
## 40
## J302CDIL40
TXARTSADTRACTSADSRADCDARIARXATXBRTSBDTRBCTSBDSRBDCDBRIBRXBTXCRTSCDTRCCTSCDSRCDCDCRICRXCTXDRTSDDTRDCTSDDSRDDCDDRIDRXD
## U0RXU1RX
## U0TXU1TX
## U0CTSU0RTSU1CTSU1RTS
C312100nF
C313100nF
## CTMS
## CTCK
## CTDI
## CTDO
## CFC15CFC14CFC13CFC12CFC11CFC10CFC9CFC8CFC7CFC6CFC5CFC4CFC3CFC2CFC1CFC0
## QCLK
## QDO
## QCS0QCS1
## QDI
## HRQ
## TOUT
## TIN
## HD0HD1HD2HD3HD4HD5HD6HD7HA0HA1HA2
## DGPO
## 4321
## 5678
RN30110k
## 4321
## 5678
RN30210k
## 4321
## 5678
RN30310k
## 4321
## 5678
RN30410k
## 4321
## 5678
RN30510k
## +3.3D
## 4321
## 5678
RN30610k
## R30410k
## +3.3D
## HCSHRDHWR
## +3.3D
## 4321
## 5678
RN30710k
## 4321
## 5678
RN30810k
## +3.3D
C315100nF
## OE
## 1
## Out
## 3
## GND
## 2
## VCC
## 4
## U30914.7456M
## CFIGO
## FCON
## D302SL22
## Xpansion

## DCE
## DTE
## UDCD
## 1
## URD
## 2
## UTD
## 3
## UDTR
## 4
## UGND
## 5
## UDSR
## 6
## URTS
## 7
## UCTS
## 8
## URI
## 9
## FGND
## 10
## LDCD
## 11
## LRD
## 12
## LTD
## 13
## LDTR
## 14
## LGND
## 15
## LDSR
## 16
## LRTS
## 17
## LCTS
## 18
## LRI
## 19
## J601232-DCE9/DTE9
## C1+
## 1
## C1-
## 2
## C2+
## 28
## C2-
## 27
## VCC
## 26
## V+
## 3
## V-
## 15
## GND
## 14
## A1
## 4
## Y1
## 6
## Y2
## 11
## A2
## 13
## B1
## 5
## Z1
## 7
## Z2
## 10
## B2
## 12
## RA1
## 24
## DY1
## 22
## DY2
## 19
## RA2
## 17
## RB1
## 25
## DZ1/DE1
## 23
## DZ2/DE2
## 18
## RB2
## 16
## SEL1
## 8
## SEL2
## 9
## LB
## 21
## ON/OFF
## 20
## U601LTC1334
C601100nFC604100nF
## C603
100nF
## C602
100nF
## C605
100nF
## K601TQ2-5VK602TQ2-5V
## +5D
## D601
## MMBD4448
## D602
## MMBD4448
## LC604
## EMI
## LC601
## EMI
## LC602
## EMI
## LC603
## EMI
## LC608
## EMI
## LC606
## EMI
## LC605
## EMI
## LC607
## EMI
## MPXENA
## MPXINTX
## +5D
## +5D
C60910uF
C607100nF
## +5D
## 1
## Q601
## VN10LF
## 1
## Q602
## VN10LF
## +5D
## MPX INMPX THRU
## 45
## 6
## U604:B74HCT08VCC=+5D
## 1213
## 11
## U604:D74HCT08VCC=+5D
## 910
## 8
## U603:C74HCT08VCC=+5D
## 1213
## 11
## U603:D74HCT08VCC=+5D
## 45
## 6
## U605:B74HCT32VCC=+5D
## 910
## 8
## U605:C74HCT32VCC=+5D
## 1213
## 11
## U605:D74HCT32VCC=+5D
## 12
## 3
## U605:A74HCT32VCC=+5D
## MPXTHTX
## MPXINRX
## MPXINCTSMPXTHCTS
## MPXTHRX
## MPXINRTSMPXTHRTS
C606100nF
## 9
## 8
## U606:D74HCT04VCC=+5D
## 5
## 6
## U606:C74HCT04VCC=+5D
## 11
## 10
## U606:E74HCT04VCC=+5D
## 3
## 4
## U606:B74HCT04VCC=+5D
## 13
## 12
## U606:F74HCT04VCC=+5D
## 1
## 2
## U606:A74HCT04VCC=+5D
## D603LED-RG5
## R601100R602100
## MPXINTEMPXTHTE
## 4321
## 5678
RN60110k
## MPXREDMPXGRN
## MPXTHMD
R61110kR61210k
## MPXINMD
## R61010k
## R606332R603332
## R605332R604332
## 12
## 3
## U604:A74HCT08VCC=+5D
## 910
## 8
## U604:C74HCT08VCC=+5D
R6081kR6071kR6091k
C608100nF

## X0
## 12
## X1
## 13
## Y0
## 2
## Y1
## 1
## Z0
## 5
## Z1
## 3
## XC
## 14
## YC
## 15
## ZC
## 4
## INH
## 6
## A
## 11
## B
## 10
## C
## 9
## U12274HC4053VCC=+5AVEE=-5AVSS=GND
C123100pF
## R15010kx
## 10
## 9
## 8
## U123:C
## TL074
## R15110kx
C124100pF
## 1213
## 14
## U123:D
## TL074
## R177182k
C1295.6nF
## R1362k
## R16110kx
C1411uF
## R1372k
## 32
## 1
## U121:A
## TL074
## R1382k
## +5A
C140100nF
VCXO Trim
## MCLK
## 56
## 7
## U123:B
## TL074
## D125BZT52C13-7
## D126BZT52C13-7
C1311nF
C14410uF
## 56
## 7
## U121:B
## TL074
## R1342k
## C128
5.6nF
## C127
5.6nF
PLL Phase Trim
## R1322k
## R15410kx
R15810kxR16410kx
## 1213
## 14
## U121:D
## TL074
## R1311.5k
C1265.6nF
## R1301k
C1255.6nF
## R17568.1k
## R13910kx
## R14010kx
## AGCCCT006
## VIN
## IOUT
## VFB
## 10
## 9
## 8
## U121:C
## TL074
## R17468.1k
C12122pF
## R17168.1k
## PSYNC
## NPCLK
## PPCLK
## PLLE
## R14810kx
## R14910kx
## R14610kx
## R14710kx
## R14110kx
## R14210kx
## PDET
## LOUT
## ATTD
C135100nF
## -15A
## +15A
C136100nF
## +15A
C133100nF
C134100nF
## -15A
## Z13FBEAD
## D121BZT52C4V7-7
## D122BZT52C4V7-7
## D123BZT52C4V7-7
## D124BZT52C4V7-7
## R1332k
## R15210kx
## R15310kx
C1421uF
R16310kxR16210kx
R15710kxR15610kxR15510kx
## R15910kx
## R16010kx
## R14510kx
## R1431k
## R1441k
## R17268.1k
## R17368.1k
## TP121ASYNC
## TP122ALEV
## TP124ADET
## TP123APLL
## Detector Phase Trim
Note:Install R171, R172 if AGCcircuit is not populated
## 9
## 10
## 8
## U126:C74HCT08VCC=+5A
## 45
## 6
## U126:B74HCT08VCC=+5A
## 12
## 3
## U126:A74HCT08VCC=+5A
## R17810kx
## R12110
## Z3FBEAD
## 1
## TP126NP
## 1
## TP127PP
## 1
## TP128PLLE
## R123249
## R1352k
## VC
## 1
## Out
## 8
## GND
## 7
## VCC
## 14
## U125BV1525AEM-21.888
## R125500
## R124500
## R126500
## 4321
## 5678
RN12110k
## Z6FBEAD
## Z4FBEAD
## Z5FBEAD
## Z11FBEADZ12FBEAD
C146100nF
C147100nF
## TDETCCT009
## SIGNAL
## LOCKLOCK
## R1291k
## R1281k
## +5A
## +5A
## +5A

C20100nF
C51000uF
C41000uF
## D41.5KE30A
C22100nF
C71000uF
C61000uF
## D51.5KE30A
## BR1W01GDI
C1310nFC1510nF
C1210nFC1410nF
## VIN
## 2
## VSW
## 1
## GND
## 4
## CB
## 3
## SYNC
## 5
## FB
## 6
## ON/OFF
## 7
## U1
## LM2670S-5.0
C1010nF
## D6SL22
L137uHSWS-2.24-37
C3433uF
## SYNC5
## D21.5KE15A
C16100nF
C12200uF
C31000uF
## D11N5400D31N5400
## AC-C
## AC-B
## AC-D
## AC-A
## Earth
## R3
## VE17P02750K
## R1
## VE17P02750K
## R2VE17P02750K
C17100nF
C3833uF
C3933uFT495D336K025AS
C3533uF
## VIN
## 2
## VSW
## 1
## GND
## 4
## CB
## 3
## SYNC
## 5
## FB
## 6
## ON/OFF
## 7
## U2
## LM2670S-3.3
C1110nF
## D7SL22
L237uHSWS-2.24-37
C3733uF
## SYNC3
C3633uFT495D336K025AS
C21100nF
C2710uF
C23100nF
C2810uF
C19100nF
C2610uF
C24100nF
## +5A
## +15A
## -15A
## -5A
## +5D
## +3.3D
R51kR41k
C8100pFC9100pF
## +VUR
C3222uFT495X226K035ASC3322uFT495X226K035AS
## VI
## 1
## VO
## 3
## GND
## 2
## U4NJM7815FA
## VI
## 2
## VO
## 3
## GND
## 1
## U5NJM7915FA
R810kxR910kx
## R1010kx
C22200uF
## VI
## 1
## VO
## 3
## GND
## 2
## U3NJM7805FA
C18100nF
## 43
## 8109576
## 21
## T1PFT24
## TP0DGND
## TP4+15ATP5-15A
## TP3+5A
## TP1+5DTP2+3.3D
## VIN
## 2
## OUT
## 4
## GND
## 3
## BIAS
## 5
## SD
## 1
## U6LP3891-1.8
C3010uF
C2910uF
C25100nF
## +5D
## R1110k
## D8SL22
## TP6+1.8D
## +1.8D
## +3.3D
## 13579
## J1MTA156-09X
R610kR710k
## +5A
C3110uF
## Z2FBEAD
L310uH
## Z1FBEAD
## HS1HS-D220
## 12
## J2MTA100-2
## +VUR
## FANG
## Vs
## GND
## Vout
## 2
## U7LM35
## +5D
## TSEN
## D9SL22
## 2
## Q12N4401
## R12332
## FCON

## DCD
## 1
## RD
## 2
## TD
## 3
## DTR
## 4
## SGND
## 5
## DSR
## 6
## RTS
## 7
## CTS
## 8
## RI
## 9
## FGND
## 10
## J604232-DCE9
## C1+
## 2
## C1-
## 4
## C2+
## 5
## C2-
## 6
## VCC
## 17
## V+
## 3
## V-
## 7
## GND
## 16
## R1IN
## 14
## R2IN
## 9
## T1OUT
## 15
## T2OUT
## 8
## R1OUT
## 13
## R2OUT
## 10
## T1IN
## 12
## T2IN
## 11
## EN
## 1
## SHDN
## 18
## U608SP3222
C620100nFC618100nF
## C621
100nF
## C619
100nF
## C617
100nF
## +5D
## LC622
## EMI
## LC621
## EMI
## LC623
## EMI
## LC624
## EMI
## +5D
## CONCTSCONRXCONRTSCONTX
## R621332R622332
## 45
## 6
## U609:B74HCT32VCC=+5D
## 12
## 3
## U609:A74HCT32VCC=+5D
## 9
## 10
## 8
## U609:C74HCT32VCC=+5D
## 1213
## 11
## U609:D74HCT32VCC=+5D
## +5D
## CONEN
## +5D
C62610uF
C623100nF
C624100nF
## Console
## PBRST
## 1
## VCC
## 2
## GND
## 3
## NMI
## 5
## ST
## 6
## RST
## 7
## IN
## 4
## WDS
## 8
## U610
## SP706
## R631182k
## R632221KR6331M
## +3.3D+VUR
## D
## 12
## Q
## 9
## CLK
## 11
## Q
## 8
## S
## 10
## R
## 13
## U611:B74HCT74VCC=+5D
## D
## 2
## Q
## 5
## CLK
## 3
## Q
## 6
## S
## 4
## R
## 1
## U611:A74HCT74VCC=+5D
## D605SD101AWS
## QBTN
## D608LED
## R625332
## 4321
## 5678
RN60410k
## +5D
## D609LED
## R626332
## R63010k
## WDTICK
C6161nF
C622100nF
## 12
## J605MTA100-2
## D
## 2
## Q
## 5
## CLK
## 3
## Q
## 6
## S
## 4
## R
## 1
## U612:A74HCT74VCC=+5D
## D
## 12
## Q
## 9
## CLK
## 11
## Q
## 8
## S
## 10
## R
## 13
## U612:B74HCT74VCC=+5D
## AIOENA
## MPXENA
## GPO
## 4321
## 5678
RN60610k
## +5D
## AIOE
## AIODDIOE
## DIOD
## D604SD101AWS
## D607LEDD606LED
## R624332R623332
## 135
## 246
## J101CDIL6
## 1213
## 11
## U126:D74HCT08VCC=+5A
R6281kR6291k
## D610LED
## R627332
## +5D
## 4321
## 5678
RN60510k
## 4321
## 5678
RN60310k
## 3
## 2
## Q603VN10LF
C625100nF
## +5A
## Z8FBEADZ7FBEAD
## ANDMPX
## POWAIO
## Reset
## TIC
## DOGCON
## AIOMPX
Note: populate R632 (monitor 3.3v supply)do not populate R633 (monitor VUR supply)

## 141315
## 12
## 10
## U91:BLM13700
## 342
## 5
## 7
## U91:ALM13700
R10368.1kR10268.1k
## VIN
## +15A
C95100nF
## R1121M
## R91100
## -15A
C96100nF
## IOUT
## R10010kx
## 1
## Q91MMBT3906
## 32
## 1
## U92:ATL074
## 56
## 7
## U92:BTL074
## 1213
## 14
## U92:DTL074
## 10
## 9
## 8
## U92:CTL074
## D93MMBD4448
C93100nF
## R9810kx
## R9710kx
## R108182k
## R931k
C1001uF
## D94BZT52C13-7
C991uF
## R9910kx
C94100nF
## LOUT
## R107182k
C92100nF
## R9410kx
## D91MMBD4448D92MMBD4448
## R9610kx
C9122pF
R106100kR105100k
## R104100k
## R9510kx
## VFB
C98100nFC97100nF
AGC Threshold
VCA Offset Null
## R109182k
## R110182k
## R111182k
## R92500
## R101100k
C901nF
## R11368.1k

## R166100k
## R167100k
## 32
## 1
## U123:A
## TL074
## VCC
## 1
## COMPI
## 8
## IN
## 2
## TR
## 12
## TC1
## 14
## TC2
## 13
## LDO
## 11
## VREF
## 10
## LDOQ
## 6
## LDF
## 3
## GND
## 4
## NC
## 9
## LDOQ
## 5
## DO
## 7
## U124XR2211
## R165100k
C12222pF
## R168100k
C139100nF
## R1801M
C1431uF
## R1791M
## R16910kx
## C138
100nF
## C130
5.6nF
C137100nF
## R12256.2
## +15A
C1321nF
C14510uF
## R17010kx
## R176100k
## R1811M
## TP125AFRQ
## Detector Frequency Trim
## R127500
## LOCKLOCK
## SIGNAL
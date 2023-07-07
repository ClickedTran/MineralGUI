## 🖼️ ICON
<div align="center">
<img src="https://github.com/Clickedtran/MineralGUI/blob/Master/icon.gif">
<br>

<img src="https://github.com/Clickedtran/MineralGUI/blob/Master/mineral.jpg" align="center">
<br>

<img src="https://github.com/Clickedtran/MineralGUI/blob/Master/icon.gif">
</div>
<br>

## 📖 Feature
- This is a plugin that allows players to create their own ore storage with unlimited quantities!
- Can disable/enable automatic storage mode
<br>

## 💬 Command
| **COMMAND** | **SUBCOMMAND** | **DESCRIPTION** |**ALIASES**|
| -- | -- | -- | -- |
| `/mineral`  |                | `MineralGUI Command` | `/mineral` |
| `/automine`  | `on` : `off`   | `AutoMine Command` | `/automine` `on/off` |
<br>

## 📝 Permission
<details>
<summary>Click To See Permission</summary>
  
- Use `mineralgui.command` to allows the player to open the `MineralGUI`
- Use `mineralgui.command.automine` to allows the player to turn on/off automatic mode on `MineralGUI`
</details>
<br>

## 💾 Config
<details>
<summary>Click To See Config</summary>
  
```yaml
---
economy:
 provider: bedrockeconomy
...
```
</details>
<br>

## 📜 Sell List
<details>
<summary>Click To See Sell List</summary>
  
```yaml
---
cobblestone: "2.0"
lapis: "5.0"
redstone: "3.0"
coal: "2.0"
raw_iron: "4.0"
raw_gold: "4.0"
diamond: "7.0"
emerald: "8.0"
lapis_block: "45.0"
redstone_block: "27.0"
coal_block: "18.0"
iron_block: "36"
gold_block: "36.0"
diamond_block: "63.0"
emerald_block: "72.0"

multip: 1 #Please do not set to 0, let it be 1 or other number, ALWAYS NOT SET TO 0
...
```
</details>
<br>

## 📑 Message List
<details>
<summary>Click To See All Message</summary>
  
```yaml
---
prefix: "§l§a[ §bMINERALGUI §a] "

menu:
 name: "§l§cM I N E R A L G U I"
 list_ore: "§l§a===§bLIST OF ALL YOUR ORE§a===\n§9＞ §bCOBBLESTONE: §d{cobblestone}\n§9＞ §bLAPIS: §d{lapis}\n§9＞ §bCOAL: §d{coal}\n§9＞ §bREDSTONE: §d{redstone}\n§9＞ §bIRON RAW: §d{iron_ore}\n§9＞ §bGOLD RAW: §d{gold_ore}\n§9＞ §bDIAMOND: §d{diamond}\n§9＞ §bEMERALD: §d{emerald}"
 list_block: "§l§a===§bLIST OF ALL YOUR BLOCK§a===\n§9＞ §bCOBBLESTONE: §d{cobblestone}\n§9＞ §bLAPIS BLOCK: §d{lapis_block}\n§9＞ §bCOAL_BLOCK: §d{coal_block}\n§9＞ §bREDSTONE: §d{redstone_block}\n§9＞ §bIRON BLOCK: §d{iron_block}\n§9＞ §bGOLD BLOCK: §d{gold_block}\n§9＞ §bDIAMOND BLOCK: §d{diamond_block}\n§9＞ §bEMERAL BLOCK: §d{emerald_block}"
 exit: "§l§cEXIT"
 back: "§l§cBack Menu"

add_successfully: "§l§aYou have deposited §9{amount} §ainto Mineral"
add_fail: "§l§cYou don't have enough in your inventory"

withdraw_successfully: "§l§aYou have withdraw §9{amount}§a from Mineral"
withdraw_fail: "§l§cYou don't have enough in your mineral!"
 
sell-message: "§l§aYou have successfully sold all the ore in your inventory, the amount: §9{total_price}§l§a has been added to your account!"

Inventory-Full: "§l§cYour inventory is full, please try again"
...
```
</details>
<br>

## Virion and Plugin Support
- [InvMenu](https://github.com/muqsit/InvMenu)(muqsit)
- [pmforms](https://github.com/dktapps-pm-pl/pmforms)(dktapps)
- [BedrockEconomy](https://github.com/cooldogepm/BedrockEconomy)(cooldogepm)
- [DEVirion](https://github.com/poggit/devirion)(SOF3)
<br>

## Install
>- Step 1: Click the `Direct Download` button to download the plugin
>- Step 2: move the file `MineralGUI.phar` into the file `plugins`
>- Step 3: Restart server


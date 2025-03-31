<?php

/**
*░█████╗░██╗░░░░░██╗░█████╗░██╗░░██╗███████╗██████╗░████████╗██████╗░░█████╗░███╗░░██╗
*██╔══██╗██║░░░░░██║██╔══██╗██║░██╔╝██╔════╝██╔══██╗╚══██╔══╝██╔══██╗██╔══██╗████╗░██║
*██║░░╚═╝██║░░░░░██║██║░░╚═╝█████═╝░█████╗░░██║░░██║░░░██║░░░██████╔╝███████║██╔██╗██║
*██║░░██╗██║░░░░░██║██║░░██╗██╔═██╗░██╔══╝░░██║░░██║░░░██║░░░██╔══██╗██╔══██║██║╚████║
*╚█████╔╝███████╗██║╚█████╔╝██║░╚██╗███████╗██████╔╝░░░██║░░░██║░░██║██║░░██║██║░╚███║
*░╚════╝░╚══════╝╚═╝░╚════╝░╚═╝░░╚═╝╚══════╝╚═════╝░░░░╚═╝░░░╚═╝░░╚═╝╚═╝░░╚═╝╚═╝░░╚══╝
*
*                                                              Copyright (C) 2025-2026 ClickedTran
*/

declare(strict_types=1);

namespace ClickedTran\mineral\gui;

use Closure;
use pocketmine\item\StringToItemParser;

use pocketmine\player\Player;

use ClickedTran\mineral\libs\muqsit\invmenu\InvMenu;
use ClickedTran\mineral\libs\muqsit\invmenu\transaction\InvMenuTransaction; 
use ClickedTran\mineral\libs\muqsit\invmenu\transaction\InvMenuTransactionResult;

use ClickedTran\mineral\Mineral;
use ClickedTran\mineral\language\LanguageManager;
use ClickedTran\mineral\manager\MineralManager;
use ClickedTran\mineral\sound\SoundEffect;

class GUIManager{
	
	/**	
  * Menu ALL ORE
  * @param Player $player
  */
  public function openMenu(Player $player) : void{
    
    $plugin = Mineral::getInstance();
    $manager = MineralManager::getInstance();
    $menu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
    $menu->readonly();
    $menu->setName
    (
      LanguageManager::getTranslate
      (
       "mineral.menu.name"
      )
   );
   $inv = $menu->getInventory();
   $items = StringToItemParser::getInstance();
   
   for($i = 0; $i <= 9; $i++){
        $inv->setItem($i, $items->parse("iron_bars")->setCustomName("§l§r "));
   }
   
    $inv->setItem(13, $items->parse("cobblestone")
        ->setLore
        ([
          LanguageManager::getTranslate
          (
            "mineral.menu.lore",
            [(string)$manager->get($player, "cobblestone")]
          )
        ])
    );
   
    $inv->setItem(17, $items->parse("iron_bars")->setCustomName("§l§r "));
    $inv->setItem(18, $items->parse("iron_bars")->setCustomName("§l§r "));
   
    $inv->setItem(19, $items->parse("lapis_block")
        ->setLore
        ([
          LanguageManager::getTranslate
          (
            "mineral.menu.lore",
            [(string)$manager->get($player, "lapis lazuli block")]
          )
        ])
    );
   
   $inv->setItem(20, $items->parse("redstone_block")
        ->setLore
        ([
          LanguageManager::getTranslate
          (
            "mineral.menu.lore",
            [(string)$manager->get($player, "redstone block")]
          )
        ])
    );
  
    $inv->setItem(21, $items->parse("coal_block")
        ->setLore
        ([
          LanguageManager::getTranslate
          (
            "mineral.menu.lore",
            [(string)$manager->get($player, "coal block")]
          )
        ])
    );
   
    $inv->setItem(22, $items->parse("iron_block")
        ->setLore
        ([
          LanguageManager::getTranslate
          (
            "mineral.menu.lore",
            [(string)$manager->get($player, "iron block")]
          )
        ])
    );
   
    $inv->setItem(23, $items->parse("gold_block")
        ->setLore
        ([
          LanguageManager::getTranslate
          (
            "mineral.menu.lore",
            [(string)$manager->get($player, "gold block")]
          )
        ])
    );
   
    $inv->setItem(24, $items->parse("emerald_block")
        ->setLore
        ([
          LanguageManager::getTranslate
          (
            "mineral.menu.lore",
            [(string)$manager->get($player, "emerald block")]
          )
        ])
    );
   
    $inv->setItem(25, $items->parse("diamond_block")
        ->setLore
        ([
          LanguageManager::getTranslate
          (
            "mineral.menu.lore",
            [(string)$manager->get($player, "diamond block")]
          )
        ])
    );
   
    $inv->setItem(26, $items->parse("iron_bars")->setCustomName("§l§r "));
    $inv->setItem(27, $items->parse("iron_bars")->setCustomName("§l§r "));
   
    $inv->setItem(28, $items->parse("lapis_lazuli")
        ->setLore
        ([
          LanguageManager::getTranslate
          (
            "mineral.menu.lore",
            [(string)$manager->get($player, "lapis lazuli")]
          )
        ])
    );
   
    $inv->setItem(29, $items->parse("redstone_dust")
        ->setLore
        ([
          LanguageManager::getTranslate
          (
            "mineral.menu.lore",
            [(string)$manager->get($player, "redstone")]
          )
        ])
    );
  
    $inv->setItem(30, $items->parse("coal")
        ->setLore
        ([
          LanguageManager::getTranslate
          (
            "mineral.menu.lore",
            [(string)$manager->get($player, "coal")]
          )
        ])
    );
   
    $inv->setItem(31, $items->parse("raw_iron")
        ->setLore
        ([
          LanguageManager::getTranslate
          (
            "mineral.menu.lore",
            [(string)$manager->get($player, "raw iron")]
          )
        ])
    );
   
    $inv->setItem(32, $items->parse("raw_gold")
        ->setLore
        ([
          LanguageManager::getTranslate
          (
            "mineral.menu.lore",
            [(string)$manager->get($player, "raw gold")]
          )
        ])
    );
   
    $inv->setItem(33, $items->parse("emerald")
        ->setLore
        ([
          LanguageManager::getTranslate
          (
            "mineral.menu.lore",
            [(string)$manager->get($player, "emerald")]
          )
        ])
    );
   
    $inv->setItem(34, $items->parse("diamond")
        ->setLore
        ([
          LanguageManager::getTranslate
          (
            "mineral.menu.lore",
            [(string)$manager->get($player, "diamond")]
          )
        ])
    );
   
    $inv->setItem(35, $items->parse("iron_bars")->setCustomName("§l§r "));
    $inv->setItem(36, $items->parse("iron_bars")->setCustomName("§l§r "));
   
    for($i = 44; $i <= 47; $i++){
        $inv->setItem($i, $items->parse("iron_bars")->setCustomName("§l§r "));
    }
    
    if($manager->getAutoMode($player) === false){
      $inv->setItem(48, $items->parse("red_wool")
         ->setCustomName
         (
           LanguageManager::getTranslate
           (
             "mineral.menu.automatic-mode",
             ["false"]
           )
         )
      );
    }else{
      $inv->setItem(48, $items->parse("lime_wool")
         ->setCustomName
         (
           LanguageManager::getTranslate
           (
             "mineral.menu.automatic-mode",
             ["true"]
           )
         )
      );
    }
   
    $inv->setItem(49, $items->parse("barrier")
        ->setCustomName
         (
           LanguageManager::getTranslate
           (
             "mineral.menu.exit"
           )
        )
    );
   
    $inv->setItem(50, $items->parse("emerald")
         ->setCustomName
         (
           LanguageManager::getTranslate
           (
             "mineral.menu.sellall"
           )
         )
      );
   
    for($i = 51; $i <= 53; $i++){
        $inv->setItem($i, $items->parse("iron_bars")->setCustomName("§l§r "));
    }
    
    $menu->setListener(function(InvMenuTransaction $transaction) use ($manager, $player): InvMenuTransactionResult{
      $inv = $transaction->getAction()->getInventory();
      $item = $transaction->getItemClicked();
      
      if($transaction->getAction()->getSlot() === 48){
        if($player->hasPermission("mineral.command.automatic")){
          $manager->changeAutoMode($player);
          $player->removeCurrentWindow();
        }else{
          $manager->sendMSG
          (
            $player,
            LanguageManager::getTranslate
            (
              "mineral.permission"
            )
          );
          $player->removeCurrentWindow();
        }
        return $transaction->discard();
      }
        
      switch($item->getCustomName()){
        case LanguageManager::getTranslate("mineral.menu.sellall"):
          $manager->sellAll($player);
          $player->removeCurrentWindow();
        break;
        
        case LanguageManager::getTranslate("mineral.menu.exit"):
          $player->removeCurrentWindow();
        break;
        case "§l§r ":
        break;
        
        default:
          $this->menuOption($player, $item);
          SoundEffect:: sendNextMenu($player);
        break;
      }
      return $transaction->discard();
    });
   
    $menu->send($player);
  }
  
  public function menuOption(Player $player, $item){
    $items = StringToItemParser::getInstance();
    $manager = MineralManager::getInstance();
    $menu = InvMenu::create(InvMenu::TYPE_HOPPER);
    $inv = $menu->getInventory();
    $menu->readonly();
    
    $menu->setName
    (
      LanguageManager::getTranslate
      (
        "mineral.menu.option.name",
        [strtoupper($item->getName())]
      )
    );
    
    $inv->setItem(0, $items->parse("hopper")
        ->setCustomName
        (
          LanguageManager::getTranslate
          (
            "mineral.menu.option.withdraw"
          )
        )
    );
    
    $inv->setItem(2, $items->parse("anvil")
        ->setCustomName
        (
          LanguageManager::getTranslate
          (
            "mineral.menu.option.deposit"
          )
        )
    );
    
    $inv->setItem(4, $items->parse("emerald")
        ->setCustomName
        (
          LanguageManager::getTranslate
          (
            "mineral.menu.option.sell"
          )
        )
    );
    
    $menu->setListener(function(InvMenuTransaction $transaction) use ($manager, $player, $item) : InvMenuTransactionResult{
      
      switch($transaction->getAction()->getSlot()){
        case 0:
          $manager->sendMSG
          (
            $player,
            LanguageManager::getTranslate
            (
              "mineral.menu.option.message.withdraw"
            )
          );
          $manager->withdraw[$player->getName()] = $item;
          $player->removeCurrentWindow();
        break;
        
        case 2:
          $manager->sendMSG
          (
            $player,
            LanguageManager::getTranslate
            (
              "mineral.menu.option.message.deposit"
            )
          );
          $manager->deposit[$player->getName()] = $item;
          $player->removeCurrentWindow();
        break;
        
        case 4:
          $manager->sendMSG
          (
            $player,
            LanguageManager::getTranslate
            (
              "mineral.menu.option.message.sell"
            )
          );
          $manager->sold[$player->getName()] = $item;
          $player->removeCurrentWindow();
        break;
      }
      return $transaction->discard();
    });
    $menu->send($player);
  }
}

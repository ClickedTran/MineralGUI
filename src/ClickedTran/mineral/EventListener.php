<?php

/**
*░█████╗░██╗░░░░░██╗░█████╗░██╗░░██╗███████╗██████╗░████████╗██████╗░░█████╗░███╗░░██╗
*██╔══██╗██║░░░░░██║██╔══██╗██║░██╔╝██╔════╝██╔══██╗╚══██╔══╝██╔══██╗██╔══██╗████╗░██║
*██║░░╚═╝██║░░░░░██║██║░░╚═╝█████═╝░█████╗░░██║░░██║░░░██║░░░██████╔╝███████║██╔██╗██║
*██║░░██╗██║░░░░░██║██║░░██╗██╔═██╗░██╔══╝░░██║░░██║░░░██║░░░██╔══██╗██╔══██║██║╚████║
*╚█████╔╝███████╗██║╚█████╔╝██║░╚██╗███████╗██████╔╝░░░██║░░░██║░░██║██║░░██║██║░╚███║
*░╚════╝░╚══════╝╚═╝░╚════╝░╚═╝░░╚═╝╚══════╝╚═════╝░░░░╚═╝░░░╚═╝░░╚═╝╚═╝░░╚═╝╚═╝░░╚══╝
*
*                                                              Copyright (C) 2023-2024 ClickedTran
*/

declare(strict_types=1);

namespace ClickedTran\mineral;

use pocketmine\event\Event;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\player\Player;

use pocketmine\utils\Config;

use pocketmine\block\BlockTypeIds;

use pocketmine\item\Item;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\data\bedrock\EnchantmentIds;
use pocketmine\data\bedrock\EnchantmentIdMap;

use ClickedTran\mineral\Mineral;

class EventListener implements Listener{
  public $data;
  
  public function __construct(){}
  
  public function onBreak(BlockBreakEvent $event): void{
    $block = $event->getBlock();
    $player = $event->getPlayer();
    $name = $player->getName();
    
    $this->data = Mineral::getInstance()->getData($player);
    
    $message = Mineral::getInstance()->getMessage();
    $prefix = Mineral::getInstance()->getMessage()->get("prefix");
    $auto = Mineral::getInstance()->getAuto();
    
   $level = $player->getInventory()->getItemInHand()->getEnchantmentLevel(EnchantmentIdMap::getInstance()->fromId(18)) + 1;

    if(!$event->isCancelled()){
     if($auto->get($player->getName()) == "on"){
      if($player->isCreative(true)){
         return;
      }else{
        /* LAPIZ */
        if($block->getTypeId() == BlockTypeIds::LAPIS_LAZULI_ORE){
          $event->setDrops(array());
          $id = mt_rand(1, $level);
          $this->data->set(Mineral::LAPIS, ($this->data->get(Mineral::LAPIS) + ($id * 4)));
          $this->data->save();
        }
        /* LAPIZ BLOCK */
        if($block->getTypeId() == BlockTypeIds::LAPIS_LAZULI){
           $event->setDrops(array());
           $this->data->set(Mineral::LAPIS_BLOCK, ($this->data->get(Mineral::LAPIS_BLOCK) + 1));
           $this->data->save();
        }
        /* COAL */
        if($block->getTypeId() == BlockTypeIds::COAL_ORE){
           $event->setDrops(array());
           $id = mt_rand(1, $level);
           $this->data->set(Mineral::COAL, ($this->data->get(Mineral::COAL) + ($id * 4)));
           $this->data->save();
        }
        /* COAL BLOCK */
        if($block->getTypeId() == BlockTypeIds::COAL){
           $event->setDrops(array());
           $this->data->set(Mineral::COAL_BLOCK, ($this->data->get(Mineral::COAL_BLOCK) + 1));
           $this->data->save();
        }
        /* IRON ORE */ 
        if($block->getTypeId() == BlockTypeIds::IRON_ORE){
          $event->setDrops(array());
          $id = mt_rand(1, $level);
          $this->data->set(Mineral::IRON_ORE, ($this->data->get(Mineral::IRON_ORE) + $id));
          //I DON'T USE IRON INGOT BECAUSE THAT IS AUTO SMELTING
          $this->data->save();
        }
        /* IRON BLOCK */
        if($block->getTypeId() == BlockTypeIds::IRON){
           $event->setDrops(array());
           $this->data->set(Mineral::IRON_BLOCK, ($this->data->get(Mineral::IRON_BLOCK) + 1));
           $this->data->save();
        }
        /* GOLD ORE */
        if($block->getTypeId() == BlockTypeIds::GOLD_ORE){
           $event->setDrops(array());
           $id = mt_rand(1, $level);
           $this->data->set(Mineral::GOLD_ORE, ($this->data->get(Mineral::GOLD_ORE) + $id));
           //I DON'T USE GOLD INGOT BECAUSE THAT IS AUTO SMELTING
           $this->data->save();
        }
        /* GOLD BLOCK */
        if($block->getTypeId() == BlockTypeIds::GOLD){
           $event->setDrops(array());
           $this->data->set(Mineral::GOLD_BLOCK, ($this->data->get(Mineral::GOLD_BLOCK) + 1));
           $this->data->save();
        }
        /* REDSTONE */
        if($block->getTypeId() == BlockTypeIds::REDSTONE_ORE){
           $event->setDrops(array());
           $id = mt_rand(1, $level);
           $this->data->set(Mineral::REDSTONE, ($this->data->get(Mineral::REDSTONE) + ($id * 4)));
           $this->data->save();
        }
        /* REDSTONE BLOCK */
        if($block->getTypeId() == BlockTypeIds::REDSTONE){
           $event->setDrops(array());
           $this->data->set(Mineral::REDSTONE_BLOCK, ($this->data->get(Mineral::REDSTONE_BLOCK) +1));
           $this->data->save();
        }
        /* DIAMOND */
        if($block->getTypeId() == BlockTypeIds::DIAMOND_ORE){
           $event->setDrops(array());
           $id = mt_rand(1, $level);
           $this->data->set(Mineral::DIAMOND, ($this->data->get(Mineral::DIAMOND) + $id));
           $this->data->save();
        }
        /* DIAMOND BLOCK */
        if($block->getTypeId() == BlockTypeIds::DIAMOND){
          $event->setDrops(array());
          $this->data->set(Mineral::DIAMOND_BLOCK, ($this->data->get(Mineral::DIAMOND_BLOCK) + 1));
          $this->data->save();
        }
        /* EMERALD */
        if($block->getTypeId() == BlockTypeIds::EMERALD_ORE){
           $event->setDrops(array());
           $id = mt_rand(1, $level);
           $this->data->set(Mineral::EMERALD, ($this->data->get(Mineral::EMERALD) + $id));
           $this->data->save();
        }
        /* EMERALD BLOCK */
        if($block->getTypeId() == BlockTypeIds::EMERALD){
           $event->setDrops(array());
           $this->data->set(Mineral::EMERALD_BLOCK, ($this->data->get(Mineral::EMERALD_BLOCK) + 1));
           $this->data->save();
        }
        /* COBBLESTONE */
        if($block->getTypeId() == BlockTypeIds::COBBLESTONE){
           $event->setDrops(array());
           $this->data->set(Mineral::COBBLESTONE, ($this->data->get(Mineral::COBBLESTONE) + 1));
           $this->data->save();
        }
        /* STONE BUT AFTER BREAK IS COBBLESTONE */
        if($block->getTypeId() == BlockTypeIds::STONE){
           $event->setDrops(array());
           $this->data->set(Mineral::COBBLESTONE, ($this->data->get(Mineral::COBBLESTONE) + 1));
           $this->data->save();
        }
       } 
      }
     }
    }
    
    public function onJoin(PlayerJoinEvent $event): void{
      $player = $event->getPlayer();
      $auto = Mineral::getInstance()->getAuto();
      if(!$auto->exists($player->getName())){
          $auto->set($player->getName(), "off");
          $auto->save();
      }
    }
}
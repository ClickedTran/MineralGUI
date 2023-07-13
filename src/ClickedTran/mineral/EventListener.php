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
        $blocks = [
          0 => ["type" => BlockTypeIds::LAPIS_LAZULI_ORE, "random" => (mt_rand(1, $level) * 4), "mineral" => Mineral::LAPIS],
          1 => ["type" => BlockTypeIds::COAL_ORE, "random" => (mt_rand(1, $level) * 4), "mineral" => Mineral::COAL],
          2 => ["type" => BlockTypeIds::REDSTONE_ORE, "random" => (mt_rand(1, $level) * 4), "mineral" => Mineral::REDSTONE],
          3 => ["type" => BlockTypeIds::IRON_ORE, "random" => mt_rand(1, $level), "mineral" => Mineral::IRON_ORE],
          4 => ["type" => BlockTypeIds::GOLD_ORE, "random" => mt_rand(1, $level), "mineral" => Mineral::GOLD_ORE],
          5 => ["type" => BlockTypeIds::DIAMOND_ORE, "random" => mt_rand(1, $level), "mineral" => Mineral::DIAMOND],
          6 => ["type" => BlockTypeIds::EMERALD_ORE, "random" => mt_rand(1, $level), "mineral" => Mineral::EMERALD],
          7 => ["type" => BlockTypeIds::LAPIS_LAZULI, "random" => 1, "mineral" => Mineral::LAPIS_BLOCK],
          8 => ["type" => BlockTypeIds::REDSTONE, "random" => 1, "mineral" => Mineral::REDSTONE_BLOCK],
          9 => ["type" => BlockTypeIds::COAL, "random" => 1, "mineral" => Mineral::COAL_BLOCK],
          10 => ["type" => BlockTypeIds::IRON, "random" => 1, "mineral" => Mineral::IRON_BLOCK],
          11 => ["type" => BlockTypeIds::GOLD, "random" => 1, "mineral" => Mineral::GOLD_BLOCK],
          12 => ["type" => BlockTypeIds::DIAMOND, "random" => 1, "mineral" => Mineral::DIAMOND_BLOCK],
          13 => ["type" => BlockTypeIds::EMERALD, "random" => 1, "mineral" => Mineral::EMERALD_BLOCK],
          14 => ["type" => BlockTypeIds::COBBLESTONE, "random" => mt_rand(1, $level), "mineral" => Mineral::COBBLESTONE],
          15 => ["type" => BlockTypeIds::STONE, "random" => mt_rand(1, $level), "mineral" => Mineral::COBBLESTONE]
          ];
        foreach($blocks as $slot => $blockData){
          $type = $blockData["type"];
          $random = $blockData["random"];
          $mineral = $blockData["mineral"];
          if($block->getTypeId() === $type){
             $event->setDrops([]);
             $this->data->set($mineral, ($this->data->get($mineral) + $random));
             $this->data->save();
          }
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

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

namespace ClickedTran\mineral;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerChatEvent;

use pocketmine\player\Player;

use pocketmine\utils\Config;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\data\bedrock\EnchantmentIds;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\item\StringToItemParser as STIP;

use ClickedTran\mineral\Mineral;
use ClickedTran\mineral\manager\MineralManager;
use ClickedTran\mineral\language\LanguageManager;
use ClickedTran\mineral\sound\SoundEffect;

class EventListener implements Listener{
  
  private MineralManager $manager;
  private Mineral $plugin;
  
  public function __construct(Mineral $plugin){
    $this->plugin = $plugin;
    $this->manager = MineralManager::getInstance();
  }
  
  public function onBreak(BlockBreakEvent $event){
    $block = $event->getBlock();
    $player = $event->getPlayer();
    $drops = $event->getDrops();
    
    if(!$event->isCancelled()){
      if($this->manager->getAutoMode($player) === true){
        if($player->isCreative(true)){
          return;
        }else{
          $itemInHand = $player->getInventory()->getItemInHand();
          $fortuneLevel = $itemInHand->getEnchantmentLevel(EnchantmentIdMap::getInstance()->fromId(18));
          //$drop = $drops[array_key_first($drops)];
          //$count = $drop->getCount();
          $blockDrop = $block->getDrops($itemInHand);
  
          if(!empty($blockDrop)){
            $item = $blockDrop[0];
            $count = $item->getCount();
            $name = strtolower($item->getName());
            if($this->manager->exists($player, $name)){
              if(!str_contains($name, "block") && $name !== "cobblestone"){
                if($fortuneLevel > 0 && count($drops) === 1){
                   $count += mt_rand(1, $fortuneLevel);
                }
              }
              $this->manager->add($player, $name, $count);
              $event->setDrops([]);
            }
          }
        }
      }
    }
  }
  
  public function onJoin(PlayerJoinEvent $event) : void{
    $player = $event->getPlayer();
    if(!file_exists($this->plugin->getDataFolder() . "players/".strtolower($player->getName()). ".yml")){
      $this->manager->createPlayerData($player);
    }
  }
  
  public function onLeave(PlayerQuitEvent $event) : void{
    $player = $event->getPlayer();
    if($this->manager->getAutoMode($player)  === true){
      $this->manager->setAutoMode($player, false);
    }
  }
  
  public function onChat(PlayerChatEvent $event) : void{
    $player = $event->getPlayer();
    $args = explode(" ", $event->getMessage());
    
    if(isset($this->manager->deposit[$player->getName()])){
      $item = $this->manager->deposit[$player->getName()];
      $event->cancel();
      $name = strtolower($item->getName());
      $inventory = $player->getInventory();
      if($args[0] != "all" and $args[0] != "cancel" and !is_numeric($args[0])){
        $this->manager->sendMSG
        (
          $player,
          LanguageManager::getTranslate
          (
            "mineral.message.error",
            [(string)$args[0]]
          )
        );
        unset($this->manager->deposit[$player->getName()]);
        return;
      }else{
        switch($args[0]){
          case "all":
            $total = 0;
            foreach($inventory->getContents() as $slot => $item){
              if($item->getTypeId() === STIP::getInstance()->parse($name)->getTypeId()){
                $total += $item->getCount();
                $player->getInventory()->setItem($slot, STIP::getInstance()->parse("air"));
                }
              }
                $this->manager->sendMSG
                (
                  $player,
                  LanguageManager::getTranslate
                  (
                    "mineral.message.deposit.success",
                    [strtolower($name), (string)$total]
                  )
                );
                $this->manager->add($player, $name, $total);
                SoundEffect::sendSuccess($player);
              unset($this->manager->deposit[$player->getName()]);
          break;
          
          case "cancel":
            unset($this->manager->deposit[$player->getName()]);
            $this->manager->sendMSG
            (
              $player,
              LanguageManager::getTranslate
              (
                "mineral.message.cancel"
              )
            );
          break;
          
          default:
            if($args[0] < 0){
              $this->manager->sendMSG
              (
                $player,
                LanguageManager::getTranslate
                (
                  "mineral.message.error",
                  [(string)$args[0]]
                )
              );
              return;
            }else{
              if($inventory->contains(STIP::getInstance()->parse($name)->setCount((int)$args[0]))){
                $inventory->removeItem(STIP::getInstance()->parse($name)->setCount((int)$args[0]));
                $this->manager->add($player, $name, (int)$args[0]);
                $this->manager->sendMSG
                (
                  $player,
                  LanguageManager::getTranslate
                  (
                    "mineral.message.deposit.success",
                    [$name, $args[0]]
                  )
                );
                SoundEffect::sendSuccess($player);
                unset($this->manager->deposit[$player->getName()]);
              }else{
                $this->manager->sendMSG
                (
                  $player,
                  LanguageManager::getTranslate
                  (
                    "mineral.message.deposit.fail",
                    [$name, $args[0]]
                  )
                );
                SoundEffect::sendFail($player);
                unset($this->manager->deposit[$player->getName()]);
              }
            }
          break;
        }
      }
    }
    
    if(isset($this->manager->withdraw[$player->getName()])){
      $item = $this->manager->withdraw[$player->getName()];
      $name = strtolower($item->getName());
      $inventory = $player->getInventory();
      $event->cancel();
      
      if($args[0] != "all" and $args[0] != "cancel" and !is_numeric($args[0])){
        $this->manager->sendMSG
        (
          $player,
          LanguageManager::getTranslate
          (
           "mineral.message.error",
           [(string)$args[0]]
          )
        );
        unset($this->manager->withdraw[$player->getName()]);
        return;
      }else{
        switch($args[0]){
          case "all":
            $total = $this->manager->get($player, $name);
            $inventory->addItem(STIP::getInstance()->parse($name)->setCount($total));
            $this->manager->set($player, $name, 0);
            $this->manager->sendMSG
            (
              $player,
              LanguageManager::getTranslate
              (
                "mineral.message.withdraw.success",
                [$name, (string)$total]
              )
            );
            SoundEffect::sendSuccess($player);
            unset($this->manager->withdraw[$player->getName()]);
          break;
          
          case "cancel":
            unset($this->manager->withdraw[$player->getName()]);
            $this->manager->sendMSG
            (
              $player,
              LanguageManager::getTranslate
              (
                "mineral.message.cancel"
              )
            );
          break;
          
          default:
            if($args[0] < 0){
              $this->manager->sendMSG
              (
                $player,
                LanguageManager::getTranslate
                (
                  "mineral.message.error",
                  [(string)$args[0]]
                )
              );
              unset($this->manager->withdraw[$player->getName()]);
              return;
            }else{
              if($inventory->firstEmpty() === -1){
                $this->manager->sendMSG
                (
                  $player,
                  LanguageManager::getTranslate
                  (
                    "mineral.message.withdraw.full-inv"
                  )
                );
                SoundEffect::sendFail($player);
                unset($this->manager->withdraw[$player->getName()]);
                return;
              }else{
                if($this->manager->get($player, $name) <= 0){
                  $this->manager->sendMSG
                  (
                    $player,
                    LanguageManager::getTranslate
                    (
                      "mineral.message.withdraw.fail",
                      [$name, $args[0]]
                    )
                  );
                  unset($this->manager->withdraw[$player->getName()]);
                  SoundEffect::sendFail($player);
                  return;
                }else{
                  $inventory->addItem(STIP::getInstance()->parse($name)->setCount((int)$args[0]));
                  $this->manager->take($player, $name, (int)$args[0]);
                  $this->manager->sendMSG
                  (
                    $player,
                    LanguageManager::getTranslate
                      (
                        "mineral.message.withdraw.success",
                        [$name, (string)$args[0]]
                      )
                  );
                  SoundEffect::sendSuccess($player);
                  unset($this->manager->withdraw[$player->getName()]);
                }
              }
            }
          break;
        }
      }
    }
    
    if(isset($this->manager->sold[$player->getName()])){
      $item = $this->manager->sold[$player->getName()];
      $name = strt_replace("_", " ", strtolower($item->getName()));
      $event->cancel();
      
      if($args[0] != "all" and $args[0] != "cancel" and !is_numeric($args[0])){
        $this->manager->sendMSG
        (
          $player,
          LanguageManager::getTranslate
          (
           "mineral.message.error",
           [(string)$args[0]]
          )
        );
        unset($this->manager->sold[$player->getName()]);
        return;
      }else{
        switch($args[0]){
          case "all":
            $this->manager->sell($player, $name, $this->manager->get($player, $name));
            unset($this->manager->sold[$player->getName()]);
          break;
          
          case "cancel":
            unset($this->manager->sold[$player->getName()]);
            $this->manager->sendMSG
            (
              $player,
              LanguageManager::getTranslate
              (
                "mineral.message.cancel"
              )
            );
          break;
          
          default:
            if($args[0] < 0){
               $this->manager->sendMSG
               (
                 $player,
                 LanguageManager::getTranslate
                 (
                   "mineral.message.error",
                   [(string)$args[0]]
                 )
               );
               return;
            }
            $this->manager->sell($player, $name, (int)$args[0]);
            unset($this->manager->sold[$player->getName()]);
          break;
        }
      }
    }
  }
}

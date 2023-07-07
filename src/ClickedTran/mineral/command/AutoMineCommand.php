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

namespace ClickedTran\mineral\command;

use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use ClickedTran\mineral\Mineral;
use ClickedTran\mineral\gui\GUIManager;
use ClickedTran\mineral\sound\SoundEffect;

class AutoMineCommand extends Command implements PluginOwned {
  
  private Mineral $plugin;
  
  public function __construct(Mineral $plugin){
    $this->plugin = $plugin;
    parent::__construct("automine", "§r§oAutoMine Command");
    $this->setPermission("mineralgui.command.automine");
  }
  
  public function execute(CommandSender $sender, string $label, array $args){
     if(!$sender instanceof Player){
         $sender->sendMessage("§l§cPlease use in-game!!");
         return true;
     }
     $auto = $this->plugin->getAuto();
     if(!isset($args[0])){
        $sender->sendMessage("§cPlease input mode: §b<on | off>");
        return;
     }else{
       switch($args[0]){
         case "on":
           if($sender->hasPermission("mineralgui.command.automine")){
               $auto->set($sender->getName(), "on");
               $sender->sendPopup("§l§cAutoMine §bON");
               SoundEffect::sendON($sender);
           }else{
             $sender->sendMessage("§l§cYou don't have permission to use command!");
           }
         break;
         case "off":
           if($sender->hasPermission("mineralgui.command.automine")){
               $auto->set($sender->getName(), "off");
               $sender->sendPopup("§l§cAutoMine §bOFF");
               SoundEffect::sendOFF($sender);
           }else{
             $sender->sendMessage("§l§cYou don't have permission to use command!");
           }
         break;
         default:
           if($sender->hasPermission("mineral.command.automine")){
              $sender->sendMessage("§l> §r/automine <on|off>");
           }else{
             $sender->sendMessage("§l§cYou don'y have permission to use command!!");
           }
         break;
       }
     }
  }
  
  public function getOwningPlugin(): Mineral{
    return $this->plugin;
  }
}

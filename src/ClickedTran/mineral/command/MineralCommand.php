<?php

/**
*░█████╗░██╗░░░░░██╗░█████╗░██╗░░██╗███████╗██████╗░████████╗██████╗░░█████╗░███╗░░██╗
*██╔══██╗██║░░░░░██║██╔══██╗██║░██╔╝██╔════╝██╔══██╗╚══██╔══╝██╔══██╗██╔══██╗████╗░██║
*██║░░╚═╝██║░░░░░██║██║░░╚═╝█████═╝░█████╗░░██║░░██║░░░██║░░░██████╔╝███████║██╔██╗██║
*██║░░██╗██║░░░░░██║██║░░██╗██╔═██╗░██╔══╝░░██║░░██║░░░██║░░░██╔══██╗██╔══██║██║╚████║
*╚█████╔╝███████╗██║╚█████╔╝██║░╚██╗███████╗██████╔╝░░░██║░░░██║░░██║██║░░██║██║░╚███║
*░╚════╝░╚══════╝╚═╝░╚════╝░╚═╝░░╚═╝╚══════╝╚═════╝░░░░╚═╝░░░╚═╝░░╚═╝╚═╝░░╚═╝╚═╝░░╚══╝
*
*                                      Copyright (C) 2023-2024 ClickedTran
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

class MineralCommand extends Command implements PluginOwned {
  
  private Mineral $plugin;
  
  public function __construct(Mineral $plugin){
    $this->plugin = $plugin;
    parent::__construct("mineral", "§r§oOpen MineRal");
    $this->setPermission("mineral.command");
  }
  
  public function execute(CommandSender $sender, string $label, array $args){
    if(!$sender instanceof Player){
        $sender->sendMessage("§cPlease use in-game!");
        return;
    }
    SoundEffect::sendOpenMenu($sender);
    $gui = new GUIManager();
    $gui->menuORE($sender);
  }
  
  public function getOwningPlugin(): Mineral{
    return $this->plugin;
  }
}

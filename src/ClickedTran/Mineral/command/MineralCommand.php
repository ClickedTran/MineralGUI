<?php

/**
*░█████╗░██╗░░░░░██╗░█████╗░██╗░░██╗███████╗██████╗░████████╗██████╗░░█████╗░███╗░░██╗
*██╔══██╗██║░░░░░██║██╔══██╗██║░██╔╝██╔════╝██╔══██╗╚══██╔══╝██╔══██╗██╔══██╗████╗░██║
*██║░░╚═╝██║░░░░░██║██║░░╚═╝█████═╝░█████╗░░██║░░██║░░░██║░░░██████╔╝███████║██╔██╗██║
*██║░░██╗██║░░░░░██║██║░░██╗██╔═██╗░██╔══╝░░██║░░██║░░░██║░░░██╔══██╗██╔══██║██║╚████║
*╚█████╔╝███████╗██║╚█████╔╝██║░╚██╗███████╗██████╔╝░░░██║░░░██║░░██║██║░░██║██║░╚███║
*░╚════╝░╚══════╝╚═╝░╚════╝░╚═╝░░╚═╝╚══════╝╚═════╝░░░░╚═╝░░░╚═╝░░╚═╝╚═╝░░╚═╝╚═╝░░╚══╝
*
*                                      Copyright (C) 2025-2026 ClickedTran
*/

declare(strict_types=1);

namespace ClickedTran\mineral\command;

use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use ClickedTran\mineral\Mineral;
use ClickedTran\mineral\manager\MineralManager;
use ClickedTran\mineral\gui\GUIManager;
use ClickedTran\mineral\sound\SoundEffect;
use ClickedTran\mineral\language\LanguageManager;

class MineralCommand extends Command implements PluginOwned {
  
  private Mineral $plugin;
  
  public function __construct(Mineral $plugin){
    $this->plugin = $plugin;
    parent::__construct
    (
      "mineral", 
      LanguageManager::getTranslate
      (
        "mineral.command.description"
      )
    );
    $this->setPermission("mineralgui.command");
  }
  
  public function execute(CommandSender $sender, string $label, array $args){
    if(!$sender instanceof Player){
        MineralManager::getInstance()->sendMSG
        (
          $sender,
          LanguageManager::getTranslate
          (
            "mineral.command.use-ingame"
          )
        );
        return;
    }
    SoundEffect::sendOpenMenu($sender);
    $gui = new GUIManager();
    $gui->openMenu($sender);
  }
  
  public function getOwningPlugin(): Mineral{
    return $this->plugin;
  }
}

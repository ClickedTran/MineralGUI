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

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;

use ClickedTran\mineral\command\MineralCommand;
use ClickedTran\mineral\language\LanguageManager;
use ClickedTran\mineral\manager\MineralManager;
use muqsit\invmenu\InvMenuHandler;

use DaPigGuy\libPiggyEconomy\libPiggyEconomy;
use function mkdir;

class Mineral extends PluginBase {
  
  private $economyProvider;
  public const PREFIX = "§4[ §9Mineral§bGUI§4 ] ";
  
  /* @var MineRal */
  public static $instance;
  
  public static function getInstance(): self{
    return self::$instance;
  }
  
  public function onEnable(): void{
  
   /**Register Multi Economy*/
    libPiggyEconomy::init();
    $this->economyProvider = libPiggyEconomy::getProvider($this->getConfig()->get("economy"));
  
    $this->getLanguageManager();
    $this->saveDefaultConfig();
    
   /**Register Command & Event*/
    $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    
    $this->getServer()->getCommandMap()->register($this->getDescription()->getName(), new MineralCommand($this));
    
    /**Register InvMenu*/
    if(!InvMenuHandler::isRegistered()){
        InvMenuHandler::register($this);
    }
    self::$instance = $this;
    MineralManager::getInstance()->getSellPrice();
  }

  public function getEconomy(){
    return $this->economyProvider;
  }
  
  private function getLanguageManager() : LanguageManager{
    return new LanguageManager($this);
  }
}

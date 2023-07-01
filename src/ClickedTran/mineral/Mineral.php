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

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\utils\Config;

use ClickedTran\mineral\command\MineralCommand;
use ClickedTran\mineral\command\AutoMineCommand;
use ClickedTran\mineral\sound\SoundEffect;
use muqsit\invmenu\InvMenuHandler;

use DaPigGuy\libPiggyEconomy\libPiggyEconomy;

use function substr;
use function mkdir;

class Mineral extends PluginBase implements Listener{
  
  public $message, $id, $int, $data, $auto, $sell, $economyProvider;
  
  public const LAPIS = "lapis";
  public const LAPIS_BLOCK = "lapis_block";
  public const COAL = "coal";
  public const COAL_BLOCK = "coal_block";
  public const IRON_ORE = "raw_iron";
  public const IRON_BLOCK = "iron_block";
  public const GOLD_ORE = "raw_gold";
  public const GOLD_BLOCK = "gold_block";
  public const REDSTONE = "redstone";
  public const REDSTONE_BLOCK = "redstone_block";
  public const DIAMOND = "diamond";
  public const DIAMOND_BLOCK = "diamond_block";
  public const EMERALD = "emerald";
  public const EMERALD_BLOCK = "emerald_block";
  public const COBBLESTONE = "cobblestone";
  
  /* @var MineRal */
  public static $instance;
  
  public static function getInstance(): self{
    return self::$instance;
  }
  
  public function onEnable(): void{
    libPiggyEconomy::init();
    $this->economyProvider = libPiggyEconomy::getProvider($this->getConfig()->get("economy"));
    
    /** 
    * Register Event, Register Command 
    */
    $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    
    $this->getServer()->getCommandMap()->register($this->getDescription()->getName(), new MineralCommand($this));
    
    $this->getServer()->getCommandMap()->register($this->getDescription()->getName(), new AutoMineCommand($this));
    
       /** 
    *All Config 
    */
    $this->id = new Config($this->getDataFolder() . "id.yml", Config::YAML);
    
		$this->auto = new Config($this->getDataFolder() . "auto.yml", Config::YAML);
		
		$this->int = new Config($this->getDataFolder() . "int.yml", Config::YAML);
 
		@mkdir($this->getDataFolder());
		$this->saveResource("message.yml");
    $this->saveResource("config.yml");
    $this->saveResource("sell.yml");
    
    $this->sell = new Config($this->getDataFolder() . "sell.yml", Config::YAML);
		$this->message = new Config($this->getDataFolder(). "message.yml", Config::YAML);
    $this->saveDefaultConfig();
    
    /** 
    * Register GUI (INVMENU) 
    */
    if(!InvMenuHandler::isRegistered()){
        InvMenuHandler::register($this);
    }
    
    self::$instance = $this;
  }

 public function getEco(){
   return $this->economyProvider;
 }
	
 public function getSellList(){
   return $this->sell;
 }
  
  public function getMessage(){
    return $this->message;
  }
  
  public function getAuto(){
    return $this->auto;
  }
 
  public function getInt(){
    return $this->int;
 }
 
  public function getId(){
    return $this->id;
 }
 
 public function getData(Player $player) : Config{
     @mkdir($this->getDataFolder() . "players/");
     $this->data = new Config($this->getDataFolder() . "players/" . $player->getName() . ".yml", Config::YAML);
   return $this->data;
 }
 
 public function getNumber($type, Player $player){
   return self::getData($player)->get($type);
 }
}

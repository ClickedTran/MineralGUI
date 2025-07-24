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

namespace ClickedTran\mineral\manager;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\console\ConsoleCommandSender as Sender;
use pocketmine\utils\{
  Config,
  SingletonTrait
};

use ClickedTran\mineral\Mineral;
use ClickedTran\mineral\language\LanguageManager;
use ClickedTran\mineral\sound\SoundEffect;

class MineralManager{
  use SingletonTrait;
  
  private ?Config $data = null;
  private ?Config $sell = null;
  public array $withdraw = [];
  public array $deposit = [];
  public array $sold = [];
  
  public function getPlayerData(Player $player){
    @mkdir(Mineral::getInstance()->getDataFolder() . "players/");
    if($this->data == null){
      $this->data = new Config(Mineral::getInstance()->getDataFolder()."players/".strtolower($player->getName()).".yml", Config::YAML);
    }
    return $this->data;
  }
  
  public function createPlayerData(Player $player){
    
    $this->getPlayerData($player)->setAll(
     [
      "automatic-mode" => false,
      "cobblestone" => 0,
      "coal" => 0,
      "coal block" => 0,
      "diamond" => 0,
      "diamond block" => 0,
      "emerald" => 0,
      "emerald block" => 0,
      "lapis lazuli" => 0,
      "lapis lazuli block" => 0,
      "redstone" => 0,
      "redstone block" => 0,
      "raw iron" => 0,
      "iron block" => 0,
      "raw gold" => 0,
      "gold block" => 0
     ]
    );
    $this->getPlayerData($player)->save();
  }
  
  public function sendMSG(Player|Sender $player, string $msg) : void{
    $player->sendMessage(Mineral::PREFIX . $msg);
  }
  
  public function add(Player $player, string $type, int $amount){
    $this->getPlayerData($player)->set($type, $this->getPlayerData($player)->get($type) + $amount);
    $this->getPlayerData($player)->save();
  }
  
  public function take(Player $player, string $type, int $amount){
    $this->getPlayerData($player)->set($type, $this->getPlayerData($player)->get($type) - $amount);
    $this->getPlayerData($player)->save();
  }
  
  public function get(Player $player, string $type){
    return $this->getPlayerData($player)->get($type);
  }
  
  public function set(Player $player, string $type, int $amount){
    $this->getPlayerData($player)->set($type, $amount);
    $this->getPlayerData($player)->save();
  }
    
  public function exists(Player $player, string $type){
     return $this->getPlayerData($player)->exists($type);
  }
  
  public function getSellPrice(){
    if($this->sell === null){
      $this->sell = new Config(Mineral::getInstance()->getDataFolder(). "sells.yml", Config::YAML, 
       [
          "cobblestone" => 1.2,
          "coal" => 2,
          "coal block" => 18,
          "diamond" => 9,
          "diamond block" => 81,
          "emerald" => 8,
          "emerald block" => 72,
          "lapis lazuli" => 5,
          "lapis lazuli block" => 45,
          "redstone" => 6,
          "redstone block" => 54,
          "raw iron" => 4,
          "iron block" => 36,
          "raw gold" => 3,
          "gold block" => 27
       ]
      );
    }
    return $this->sell;
  }
  
  public function sellAll(Player $player){
    $totalMoney = 0;
    foreach($this->getPlayerData($player)->getAll() as $item => $amount){
      $price = $this->getSellPrice()->get($item, 0);
      if($price > 0){
        $totalMoney += $amount * $price;
      }
      if($item !== "automatic-mode"){
        $this->set($player, $item, 0);
      }
    }
    if($totalMoney > 0){
      $this->sendMSG
      (
        $player,
        LanguageManager::getTranslate
        (
          "mineral.message.sellall.success",
          [(string)$totalMoney]
        )
      );
      Mineral::getInstance()->getEconomy()->giveMoney($player, $totalMoney);
    }else{
      $this->sendMSG
      (
        $player,
        LanguageManager::getTranslate
        (
          "mineral.message.sellall.fail",
        )
      );
    }
  }
  
  public function sell(Player $player, string $type, int $amount = 1){
    $money = 0;
    //$amount = $this->getPlayerData($player)->get($type);
    $price = $this->getSellPrice()->get($type);
    
    if($price > 0){
      $money += $amount * $price;
    }
    
    if($money > 0){
      $this->sendMSG
      (
        $player,
        LanguageManager::getTranslate
        (
          "mineral.message.sell.success",
          [$type, (string)$amount, (string)$money]
        )
      );
      Mineral::getInstance()->getEconomy()->giveMoney($player, $money);
      $this->take($player, $type, $amount);
      SoundEffect::sendSuccess($player);
    }else{
      $this->sendMSG
      (
        $player,
        LanguageManager::getTranslate
        (
          "mineral.message.sell.fail",
          [(string)$amount, $type]
        )
      );
      SoundEffect::sendFail($player);
    }
  }
  
  public function getAutoMode(Player $player) : bool{
    return $this->getPlayerData($player)->get("automatic-mode");
  }
  
  public function setAutoMode(Player $player, bool $key){
    $this->getPlayerData($player)->set("automatic-mode", $key);
    $this->getPlayerData($player)->save();
  }
    
  public function changeAutoMode(Player $player) : bool{
    $mode = $this->getAutoMode($player);
    $newMode = !$mode;
    $this->getPlayerData($player)->set("automatic-mode", $newMode);
    $this->getPlayerData($player)->save();
    $status = $newMode ? "true" : "false";
    
    $this->sendMSG
    (
      $player,
      LanguageManager::getTranslate
      (
        "mineral.message.automatic-mode",
        [$status]
      )
    );
    
    return $newMode;
  }
}

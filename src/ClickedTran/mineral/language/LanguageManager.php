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

namespace ClickedTran\mineral\language;

use pocketmine\utils\Config;
use function vsprintf;

use ClickedTran\mineral\Mineral;

class LanguageManager{
  
  private static Mineral $plugin;
  private static Config $lang;
  
  public function __construct(Mineral $plugin){
    self::$plugin = $plugin;
    $this->loadLanguage();
  }
  
  public function loadLanguage() : void{
    $languageFolder = $this->getPlugin()->getDataFolder() . "language/";
    
    $languageFile = $this->getPlugin()->getConfig()->get("language");
    
    if(!file_exists($languageFolder . $languageFile.".yml")){
      $this->getPlugin()->getLogger()->warning("Language $languageFile not found, Use default language as vi-VN");
      $languageFile = "en-US";
      $this->getPlugin()->getConfig()->set("language", $languageFile);
      $this->getPlugin()->getConfig()->save();
    }
    $this->getPlugin()->saveResource("language/".$languageFile.".yml", false);
    self::$lang = new Config($languageFolder.$languageFile.".yml", Config::YAML);
    $this->getPlugin()->getLogger()->info("Current language: ".$languageFile);
  }
  
  public static function getTranslate(string $text, array $key = []){
      $message = self::$lang->getNested($text, $text);
      for($i = 0; $i < count($key); $i++){
          $message = str_replace("%".($i+1), $key[$i], $message);
      }
      
      if(empty($key)){
         return $message;
      }
      return $message;
  }
    
  private function getPlugin() : Mineral{
      return self::$plugin;
  }
}

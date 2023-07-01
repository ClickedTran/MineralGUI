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
namespace ClickedTran\mineral\sound;

use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\network\mcpe\NetworkBroadcastUtils;
use pocketmine\player\Player;

class SoundEffect {
  
  public static function sendSuccess(Player $player) : void{
    self::livingRoom($player, "random.levelup");
  }
  
  public static function sendFail(Player $player) : void{
    self::livingRoom($player, "mob.villager.no");
  }
  
  public static function sendNextMenu(Player $player) : void{
    self::livingRoom($player, "random.shulkerboxopen");
  }
  
  public static function sendOpenMenu(Player $player) : void{
    self::livingRoom($player, "random.enderchestopen");
  }
  
  public static function sendON(Player $player) : void{
    self::livingRoom($player, "random.anvil_use");
  }
  
  public static function sendOFF(Player $player) : void{
    self::livingRoom($player, "mob.blaze.shot");
  }
  
  public static function livingRoom(Player $player, string $text) : void{
    $pos = $player->getPosition();
    $sound = new PlaySoundPacket();
    $sound->soundName = $text;
    $sound->x = $pos->getX();
    $sound->y = $pos->getY();
    $sound->z = $pos->getZ();
    $sound->volume = 1.5;
    $sound->pitch = 1;
    $player->getNetworkSession()->sendDataPacket($sound);
  }
}

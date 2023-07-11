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

namespace ClickedTran\mineral\gui;

use Closure;
use pocketmine\item\VanillaItems;
use pocketmine\item\StringToItemParser;
use pocketmine\block\VanillaBlocks;

use pocketmine\player\Player;

use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction; 
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use muqsit\invmenu\type\InvMenuTypeIds;

use ClickedTran\mineral\Mineral;
use ClickedTran\mineral\sound\SoundEffect;

use dktapps\pmforms\{CustomForm, CustomFormResponse};
use dktapps\pmforms\element\Input;

class GUIManager{
	
	/**	
  * Menu ALL ORE
  * @param Player $player
  */
  public function menuORE(Player $player){
   $message = Mineral::getInstance()->getMessage();
   $plugin = Mineral::getInstance();
   $menu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
   $menu->setListener(Closure::fromCallable([$this, "menuListener"]));
   $menu->readonly();
   $menu->setName($message->getNested("menu.name"));
   $inv = $menu->getInventory();
   
  for($i = 0; $i <= 9; $i++){
       $inv->setItem($i, VanillaBlocks::IRON_BARS()->asItem()->setCustomName("§l§r "));
   }
   
   $inv->setItem(13, VanillaBlocks::COBBLESTONE()->asItem()->setCustomName("Cobblestone"));
   
   $inv->setItem(17, VanillaBlocks::IRON_BARS()->asItem()->setCustomName("§l§r "));
   $inv->setItem(18, VanillaBlocks::IRON_BARS()->asItem()->setCustomName("§l§r "));
   
   $inv->setItem(19, VanillaBlocks::LAPIS_LAZULI()->asItem()->setCustomName("Lapis Block"));
   
   $inv->setItem(20, VanillaBlocks::REDSTONE()->asItem()->setCustomName("Redstone Block"));
  
   $inv->setItem(21, VanillaBlocks::COAL()->asItem()->setCustomName("Coal Block"));
   
   $inv->setItem(22, VanillaBlocks::IRON()->asItem()->setCustomName("Iron Block"));
   
   $inv->setItem(23, VanillaBlocks::GOLD()->asItem()->setCustomName("Gold Block"));
   
   $inv->setItem(24, VanillaBlocks::EMERALD()->asItem()->setCustomName("Emerald Block"));
   
   $inv->setItem(25, VanillaBlocks::DIAMOND()->asItem()->setCustomName("Diamond Block"));
   
   $inv->setItem(26, VanillaBlocks::IRON_BARS()->asItem()->setCustomName("§l§r "));
   $inv->setItem(27, VanillaBlocks::IRON_BARS()->asItem()->setCustomName("§l§r "));
   
   $inv->setItem(28, VanillaItems::LAPIS_LAZULI()->setCustomName("Lapis"));
   
   $inv->setItem(29, VanillaItems::REDSTONE_DUST()->setCustomName("Redstone"));
  
   $inv->setItem(30, VanillaItems::COAL()->setCustomName("Coal"));
   
   $inv->setItem(31, VanillaItems::RAW_IRON()->setCustomName("Raw Iron"));
   
   $inv->setItem(32, VanillaItems::RAW_GOLD()->setCustomName("Raw Gold"));
   
   $inv->setItem(33, VanillaItems::EMERALD()->setCustomName("Emerald"));
   
   $inv->setItem(34, VanillaItems::DIAMOND()->setCustomName("Diamond"));
   
   $inv->setItem(35, VanillaBlocks::IRON_BARS()->asItem()->setCustomName("§l§r "));
   $inv->setItem(36, VanillaBlocks::IRON_BARS()->asItem()->setCustomName("§l§r "));
   
   $inv->setItem(40, VanillaBlocks::CHEST()->asItem()->setCustomName("§l§cSell All"));
   
   for($i = 44; $i <= 47; $i++){
       $inv->setItem($i, VanillaBlocks::IRON_BARS()->asItem()->setCustomName("§l§r "));
   }
   
   $inv->setItem(48, VanillaItems::WRITABLE_BOOK()->setCustomName(str_replace(["{cobblestone}", "{coal}", "{lapis}", "{redstone}", "{iron_ore}", "{gold_ore}", "{diamond}", "{emerald}"], [$plugin->getNumber(Mineral::COBBLESTONE, $player), $plugin->getNumber(Mineral::COAL, $player), $plugin->getNumber(Mineral::LAPIS, $player), $plugin->getNumber(Mineral::REDSTONE, $player), $plugin->getNumber(Mineral::IRON_ORE, $player), $plugin->getNumber(Mineral::GOLD_ORE, $player), $plugin->getNumber(Mineral::DIAMOND, $player), $plugin->getNumber(Mineral::EMERALD, $player)], $message->getNested("menu.list_ore"))));
   
   $inv->setItem(49, VanillaBlocks::REDSTONE()->asItem()->setCustomName($message->getNested("menu.exit")));
   
   $inv->setItem(50, VanillaItems::WRITABLE_BOOK()->setCustomName(str_replace(["{cobblestone}", "{coal_block}", "{lapis_block}", "{redstone_block}", "{iron_block}", "{gold_block}", "{diamond_block}", "{emerald_block}"], [$plugin->getNumber(Mineral::COBBLESTONE, $player), $plugin->getNumber(Mineral::COAL_BLOCK, $player), $plugin->getNumber(Mineral::LAPIS_BLOCK, $player), $plugin->getNumber(Mineral::REDSTONE_BLOCK, $player), $plugin->getNumber(Mineral::IRON_BLOCK, $player), $plugin->getNumber(Mineral::GOLD_BLOCK, $player), $plugin->getNumber(Mineral::DIAMOND_BLOCK, $player), $plugin->getNumber(Mineral::EMERALD_BLOCK, $player)], $message->getNested("menu.list_block"))));
   
   for($i = 51; $i <= 53; $i++){
       $inv->setItem($i, VanillaBlocks::IRON_BARS()->asItem()->setCustomName("§l§r "));
   }
   
   $menu->send($player);
  }
  
  public function menuListener(InvMenuTransaction $action): InvMenuTransactionResult{
    $item = $action->getOut();
    $item_name = $item->getCustomName();
    $player = $action->getPlayer();
    $inv = $action->getAction()->getInventory();
    $int = Mineral::getInstance()->getInt();
    $id = Mineral::getInstance()->getId();
    $message = Mineral::getInstance()->getMessage();
    $data = Mineral::getInstance()->getData($player);
    $sell = Mineral::getInstance()->getSellList();
    
    if($item_name === "Cobblestone"){
       $int->set($player->getName(), Mineral::COBBLESTONE);
       $id->set($player->getName(), "cobblestone");
       $this->menuItem($player);
       SoundEffect::sendNextMenu($player);
       return $action->discard();
    }
    
    if($item_name === "Lapis"){
       $int->set($player->getName(), Mineral::LAPIS);
       $id->set($player->getName(), "lapis_lazuli");
       $this->menuItem($player);
       SoundEffect::sendNextMenu($player);
       return $action->discard();
    }
    
    if($item_name === "Lapis Block"){
       $int->set($player->getName(), Mineral::LAPIS_BLOCK);
       $id->set($player->getName(), "lapis_lazuli_block");
       $this->menuItem($player);
       SoundEffect::sendNextMenu($player);
       return $action->discard();
    }
    
    if($item_name === "Coal"){
       $int->set($player->getName(), Mineral::COAL);
       $id->set($player->getName(), "coal");
       $this->menuItem($player);
       SoundEffect::sendNextMenu($player);
       return $action->discard();
    }
    
    if($item_name === "Coal Block"){
       $int->set($player->getName(), Mineral::COAL_BLOCK);
       $id->set($player->getName(), "coal_block");
       $this->menuItem($player);
       SoundEffect::sendNextMenu($player);
       return $action->discard();
    }
    
    if($item_name === "Raw Iron"){
       $int->set($player->getName(), Mineral::IRON_ORE);
       $id->set($player->getName(), "raw_iron");
       $this->menuItem($player);
       SoundEffect::sendNextMenu($player);
       return $action->discard();
    }
    
    if($item_name === "Iron Block"){
       $int->set($player->getName(), Mineral::IRON_BLOCK);
       $id->set($player->getName(), "iron_block");
       $this->menuItem($player);
       SoundEffect::sendNextMenu($player);
       return $action->discard();
    }
    
    if($item_name === "Raw Gold"){
       $int->set($player->getName(), Mineral::GOLD_ORE);
       $id->set($player->getName(), "raw_gold");
       $this->menuItem($player);
       SoundEffect::sendNextMenu($player);
       return $action->discard();
    }
    
    if($item_name === "Gold Block"){
       $int->set($player->getName(), Mineral::GOLD_BLOCK);
       $id->set($player->getName(), "gold_block");
       $this->menuItem($player);
       SoundEffect::sendNextMenu($player);
       return $action->discard();
    }
    
    if($item_name === "Redstone"){
       $int->set($player->getName(), Mineral::REDSTONE);
       $id->set($player->getName(), "redstone_dust");
       $this->menuItem($player);
       SoundEffect::sendNextMenu($player);
       return $action->discard();
    }
    
    if($item_name === "Redstone Block"){
       $int->set($player->getName(), Mineral::REDSTONE_BLOCK);
       $id->set($player->getName(), "redstone_block");
       SoundEffect::sendNextMenu($player);
       $this->menuItem($player);
       return $action->discard();
    }
    
    if($item_name === "Diamond"){
       $int->set($player->getName(), Mineral::DIAMOND);
      $id->set($player->getName(), "diamond");
      $this->menuItem($player);
      SoundEffect::sendNextMenu($player);
      return $action->discard();
    }
    
    if($item_name === "Diamond Block"){
       $int->set($player->getName(), Mineral::DIAMOND_BLOCK);
       $id->set($player->getName(), "diamond_block");
       $this->menuItem($player);
       SoundEffect::sendNextMenu($player);
       return $action->discard();
    }
    
    if($item_name === "Emerald"){
       $int->set($player->getName(), Mineral::EMERALD);
       $id->set($player->getName(), "emerald");
       $this->menuItem($player);
       SoundEffect::sendNextMenu($player);
       return $action->discard();
    }
    
    if($item_name === "Emerald Block"){
       $int->set($player->getName(), Mineral::EMERALD_BLOCK);
       $id->set($player->getName(), "emerald_block");
       $this->menuItem($player);
       SoundEffect::sendNextMenu($player);
       return $action->discard();
    }
    
    /**
    * Get information and prices at sell.yml
    */
    if($item_name === "§l§cSell All"){
       $cobblestone = $data->get(Mineral::COBBLESTONE) * $sell->get("cobblestone");
       
       /**ORE*/
       $lapis = $data->get(Mineral::LAPIS) * $sell->get("lapis");
       $redstone = $data->get(Mineral::REDSTONE) * $sell->get("redstone");
       $coal = $data->get(Mineral::COAL) * $sell->get("coal");
       $raw_iron = $data->get(Mineral::IRON_ORE) * $sell->get("raw_iron");
       $raw_gold = $data->get(Mineral::GOLD_ORE) * $sell->get("raw_gold");
       $diamond = $data->get(Mineral::DIAMOND) * $sell->get("diamond");
       $emerald = $data->get(Mineral::EMERALD) * $sell->get("emerald");
       /**BLOCK*/
       
       $lapis_block = $data->get(Mineral::LAPIS_BLOCK) * $sell->get("lapis_block");
       $redstone_block = $data->get(Mineral::REDSTONE_BLOCK) * $sell->get("redstone_block");
       $coal_block = $data->get(Mineral::COAL_BLOCK) * $sell->get("coal_block");
       $iron_block = $data->get(Mineral::IRON_BLOCK) * $sell->get("iron_block");
       $gold_block = $data->get(Mineral::GOLD_BLOCK) * $sell->get("gold_block");
       $diamond_block = $data->get(Mineral::DIAMOND_BLOCK) * $sell->get("diamond_block");
       $emerald_block = $data->get(Mineral::EMERALD_BLOCK) * $sell->get("emerald_block");
       /**
       * Add up all the prices of ore that will be sold
       */
       $ore = $lapis + $redstone + $coal + $raw_gold + $raw_iron + $diamond + $emerald + $lapis_block + $redstone_block + $coal_block + $iron_block + $gold_block + $diamond_block + $emerald_block + $cobblestone;
       
       /** MULTIPLY */
       $total_price = $ore * $sell->get("multip");
       
       /**ADD MONEY TO PLAYER*/
         Mineral::getInstance()->getEco()->giveMoney($player, $total_price);
       
       /**SEND MESSAGE FOR PLAYER AFTER SELL*/
       $player->sendMessage($message->get("prefix") . str_replace(["{total_price}"], [$total_price], $message->get("sell-message")));
       
       /**Send Sound*/
       SoundEffect::sendSuccess($player);
       
       /**SET ALL TO 0*/
       $data->set(Mineral::LAPIS, 0);
       $data->set(Mineral::REDSTONE, 0);
       $data->set(Mineral::COAL, 0);
       $data->set(Mineral::GOLD_ORE, 0);
       $data->set(Mineral::IRON_ORE, 0);
       $data->set(Mineral::DIAMOND, 0);
       $data->set(Mineral::EMERALD, 0);
       $data->set(Mineral::LAPIS_BLOCK, 0);
       $data->set(Mineral::REDSTONE_BLOCK, 0);
       $data->set(Mineral::COAL_BLOCK, 0);
       $data->set(Mineral::GOLD_BLOCK, 0);
       $data->set(Mineral::IRON_BLOCK, 0);
       $data->set(Mineral::DIAMOND_BLOCK, 0);
       $data->set(Mineral::EMERALD_BLOCK, 0);
       $data->set(Mineral::COBBLESTONE, 0);
       $data->save();
       $player->removeCurrentWindow($inv);
       return $action->discard();
    }
    return $action->discard();
  }
  
  /**
  * Menu For Ore
  * @param Player $player
  */
  public function menuItem($player){
   $type = Mineral::getInstance()->getInstance()->getId()->get($player->getName());
   $id = Mineral::getInstance()->getInstance()->getInt()->get($player->getName());
   $message = Mineral::getInstance()->getInstance()->getMessage();
   $menu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
   $menu->setListener(Closure::fromCallable([$this, "menuItemListener"]));
   $menu->readonly();
   $menu->setName($message->getNested("menu.name"));
   $inv = $menu->getInventory();
   for($i = 0; $i <= 9; $i++){
     $inv->setItem($i, VanillaBlocks::IRON_BARS()->asItem()->setCustomName("§l§r "));
   }
   
   $inv->setItem(13, StringToItemParser::getInstance()->parse($type)->setCustomName("§l§aYou Have: §9[ §c" . Mineral::getInstance()->getNumber($id, $player) . " §9]"));
   
   $inv->setItem(17, VanillaBlocks::IRON_BARS()->asItem()->setCustomName("§l§r "));
   $inv->setItem(18, VanillaBlocks::IRON_BARS()->asItem()->setCustomName("§l§r "));
   
   $inv->setItem(20, VanillaItems::NETHER_STAR()->setCustomName("§l§bADD"));
   
   $inv->setItem(22, VanillaBlocks::RAIL()->asItem()->setCustomName("§l|"));
   
   $inv->setItem(24, VanillaItems::NETHER_STAR()->setCustomName("§l§bWITHDRAW"));
   
   $inv->setItem(26, VanillaBlocks::IRON_BARS()->asItem()->setCustomName("§l§r "));
   $inv->setItem(27, VanillaBlocks::IRON_BARS()->asItem()->setCustomName("§l§r "));
    
   $inv->setItem(28, VanillaItems::PAPER()->setCustomName("§oAdd x64")->setCount(64));
   $inv->setItem(29, VanillaItems::PAPER()->setCustomName("§oAdd x32")->setCount(32));
   $inv->setItem(30, VanillaItems::PAPER()->setCustomName("§oAdd x16")->setCount(16));
   
   $inv->setItem(31, VanillaBlocks::RAIL()->asItem()->setCustomName("§l|"));
   
   $inv->setItem(32, VanillaItems::PAPER()->setCustomName("§oWithdraw x16")->setCount(16));
   $inv->setItem(33, VanillaItems::PAPER()->setCustomName("§oWithdraw x32")->setCount(32));
   $inv->setItem(34, VanillaItems::PAPER()->setCustomName("§oWithdraw x64")->setCount(64));
   
   $inv->setItem(35, VanillaBlocks::IRON_BARS()->asItem()->setCustomName("§l§r "));
   $inv->setItem(36, VanillaBlocks::IRON_BARS()->asItem()->setCustomName("§l§r "));
   
   $inv->setitem(38, VanillaBlocks::CHEST()->asItem()->setCustomName("§oAdd §cCustom"));
   
   $inv->setItem(40, VanillaBlocks::RAIL()->asItem()->setCustomName("§l|"));
   
   $inv->setItem(42, VanillaBlocks::CHEST()->asItem()->setCustomName("§oWithdraw §cCustom"));
   
   for($i = 44; $i <= 52; $i++){
     $inv->setItem($i, VanillaBlocks::IRON_BARS()->asItem()->setCustomName("§l§r "));
   }
   
   $inv->setItem(53, VanillaItems::WRITABLE_BOOK()->setCustomName($message->getNested("menu.back")));
   
   $menu->send($player);
  }
  
  public function menuItemListener(InvMenuTransaction $action) : InvMenuTransactionResult{
    $item = $action->getOut();
    $item_name = $item->getCustomName();
    $player = $action->getPlayer();
    $inv = $action->getAction()->getInventory();
    $id = Mineral::getInstance()->getId()->get($player->getName());
    $type = Mineral::getInstance()->getInt()->get($player->getName());
    $message = Mineral::getInstance()->getMessage();
    $prefix = $message->get("prefix");
    $data = Mineral::getInstance()->getData($player);
   
    if($item_name === $message->getNested("menu.back")){
       $this->menuORE($player);
       return $action->discard();
    }
    
    if($item_name === "§oAdd §cCustom"){
       $player->removeCurrentWindow($inv);
       $player->sendForm($this->CustomAddForm($player));
       return $action->discard();
    }
    
    if($item_name === "§oWithdraw §cCustom"){
      $player->removeCurrentWindow($inv);
      $player->sendForm($this->CustomWithdrawForm($player));
      return $action->discard();
    }
    
    if($item_name === "§oAdd x64"){
      if($player->getInventory()->contains(StringToItemParser::getInstance()->parse($id)->setCount(64))){
         $player->getInventory()->removeItem(StringToItemParser::getInstance()->parse($id)->setCount(64));
         $data->set($type, ($data->get($type) + 64));
         $data->save();
         SoundEffect::sendSuccess($player);
         $player->sendMessage($prefix . str_replace(["{amount}"], ["64"], $message->get("add_successfully")));
         $player->removeCurrentWindow($inv);
      }else{
         $player->sendMessage($prefix . $message->get("add_fail"));
         SoundEffect::sendFail($player);
         $player->removeCurrentWindow($inv);
      }
      return $action->discard();
    }
    
    if($item_name === "§oAdd x32"){
      if($player->getInventory()->contains(StringToItemParser::getInstance()->parse($id)->setCount(32))){
         $player->getInventory()->removeItem(StringToItemParser::getInstance()->parse($id)->setCount(32));
         $data->set($type, ($data->get($type) + 32));
         $data->save();
         SoundEffect::sendSuccess($player);
         $player->sendMessage($prefix . str_replace(["{amount}"], ["32"], $message->get("add_successfully")));
         $player->removeCurrentWindow($inv);
      }else{
         $player->sendMessage($prefix . $message->get("add_fail"));
         SoundEffect::sendFail($player);
         $player->removeCurrentWindow($inv);
      }
      return $action->discard();
    }
    
    if($item_name === "§oAdd x16"){
      if($player->getInventory()->contains(StringToItemParser::getInstance()->parse($id)->setCount(16))){
         $player->getInventory()->removeItem(StringToItemParser::getInstance()->parse($id)->setCount(16));
         $data->set($type, ($data->get($type) + 16));
         $data->save();
         SoundEffect::sendSuccess($player);
         $player->sendMessage($prefix . str_replace(["{amount}"], ["16"], $message->get("add_successfully")));
         $player->removeCurrentWindow($inv);
      }else{
         $player->sendMessage($prefix . $message->get("add_fail"));
         SoundEffect::sendFail($player);
         $player->removeCurrentWindow($inv);
      }
      return $action->discard();
    }
    
    if($item_name === "§oWithdraw x64"){
      if($data->get($type) >= 64){
         if($player->getInventory()->firstEmpty() == -1){
            SoundEffect::sendFail($player);
            $player->sendMessage($prefix . $message->get("Inventory-Full"));
            $player->removeCurrentWindow($inv);
         }else{
            $player->getInventory()->addItem(StringToItemParser::getInstance()->parse($id)->setCount(64));
            $data->set($type, ($data->get($type) - 64));
            $data->save();
            SoundEffect::sendSuccess($player);
            $player->sendMessage($prefix . str_replace(["{amount}"], ["64"], $message->get("withdraw_successfully")));
            $player->removeCurrentWindow($inv);
         }
      }else{
        $player->removeCurrentWindow($inv);
        $player->sendMessage($prefix . $message->get("withdraw_fail"));
        SoundEffect::sendFail($player);
      }  
      return $action->discard();
    }
    
   
    if($item_name === "§oWithdraw x32"){
      if($data->get($type) >= 32){
         if($player->getInventory()->firstEmpty() == -1){
            SoundEffect::sendFail($player);
            $player->sendMessage($prefix . $message->get("Inventory-Full"));
            $player->removeCurrentWindow($inv);
         }else{
            $player->getInventory()->addItem(StringToItemParser::getInstance()->parse($id)->setCount(32));
            $data->set($type, ($data->get($type) - 32));
            $data->save();
            SoundEffect::sendSuccess($player);
            $player->sendMessage($prefix . str_replace(["{amount}"], ["32"], $message->get("withdraw_successfully")));
            $player->removeCurrentWindow($inv);
         }
      }else{
        $player->removeCurrentWindow($inv);
        $player->sendMessage($prefix . $message->get("withdraw_fail"));
        SoundEffect::sendFail($player);
      }  
      return $action->discard();
    }
    
    if($item_name === "§oWithdraw x16"){
      if($data->get($type) >= 16){
         if($player->getInventory()->firstEmpty() == -1){
            SoundEffect::sendFail($player);
            $player->sendMessage($prefix . $message->get("Inventory-Full"));
            $player->removeCurrentWindow($inv);
         }else{
            $player->getInventory()->addItem(StringToItemParser::getInstance()->parse($id)->setCount(16));
            $data->set($type, ($data->get($type) - 16));
           $data->save();
            SoundEffect::sendSuccess($player);
            $player->sendMessage($prefix . str_replace(["{amount}"], ["16"], $message->get("withdraw_successfully")));
            $player->removeCurrentWindow($inv);
         }
      }else{
        $player->removeCurrentWindow($inv);
        $player->sendMessage($prefix . $message->get("withdraw_fail"));
        SoundEffect::sendFail($player);
      }  
      return $action->discard();
    }
    return $action->discard();
  }
  
  
  public function CustomAddForm(Player $player) : CustomForm{
    $message = Mineral::getInstance()->getMessage();
    $prefix = $message->get("prefix");
    $id = Mineral::getInstance()->getId()->get($player->getName());
    $type = Mineral::getInstance()->getInt()->get($player->getName());
    $data_player = Mineral::getInstance()->getData($player);
    
    return new CustomForm(
      "§l§aMINERAL §b| §cADD",
      [
        new Input("amount", "Amount", "Enter quantity here")
      ],
      function(Player $player, CustomFormResponse $data) use ($message, $id, $type, $data_player, $prefix) : void{
        $data = $data->getAll();
        $amount = $data["amount"];
        if(!is_numeric($amount)){
           $player->sendMessage($amount . " §cis not a number!");
           return;
        }
        
        if(!ctype_digit($amount) == 0.1){
           $player->sendMessage($amount . " §c is a negative number");
           return;
        }
        
        if($amount < 0){
           $player->sendMessage($amount . " §cis less than 0");
        }else{
          if($player->getInventory()->contains(StringToItemParser::getInstance()->parse($id)->setCount((int)$amount))){
             $player->getInventory()->removeItem(StringToItemParser::getInstance()->parse($id)->setCount((int)$amount));
             $data_player->set($type, ($data_player->get($type) + $amount));
             $data_player->save();
             SoundEffect::sendSuccess($player);
             $player->sendMessage($prefix . str_replace(["{amount}"], [$amount], $message->get("add_successfully")));
          }else{
             $player->sendMessage($prefix . $message->get("add_fail"));
             SoundEffect::sendFail($player);
          }
        }
      },
      function(Player $player) : void{
        $player->sendMessage("§l§aThank For Using!");
      }
    );
  }
 public function CustomWithdrawForm(Player $player) : CustomForm{
    $message = Mineral::getInstance()->getMessage();
    $prefix = $message->get("prefix");
    $id = Mineral::getInstance()->getId()->get($player->getName());
    $type = Mineral::getInstance()->getInt()->get($player->getName());
    $data_player = Mineral::getInstance()->getData($player);
    
    return new CustomForm(
      "§l§aMINERAL §b| §cWITHDRAW",
      [
        new Input("amount", "Amount", "Enter quantity here")
      ],
      function(Player $player, CustomFormResponse $data) use ($message, $id, $type, $data_player, $prefix) : void{
        $data = $data->getAll();
        $amount = $data["amount"];
        if(!is_numeric($amount)){
           $player->sendMessage($amount . " §cis not a number!");
           return;
        }
        
        if(!ctype_digit($amount) == 0.1){
           $player->sendMessage($amount . " §c is a negative number");
           return;
        }
        
        if($amount < 0){
           $player->sendMessage($amount . " §cis less than 0");
        }else{
          if($data_player->get($type) >= $amount){
            if($player->getInventory()->firstEmpty() === -1){
               $player->sendMessage($prefix . $message->get("Inventory-Full"));
            }else{
              SoundEffect::sendSuccess($player);
              $player->getInventory()->addItem(StringToItemParser::getInstance()->parse($id)->setCount((int)$amount));
              $player->sendMessage($prefix . str_replace(["{amount}"], [$amount], $message->get("withdraw_successfully")));
              $data_player->set($type, ($data_player->get($type) - $amount));
              $data_player->save();
            }
          }else{
            SoundEffect::sendFail($player);
            $player->sendMessage($prefix . $message->get("withdraw_fail"));
          }
        }
      },
      function(Player $player) : void{
        $player->sendMessage("§l§aThank For Using!");
      }
    );
  }
}

<?php

/**
 * ______                 _
 * | ___ \               (_)
 * | |_/ /___ _ __   __ _ _ _ __
 * |    // _ \ '_ \ / _` | | '__|
 * | |\ \  __/ |_) | (_| | | |
 * \_| \_\___| .__/ \__,_|_|_|
 *           | |
 *           |_| By @JackMD for PMMP
 *
 * Repair, a Repair plugin for PocketMine-MP.
 * Copyright (c) 2018 JackMD  < https://github.com/JackMD >
 *
 * Discord: JackMD#3717
 * Twitter: JackMTaylor_
 *
 * This software is distributed under "GNU General Public License v3.0".
 * This license allows you to use it and/or modify it but you are not at
 * all allowed to sell this plugin at any cost. If found doing so the
 * necessary action required would be taken. Further removal of the
 * License and or authors name from this software is strictly prohibited.
 *
 * Repair is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License v3.0 for more details.
 *
 * You should have received a copy of the GNU General Public License v3.0
 * along with this program. If not, see
 * <https://opensource.org/licenses/GPL-3.0>.
 * ------------------------------------------------------------------------
 */

declare(strict_types = 1);

namespace JackMD\Repair;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\math\Vector3;
use pocketmine\tile\Sign;
use pocketmine\utils\TextFormat;

class EventListener implements Listener{
	
	/** @var Main $plugin */
	private $plugin;
	
	/**
	 * EventListener constructor.
	 *
	 * @param Main $plugin
	 */
	public function __construct(Main $plugin){
		$this->plugin = $plugin;
	}
	
	/**
	 * @param PlayerInteractEvent $event
	 */
	public function onSignTap(PlayerInteractEvent $event): void{
		$tile = $event->getBlock()->getLevel()->getTile(new Vector3($event->getBlock()->getFloorX(), $event->getBlock()->getFloorY(), $event->getBlock()->getFloorZ()));
		if($tile instanceof Sign){
			if(TextFormat::clean($tile->getText()[0], true) === "[Repair]"){
				if($this->plugin->getConfig()->get("enableRepairSigns") == true){
					$event->setCancelled(true);
					if(!$event->getPlayer()->hasPermission("repair.sign.use")){
						$event->getPlayer()->sendMessage(TextFormat::RED . "[Error]" . TextFormat::DARK_RED . " You don't have permissions to use this sign.");
						return;
					}
					if(($tile->getText()[1]) === "Hand"){
						if(!$event->getPlayer()->hasPermission("repair.sign.use.hand")){
							$event->getPlayer()->sendMessage(TextFormat::RED . "[Error]" . TextFormat::DARK_RED . " You don't have the permission to use this sign.");
							return;
						}
						$index = $event->getPlayer()->getInventory()->getHeldItemIndex();
						$item = $event->getPlayer()->getInventory()->getItem($index);
						if($this->plugin->isRepairable($item)){
							if($item->getDamage() > 0){
								$event->getPlayer()->getInventory()->setItem($index, $item->setDamage(0));
								$event->getPlayer()->sendMessage(TextFormat::GREEN . "Item successfully repaired.");
							}else{
								$event->getPlayer()->sendMessage(TextFormat::RED . "[Error]" . TextFormat::DARK_RED . " Item does not have any damage.");
							}
						}else{
							$event->getPlayer()->sendMessage(TextFormat::RED . "[Error]" . TextFormat::DARK_RED . " This item cannot be repaired.");
						}
					}
					if(($tile->getText()[1]) === "All"){
						if(!$event->getPlayer()->hasPermission("repair.sign.use.all")){
							$event->getPlayer()->sendMessage(TextFormat::RED . "[Error]" . TextFormat::DARK_RED . " You don't have the permission to use this sign.");
							return;
						}
						foreach($event->getPlayer()->getInventory()->getContents() as $index => $item){
							if($this->plugin->isRepairable($item)){
								if($item->getDamage() > 0){
									$event->getPlayer()->getInventory()->setItem($index, $item->setDamage(0));
								}
							}
						}
						foreach($event->getPlayer()->getArmorInventory()->getContents() as $index => $item){
							if($this->plugin->isRepairable($item)){
								if($item->getDamage() > 0){
									$event->getPlayer()->getArmorInventory()->setItem($index, $item->setDamage(0));
								}
							}
						}
						$event->getPlayer()->sendMessage(TextFormat::GREEN . "All the tools in your inventory were repaired (including the equipped Armor)");
					}
				}else{
					$event->getPlayer()->sendMessage(TextFormat::RED . "[Error]" . TextFormat::DARK_RED . " Repair signs are currently disabled.");
				}
			}
		}
	}
	
	/**
	 * @param BlockPlaceEvent $event
	 * @priority HIGH
	 */
	public function onBlockPlace(BlockPlaceEvent $event): void{
		$tile = $event->getBlock()->getLevel()->getTile(new Vector3($event->getBlock()->getFloorX(), $event->getBlock()->getFloorY(), $event->getBlock()->getFloorZ()));
		if($tile instanceof Sign){
			if(TextFormat::clean($tile->getText()[0], true) === "[Repair]"){
				if(!$event->getPlayer()->hasPermission("repair.sign.place")){
					$event->getPlayer()->sendMessage(TextFormat::RED . "[Error]" . TextFormat::DARK_RED . " You don't have permission to place repair signs.");
					return;
				}
				if($this->plugin->getConfig()->get("enableRepairSigns") == true){
					$event->setCancelled(true);
					$event->getPlayer()->sendMessage(TextFormat::RED . "You don't have permissions to break this sign.");
				}else{
					$event->getPlayer()->sendMessage(TextFormat::RED . "[Error]" . TextFormat::DARK_RED . " Repair signs are currently disabled.");
				}
			}
		}
	}
	
	/**
	 * @param BlockBreakEvent $event
	 * @priority HIGH
	 */
	public function onBlockBreak(BlockBreakEvent $event): void{
		$tile = $event->getBlock()->getLevel()->getTile(new Vector3($event->getBlock()->getFloorX(), $event->getBlock()->getFloorY(), $event->getBlock()->getFloorZ()));
		if($tile instanceof Sign){
			if(TextFormat::clean($tile->getText()[0], true) === "[Repair]"){
				if(!$event->getPlayer()->hasPermission("repair.sign.break")){
					$event->getPlayer()->sendMessage(TextFormat::RED . "[Error]" . TextFormat::DARK_RED . " You don't have permission to break repair signs.");
					return;
				}
				if($this->plugin->getConfig()->get("enableRepairSigns") == true){
					$event->getPlayer()->sendMessage(TextFormat::GREEN . "Repair sign successfully broken.");
				}else{
					$event->setCancelled(true);
					$event->getPlayer()->sendMessage(TextFormat::RED . "[Error]" . TextFormat::DARK_RED . " Repair signs are currently disabled.");
				}
			}
		}
	}
	
	/**
	 * @param SignChangeEvent $event
	 */
	public function onSignChange(SignChangeEvent $event): void{
		if(strtolower(TextFormat::clean($event->getLine(0), true)) == "[repair]"){
			if(!$event->getPlayer()->hasPermission("repair.sign.create")){
				$event->getPlayer()->sendMessage(TextFormat::RED . "[Error]" . TextFormat::DARK_RED . " You don't have permission to create repair signs.");
				return;
			}
			if($this->plugin->getConfig()->get("enableRepairSigns") == true){
				switch(strtolower($event->getLine(1))){
					case "hand":
						$event->setLine(1, "Hand");
						break;
					case "all":
						$event->setLine(1, "All");
						break;
					default:
						$event->setCancelled(true);
				}
				$event->getPlayer()->sendMessage(TextFormat::GREEN . "Repair sign successfully created!");
				$event->setLine(0, TextFormat::AQUA . "[Repair]");
			}else{
				$event->getPlayer()->sendMessage(TextFormat::RED . "[Error]" . TextFormat::DARK_RED . " Repair signs are currently disabled.");
			}
		}
	}
}

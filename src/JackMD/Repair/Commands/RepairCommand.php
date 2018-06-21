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

namespace JackMD\Repair\Commands;

use JackMD\Repair\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class RepairCommand extends PluginCommand{
	
	/** @var Main $plugin */
	private $plugin;
	
	/**
	 * RepairCommand constructor.
	 *
	 * @param string $name
	 * @param Main   $plugin
	 */
	public function __construct(string $name, Main $plugin){
		parent::__construct($name, $plugin);
		$this->setDescription("Access to repair commands.");
		$this->setUsage("/repair [all:hand]");
		$this->setAliases(["fix"]);
		$this->setPermission("repair.command.use");
		$this->plugin = $plugin;
	}
	
	/**
	 * @param CommandSender $sender
	 * @param string        $alias
	 * @param array         $args
	 * @return bool
	 */
	public function execute(CommandSender $sender, string $alias, array $args): bool{
		if(!$this->testPermission($sender)){
			return true;
		}
		if(!$sender instanceof Player){
			$sender->sendMessage(TextFormat::RED . "[Error]" . TextFormat::DARK_RED . " This command only works in game.");
			return true;
		}
		$a = "hand";
		if(isset($args[0])){
			$a = strtolower($args[0]);
		}
		if(!($a === "hand" || $a === "all")){
			$sender->sendMessage(TextFormat::RED . "Usage:" . TextFormat::DARK_RED . "/repair [all:hand]");
			return true;
		}
		if($a === "all"){
			if(!$sender->hasPermission("repair.command.use.all")){
				$sender->sendMessage(TextFormat::RED . "[Error]" . TextFormat::DARK_RED . " You don't have permission to use this command.");
				return true;
			}
			foreach($sender->getInventory()->getContents() as $index => $item){
				if($this->plugin->isRepairable($item)){
					if($item->getDamage() > 0){
						$sender->getInventory()->setItem($index, $item->setDamage(0));
					}
				}
			}
			$m = TextFormat::GREEN . "All the tools in your inventory were repaired!";
			if($sender->hasPermission("essentials.repair.armor")){
				foreach($sender->getArmorInventory()->getContents() as $index => $item){
					if($this->plugin->isRepairable($item)){
						if($item->getDamage() > 0){
							$sender->getArmorInventory()->setItem($index, $item->setDamage(0));
						}
					}
				}
				$m .= TextFormat::AQUA . " (Including the equipped Armor)";
			}
		}else{
			if(!$sender->hasPermission("repair.command.use.hand")){
				$sender->sendMessage(TextFormat::RED . "[Error]" . TextFormat::DARK_RED . " You don't have permission to use this command.");
				return true;
			}
			$index = $sender->getInventory()->getHeldItemIndex();
			$item = $sender->getInventory()->getItem($index);
			if(!$this->plugin->isRepairable($item)){
				$sender->sendMessage(TextFormat::RED . "[Error] This item can't be repaired!");
				return true;
			}
			if($item->getDamage() > 0){
				$sender->getInventory()->setItem($index, $item->setDamage(0));
			}else{
				$sender->sendMessage(TextFormat::RED . "[Error] Item does not have any damage");
			}
			$m = TextFormat::GREEN . "Item successfully repaired!";
		}
		$sender->sendMessage($m);
		return true;
	}
}

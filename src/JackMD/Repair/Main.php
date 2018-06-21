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

use JackMD\Repair\Commands\RepairCommand;
use pocketmine\item\Armor;
use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase{
	
	public function onEnable(): void{
		if (!is_dir($this->getDataFolder())){
			mkdir($this->getDataFolder());
		}
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		$this->getServer()->getCommandMap()->register("repair", new RepairCommand("repair", $this));
		$this->saveDefaultConfig();
		$this->getLogger()->info("Plugin Enabled.");
	}
	
	/**
	 * @param Item $item
	 * @return bool
	 */
	public function isRepairable(Item $item): bool{
		return $item instanceof Tool || $item instanceof Armor;
	}
}

<?php

namespace antbag\JoinCount;

use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerJoinEvent;

class Main extends PluginBase {

    public function onEnable(): void {
        // Register event listener
        $listener = new PlayerJoinListener($this->getDataFolder() . "playerData.json");
        $this->getServer()->getPluginManager()->registerEvents($listener, $this);
    }
}

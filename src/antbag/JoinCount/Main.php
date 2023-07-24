<?php

namespace antbag\JoinCount;

use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\util\Config;

class Main extends PluginBase {

    public function onEnable(): void {
        // Register event listener
        $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $config->save();
        $listener = new PlayerJoinListener($this->getDataFolder() . "playerData.json");
        $this->getServer()->getPluginManager()->registerEvents($listener, $this);
    }
}

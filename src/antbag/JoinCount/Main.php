<?php

namespace antbag\JoinCount;

use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\Config;

class Main extends PluginBase {

    public function onEnable(): void {
        // Register event listener
        $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->saveResource("config.yml");
        $listener = new PlayerJoinListener($this->getDataFolder() . "playerData.json");
        $this->getServer()->getPluginManager()->registerEvents($listener, $this);
    }
}

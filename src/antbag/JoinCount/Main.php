<?php

namespace antbag\JoinCount;

use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\Config;
use antbag\JoinCount\PlayerJoinListener;


class Main extends PluginBase {

    public static $instance;
    
    
    public function onEnable(): void {
        // Register event listener
        self::$instance = $this;
        $listener = new PlayerJoinListener($this->getDataFolder() . "playerData.json");
        $this->getServer()->getPluginManager()->registerEvents($listener, $this);
    }
    public static function getInstance(): Main{
        return self::$instance;
    }
}

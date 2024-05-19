<?php

namespace antbag\JoinCount;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase {

  private $config;

  public function onEnable(): void {
    $this->saveDefaultConfig();
    $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
    
    $listener = new PlayerJoinListener($this->getDataFolder() . "playerData.json", $this->config);
    $this->getServer()->getPluginManager()->registerEvents($listener, $this);
  }
}

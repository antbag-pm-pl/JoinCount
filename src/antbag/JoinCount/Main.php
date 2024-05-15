<?php

namespace antbag\JoinCount;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

  public function onEnable(): void {
    $listener = new PlayerJoinListener($this->getDataFolder() . "playerData.json");
    $this->getServer()->getPluginManager()->registerEvents($listener, $this);
  }
}
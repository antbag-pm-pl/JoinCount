<?php

namespace antbag\JoinCount;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\permission\Permission;
use pocketmine\permission\PermissionManager;

class Main extends PluginBase {

  private $config;
  private $listener;

  public function onEnable(): void {
    $this->saveDefaultConfig();
    $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
    
    $this->listener = new PlayerJoinListener($this->getDataFolder() . "playerData.json", $this->config);
    $this->getServer()->getPluginManager()->registerEvents($this->listener, $this);

    // Add permission
    $perm = new Permission("joincount.totalplayers", "Allows the user to see the total number of players");
    PermissionManager::getInstance()->addPermission($perm);
  }

  public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
    if ($command->getName() === "totalplayers") {
      if($sender->hasPermission("joincount.totalplayers")) {
        $totalPlayers = count($this->listener->loadData());
        $sender->sendMessage("Total players registered: " . $totalPlayers);
        return true;
      } else {
        $sender->sendMessage("You do not have permission to use this command.");
        return true;
      }
    }
    return false;
  }
}

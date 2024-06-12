<?php

namespace antbag\JoinCount;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Server;
use pocketmine\utils\Config;

class PlayerJoinListener implements Listener {

  private $dataFile;
  private $config;

  public function __construct(string $dataFilePath, Config $config) {
    $this->dataFile = $dataFilePath;
    $this->config = $config;
  }

  public function onPlayerJoin(PlayerJoinEvent $event) {
    $player = $event->getPlayer();
    $playerName = $player->getName();
    $data = $this->loadData(); 
    if (!isset($data[$playerName])) {
      $data[$playerName] = true; 
      $this->saveData($data); 
      $totalPlayers = count($data);
      $message = str_replace("{player}", $playerName, $this->config->get("messages.join"));
      $message = str_replace("{number}", $totalPlayers, $message);
      Server::getInstance()->broadcastMessage($message);
    }
  }

  public function loadData(): array {
    if (!file_exists($this->dataFile)) {
      return [];
    }
    $data = file_get_contents($this->dataFile);
    return json_decode($data, true) ?? [];
  }

  private function saveData(array $data) {
    $encodedData = json_encode($data);
    file_put_contents($this->dataFile, $encodedData);
  }
}

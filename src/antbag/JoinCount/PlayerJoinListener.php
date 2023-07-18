<?php

namespace antbag\JoinCount;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Server;

class PlayerJoinListener implements Listener {

    private $dataFile; // File to store player information

    public function __construct(string $dataFilePath) {
        $this->dataFile = $dataFilePath;
    }

    public function onPlayerJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $playerName = $player->getName();

        $data = $this->loadData(); // Load existing player data

        if (!isset($data[$playerName])) {
            $data[$playerName] = true; // Store the player's join status

            $this->saveData($data); // Save updated player data

            $totalPlayers = count($data);

         $welcomeMessage = "Â§8Welcome,Â§c $playerName! Â§8You are the #Â§8 $totalPlayers Â§8player to join our server!";
 
 $cmds = "say " .$welcomeMessage. " ";
            
        Server::getInstance()->broadcastMessage($welcomeMessage);
        }
    }

    private function loadData(): array {
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
    
 private function sendToAllPlayers(string $message) {
    $server = $this->getPlugin()->getServer();
    $players = $server->getOnlinePlayers();
    foreach ($players as $player) {
        $player->sendMessage($message);
    }
}
}

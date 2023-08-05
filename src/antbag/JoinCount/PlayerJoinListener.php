<?php

namespace antbag\JoinCount;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Server;
use antbag\JoinCount\Main;



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

            $welcomeMessage = "§8Welcome,§c $playerName! §8You are the #§8 $totalPlayers §8player to join our server!"
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
}

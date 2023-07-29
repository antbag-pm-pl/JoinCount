<?php

namespace antbag\JoinCount;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Server;
use antbag\JoinCount\Main;

use CortexPE\DiscordWebhookAPI\Message;
use CortexPE\DiscordWebhookAPI\Webhook;
use CortexPE\DiscordWebhookAPI;

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

            $welcomeMessage = Main::getInstance()->config->getNested("WelcomeMessage");
            $player = str_replace("{player}", $playerName, $player);
            $totalplayer = str_replace("{total_players}", $totalPlayers, $totalplayer);
            Server::getInstance()->broadcastMessage($welcomeMessage);
            
            $webHook = new Webhook(Main::getInstance()->$url);
            
            $msg = new Message();
            
            $msg->setUsername("JoinCount");
            $msg->setAvatarURL("https://cortexpe.xyz/utils/kitsu.png");
            
            $embed = new Embed();
            $embed->setTitle("New Player");
            $embed->setColor(0x00FF00);
            $embed->setAuthor("antbag");
            $embed->setDescription($welcomeMessage);
            $msg->addEmbed($embed);
            
            $webHook->send($msg);
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

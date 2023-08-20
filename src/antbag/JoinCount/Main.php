<?php

declare(strict_types=1);

namespace antbag\JoinCount;

use NhanAZ\libBedrock\Counter;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerJoinEvent;
use CortexPE\DiscordWebhookAPI\Message;
use CortexPE\DiscordWebhookAPI\Webhook;

class Main extends PluginBase implements Listener {

    private int $totalPlayers;
    private $webhook = false;
    private $webhook_url;

    protected function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->totalPlayers = Counter::getFileInfo($this->getServer()->getDataPath() . "players", ".dat")["totalFiles"];
        $this->saveDefaultConfig();
        $this->webhook_url = $this->getConfig()->get("webhook-url");
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $playerName = $player->getName();
        if (!$player->hasPlayedBefore()) {
            if ($this->getConfig()->get("webhook") == true) {
                $this->webhook = true;
                $webHook = new Webhook($this->webhook_url);
                $msg = new Message();

                $msg->setUsername("JoinCount");
                $msg->setAvatarURL("https://cortexpe.xyz/utils/kitsu.png");
                $msg->setContent($welcomeMessage);

                $webHook->send($msg);
                $this->getServer()->broadcastMessage($welcomeMessage);
            }
            $this->totalPlayers++;
            $welcomeMessage = "§8Welcome,§c $playerName! §8You are the #§8 " . $this->totalPlayers . " §8player to join our server!";
            $this->getServer()->broadcastMessage($welcomeMessage);
        }
    }
}

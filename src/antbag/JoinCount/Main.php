<?php

declare(strict_types=1);

namespace antbag\JoinCount;

use NhanAZ\libBedrock\Counter;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerJoinEvent;

class Main extends PluginBase implements Listener {

    private int $totalPlayers;

    protected function onEnable(): void {
        // Register event listener
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->totalPlayers = Counter::getFileInfo($this->getServer()->getDataPath() . "players", ".dat")["totalFiles"];
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $playerName = $player->getName();
        if (!$player->hasPlayedBefore()) {
            $this->totalPlayers++;
            $welcomeMessage = "§8Welcome,§c $playerName! §8You are the #§8 " . $this->totalPlayers . " §8player to join our server!";
            $this->getServer()->broadcastMessage($welcomeMessage);
        }
    }
}

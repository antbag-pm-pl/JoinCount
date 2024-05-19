namespace antbag\JoinCount;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Server;

class PlayerJoinListener implements Listener {

  private $dataFile;
  private $welcomeMessage;

  public function __construct(string $dataFilePath, array $config) {
    $this->dataFile = $dataFilePath;
    $this->welcomeMessage = $config["welcome_message"];
  }

  public function onPlayerJoin(PlayerJoinEvent $event) {
    $player = $event->getPlayer();
    $playerName = $player->getName();
    $data = $this->loadData(); 
    if (!isset($data[$playerName])) {
      $data[$playerName] = true; 
      $this->saveData($data); 
      $totalPlayers = count($data);
      $message = str_replace(["{player}", "{count}"], [$playerName, $totalPlayers], $this->welcomeMessage);
      Server::getInstance()->broadcastMessage($message);
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

namespace antbag\JoinCount;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

  public function onEnable(): void {
    $this->saveDefaultConfig(); // Copy default config.yml if it doesn't exist
    $config = $this->getConfig()->getAll();
    $listener = new PlayerJoinListener($this->getDataFolder() . "playerData.json", $config, $this->getLogger());
    $this->getServer()->getPluginManager()->registerEvents($listener, $this);
    $this->getLogger()->info("Plugin enabled successfully.");
  }
}

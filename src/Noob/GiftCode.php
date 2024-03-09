<?php

namespace Noob;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use pocketmine\player\Player;
use Noob\commands\EnterCodeCommand;
use Noob\commands\CreateCodeCommand;
use Noob\commands\DeleteCodeCommand;
use pocketmine\Server;

class GiftCode extends PluginBase {

    public $code;
	public static $instance;

	public static function getInstance() : self {
		return self::$instance;
	}

	public function onEnable(): void{
        self::$instance = $this;
        $this->getServer()->getCommandMap()->register("/createcode", new CreateCodeCommand($this));
        $this->getServer()->getCommandMap()->register("/deletecode", new DeleteCodeCommand($this));
        $this->getServer()->getCommandMap()->register("/entercode", new EnterCodeCommand($this));
        $this->code = new Config($this->getDataFolder() . "code.yml", Config::YAML);
	}

    public function onDisable(): void{
        $this->code->save();
    }

    public function Code(){
        return $this->code;
    }

    public function createCode(string $codeName, int $soLuot, int $coin, int $money){
        $this->code->set($codeName, [
            "Luot-Nhap" => $soLuot,
            "Money" => $money,
            "Coin" => $coin,
            "Used" => ""
        ]);
        $this->code->save();
    }

    public function deleteCode(string $codeName){
        $this->code->remove($codeName);
    }

    public function getUsed(string $codeName, Player $player): bool{
        $used = $this->code->getNested($codeName. ".Used");
        $list = explode(", ", $used);
        foreach($list as $name){
            if($player->getName() == $name){
                return true;
            }
        }
        return false;
    }
}
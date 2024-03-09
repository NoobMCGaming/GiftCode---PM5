<?php

namespace Noob\commands;

use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use Noob\GiftCode;
use Noob\forms\EnterForm;

class EnterCodeCommand extends Command implements PluginOwned {

	private GiftCode $plugin;

    public function __construct(GiftCode $plugin){
    	$this->plugin = $plugin;
    	parent::__construct("entercode", "Lệnh Để Mở Giao Diện Nhập Code", null, []);
        $this->setPermission("entercode.cmd");
    }

    public function execute(CommandSender $player, string $label, array $args){
    	if(!$player instanceof Player){
            $this->getOwningPlugin()->getLogger()->notice("Xin hãy sử dụng lệnh trong trò chơi");
            return true;
        }
        $form = new EnterForm;
        $form->enterMenu($player);
    }

    public function getOwningPlugin() : GiftCode {
        return $this->plugin;
    }
}
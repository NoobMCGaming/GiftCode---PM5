<?php

namespace Noob\commands;

use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use Noob\GiftCode;
use Noob\forms\DeleteForm;

class DeleteCodeCommand extends Command implements PluginOwned {

	private GiftCode $plugin;

    public function __construct(GiftCode $plugin){
    	$this->plugin = $plugin;
    	parent::__construct("deletecode", "Lệnh Để Mở Giao Diện Xóa Code", null, []);
        $this->setPermission("deletecode.cmd");
    }

    public function execute(CommandSender $player, string $label, array $args){
    	if(!$player instanceof Player){
            $this->getOwningPlugin()->getLogger()->notice("Xin hãy sử dụng lệnh trong trò chơi");
            return true;
        }
        $form = new DeleteForm;
        $form->deleteMenu($player);
    }

    public function getOwningPlugin() : GiftCode {
        return $this->plugin;
    }
}
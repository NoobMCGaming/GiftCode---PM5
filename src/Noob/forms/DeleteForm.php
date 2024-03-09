<?php

declare(strict_types=1);

namespace Noob\forms;

use pocketmine\player\Player;
use Noob\GiftCode;
use pocketmine\Server;
use jojoe77777\FormAPI\{SimpleForm, CustomForm};

class DeleteForm {

    public function deleteMenu(Player $player){
        $form = new CustomForm(function(Player $player, $data){
            if($data === null){
                return true;
            }
            if(!isset($data[0])){
                $player->sendMessage("§a* §fVui Lòng Tạo Code Là Chữ");
                return true;
            }
            if(GiftCode::getInstance()->Code()->exists($data[0])){
                GiftCode::getInstance()->deleteCode($data[0]);
            }
            else{
                $player->sendMessage("§a* §fCode Không Tồn Tại !");
            }
        });
        $form->setTitle("§l§c● §eXóa Code §c●");
        $form->addInput("§a* §fNhập Tên Code:", "Free Fire");
        $form->sendToPlayer($player);
    }
}
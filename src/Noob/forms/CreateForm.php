<?php

declare(strict_types=1);

namespace Noob\forms;

use pocketmine\player\Player;
use Noob\GiftCode;
use pocketmine\Server;
use jojoe77777\FormAPI\{SimpleForm, CustomForm};
use onebone\economyapi\EconomyAPI;
use onebone\coinapi\CoinAPI;

class CreateForm {

    public function createMenu(Player $player){
        $form = new CustomForm(function(Player $player, $data){
            if($data === null){
                return true;
            }
            if(!isset($data[0])){
                $player->sendMessage("§a* §fVui Lòng Tạo Code Là Chữ");
                return true;
            }
            if(!is_numeric($data[1])){
                $player->sendMessage("§a* §fVui Lòng Nhập Số Xu Muốn Tặng");
                return true;
            }
            if(!is_numeric($data[2])){
                $player->sendMessage("§a* §fVui Lòng Nhập Số Coin Muốn Tặng");
                return true;
            }
            if(!is_numeric($data[3]) && $data[3] > 0){
                $player->sendMessage("§a* §fVui Lòng Nhập Số Lượt Nhập");
                return true;
            }
            if(EconomyAPI::getInstance()->myMoney($player) >= $data[1]){
                if(CoinAPI::GetInstance()->myCoin($player) >= $data[2]){
                    if(!GiftCode::getInstance()->Code()->exists($data[0])){
                        GiftCode::getInstance()->createCode($data[0], (int)$data[3], (int)$data[2], (int)$data[1]);
                        EconomyAPI::getInstance()->reduceMoney($player, $data[1]);
                        CoinAPI::getInstance()->reduceCoin($player, $data[2]);
                    }
                    else{
                        $player->sendMessage("§a* §fCode Đã Tồn Tại Trước Đó");
                    }
                }
                else{
                    $player->sendMessage("§a* §fBạn Không Đủ Coin Để Tạo");
                }
            }
            else{
                $player->sendMessage("§a* §fBạn Không Đủ Xu Để Tạo");
            }
        });
        $form->setTitle("§l§c● §eTạo Code §c●");
        $form->addInput("§a* §fNhập Tên Code:", "Free Fire");
        $form->addInput("§a* §fNhập Xu Muốn Tặng:", "10");
        $form->addInput("§a* §fNhập Coin Muốn Tặng:", "20");
        $form->addInput("§a* §fNhập Số Lượt Nhập:", "1");
        $form->sendToPlayer($player);
    }
}
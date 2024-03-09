<?php

declare(strict_types=1);

namespace Noob\forms;

use pocketmine\player\Player;
use Noob\GiftCode;
use pocketmine\Server;
use jojoe77777\FormAPI\{SimpleForm, CustomForm};
use onebone\economyapi\EconomyAPI;
use onebone\coinapi\CoinAPI;

class EnterForm {

    public function enterMenu(Player $player){
        $form = new CustomForm(function(Player $player, $data){
            if($data === null){
                return true;
            }
            if(!isset($data[0])){
                $player->sendMessage("§a* §fVui Lòng Tạo Code Là Chữ");
                return true;
            }
            if(GiftCode::getInstance()->Code()->exists($data[0])){
                if(GiftCode::getInstance()->Code()->getNested($data[0]. ".Luot-Nhap") > 0){
                    if(GiftCode::getInstance()->getUsed($data[0], $player) == false){
                        $money = GiftCode::getInstance()->Code()->getNested($data[0]. ".Money");
                        $coin = GiftCode::getInstance()->Code()->getNested($data[0]. ".Coin");
                        $used = GiftCode::getInstance()->Code()->getNested($data[0]. ".Used");
                        $used .= ($player->getName() . ", ");
                        GiftCode::getInstance()->Code()->setNested($data[0]. ".Used", $used);
                        GiftCode::getInstance()->Code()->save();
                        GiftCode::getInstance()->Code()->setNested($data[0]. ".Luot-Nhap", GiftCode::getInstance()->Code()->getNested($data[0]. ".Luot-Nhap") - 1);
                        GiftCode::getInstance()->Code()->save();
                        EconomyAPI::getInstance()->addMoney($player, $money);
                        CoinAPI::getInstance()->addCoin($player, $coin);
                        $player->sendMessage("§a* §fBạn Đã Nhận Được ". $money ." Xu Và ". $coin ." Coin Từ Code ". $data[0]);
                        NhutDev::getInstance()->sendSound($player, "random.levelup");
                    }
                    else{
                        $player->sendMessage("§a* §fBạn Đã Nhập Code Này Trước Đó !");
                    }
                }
                else{
                    $player->sendMessage("§a* §fCode Đã Hết Lượt Nhập !");
                }
            }
            else{
                $player->sendMessage("§a* §fCode Không Tồn Tại !");
            }
        });
        $form->setTitle("§l§c● §eNhập Code §c●");
        $form->addInput("§a* §fNhập Tên Code:", "Free Fire");
        $form->sendToPlayer($player);
    }
}
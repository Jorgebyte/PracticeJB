<?php

namespace PracticeJB\Jorgebyte\utils;

use pocketmine\player\Player;
use pocketmine\utils\TextFormat as JB;
#  - - - -- - - - Libs - - - - - - - - -
use PracticeJB\Jorgebyte\libs\Forms\SimpleForm;
use PracticeJB\Jorgebyte\libs\Forms\Form;
# - - - - - - - - - - - - - - - - - - -
#  - - - - - - - My class - - - - - - - -
use PracticeJB\Jorgebyte\Main;
use PracticeJB\Jorgebyte\utils\Utils;
# - - - - - - - - - - - - - - - - - - - -

class Forms
{

    public $plugin;

    public function __construct()
    {
        $this->plugin = Main::getInstance();
    }

    public function gameForm($player): void
    {
        $form = new SimpleForm(function (Player $player, ?int $data) {
            if ($data === null) {
                return;
            }
            switch($data) {
                case 0:
                    $this->plugin->setGames()->sumoGame($player);
                    Utils::addSound($player, "random.pop", 1, 1);
                    break;
                case 1:
                    $this->plugin->setGames()->gappleGame($player);
                    Utils::addSound($player, "random.pop", 1, 1);
                    break;
                case 2:
                    Utils::addSound($player, "random.pop2", 1, 1);
                    break;
            }
            return true;
        });
        $form->setTitle(JB::RED . "GAMES");
        $form->setContent(JB::GOLD . "Select the game mode you want");
        $form->addButton(JB::BOLD . JB::BLUE . "SUMO");
        $form->addButton(JB::BOLD . JB::YELLOW . "GAPPLE");
        $form->addButton(JB::RED . "Close");
        $form->sendToPlayer($player);
    }

    public function infoForm($player): void
    {
        $form = new SimpleForm(function (Player $player, ?int $data) {
            if ($data === null) {
                return;
            }
            switch($data) {
                case 1:
                    Utils::addSound($player, "random.pop2", 1, 1);
                    break;
            }
            return true;
        });
        $form->setTitle(JB::GREEN . "Info");
        $form->setContent($this->plugin->getConfig()->get("info-content"));
        $form->addButton(JB::BOLD . JB::RED . "Close");
        $form->sendToPlayer($player);
    }

    public function deathForm($player): void
    {
        $form = new SimpleForm(function (Player $player, ?int $data) {
            if ($data === null) {
                return;
            }
            switch($data) {
                case 0:
                    Utils::addSound($player, "random.pop2", 1, 1);
                    break;
            }
            return true;
        });
        $form->setTitle(JB::DARK_AQUA . "PracticeJB");
        $form->setContent(JB::GRAY . "Respawn");
        $form->addButton(JB::GRAY . "Change Mode");
        $form->addButton(JB::RED . "Go out");
        $form->sendToPlayer($player);
    }
}
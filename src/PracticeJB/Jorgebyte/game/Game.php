<?php

namespace PracticeJB\Jorgebyte\game;

use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat as JB;
use PracticeJB\Jorgebyte\Main;
use PracticeJB\Jorgebyte\utils\Utils;
use PracticeJB\Jorgebyte\game\Kits;


class Game
{

    public $plugin;

    public function __construct()
    {
        $this->plugin = Main::getInstance();
    }

    private function configurePlayer(Player $player): void
    {
        $player->setGamemode(GameMode::ADVENTURE());
        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();
        $player->getEffects()->clear();
        $player->setScale(1);
        $player->setHealth(20);
        $player->setAllowFlight(false);
        $player->setFlying(false);
        $player->sendTitle(JB::DARK_AQUA . "You Have Joined");
    }

    private function joinGame(Player $player, string $worldName, string $gameMode): void
    {
        $world = Server::getInstance()->getWorldManager()->getWorldByName($this->plugin->getConfig()->get($worldName));

        if ($world !== null) {
            $player->teleport($world->getSafeSpawn());
            $this->configurePlayer($player, $world);

            if ($gameMode === "sumo") {
                Kits::setSumoKit($player);
            } elseif ($gameMode === "gapple") {
                Kits::setGappleKit($player);
            }

            foreach ($world->getPlayers() as $playerInWorld) {
                $name = $player->getName();
                $playerInWorld->sendMessage(Utils::PREFIX . JB::RED . $name . JB::GRAY . " Joined game mode: " . ucfirst($gameMode));
            }
        } else {
            $player->sendMessage(Utils::PREFIX . "The world does not exist.");
        }
    }

    public function sumoGame(Player $player): void
    {
        $this->joinGame($player, "sumo", "sumo");
    }

    public function gappleGame(Player $player): void
    {
        $this->joinGame($player, "gapple", "gapple");
    }
}
<?php

namespace PracticeJB\Jorgebyte\tasks;

use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\utils\TextFormat as JB;
# - - - - - - - - - Lib - - - - - - - - - -
use PracticeJB\Jorgebyte\libs\Score\ScoreJB;
# - - - - - - - - My Class - - - - - - - -
use PracticeJB\Jorgebyte\Main;
use PracticeJB\Jorgebyte\utils\Utils;
# - - - - - - - - - - - - - - - - - - - -

class ScoreTask extends Task
{
    public $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onRun(): void
    {
        $worldsToCheck = [
            "lobby" => JB::BOLD . JB::BLUE . "Lobby",
            "sumo" => JB::BOLD . JB::GREEN . "Sumo",
            "gapple" => JB::BOLD . JB::YELLOW . "Gapple",
        ];

        foreach (Server::getInstance()->getOnlinePlayers() as $player)
        {
            $score = new ScoreJB();
            $playerWorld = $player->getWorld()->getFolderName();

            foreach ($worldsToCheck as $mode => $worldDisplayName) {
                $worlds = $this->plugin->getConfig()->get($mode);
                if ($playerWorld === $worlds) {
                    $score->new($player, "Objective", $worldDisplayName);
                    $score->setLine($player, 1, JB::YELLOW . "You ping: " . JB::GRAY . Utils::getPlayerPing($player));
                    $score->setLine($player, 2, JB::YELLOW . "Online: " . JB::GRAY . Utils::getOnlinePlayerCount());
                }
            }
        }
    }
}
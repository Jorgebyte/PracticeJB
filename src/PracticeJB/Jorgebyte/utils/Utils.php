<?php

namespace PracticeJB\Jorgebyte\utils;

use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat as JB;
# - - - - Items - - - -
use PracticeJB\Jorgebyte\items\GamesItem;
use PracticeJB\Jorgebyte\items\InfoItem;
# - - - - - - - - - - -
class Utils
{

    public const NO_PERMS = JB::GRAY . "[" . JB::RED . "!" . JB::GRAY . "] " . JB::RED . "You don't have enough permissions for this.";
    public const PREFIX = JB::BOLD . JB::GRAY . "[" . JB::BLUE . "PracticeJB" . JB::GRAY . "] " . JB::RESET;

    public static function addSound(Player $player, string $sound, $volume = 1, $pitch = 1): void
    {
        $packet = new PlaySoundPacket();
        $packet->x = $player->getPosition()->getX();
        $packet->y = $player->getPosition()->getY();
        $packet->z = $player->getPosition()->getZ();
        $packet->soundName = $sound;
        $packet->volume = 1;
        $packet->pitch = 1;
        $player->getNetworkSession()->sendDataPacket($packet);
    }

    public static function kitLobby(Player $player): void
    {
        $player->getInventory()->setItem(0, new GamesItem());
        $player->getInventory()->setItem(2, new InfoItem());
    }

    public static function getPlayerPing(Player $player): int
    {
        return $player->getNetworkSession()->getPing();
    }

    public static function getOnlinePlayerCount(): int
    {
        $onlinePlayers = Server::getInstance()->getOnlinePlayers();
        return count($onlinePlayers);
    }

}
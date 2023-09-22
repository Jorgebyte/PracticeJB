<?php

namespace PracticeJB\Jorgebyte\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat as JB;
use PracticeJB\Jorgebyte\Main;
use PracticeJB\Jorgebyte\utils\Utils;

class HubCommand extends Command
{

    public $plugin;

    public function __construct(Main $plugin)
    {
        parent::__construct("hub", "return to the lobby - PracticeJB", null, ["lobby"]);
        $this->setPermission("practicejb.default.command");
        $this->setPermissionMessage(Utils::NO_PERMS);
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void
    {
        if ($sender instanceof Player) {
            $lobbyWorld = $this->plugin->getConfig()->get("lobby");
            $lobbyWorld = Server::getInstance()->getWorldManager()->getWorldByName($lobbyWorld);

            if ($lobbyWorld !== null) {
                $sender->teleport($lobbyWorld->getSafeSpawn());
                $sender->setGamemode(GameMode::SURVIVAL());
                $sender->getInventory()->clearAll();
                $sender->getArmorInventory()->clearAll();
                $sender->getEffects()->clear();
                $sender->setScale(1);
                $sender->setHealth(20);
                $sender->setAllowFlight(false);
                $sender->setFlying(false);
                $sender->sendMessage(Utils::PREFIX . JB::GRAY . "You have been teleported to the lobby.");
                Utils::kitLobby($sender);
            } else {
                $sender->sendMessage(Utils::PREFIX . JB::RED . "The lobby world is not configured or does not exist.");
            }
        } else {
            $sender->sendMessage(Utils::PREFIX . JB::RED . "This command can only be executed by players.");
        }
    }

}
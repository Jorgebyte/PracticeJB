<?php

namespace PracticeJB\Jorgebyte\events;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat as JB;
# - - - - my class - - - - -
use PracticeJB\Jorgebyte\items\GamesItem;
use PracticeJB\Jorgebyte\items\InfoItem;
use PracticeJB\Jorgebyte\Main;
use PracticeJB\Jorgebyte\utils\Utils;
# - - - - - - - - - - - - -

class LobbyEvent implements Listener
{
    public Main $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onJoin(PlayerJoinEvent $event): void
    {
        $player = $event->getPlayer();
        $name = $player->getName();
        $event->setJoinMessage(JB::GREEN . "[+] " . JB::GRAY . $name);
        $lobbyWorld = $this->plugin->getConfig()->get("lobby");
        $lobbyWorld = Server::getInstance()->getWorldManager()->getWorldByName($lobbyWorld);
        $player->teleport($lobbyWorld->getSafeSpawn());
        $player->setGamemode(GameMode::SURVIVAL());
        $player->getInventory()->clearAll();
        $player->getEffects()->clear();
        $player->getArmorInventory()->clearAll();
        $player->setScale(1);
        $player->setHealth(20);
        $player->setAllowFlight(false);
        $player->setFlying(false);
        Utils::addSound($player, "random.levelup", 1, 1);
        Utils::kitLobby($player);
    }

    public function onQuit(PlayerQuitEvent $event): void
    {
        $player = $event->getPlayer();
        $name = $player->getName();
        $event->setQuitMessage(JB::RED. "[-] " . JB::GRAY . $name);
    }

    public function onBreak(BlockBreakEvent $event): void
    {
        $player = $event->getPlayer();
        $lobbyWorld = $this->plugin->getConfig()->get("lobby");
        $playerWorld = $player->getWorld()->getFolderName();

        if ($playerWorld === $lobbyWorld) {
            if (!$player->hasPermission("practicejb.break")) {
                $player->sendTip(JB::RED . "Insufficient permissions");
                $event->cancel();
            }
        }
    }

    public function onPlace(BlockPlaceEvent $event): void
    {
        $player = $event->getPlayer();
        $lobbyWorld = $this->plugin->getConfig()->get("lobby");
        $playerWorld = $player->getWorld()->getFolderName();

        if ($playerWorld === $lobbyWorld) {
            if (!$player->hasPermission("practicejb.place")) {
                $player->sendTip(JB::RED . "Insufficient permissions");
                $event->cancel();
            }
        }
    }

    public function onInventoryMove(InventoryTransactionEvent $event): void
    {
        $player = $event->getTransaction()->getSource();
        $lobbyWorld = $this->plugin->getConfig()->get("lobby");
        $playerWorld = $player->getWorld()->getFolderName();

        if ($playerWorld === $lobbyWorld) {
            $event->cancel();
        }
    }

    public function onEntityDamage(EntityDamageEvent $event): void
    {
        $player = $event->getEntity();
        if (!($player instanceof Player)) {
            return;
        }

        $lobbyWorld = $this->plugin->getConfig()->get("lobby");
        $playerWorld = $player->getWorld()->getFolderName();

        if ($playerWorld === $lobbyWorld) {
            return;
        }
        switch ($event->getCause()) {
            case EntityDamageEvent::CAUSE_FALL:
            case EntityDamageEvent::CAUSE_ENTITY_ATTACK:
            case EntityDamageEvent::CAUSE_PROJECTILE:
                $event->cancel();
                break;
            case EntityDamageEvent::CAUSE_VOID:
                $event->cancel();
                $player->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()->getSafeSpawn());
                break;
        }
    }

    public function onPlayerUse(PlayerItemUseEvent $event): void
    {
        $player = $event->getPlayer();
        $item = $event->getItem();

        if ($item instanceof GamesItem) {
            $this->plugin->sendForms()->gameForm($player);
            $event->cancel();
        }

        if ($item instanceof InfoItem) {
            $this->plugin->sendForms()->infoForm($player);
            $event->cancel();
        }
    }
}
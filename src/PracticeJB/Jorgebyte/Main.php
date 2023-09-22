<?php

namespace PracticeJB\Jorgebyte;


use pocketmine\plugin\PluginBase;

#  - - - - - - - - Events - - - - - - - -
use PracticeJB\Jorgebyte\events\LobbyEvent;
# - - - - - - - - - - - - - - - - - - - -
# - - - - - - - - Utils - - - - - - - - -
use PracticeJB\Jorgebyte\game\Game;
use PracticeJB\Jorgebyte\tasks\ScoreTask;
use PracticeJB\Jorgebyte\utils\Forms;
# - - - - - - - - Commands - - - - - - - -
use PracticeJB\Jorgebyte\commands\HubCommand;
# - - - - - - - - - - - - - - - - - - - - -


class Main extends PluginBase
{

    public static Main $instance;

    public static function getInstance(): Main
    {
        return self::$instance;
    }

    public function onLoad(): void
    {
        self::$instance = $this;
    }

    public function onEnable(): void
    {
        $this->getLogger()->info("PracticeJB: Contact the creator if you have any errors in the code of this plugin.");
        $this->saveDefaultConfig();
        $config = $this->getConfig();

        $this->loadEvents();
        $this->loadTask();
        $this->loadCommand();

    }

    public function loadEvents(): void
    {
        $events = [
            LobbyEvent::class
        ];
        $success = true;
        foreach ($events as $eventClass) {
            try {
                $event = new $eventClass($this);
                $this->getServer()->getPluginManager()->registerEvents($event, $this);
            } catch (\Exception $e) {
                $this->getLogger()->error("Error registering event: " . $e->getMessage());
                $success = false;
            }
        }
        if ($success) {
            $this->getLogger()->info("All events were successfully loaded.");
        } else {
            $this->getLogger()->error("There were errors loading some events. Contact: jorgebyte");
        }
    }

    public function loadTask(): void
    {
        $map = $this->getScheduler();

        $map->scheduleRepeatingTask(new ScoreTask($this), 20);
    }

    public function loadCommand(): void
    {
        $map = $this->getServer()->getCommandMap();

        $map->register("HubCommand", new HubCommand($this));
    }

    public function setGames(): Game
    {
        return new Game();
    }

    public function sendForms(): Forms
    {
        return new Forms();
    }
}
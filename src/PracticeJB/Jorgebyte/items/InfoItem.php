<?php

namespace PracticeJB\Jorgebyte\items;

use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;
use pocketmine\utils\TextFormat as JB;

class InfoItem extends Item
{

    public function __construct()
    {
        parent::__construct(new ItemIdentifier(ItemTypeIds::BOOK));
        $this->setCustomName(JB::RED .  "[". JB::GREEN . "Info" . JB::RED . "]");
    }

}
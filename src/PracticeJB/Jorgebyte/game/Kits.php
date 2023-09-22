<?php

declare(strict_types=1);

namespace PracticeJB\Jorgebyte\game;

use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as JB;

class Kits
{
    public static function setSumoKit(Player $player): void
    {
        $player->getEffects()->add(new EffectInstance(VanillaEffects::RESISTANCE(), 99999999, 255, false));

    }

    public static function setGappleKit(Player $player): void
    {
        $items = VanillaItems::DIAMOND_SWORD();
        $items = VanillaItems::GOLDEN_APPLE()->setCount(10);
        $items = VanillaItems::BOW();
        $items = VanillaItems::ARROW()->setCount(32);
        $items->setCustomName(JB::RED . "KIT" . JB::BLUE . "GAPPLE");

        $armorInventory = $player->getArmorInventory();
        $armorH = VanillaItems::DIAMOND_HELMET();
        $armorC = VanillaItems::DIAMOND_CHESTPLATE();
        $armorL = VanillaItems::DIAMOND_LEGGINGS();
        $armorB = VanillaItems::DIAMOND_BOOTS();

        $armorInventory->setHelmet($armorH);
        $armorInventory->setChestplate($armorC);
        $armorInventory->setLeggings($armorL);
        $armorInventory->setBoots($armorB);



    }
}
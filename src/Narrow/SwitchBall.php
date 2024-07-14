<?php

namespace Narrow;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\entity\ProjectileHitEntityEvent;
use pocketmine\entity\projectile\Snowball;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class SwitchBall extends PluginBase implements Listener
{
    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onProjectileHitEntity(ProjectileHitEntityEvent $event): void
    {
        $projectile = $event->getEntity();
        $hitEntity = $event->getEntityHit();

        if ($projectile instanceof Snowball && $hitEntity instanceof Player) {
            $shooter = $projectile->getOwningEntity();

            if ($shooter instanceof Player) {
                $this->switchPositions($shooter, $hitEntity);
                $shooter->sendMessage(TextFormat::GREEN . "Vous avez changé votre position avec " . $hitEntity->getName());
                $hitEntity->sendMessage(TextFormat::RED . "Vous avez changé votre position avec " . $shooter->getName());
            }
        }
    }

    private function switchPositions(Player $player1, Player $player2): void
    {
        $position1 = $player1->getPosition();
        $position2 = $player2->getPosition();

        $player1->teleport($position2);
        $player2->teleport($position1);
    }
}

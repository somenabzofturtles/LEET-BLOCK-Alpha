<?php

/* 
 * Plugin developed by TurtleSoft
 * Some bug fixes! Realeased!
 */

namespace TurtleSoft\LeetBlock;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;

class BadWordBlocker extends PluginBase implements Listener {
    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
        $this->getServer()->getLogger()->info("§3[LeetBlock] §aEnabled successfully");
    }
    
    public function contains($wort, array $liste) {
    
        foreach ($liste as $item) {
            if (strpos(strtolower($wort),$item) !== FALSE) {
                return true;
            }
        }
        return false;
    }
    
    public function onPlayerChat (PlayerChatEvent $event) {
        $badwordlist = $this->getConfig()->get("badwords");
        $blockmessage = $this->getConfig()->get("blockmessage");
        $message = $event->getMessage();
        $player = $event->getPlayer();
        
        $list = explode(',', $badwordlist);
        
        if ($this->contains($message, $list)) {
            // Detected bad word so block it and notify user
            $event->setCancelled(true);
            $player->sendMessage($blockmessage);
        }
    }
}

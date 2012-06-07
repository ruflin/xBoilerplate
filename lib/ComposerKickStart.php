<?php
/**
 * @author Oliver Tupman <oliver.tupman@centralway.com>
 * Date: 07/06/2012
 * Time: 17:46
 */
use Composer\Script\Event;

class ComposerKickStart
{
    public static function postInstall(Event $event) {
        echo "DIR: " . __DIR__ . "\n";
    }
}

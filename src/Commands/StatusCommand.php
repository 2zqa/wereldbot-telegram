<?php

namespace Wereldbot\Commands;

use Telegram\Bot\Commands\Command;
use MCServerStatus\MCQuery;

class StatusCommand extends Command
{
    protected $name = 'status';
    const HOSTNAME = 'mc.marijnk.nl';

    private function response() {

    }

    public function handle() {

        $result=MCQuery::check(self::HOSTNAME);

        $response = "";

        if ($result->online) {
            $response .= "_" . $result->motd . "_" . PHP_EOL . PHP_EOL;
        }

        $response .= "Wereldbouw is op dit moment ";
        
        if(!$result->online) {
            $response .= "helaas *offline*. Tip: check discord voor actuele info.";
        } else {
            $response .= "*online*." . PHP_EOL . "Er zijn nu ";            
            if($result->players > 0) {
                $response .= $result->players . " spelers ingelogd:" . "\n";
                foreach($result->player_list as $playername) {
                    $response .= " • " . str_replace("_", "\_", $playername) . "\n";
                }
            } else {
                $response .= "geen spelers ingelogd.";
            }
            
            
        }

        $this->replyWithMessage([
            'text' => $response,
            'parse_mode'=>'markdown'
        ]);
    }
}
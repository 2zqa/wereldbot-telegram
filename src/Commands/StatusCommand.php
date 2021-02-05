<?php

namespace Wereldbot\Commands;

use Telegram\Bot\Commands\Command;
use MCServerStatus\MCPing;

class StatusCommand extends Command
{
    protected $name = 'status';
    const HOSTNAME = 'mc.marijnk.nl';

    private function response() {

    }

    public function handle() {

        $result=MCPing::check(self::HOSTNAME)->toArray();

        $response = "";

        if ($result['online']) {
            $response .= "_" . $result["motd"] . "_" . PHP_EOL . PHP_EOL;
        }

        $response .= "Wereldbouw is op dit moment ";
        
        if(!$result['online']) {
            $response .= "helaas *offline*. Tip: check discord voor actuele info.";
        } else {
            $response .= "*online*." . PHP_EOL . "Er zijn " . str_replace("0", "geen", $result['players']) . " spelers ingelogd.";            
            if($result['players'] > 0) {
                $response .= "Spelers online:" . PHP_EOL;
                foreach($result['sample_player_list'] as $playername) {
                    $response .= " • " . $playername . "\n";
                }
            }
            
            
        }

        $this->replyWithMessage([
            'text' => $response,
            'parse_mode'=>'markdown'
        ]);
    }
}
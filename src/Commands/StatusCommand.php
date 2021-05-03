<?php

namespace Wereldbot\Commands;

use Telegram\Bot\Commands\Command;
use MCServerStatus\MCQuery;

class StatusCommand extends Command
{
    protected $name = 'status';
    const HOSTNAME = 'mc.marijnk.nl';

    private function getMessage() {
        $query = MCQuery::check(self::HOSTNAME);

        # Check online status
        if (!$query->online) {
            return "Wereldbouw is op dit moment helaas <b>offline</b>. Tip: check de discord voor actuele info.";
        }

        # MOTD
        $response = "<i>" . $query->motd . "</i>" . "\n\n" . "Wereldbouw is op dit moment <b>online</b>." . "\n";

        # Playerlist
        if ($query->players == 0) {
            $response .= "Er zijn op dit moment geen spelers ingelogd.";
            return $response;
        }

        $response .= "Er zijn op dit moment " . $query->players . " spelers ingelogd:" . "\n";
        foreach ($query->player_list as $playername) {
            $response .= " • " . $playername . "\n";
        }

        return $response;
    }

    public function handle() {
        $this->replyWithMessage([
            'text' => $this->getMessage(),
            'parse_mode' => 'html'
        ]);
    }
}

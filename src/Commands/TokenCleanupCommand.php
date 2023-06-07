<?php

namespace Yumb\MagicLogin\Commands;

use Illuminate\Console\Command;
use Yumb\MagicLogin\Models\MagicLoginToken;
use Yumb\MagicLogin\Enums\TokenStatus;

class TokenCleanupCommand extends Command
{
    public $signature = 'token-cleanup';

    public $description = 'This will delete all tokens that have expired or consumed';

    public function handle(): int
    {
        $this->comment('Cleanup on isle 9!');

        $tokens = MagicLoginToken::whereIn('status', [
            TokenStatus::INVALID(),
            TokenStatus::EXPIRED(),
            TokenStatus::CONSUMED()
          ])->get();
          
        $tokens->each(fn($token) => $token->delete());

        $this->comment('This house is clean!');

        return self::SUCCESS;
    }
}

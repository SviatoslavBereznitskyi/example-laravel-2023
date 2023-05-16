<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Commands\Promo\Generate\GenerateCodeCommand;
use App\Commands\Promo\Generate\GenerateCodeCommandHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GeneratePromoCodesJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private GenerateCodeCommand $command)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(GenerateCodeCommandHandler $handler): void
    {
        $handler->handle($this->command);
    }
}

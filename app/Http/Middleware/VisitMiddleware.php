<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Commands\User\Achievement\Create\CreateAchievementCommand;
use App\Commands\User\Achievement\Create\CreateAchievementCommandHandler;
use App\Models\User\Enums\AchievementEnum;
use App\Models\User\User;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class VisitMiddleware
{
    public function __construct(private Guard $auth, private CreateAchievementCommandHandler $handler)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var User $user */
        if ($user = $request->user('api')) {
            if ($user->visited_at !== null && now()->diffInDays($user->visited_at) > 30) {
                $user->visited_at = now();
                if ($user->save()) {
                    $createAchievementCommand = new CreateAchievementCommand();
                    $createAchievementCommand->userId = $user->id;
                    $createAchievementCommand->achievementSlug = AchievementEnum::REBIRTH->value;

                    $this->handler->handle($createAchievementCommand);
                }
            }

            if ($user->visited_at === null || $user->visited_at->isYesterday()) {
                ++$user->visited_in_row;
            } elseif (now()->diffInDays($user->visited_at) > 1) {
                $user->visited_in_row = 1;
            }
            $user->visited_at = now();
            $user->reward_claimed = false;
            $user->save();
        }

        return $next($request);
    }
}

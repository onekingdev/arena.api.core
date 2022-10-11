<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

use App\Broadcasting\{Common\JobChannel,
    Soundblock\ContractChannel,
    Soundblock\ProjectChannel,
    Soundblock\ServiceChannel,
    Support\TicketChannel,
    UserChannel};

Broadcast::channel("App.User.{id}", function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel("channel.app.soundblock.user.{user}", UserChannel::class);

Broadcast::channel("channel.app.soundblock.project.{project}.contract", ContractChannel::class);
Broadcast::channel("channel.app.soundblock.project.{project}.files", ProjectChannel::class);
Broadcast::channel("channel.app.soundblock.project.{project}.team", ProjectChannel::class);
Broadcast::channel("channel.app.soundblock.project.{project}.ledger", ProjectChannel::class);

Broadcast::channel("channel.app.soundblock.service.{service}.ledger", ServiceChannel::class);

Broadcast::channel("channel.app.arena.user.{user}", UserChannel::class);
Broadcast::channel("channel.app.apparel.user.{user}", UserChannel::class);
Broadcast::channel("channel.app.catalog.user.{user}", UserChannel::class);
Broadcast::channel("channel.app.io.user.{user}", UserChannel::class);
Broadcast::channel("channel.app.merchandising.user.{user}", UserChannel::class);
Broadcast::channel("channel.app.music.user.{user}", UserChannel::class);
Broadcast::channel("channel.app.office.user.{user}", UserChannel::class);
Broadcast::channel("channel.app.account.user.{user}", UserChannel::class);
Broadcast::channel("channel.app.soundblock.support.ticket.{ticket}", TicketChannel::class);

Broadcast::channel("channel.app.soundblock.job.{job}", JobChannel::class);


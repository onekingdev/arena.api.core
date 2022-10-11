<?php

namespace App\Listeners\Soundblock;

use App\Events\Soundblock\TrackVolumeNumber as TrackVolumeNumberEvent;

class TrackVolumeNumber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param TrackVolumeNumberEvent $event
     * @return void
     */
    public function handle(TrackVolumeNumberEvent $event)
    {
        $objTrack = $event->objTrack;
        $intVolumeNumber = $event->newVolumeNumber;
        $objCollection = $objTrack->collections()->latest()->first();
        $oldVolumeNumber = $objTrack->track_volume_number;

        $orderedFilesGrouped = $objCollection->tracks->groupBy("track_volume_number");
        $orderedFilesGrouped[$intVolumeNumber]->push($objTrack);
        $objTrack->track_volume_number = $intVolumeNumber;
        $objTrack->save();

        foreach ($orderedFilesGrouped[$intVolumeNumber] as $key => $objVolumeTrack) {
            $objVolumeTrack->track_number = $key + 1;
            $objVolumeTrack->save();
        }

        $orderedFilesGrouped = $objCollection->tracks->groupBy("track_volume_number");
        if (!empty($orderedFilesGrouped[$oldVolumeNumber])) {
            foreach ($orderedFilesGrouped[$oldVolumeNumber] as $key => $objVolumeTrack) {
                $objVolumeTrack->track_number = $key + 1;
                $objVolumeTrack->save();
            }
        }
    }
}

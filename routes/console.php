<?php

use App\Actions\ScanVitalSignsAction;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    (new ScanVitalSignsAction())->execute();
})->everyFiveMinutes()->name('scan-vital-signs');
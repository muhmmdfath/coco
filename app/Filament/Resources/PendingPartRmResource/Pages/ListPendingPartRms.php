<?php

namespace App\Filament\Resources\PendingPartRmResource\Pages;

use App\Filament\Resources\PendingPartRmResource;
use Filament\Resources\Pages\Page;

class ListPendingPartRms extends Page
{
    protected static string $resource = PendingPartRmResource::class;

    protected static string $view = 'filament.pages.list-pending-part-rms';

}

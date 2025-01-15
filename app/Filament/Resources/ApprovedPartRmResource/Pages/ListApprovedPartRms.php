<?php

namespace App\Filament\Resources\ApprovedPartRmResource\Pages;

use App\Filament\Resources\ApprovedPartRmResource;
use Filament\Resources\Pages\Page;

class ListApprovedPartRms extends Page
{
    protected static string $resource = ApprovedPartRmResource::class;

    protected static string $view = 'filament.pages.list-approved-part-rms';
}

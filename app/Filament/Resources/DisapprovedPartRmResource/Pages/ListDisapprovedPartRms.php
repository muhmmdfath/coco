<?php

namespace App\Filament\Resources\DisapprovedPartRmResource\Pages;

use App\Filament\Resources\DisapprovedPartRmResource;
use Filament\Resources\Pages\Page;

class ListDisapprovedPartRms extends Page
{
    protected static string $resource = DisapprovedPartRmResource::class;

    protected static string $view = 'filament.pages.list-disapproved-part-rms';
}

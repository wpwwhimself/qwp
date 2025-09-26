<?php

namespace App\Models;

use App\Models\Shipyard\LocalSetting as ShipyardLocalSetting;

class LocalSetting extends ShipyardLocalSetting
{
    public static function fields(): array
    {
        /**
         * * hierarchical structure of the page *
         * grouped by sections (title, subtitle, icon, identifier)
         * each section contains fields (name, label, hint, icon)
         */
        return [

        ];
    }
}
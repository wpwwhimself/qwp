<?php

namespace App\Scaffolds;

use App\Scaffolds\Shipyard\Modal as ShipyardModal;

class Modal extends ShipyardModal
{
    protected static function items(): array
    {
        return [
            "create-scope" => [
                "heading" => "Utwórz zakres",
                "target_route" => "scopes.create",
                "fields" => [
                    [
                        "name" => "name",
                        "type" => "text",
                        "label" => "Nazwa zakresu",
                        "icon" => "badge-account",
                        "required" => true
                    ]
                ]
            ],
            "create-task" => [
                "heading" => "Utwórz zadanie",
                "target_route" => "tasks.create",
                "fields" => [
                    [
                        "name" => "name",
                        "type" => "text",
                        "label" => "Nazwa",
                        "icon" => "badge-account",
                        "required" => true,
                    ],
                    [
                        "name" => "description",
                        "type" => "TEXT",
                        "label" => "Opis",
                        "icon" => "text"
                    ],
                    [
                        "name" => "priority",
                        "type" => "select",
                        "label" => "Priorytet",
                        "icon" => "priority-high",
                        "required" => true,
                        "extra" => [
                            "selectData" => [
                                "options" => [
                                    ["label" => "1 - krytyczny", "value" => 1],
                                    ["label" => "2 - wysoki", "value" => 2],
                                    ["label" => "3 - normalny", "value" => 3],
                                    ["label" => "4 - niski", "value" => 4],
                                    ["label" => "5 - kiedyś", "value" => 5]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}

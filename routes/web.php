<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/Shipyard/shipyard.php';

Route::redirect("/", "profile");

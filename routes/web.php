<?php

use App\Livewire\HomePage;
use Illuminate\Support\Facades\Route;

// Redireccionar la ruta raíz a /en
Route::redirect('/', '/en');

// Definir la ruta para cada idioma y asociarla a la clase HomePage
Route::get('/{lang}', HomePage::class);

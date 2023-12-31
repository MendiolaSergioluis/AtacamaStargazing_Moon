<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class HomePage extends Component
{
    // Variables de configuración de lenguaje
    public $lang;

    /**
     * Método mount
     *
     * Este método se ejecuta al inicializar el componente y recibe el parámetro $lang.
     * Establece el idioma y la variable $lang.
     *
     * @param string $lang
     * @return void
     */
    public function mount(string $lang) : void
    {
        $this->lang = $lang;
        App::setLocale($lang);
    }

    /**
     * Método ChangeLang
     *
     * Este método se ejecuta cuando se cambia el idioma.
     * Actualiza el idioma y redirige a la vista correspondiente al nuevo idioma.
     *
     * @param string $lang
     * @return void
     */
    public function ChangeLang(string $lang) : void
    {
        $this->lang = $lang;
        App::setLocale($lang);

        // Redirigir a la vista correspondiente al nuevo idioma
        $this->redirect("/{$lang}", navigate: true);
    }

    /**
     * Método render
     *
     * Renderiza la vista livewire.home-page.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.home-page')->title(__('moon.moon'));
    }
}

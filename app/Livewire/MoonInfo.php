<?php

namespace App\Livewire;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Rik0253\Moonphase\Moonphase;
use Carbon\Carbon;

class MoonInfo extends Component
{
    #[Rule('required')]
    public $selectedDate;
    public $moonPhaseAge;
    public $illumination;
    public $moonriseTime;
    public $moonriseDay;
    public $moonsetDay;
    public $moonsetTime;
    public $tomorrow_moonset;

    /**
     * Método mount
     *
     * Este método se ejecuta al inicializar el componente.
     * Establece la fecha seleccionada y obtiene la información de la luna.
     *
     * @return void
     */
    public function mount()
    {
        // Establecer la fecha seleccionada como la fecha actual en la zona horaria 'America/Santiago'
        $this->selectedDate = Carbon::parse(Carbon::now()->setTimezone('America/Santiago'))->format('Y-m-d');
        $this->moonInfo();
    }

    /**
     * Método moonInfo
     *
     * Obtiene la información de la luna para la fecha seleccionada.
     *
     * @return void
     */
    public function moonInfo()
    {
        $validated = $this->validate();

        // Crea un objeto DateTimeImmutable para buscar información de la luna en esa fecha y hora.
        $date = new DateTimeImmutable(
            Carbon::parse($validated['selectedDate'])->format('Y-m-d').' 21:30' ?? Carbon::parse(Carbon::now())->format('Y-m-d').' 21:30',
            new DateTimeZone('UTC')
        );
        $date->setTimezone(new DateTimeZone('America/Santiago'));
        $timezoneOffset = $date->getOffset() / 3600;

        // Ajuste para el horario de verano en Chile
        $year = $date->format('Y');
        $firstApril = new DateTime('01-04-'.$year);
        $firstApril->modify('first saturday');
        $firstSeptember = new DateTime('01-09-'.$year);
        $firstSeptember->modify('first saturday');
        if ($date < $firstApril || $date > $firstSeptember) {
            $timezoneOffset += 1;
        }

        // Obtiene información sobre la iluminación, la hora de salida y la hora de puesta de la luna
        $moon = new Moonphase($date->format('Y-m-d H:i:s.u'));
        $illumination = round($moon->getMoonData('illumination') * 100, 1);
        $this->illumination = $illumination;
        $this->moonPhaseAge = intval(round($moon->getMoonData('age')));
        $moonTimes = $moon->getMoonTimes(-22.908333, -68.199722);
        $moonrise = (new DateTime())->setTimestamp($moonTimes->moonrise)->modify("+$timezoneOffset hours");
        $moonset = (new DateTime())->setTimestamp($moonTimes->moonset)->modify("+$timezoneOffset hours");

        $tomorrow = $date->modify("+1 day");
        $timezoneOffset_tomorrow = $tomorrow->getOffset() / 3600;
        if ($tomorrow < $firstApril || $tomorrow > $firstSeptember) {
            $timezoneOffset_tomorrow += 1;
        }
        $tomorrow_moon = new Moonphase($tomorrow->format('Y-m-d H:i:s.u'));
        $tomorrow_moonTimes = $tomorrow_moon->getMoonTimes(-22.908333, -68.199722);
        $tomorrow_moonset = (new DateTime())->setTimestamp($tomorrow_moonTimes->moonset)->modify("+$timezoneOffset_tomorrow hours");

        $this->moonriseTime = $moonrise;
        $this->moonsetTime = $moonset;

        $current_day = Carbon::parse($this->selectedDate)->day;

        if (Carbon::parse($moonrise)->day > $current_day) {
            $this->moonriseDay = 1;
        } elseif (Carbon::parse($moonrise)->day < $current_day) {
            $this->moonriseDay = -1;
        } else {
            $this->moonriseDay = 0;
        }

        if (Carbon::parse($moonset)->day > $current_day) {
            $this->moonsetDay = 1;
        } elseif (Carbon::parse($moonset)->day < $current_day) {
            $this->moonsetDay = -1;
        } else {
            $this->moonsetDay = 0;
        }
        $this->tomorrow_moonset = $tomorrow_moonset->format('H:i');
    }

    /**
     * Método nextDay
     *
     * Avanza al día siguiente y actualiza la información de la luna.
     *
     * @return void
     */
    public function nextDay()
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)->addDay()->format('Y-m-d');
        $this->moonInfo();
    }

    /**
     * Método previousDay
     *
     * Retrocede al día anterior y actualiza la información de la luna.
     *
     * @return void
     */
    public function previousDay()
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)->subDay()->format('Y-m-d');
        $this->moonInfo();
    }

    /**
     * Método render
     *
     * Renderiza la vista livewire.moon-info.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.moon-info');
    }
}

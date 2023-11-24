<div wire:poll class="w-full h-full py-10 px-4 text-slate-700">
    <div class="m-auto w-full md:max-w-4xl">
        <h1 class="text-3xl lg:text-4xl font-bold pb-6 text-left">@lang('moon.The Moon in San Pedro de Atacama')</h1>
        <h2 class="text-2xl lg:text-3xl font-semibold">
            @lang('moon.How will the Moon influence the visibility of the stars?')
            <br>
            @lang('moon.Find out here!')
        </h2>
        <p class="py-4 font-semibold">@lang('moon.The percentage of lunar visibility is crucial to determine the sky conditions on the day of your tour. The higher this percentage, the fewer stars you will see. (You can also check other days if you wish)')</p>
        <div class="w-full flex justify-center">
            <div class="w-full border-2 rounded-3xl bg-primary/30 border-gray-200 py-4 shadow-black/30 shadow-md">

                {{--    Here the user select the date--}}
                <form class="mt-2 mb-6 flex flex-col justify-center items-center gap-2 font-semibold">
                    <label for="selectedDate" class="font-semibold text-lg text-center">@lang('moon.Select Date')</label>
                    <div class="flex items-center gap-2">
                        <button wire:click.prevent="previousDay">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                 stroke="currentColor" class="w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                            </svg>
                            <span class="sr-only">Previous Day</span>
                        </button>
                        <input
                            type="date"
                            id="selectedDate"
                            wire:model.live="selectedDate"
                            wire:change="moonInfo"
                            value="{{$selectedDate}}"
                            class="text-black p-2 rounded-lg">
                        <button wire:click.prevent="nextDay">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                 stroke="currentColor" class="w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                            </svg>
                            <span class="sr-only">Next Day</span>
                        </button>
                    </div>
                    @error('selectedDate')
                    <p class="text-red-600 text-base">@lang('moon.Date required!')</p>
                    @enderror
                </form>

                <div class="grid grid-cols-2 grid-rows-3 md:grid-cols-3 md:grid-rows-1 text-center">
                    <div class="order-1 md:order-2 col-span-2 row-span-2 md:col-span-1 flex flex-col items-center justify-center">
                        @if($moonPhaseAge >= 2 && $moonPhaseAge < 29 )
                            <img src="{{asset('images/Moon/'.$moonPhaseAge.'.svg')}}" alt="MoonPhase-{{$moonPhaseAge}}"
                                 class="w-32 h-32">
                        @else
                            <img src="{{asset('images/Moon/29.svg')}}" alt="MoonPhase-{{$moonPhaseAge}}" class="w-32 h-32">
                        @endif
                        <div class="flex gap-4 font-semibold text-2xl mt-2">
                            <div>
                                {{$illumination}}%
                                <br>
                                @if($moonPhaseAge <= 15)
                                    <p>@lang('moon.Waxing moon')</p>
                                @else
                                    <p>@lang('moon.Waning moon')</p>
                                @endif
                            </div>


                        </div>
                    </div>
                    <div class="order-2 md:{{Carbon\Carbon::parse($moonsetTime)->lt(Carbon\Carbon::parse($moonriseTime)) ? 'order-3' : 'order-1'}} flex justify-center items-center">
                        <div class="flex flex-col justify-center items-center font-semibold text-lg mt-1 sm:mt-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-8 h-8 md:w-12 md:w-12">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 11.25l-3-3m0 0l-3 3m3-3v7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="hidden xs:block">@lang('moon.Rises at')</p>
                            <p>{{$moonriseTime->format('H:i A')}}</p>
                            @if($moonriseDay === -1)
                                <p>(Día Anterior)</p>
                            @endif
                            @if($moonriseDay === 1)
                                <p>(Día Siguiente)</p>
                            @endif
                            @if($moonriseDay === 0)
                                <p>&nbsp;</p>
                            @endif
                        </div>
                    </div>
                    <div class="order-3 md:{{Carbon\Carbon::parse($moonsetTime)->lt(Carbon\Carbon::parse($moonriseTime)) ? 'order-1' : 'order-3'}} flex justify-center items-center">
                        <div class="flex flex-col justify-center items-center font-semibold text-lg mt-1 sm:mt-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-8 h-8 md:w-12 md:w-12">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 12.75l3 3m0 0l3-3m-3 3v-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="hidden xs:block">@lang("moon.It's hidden from")</p>
                            <p>{{$moonsetTime->format('H:i A')}}</p>
                            @if($moonsetDay === -1)
                                <p>@lang('moon.(Previous day)')</p>
                            @endif
                            @if($moonsetDay === 1)
                                <p>@lang('moon.(Next day)')</p>
                            @endif
                            @if($moonsetDay === 0)
                                <p>&nbsp;</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p class="pt-4 font-semibold">
            @lang('moon.This information will help you better plan your stargazing in San Pedro Atacama. Enjoy the experience!')
        </p>
    </div>
</div>




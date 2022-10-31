<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2 text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500" id="encuesta-tab" data-tabs-target="#encuesta" type="button" role="tab" aria-controls="encuesta" aria-selected="true">Encuesta</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:border-transparent text-gray-500 dark:text-gray-400 border-gray-100 dark:border-gray-700" id="pregunta-tab" data-tabs-target="#pregunta" type="button" role="tab" aria-controls="pregunta" aria-selected="false">Pregunta</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:border-transparent text-gray-500 dark:text-gray-400 border-gray-100 dark:border-gray-700" id="respuesta-tab" data-tabs-target="#respuesta" type="button" role="tab" aria-controls="respuesta" aria-selected="false">Respuesta</button>
                            </li>
                            <li role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:border-transparent text-gray-500 dark:text-gray-400 border-gray-100 dark:border-gray-700" id="fecha-tab" data-tabs-target="#fecha" type="button" role="tab" aria-controls="fecha" aria-selected="false">Fecha</button>
                            </li>
                            <li role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:border-transparent text-gray-500 dark:text-gray-400 border-gray-100 dark:border-gray-700" id="muestra-tab" data-tabs-target="#muestra" type="button" role="tab" aria-controls="muestra" aria-selected="false">Muestra</button>
                            </li>
                            <li role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:border-transparent text-gray-500 dark:text-gray-400 border-gray-100 dark:border-gray-700" id="muestreo-tab" data-tabs-target="#muestreo" type="button" role="tab" aria-controls="muestreo" aria-selected="false">Muestreo</button>
                            </li>
                        </ul>
                    </div>
                    <div id="myTabContent">
                        <div class="p-4 bg-gray-50 rounded-lg dark:bg-gray-800" id="encuesta" role="tabpanel" aria-labelledby="encuesta-tab">
                        @include("configuracion/encuesta/encuesta_tab")
                        </div>
                        <div class="hidden p-4 bg-gray-50 rounded-lg dark:bg-gray-800" id="pregunta" role="tabpanel" aria-labelledby="pregunta-tab">
                        @include("configuracion/encuesta/pregunta_tab")
                        </div>
                        <div class="hidden p-4 bg-gray-50 rounded-lg dark:bg-gray-800" id="respuesta" role="tabpanel" aria-labelledby="respuesta-tab">
                        @include("configuracion/encuesta/respuesta_tab")
                        </div>
                        <div class="hidden p-4 bg-gray-50 rounded-lg dark:bg-gray-800" id="fecha" role="tabpanel" aria-labelledby="fecha-tab">
                        @include("configuracion/encuesta/fecha_tab")
                        </div>
                        <div class="hidden p-4 bg-gray-50 rounded-lg dark:bg-gray-800" id="muestra" role="tabpanel" aria-labelledby="muestra-tab">
                        @include("configuracion/encuesta/muestra_tab")
                        </div>
                        <div class="hidden p-4 bg-gray-50 rounded-lg dark:bg-gray-800" id="muestreo" role="tabpanel" aria-labelledby="muestreo-tab">
                        @include("configuracion/encuesta/muestreo_tab")
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
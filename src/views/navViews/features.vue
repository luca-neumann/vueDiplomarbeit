<template>
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold text-center mt-10">Luftgüte-Messung</h1>
        <p class="text-gray-600 mb-8 text-center mt-2">
            Die Messung der Luftgüte ist entscheidend, um die Auswirkungen von Luftverschmutzung auf die Gesundheit zu verstehen.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow shadow-green-500 p-4">
                <h2 class="text-xl font-bold mb-2">Feinstaub und Gesundheitsrisiken</h2>
                <p class="text-gray-600 mb-4">
                    Informiere dich über die gesundheitlichen Risiken von Feinstaub und seine Auswirkungen auf den Körper.
                </p>
                <a 
                    href="https://www.bmk.gv.at/themen/klima_umwelt/luft/luftguete/feinstaub.html" 
                    target="_blank" 
                    class="bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-4 rounded inline-block text-center">
                    Mehr erfahren
                </a>
            </div>

            <div class="bg-white rounded-lg shadow shadow-green-500 p-4">
                <h2 class="text-xl font-bold mb-2">Feinstaubkarte von Tirol</h2>
                <p class="text-gray-600 mb-4">
                    Hier kannst du die aktuelle Luftverschmutzung in ganz Tirol einsehen und mehr über die Luftqualitätswerte erfahren.
                </p>
                <a 
                    href="/" 
                    target="_blank" 
                    class="bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-4 rounded inline-block text-center">
                    Mehr erfahren
                </a>
            </div>

            <div class="bg-white rounded-lg shadow shadow-green-500 p-4">
                <h2 class="text-xl font-bold mb-2">COVID-19 und Luftverschmutzung</h2>
                <p class="text-gray-600 mb-4">
                    Erfahre, wie Luftverschmutzung die Verbreitung von COVID-19 beeinflussen kann.
                </p>
                <a 
                    href="https://www.who.int/news-room/fact-sheets/detail/ambient-(outdoor)-air-quality-and-health" 
                    target="_blank" 
                    class="bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-4 rounded inline-block text-center">
                    Mehr erfahren
                </a>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    name: 'FeaturesView',
}
</script>
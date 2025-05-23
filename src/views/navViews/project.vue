<template>
    <div class="about-project bg-gray-50 py-12 px-6">
        <div class="container mx-auto flex flex-wrap">
            <div class="w-full md:w-1/2 mb-8 md:mb-0">
                <h2 class="text-4xl font-extrabold text-black mb-6">Über unser Projekt</h2>
                <p class="text-lg text-black leading-relaxed mb-8">
                    Dieses Projekt ist Teil der Diplomarbeit an der HTL Anichstraße Wirtschaftsingeneur. Die beteiligten Schüler sind Luca Neumann und Moritz Pacher, und ihr betreuender Lehrer ist Albert Greinöcker.
                </p>
                <h3 class="text-2xl font-semibold text-black mb-4">Hintergrund</h3>
                <p class="text-lg text-black leading-relaxed">
                    Derzeit gibt es keine ausreichende flächendeckende Messung der Luftqualität (Verschmutzungslevel). Insbesondere die individuelle Messung der persönlichen Belastung (z.B. durch nahegelegene Industrien) ist nicht möglich. Luftverschmutzung und Feinstaub sind nachgewiesene Ursachen für verschiedene Krankheiten und vorzeitige Todesfälle.
                </p>
            </div>

            <div class="w-full md:w-1/2">
                <h3 class="text-2xl font-semibold text-black mb-4">Teilgebiete</h3>
                <div class="border-4 bg-green-100 border-green-500 rounded-lg p-4 mb-8 ">
                    <h3 class="text-2xl font-semibold text-black mb-4">Sensorkomponente</h3>
                    <ul class="list-disc text-lg text-black ml-8 space-y-2">
                        <li>Hardware: Mikrocontroller (ESP32 mit LoRaWAN), Feinstaubsensor (Plantower PMS3003 Sensor), Batteriefach</li>
                        <li>Programmiersprache: C/C++</li>
                        <li>Sendet Daten über MQTT und LoRaWAN an den Hub</li>
                    </ul>
                </div>

                <div class="border-4 bg-green-100 border-green-500 rounded-lg p-4 mb-8">
                    <h3 class="text-2xl font-semibold text-black mb-4">Hub / Broker Komponente</h3>
                    <ul class="list-disc text-lg text-black ml-8 space-y-2">
                        <li>Hardware: Mikrocontroller (ESP32 mit LoRaWAN), Stromversorgung, WLAN-Adapter</li>
                        <li>Programmiersprache: C/C++</li>
                        <li>Empfängt Daten vom Sensor und sendet sie an die Datenbank</li>
                    </ul>
                </div>

                <div class="border-4 bg-green-100 border-green-500 rounded-lg p-4 mb-8">
                    <h3 class="text-2xl font-semibold text-black mb-4">Datenbank mit GUI</h3>
                    <ul class="list-disc text-lg text-black ml-8 space-y-2">
                        <li>Hardware: Server mit MySQL</li>
                        <li>Programmiersprache: VueJS für die GUI und MySQL für die Datenbank</li>
                        <li>Datenbank speichert Daten vom Hub/Broker</li>
                        <li>GUI stellt die Daten visuell ansprechend dar (über Web)</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container mx-auto flex flex-wrap">
            <div class="border-4 bg-blue-100 border-blue-500 rounded-lg p-4 mb-8 mx-auto">
                <h3 class="text-2xl font-semibold text-black mb-4">Ziele der Diplomarbeit</h3>
                <ul class="list-disc text-lg text-black ml-8 space-y-2">
                    <li>Sensorkomponente sendet Daten über LoRaWAN und MQTT an den Broker</li>
                    <li>Broker sendet Außendaten an die Datenbank (Schul-Server)</li>
                    <li>Daten werden visualisiert (Karten, etc.) und sind über eine Website zugänglich</li>
                </ul>
            </div>

            <div class="border-4 bg-blue-100 border-blue-500 rounded-lg p-4 mb-8 mx-auto">
                <h3 class="text-2xl font-semibold text-black mb-4">Name der Diplomarbeit</h3>
                <p class="text-lg text-black mb-6">
                    SmartSensorNetz: LoRaWAN-basierte MQTT-Datenübertragung und Visualisierung mit ESP32-gesteuertem Broker
                </p>
                <p class="text-lg text-black">
                    Dieser Titel betont:
                </p>
                <ul class="list-disc text-lg text-black ml-8 space-y-2">
                    <li>LoRaWAN-basierte MQTT-Datenübertragung: Beschreibt das Übertragungsmedium (LoRaWAN) und das Protokoll (MQTT), das für die Datenübertragung verwendet wird</li>
                    <li>Visualisierung mit ESP32-gesteuertem Broker: Betont die zentrale Rolle des Brokers, der von einem ESP32 verwaltet wird, für die Datenintegration und -visualisierung</li>
                </ul>
            </div>
        </div>
    </div>
</template>

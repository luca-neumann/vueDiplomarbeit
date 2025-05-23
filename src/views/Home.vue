<script setup>
import { reactive, ref, onMounted } from 'vue';
import axios from 'axios';

const windSpeed = ref(null);
const windDirection = ref(0); // Standardrichtung: Norden
const windDirectionInnsbruck = ref(0);
const windDirectionInnsbruckLand = ref(0);
const windDirectionSchwaz = ref(0);
const windDirectionKufstein = ref(0);
const windDirectionKitzbuehel = ref(0);
const windDirectionLienz = ref(0);
const windDirectionImst = ref(0);
const windDirectionReutte = ref(0);
const windDirectionLandeck = ref(0);

const clients = ref([]);
const tooltipText = ref('');
const clientCounts = ref({});

// Funktion zur Abrufung der Client-Daten
const fetchClients = async () => {
  try {
    const response = await axios.get('https://os-beyond.at/htl/smart_sensor_netz/clients');
    clients.value = response.data;
    console.log(response.data); // Logge die Antwort zum Überprüfen
    countClients();
  } catch (error) {
    console.error("Fehler beim Abrufen der Client-Daten:", error);
  }
};

// Zähle Clients nach Ort
const countClients = () => {
  // Sicherstellen, dass clientCounts korrekt initialisiert ist
  clientCounts.value = {}; // Leere das Objekt vor der Zählung
  clients.value.forEach(client => {
    const ort = client.Ort;
    // Zähle die Vorkommen für den jeweiligen Ort
    clientCounts.value[ort] = (clientCounts.value[ort] || 0) + 1;
  });
};

// Funktion zur Anzeige der Tooltip-Nachricht
const showTooltip = (ort) => {
  console.log(`Clients in ${ort}: ${clientCounts.value[ort] || 0}`);  // Korrekt auf clientCounts.value zugreifen
  tooltipText.value = `Clients in ${ort}: ${clientCounts.value[ort] || 0} 📡`;  // Korrekt auf clientCounts.value zugreifen
};


async function fetchWindData() {
  const apiKey = 'de3a51acffa1ffc6eb47ec305836e29e';
  const lat = 47.267;  // Breitengrad von Tirol
  const lon = 11.392;  // Längengrad von Tirol
  
  try {
    const response = await fetch(
      `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric`
    );
    const data = await response.json();
    
    console.log(data);
    
    if (data.wind) {
      windSpeed.value = data.wind.speed;        // Windgeschwindigkeit in m/s
      windDirection.value = data.wind.deg;      // Windrichtung in Grad
    } else {
      console.error('Keine Winddaten verfügbar');
    }
  } catch (error) {
    console.error('Fehler beim Abrufen der Winddaten:', error);
  }
}

async function fetchWindDataInnsbruck() {
  const apiKey = 'c988a630d949bdf47db8e919f28b88f8';
  const lat = 47.263;  // Breitengrad von Innsbruck
  const lon = 11.395;  // Längengrad von Innsbruck
  
  try {
    const response = await fetch(
      `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric`
    );
    const data = await response.json();
    
    console.log(data);
    
    if (data.wind) {
      windDirectionInnsbruck.value = data.wind.deg;      // Windrichtung in Grad
    } else {
      console.error('Keine Winddaten verfügbar');
    }
  } catch (error) {
    console.error('Fehler beim Abrufen der Winddaten:', error);
  }
}

async function fetchWindDataInnsbruckLand() {
  const apiKey = '5adc2ecd33a333f7588a9e93cc0c6f8c';
  const lat = 47.117;  // Breitengrad von InnsbruckLand (Neustift)
  const lon = 11.317;  // Längengrad von InnsbruckLand (Neustift)
  
  try {
    const response = await fetch(
      `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric`
    );
    const data = await response.json();
    
    console.log(data);
    
    if (data.wind) {
      windDirectionInnsbruckLand.value = data.wind.deg;      // Windrichtung in Grad
    } else {
      console.error('Keine Winddaten verfügbar');
    }
  } catch (error) {
    console.error('Fehler beim Abrufen der Winddaten:', error);
  }
}

async function fetchWindDataKitzbuehel() {
  const apiKey = 'c200eea170966b1cbd77dad5515cca03';
  const lat = 47.446;  // Breitengrad von Kitzbuehl
  const lon = 12.392;  // Längengrad von Kitzbuehl
  
  try {
    const response = await fetch(
      `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric`
    );
    const data = await response.json();
    
    console.log(data);
    
    if (data.wind) {
      windDirectionKitzbuehel.value = data.wind.deg;      // Windrichtung in Grad
    } else {
      console.error('Keine Winddaten verfügbar');
    }
  } catch (error) {
    console.error('Fehler beim Abrufen der Winddaten:', error);
  }
}

async function fetchWindDataKufstein() {
  const apiKey = 'ef75f3589cda1ccbd7d1e1add5a1d8ba';
  const lat = 47.583;  // Breitengrad von Kufstein
  const lon = 12.166;  // Längengrad von Kufstein
  
  try {
    const response = await fetch(
      `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric`
    );
    const data = await response.json();
    
    console.log(data);
    
    if (data.wind) {
      windDirectionKufstein.value = data.wind.deg;      // Windrichtung in Grad
    } else {
      console.error('Keine Winddaten verfügbar');
    }
  } catch (error) {
    console.error('Fehler beim Abrufen der Winddaten:', error);
  }
}

async function fetchWindDataLienz() {
  const apiKey = 'fa28d821a34655e3140b4848e68f609e';
  const lat = 46.829;  // Breitengrad von Lienz
  const lon = 12.769;  // Längengrad von Lienz
  
  try {
    const response = await fetch(
      `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric`
    );
    const data = await response.json();
    
    console.log(data);
    
    if (data.wind) {
      windDirectionLienz.value = data.wind.deg;      // Windrichtung in Grad
    } else {
      console.error('Keine Winddaten verfügbar');
    }
  } catch (error) {
    console.error('Fehler beim Abrufen der Winddaten:', error);
  }
}

async function fetchWindDataSchwaz() {
  const apiKey = '9b859aa666acc2062084909d5d8762df';
  const lat = 47.350;  // Breitengrad von Schwaz
  const lon = 11.700;  // Längengrad von Schwaz
  
  try {
    const response = await fetch(
      `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric`
    );
    const data = await response.json();
    
    console.log(data);
    
    if (data.wind) {
      windDirectionSchwaz.value = data.wind.deg;      // Windrichtung in Grad
    } else {
      console.error('Keine Winddaten verfügbar');
    }
  } catch (error) {
    console.error('Fehler beim Abrufen der Winddaten:', error);
  }
}

async function fetchWindDataLandeck() {
  const apiKey = '884df0747e812a70f922632b369ea991';
  const lat = 47.133;  // Breitengrad von Landeck
  const lon = 10.566;  // Längengrad von Landeck
  
  try {
    const response = await fetch(
      `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric`
    );
    const data = await response.json();
    
    console.log(data);
    
    if (data.wind) {
      windDirectionLandeck.value = data.wind.deg;      // Windrichtung in Grad
    } else {
      console.error('Keine Winddaten verfügbar');
    }
  } catch (error) {
    console.error('Fehler beim Abrufen der Winddaten:', error);
  }
}

async function fetchWindDataImst() {
  const apiKey = '6530f571064edcd5445f21e5043ce550';
  const lat = 47.239;  // Breitengrad von Imst
  const lon = 10.738;  // Längengrad von Imst
  
  try {
    const response = await fetch(
      `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric`
    );
    const data = await response.json();
    
    console.log(data);
    
    if (data.wind) {
      windDirectionImst.value = data.wind.deg;      // Windrichtung in Grad
    } else {
      console.error('Keine Winddaten verfügbar');
    }
  } catch (error) {
    console.error('Fehler beim Abrufen der Winddaten:', error);
  }
}

async function fetchWindDataReutte() {
  const apiKey = 'c7e6c0a1d00c7732fdf2bd6ab997ecf4';
  const lat = 10.550;  // Breitengrad von Reutte
  const lon = 47.416;  // Längengrad von Reutte
  
  try {
    const response = await fetch(
      `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric`
    );
    const data = await response.json();
    
    console.log(data);
    
    if (data.wind) {
      windDirectionReutte.value = data.wind.deg;      // Windrichtung in Grad
    } else {
      console.error('Keine Winddaten verfügbar');
    }
  } catch (error) {
    console.error('Fehler beim Abrufen der Winddaten:', error);
  }
}

onMounted(() => {
  fetchWindData();
  fetchWindDataInnsbruck();
  fetchWindDataInnsbruckLand();
  fetchWindDataKitzbuehel();
  fetchWindDataKufstein();
  fetchWindDataLienz();
  fetchWindDataSchwaz();
  fetchWindDataLandeck();
  fetchWindDataImst();
  fetchWindDataReutte();
  fetchClients();
});

</script>

<!-- standard Sicht mit Infos zum Projekt sowie vielleicht Karte -->
<template>
  <h1 class="text-4xl font-bold text-center mt-10 bg-gradient-to-r from-green-400 via-green-700 to-green-600 text-transparent bg-clip-text">
    Willkommen auf SmartSensorNetz
  </h1>
  <!-- Karte -->
  <div class="flex justify-center mt-10">
        
    <!-- Created with Inkscape (http://www.inkscape.org/) -->
    <!-- https://upload.wikimedia.org/wikipedia/commons/f/fb/Karte_A_Tirol_I.svg -->
    <svg xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" width="1050" height="600" id="svg39755" version="1.1" inkscape:version="0.47 r22583" sodipodi:docname="Karte A Vlbg FK.svg">
      <defs id="defs39757"/>
      <sodipodi:namedview id="base" pagecolor="#ffffff" bordercolor="#666666" borderopacity="1.0" inkscape:pageopacity="0.0" inkscape:pageshadow="2" inkscape:zoom="0.49497475" inkscape:cx="205.3941" inkscape:cy="337.59823" inkscape:document-units="px" inkscape:current-layer="layer1" showgrid="false" inkscape:window-width="1680" inkscape:window-height="994" inkscape:window-x="-4" inkscape:window-y="-4" inkscape:window-maximized="1"/>
      <metadata id="metadata39760">
        <rdf:RDF>
          <cc:Work rdf:about="">
            <dc:format>image/svg+xml</dc:format>
            <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage"/>
            <dc:title/>
          </cc:Work>
        </rdf:RDF>
      </metadata>
      <g inkscape:label="Ebene 1" inkscape:groupmode="layer" id="layer1" transform="translate(0,-452.36218)">
        <g transform="translate(-328.33972,-590.83527)" id="g40362">
          <path d="m 813.32231,1277.4151 4.44679,9.8469 6.22551,-0.8949 4.44679,5.3691 1.77872,9.8433 0,3.5794 -8.00422,6.2678 -7.11487,0 0,3.5794 15.11909,14.3212 -16.00845,-4.4778 -5.33615,4.4778 -0.88936,-0.8985 0,-12.5278 0.88936,-2.6846 -2.66808,-1.7897 -13.33667,1.7897 1.77872,-2.6845 -9.78295,-8.9524 -6.22551,0 0.88936,-13.4227 10.67231,-11.6366 -0.88936,-14.3175 8.89358,-8.9524 24.00898,8.0575 -0.88936,12.5279 -8.00423,3.5794" style="fill:#22c55e;fill-opacity:1;stroke:#064e3b;stroke-width:4;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-opacity:1;stroke-dasharray:none" id="path7116"/>
          <!-- BZ Imst --><path @mouseover="showTooltip('IM')" @mouseleave="tooltipText = ''" id="path7120" style="fill:#22c55e;fill-opacity:1;stroke:#064e3b;stroke-width:4;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-opacity:1;stroke-dasharray:none" d="m 679.0403,1245.1967 -6.22551,8.9485 -1.77872,13.4266 1.77872,7.1587 12.45101,2.6846 -0.88935,6.2675 9.78294,-0.8948 3.55743,4.4742 0,17.8969 -3.55743,3.5833 4.44679,8.9485 7.11487,1.7897 -4.44679,7.1587 -9.78295,3.583 -5.33615,4.4743 0.88936,7.1587 1.77872,12.5318 5.33615,7.1588 -0.88936,14.3211 12.45102,25.9544 6.22551,9.8434 -10.6723,28.6387 19.56218,13.4265 5.33615,-0.8948 0.88936,11.633 -10.6723,7.1624 -8.00052,-1.7897 -1.77872,8.0536 -4.44679,0.8949 0.88935,12.5278 -10.6723,17.9008 -0.88936,8.0572 4.4468,8.0537 -15.1191,8.0536 -6.22551,19.6905 -3.55743,-2.6845 -6.2218,1.7897 -26.68076,-4.4743 -12.45102,5.3691 -15.11539,-9.8433 -8.89358,2.6845 -9.78295,-10.742 -9.78294,5.373 -9.77924,-1.7897 -0.88935,-5.373 13.33667,-11.633 7.11486,-4.4743 -1.77871,-8.952 5.33615,-4.4742 0.88936,-11.6331 -6.22551,-5.3729 0,-8.9485 6.22551,-9.8469 -2.66808,-8.9485 6.22551,-17.0059 -1.77872,-14.3176 9.78295,-8.9521 -8.89359,-20.5853 -1.77871,-8.0536 -9.78295,-7.1588 -7.11487,-1.7897 -1.77871,-3.5794 -13.33667,-14.3212 5.33615,-5.369 -7.11487,-1.7897 -4.44679,-6.2678 1.77871,-2.6846 0.88936,-20.5851 -1.77872,-0.8948 -1.77871,-3.5794 -0.88936,-8.0536 -7.11487,-2.6846 -8.00423,-9.8472 -5.33615,7.1627 -8.00052,-0.8948 -5.33615,-5.373 1.77872,-15.2124 -9.78294,-8.9521 0,-0.8948 5.33615,-1.7897 14.22603,14.3211 18.67653,3.5794 1.77871,-13.4263 -7.11487,0 -1.77871,-9.8433 -6.22551,0.8949 0,-8.9485 9.78294,-0.8949 2.66808,3.5794 9.78294,-8.9523 6.22551,2.6845 5.33615,-12.5278 9.77924,2.6845 9.78294,-2.6845 3.55744,-9.8434 16.00845,-0.8984 0,8.0572 14.22603,17.006 17.78717,-7.1627 3.55743,-8.0536 22.23026,4.4742 1.77872,-18.7953 8.00422,0.8948 -1.77871,13.4263"/>
          <path d="m 831.10948,1232.6653 24.00897,10.7417 -1.77871,8.0536 -6.22181,1.7897 -0.88936,4.4743 13.33668,-1.7897 7.11486,3.5832 15.1191,1.7897 -1.77872,4.4743 5.33615,9.8433 2.66808,0 0.88936,6.2639 3.55743,-0.8948 6.2218,8.0572 13.34038,17.006 3.55744,29.5335 -12.45102,3.5794 1.77871,8.9485 -3.55743,4.4781 3.55743,5.3691 -14.22603,9.8433 0,17.9005 5.33245,8.0536 -1.77872,3.5794 4.44679,15.2163 -2.66807,3.5794 -1.77872,8.0572 -6.2218,2.6845 -0.88936,5.3691 -12.45102,4.4743 -18.67653,9.8472 -8.88988,-10.7421 -11.56166,-3.5794 -2.66807,8.0537 -6.22551,1.7897 -6.22551,8.9523 -11.56166,4.4742 -7.11116,-2.6845 -8.00423,-10.742 -8.00423,1.7896 -4.44679,-3.5793 -5.33615,4.4781 -6.22551,-0.8988 -28.45577,10.7421 -4.44679,-4.4742 -7.11487,4.4742 -3.55743,-1.7897 -5.33615,0.8948 -19.56218,-13.4265 10.6723,-28.6387 -6.22551,-9.8434 -12.45102,-25.9544 0.88936,-14.3211 -5.33615,-7.1588 -1.77872,-12.5318 -0.88936,-7.1587 5.33615,-4.4743 9.78295,-3.583 4.44679,-7.1587 -7.11487,-1.7897 -4.44679,-8.9485 3.55743,-3.5833 0,-17.8969 -3.55743,-4.4742 -9.78294,0.8948 0.88935,-6.2675 -12.45101,-2.6846 -1.77872,-7.1587 1.77872,-13.4266 6.22551,-8.9485 1.77871,-13.4263 14.22974,0.8949 20.45154,0 5.33615,-8.0537 9.78294,-4.4742 16.89781,-6.2639 15.11539,1.7897 0.88936,2.6845 -11.55795,15.2124 20.45154,-1.7897 4.44679,-13.4227 13.34038,-5.3691 2.66807,-5.3729 28.45577,3.5793 4.44679,2.6885 -2.66808,7.1587 8.00423,11.6331" style="fill:#22c55e;fill-opacity:1;stroke:#064e3b;stroke-width:4;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-opacity:1;stroke-dasharray:none" id="path7124" @mouseover="showTooltip('IL')" @mouseleave="tooltipText = ''"/> <!-- BZ Innsbruck Land-->
          <!-- BZ Innsbruck--><path @mouseover="showTooltip('IN')" @mouseleave="tooltipText = ''" id="path7128" style="fill:#22c55e;fill-opacity:1;stroke:#064e3b;stroke-width:4;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-opacity:1;stroke-dasharray:none" d="m 790.2027,1276.5202 -10.67231,11.6366 -0.88936,13.4227 6.22551,0 9.78295,8.9524 -1.77872,2.6845 13.33667,-1.7897 2.66808,1.7897 -0.88936,2.6846 0,12.5278 0.88936,0.8985 5.33615,-4.4778 16.00845,4.4778 -15.11909,-14.3212 0,-3.5794 7.11487,0 8.00422,-6.2678 0,-3.5794 -1.77872,-9.8433 -4.44679,-5.3691 -6.22551,0.8949 -4.44679,-9.8469 8.00423,-3.5794 0.88936,-12.5279 -24.00898,-8.0575 -8.89358,8.9524 0.88936,14.3175"/>
          <path d="m 1173.4829,1089.4673 -0.8894,9.8469 9.7829,13.4227 10.6723,12.5318 8.8936,-2.6846 4.4468,-2.6845 13.3367,1.7897 -0.8894,13.4227 27.5701,9.8469 4.4468,4.4742 -13.3403,15.2124 8.8935,6.2678 1.7788,12.5279 2.668,1.7897 10.6686,15.216 -12.4473,7.1588 -10.6723,0 0,17.0059 -2.6681,4.4743 -16.8978,15.216 -10.6723,-2.6846 -7.1111,3.5794 -6.2255,-1.7897 -10.6723,12.5279 7.1148,10.742 -0.8893,5.3691 -6.2255,5.3691 -12.4511,-0.8949 -10.6686,7.1624 -12.451,0.8948 -13.3404,-8.0572 -6.2255,0.8949 -7.1148,-3.5794 -11.558,15.216 -3.5574,-2.6846 -5.3362,3.5794 -2.668,-6.2639 -3.5575,0.8948 -7.1149,5.3691 -11.5616,-0.8948 -7.1112,7.1588 -10.6723,-9.8434 -12.451,15.2124 -3.5574,-1.7896 -12.451,4.4742 -9.7793,-0.8949 7.1112,-25.0593 13.3404,-5.3691 8.8935,-20.5853 -6.2255,-25.0593 5.3362,-5.3691 7.1148,0 -4.4467,-11.6369 5.3361,0 1.7787,-5.3691 0.8894,0.8949 7.1149,-2.6846 -1.7788,-6.2639 7.1149,-1.7897 8.0005,-0.8949 6.2255,4.4743 0.8894,4.4742 3.5574,2.6846 3.5575,-1.7897 11.5616,-5.3691 15.1154,2.6845 6.2255,0 4.4468,-14.3211 -0.8893,-29.5339 -2.6681,-7.1587 -0.8894,-3.5794 5.3362,-5.3727 -0.8894,-2.6845 6.2255,-17.0021 -4.4468,-4.4781 1.7787,-8.9485 8.8936,-5.3691 -5.3361,-11.6366 8.8936,3.5794 25.7877,-5.3691" style="fill:#22c55e;fill-opacity:1;stroke:#064e3b;stroke-width:4;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-opacity:1;stroke-dasharray:none" id="path7132" @mouseover="showTooltip('KI')" @mouseleave="tooltipText = ''"/> <!-- BZ Kitzbühl -->
          <!-- BZ Kufstein --><path @mouseover="showTooltip('KU')" @mouseleave="tooltipText = ''" id="path7136" style="fill:#22c55e;fill-opacity:1;stroke:#064e3b;stroke-width:4;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-opacity:1;stroke-dasharray:none" d="m 1113.9032,1069.7768 -8.0042,20.5854 4.4468,6.2675 24.8983,-8.0572 3.5575,-0.8949 0,3.5794 5.3361,11.6366 -8.8936,5.3691 -1.7787,8.9485 4.4468,4.4781 -6.2255,17.0021 0.8894,2.6845 -5.3362,5.3727 0.8894,3.5794 2.6681,7.1587 0.8893,29.5339 -4.4468,14.3211 -6.2255,0 -15.1154,-2.6845 -11.5616,5.3691 -3.5575,1.7897 -3.5574,-2.6846 -0.8894,-4.4742 -6.2255,-4.4743 -8.0005,0.8949 -7.1149,1.7897 1.7788,6.2639 -7.1149,2.6846 -0.8894,-0.8949 -1.7787,5.3691 -5.3361,0 4.4467,11.6369 -7.1148,0 -5.3362,5.3691 6.2255,25.0593 -8.8935,20.5853 -13.3404,5.3691 -15.1154,-6.2639 -10.6723,1.7897 -7.11488,-3.5794 -1.77872,-13.4266 -10.6723,-8.9485 -14.22603,-11.633 -3.55743,1.7897 0,-5.3726 -6.22551,2.6845 0,-5.3691 -16.00846,-11.633 2.66808,-10.742 16.89781,-7.1588 0.88936,-7.1588 0.88936,-15.216 3.55743,-3.5794 -2.66807,-8.0536 -9.78295,0 -5.33615,-4.4781 1.77872,-5.3691 -14.22603,-1.7897 8.88988,-8.9485 -0.88936,-7.1623 23.12332,5.3726 4.44679,-10.7417 13.33667,-2.6846 27.57007,-2.6845 11.5617,-5.3691 4.4431,7.1588 13.3404,-2.6845 8.0042,4.4742 22.2303,0.8948 10.6723,-3.5793 -0.8894,7.1587 9.7829,-3.5794 -2.668,-17.0059 -3.5575,-8.0537 -8.0042,-22.3747 8.0042,0 8.8936,-4.4743 16.0085,-17.0059 2.668,6.2639"/>
          <path d="m 542.0902,1301.5795 8.00423,9.8472 7.11487,2.6846 0.88936,8.0536 1.77871,3.5794 1.77872,0.8948 -0.88936,20.5851 -1.77871,2.6846 4.44679,6.2678 7.11487,1.7897 -5.33615,5.369 13.33667,14.3212 1.77871,3.5794 7.11487,1.7897 9.78295,7.1588 1.77871,8.0536 8.89359,20.5853 -9.78295,8.9521 1.77872,14.3176 -6.22551,17.0059 2.66808,8.9485 -6.22551,9.8469 0,8.9485 6.22551,5.3729 -0.88936,11.6331 -5.33615,4.4742 1.77871,8.952 -7.11486,4.4743 -2.66808,-5.3691 -21.3409,-10.7417 1.77872,-5.3691 -10.6723,-7.1588 -5.33615,4.4742 -8.89359,0.8949 -26.67705,12.5278 0.88936,-6.2639 -18.67653,0.8949 -6.22551,-6.264 -3.55372,1.7897 -1.77872,-14.3214 8.00052,-16.1073 1.77872,-10.7417 -10.6686,-8.0536 -11.56166,-4.4743 0.88936,-8.0575 -12.45102,-13.4227 -6.22551,5.3691 -7.11487,-0.8949 -8.88988,18.7957 -7.11486,2.6846 2.66807,11.633 -7.11487,2.6845 -18.67653,-7.1588 -6.22551,17.9006 1.77872,15.2162 -13.33667,0 -8.89358,7.1588 -8.00423,0 -1.77872,-12.5317 -10.6723,-10.7382 -2.66808,-16.1108 9.78295,-7.1588 8.00422,-21.4802 4.4468,0 -0.88936,-10.7418 -10.6723,-8.9484 4.44679,-3.5794 8.00423,-9.8472 -1.77872,-7.1588 -5.33615,-0.8948 -0.88936,-7.1588 9.78294,-17.9006 9.78295,-2.6845 0,-4.4742 8.00052,-0.8949 -1.77501,-6.2678 6.2218,-2.6845 -2.66808,-4.4743 4.4468,2.6846 24.90203,-6.264 5.33615,-3.5793 15.11539,0.8948 4.4468,-5.3691 8.89358,5.3691 7.11487,-1.7897 3.55743,-7.1624 8.89359,-19.6866 11.55795,-6.2678 4.44679,4.4781 17.78717,2.6845 3.55744,-8.0575 3.55743,0.8949 5.33615,5.373 8.00052,0.8948 5.33615,-7.1627" style="fill:#22c55e;fill-opacity:1;stroke:#064e3b;stroke-width:4;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-opacity:1;stroke-dasharray:none" id="path7140" @mouseover="showTooltip('LA')" @mouseleave="tooltipText = ''"/> <!-- BZ Landeck -->
          <!-- BZ Lienz --><path @mouseover="showTooltip('LZ')" @mouseleave="tooltipText = ''" id="path7144" style="fill:#22c55e;fill-opacity:1;stroke:#064e3b;stroke-width:4;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-opacity:1;stroke-dasharray:none" d="m 1198.3849,1367.8096 8.0042,10.7417 7.1112,-2.6845 8.0042,0.8948 0.8894,4.4743 8.8935,1.7897 13.3404,10.7381 15.1154,14.3215 6.2255,15.216 14.2298,-1.7933 4.4468,3.583 -5.3362,2.6845 -9.7829,18.7957 4.4468,14.3175 0.8893,4.4743 5.3362,2.6845 8.8935,8.0572 2.6681,6.2639 5.3325,2.6846 4.4468,2.6845 5.3361,3.5794 -1.7787,4.4781 3.5574,4.4743 -0.8893,16.1108 16.0084,9.8433 3.5575,8.0536 2.668,1.7897 0.8894,0 19.5622,12.5318 0.8893,5.3691 -11.5579,11.6366 -11.5617,-6.2675 -15.1191,8.952 -5.3361,5.3691 -9.783,0 -0.8893,-3.5794 -5.3325,0 -16.0084,4.4742 -13.3404,5.3691 -0.8894,10.7421 4.4468,6.2639 -9.7829,0 -0.8894,23.2696 -17.7834,2.6846 -3.5575,-5.3691 -21.3446,5.3691 -6.2218,-4.4743 -12.451,-9.8433 -12.451,0.8948 -1.7787,-5.3726 -11.5617,-0.8949 -5.3361,-5.3691 -16.0048,-10.7381 -7.1149,-28.6426 -25.7877,-4.4742 0,-16.1112 8.0006,-13.4227 -3.5575,-1.7897 -1.775,-10.7417 -5.3361,-3.5794 0,-5.3691 -10.6723,-3.5794 -9.783,8.0536 -7.1148,-15.2124 -16.8941,-6.2678 8.0005,-10.7381 -12.4473,-13.4263 1.7787,-9.8433 -3.5575,-1.7897 -1.7787,-10.7421 8.8936,-8.9485 6.2218,2.6846 14.2297,-3.5794 4.4468,-16.1108 8.0043,-5.3691 7.1148,-1.7897 8.0043,-9.8472 8.8898,-0.8949 0.8894,-4.4742 11.5617,-3.5794 5.3361,-3.5794 1.7787,-12.5314 12.451,-5.3691 5.3325,5.3691 6.2255,-4.4743 10.6723,3.5794 6.2255,-7.1588 13.3404,4.4743"/>
          <path d="m 490.51112,1144.064 12.45102,8.0537 2.66807,0.8948 8.89359,1.7897 13.34037,0 3.55744,1.7897 2.66437,-10.7382 6.22551,-7.1623 27.57011,8.0572 4.44679,-2.6846 0.88936,8.0537 16.00475,3.5794 6.22551,2.6845 0.88936,7.1588 4.44679,3.5832 12.45102,-2.6845 0,-3.5833 26.67705,-4.4742 4.44679,9.8472 5.33615,0.8948 -16.89781,8.0537 0,8.9484 4.44679,1.7897 8.89359,-2.6845 8.89358,1.7897 -0.88936,7.1623 16.89411,19.6906 -5.33245,13.4227 7.11117,3.5794 -1.77872,18.7953 -22.23026,-4.4742 -3.55743,8.0536 -17.78717,7.1627 -14.22603,-17.006 0,-8.0572 -16.00845,0.8984 -3.55744,9.8434 -9.78294,2.6845 -9.77924,-2.6845 -5.33615,12.5278 -6.22551,-2.6845 -9.78294,8.9523 -2.66808,-3.5794 -9.78294,0.8949 0,8.9485 6.22551,-0.8949 1.77871,9.8433 7.11487,0 -1.77871,13.4263 -18.67653,-3.5794 -14.22974,-14.3211 -5.33244,1.7897 0,0.8948 9.78294,8.9521 -1.77872,15.2124 -3.56114,-0.8949 -3.55373,8.0575 -17.78717,-2.6845 -4.44679,-4.4781 -11.56166,6.2678 -8.89358,19.6866 -3.55744,7.1624 -7.11116,1.7897 -8.89358,-5.3691 -4.4468,5.3691 -15.11909,-0.8948 -5.33615,3.5793 -24.89833,6.264 -4.4468,-2.6846 0,-7.1587 -4.44679,-10.7418 6.22551,-7.1588 0,-8.9485 -5.33615,-6.2678 8.89358,-8.0536 -16.00845,-6.2639 0.88936,-3.5794 8.00423,-2.6845 11.56166,3.5793 11.56166,-8.952 5.33244,0 11.56166,-8.0536 5.33615,0.8948 6.22551,-6.2639 16.89781,-29.5374 8.88988,-3.5794 6.22551,1.7897 -2.66807,-5.3691 2.66807,-9.8433 13.34038,-10.7421 0,-5.3691 -2.66807,-20.585 -6.22551,-0.8949 -2.66808,-5.3691 -1.77872,-4.4742 8.89359,-25.9545 -6.22551,-8.0572 0.88936,-7.1587 16.00845,0.8948 -10.6723,14.3211" style="fill:#22c55e;fill-opacity:1;stroke:#064e3b;stroke-width:4;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-opacity:1;stroke-dasharray:none" id="path7148" @mouseover="showTooltip('RE')" @mouseleave="tooltipText = ''"/> <!-- BZ Reute -->
          <!-- BZ Schwaz --><path @mouseover="showTooltip('SW')" @mouseleave="tooltipText = ''" id="path7152" style="fill:#22c55e;fill-opacity:1;stroke:#064e3b;stroke-width:4;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-opacity:1;stroke-dasharray:none" d="m 896.9146,1136.0068 8.00422,5.3691 40.01743,-2.6845 0.88936,7.1623 -8.88988,8.9485 14.22603,1.7897 -1.77872,5.3691 5.33615,4.4781 9.78295,0 2.66807,8.0536 -3.55743,3.5794 -0.88936,15.216 -0.88936,7.1588 -16.89781,7.1588 -2.66808,10.742 16.00846,11.633 0,5.3691 6.22551,-2.6845 0,5.3726 3.55743,-1.7897 14.22603,11.633 10.6723,8.9485 1.77872,13.4266 7.11488,3.5794 10.6723,-1.7897 15.1154,6.2639 -7.1112,25.0593 9.7793,0.8949 12.451,-4.4742 3.5574,1.7896 10.6723,17.9009 -8.8936,13.4263 -1.7787,10.7381 5.3362,25.0596 4.4467,2.6846 8.8936,30.4322 -6.2255,3.5794 -7.1148,-2.6845 -8.0043,9.8433 -11.5616,-0.8948 -8.0006,7.1587 -14.2297,-2.6845 -11.56165,8.9521 -4.44679,-2.6846 -6.22551,2.6846 -14.22603,10.7381 -13.34038,8.9524 -19.56588,0 -5.33245,8.9484 -6.22551,2.6846 -7.11487,-2.6846 -5.33615,-10.742 -16.00845,0.8948 -13.33667,-11.633 0.88936,-5.3691 6.2218,-2.6845 1.77872,-8.0572 2.66807,-3.5794 -4.44679,-15.2163 1.77872,-3.5794 -5.33245,-8.0536 0,-17.9005 14.22603,-9.8433 -3.55743,-5.3691 3.55743,-4.4781 -1.77871,-8.9485 12.45102,-3.5794 -3.55744,-29.5335 -13.34038,-17.006 -6.2218,-8.0572 -3.55743,0.8948 -0.88936,-6.2639 -2.66808,0 -5.33615,-9.8433 1.77872,-4.4743 -15.1191,-1.7897 -7.11486,-3.5832 -13.33668,1.7897 0.88936,-4.4743 6.22181,-1.7897 1.77871,-8.0536 -24.00897,-10.7417 -8.00423,-11.6331 2.66808,-7.1587 -4.44679,-2.6885 -3.55744,-11.633 -8.89358,-3.5794 18.67653,-21.4799 4.44679,4.4743 19.56218,1.7897 23.12332,-4.4743 5.33615,-5.3691 0,-15.2162 4.44679,-6.264 2.66808,-7.1623 8.88988,0 0.88936,-6.264"/>

          <!-- Pfeil Landeck Anfang-->
          <g :transform="`translate(-320, 120)`">
            <polygon :transform="`rotate(${windDirectionLandeck}, 813.32231, 1277.4151)`" points="813.32231,1277.4151 808.32231,1287.4151 818.32231,1287.4151" fill="#00FFFF" />
            <line :transform="`rotate(${windDirectionLandeck}, 813.32231, 1277.4151)`" x1="813.32231" y1="1296.4151" x2="813.32231" y2="1287.4151" stroke="#00FFFF" stroke-width="4" />
          </g>
          <!-- Pfeil Landeck Ende-->

          <!-- Pfeil Reutte Anfang-->
          <g :transform="`translate(-265, -60)`">
            <polygon :transform="`rotate(${windDirectionReutte}, 813.32231, 1277.4151)`" points="813.32231,1277.4151 808.32231,1287.4151 818.32231,1287.4151" fill="#00FFFF" />
            <line :transform="`rotate(${windDirectionReutte}, 813.32231, 1277.4151)`" x1="813.32231" y1="1296.4151" x2="813.32231" y2="1287.4151" stroke="#00FFFF" stroke-width="4" />
          </g>
          <!-- Pfeil Reutte Ende-->

          <!-- Pfeil Imst Anfang-->
          <g :transform="`translate(-180, 85)`">
            <polygon :transform="`rotate(${windDirectionImst}, 813.32231, 1277.4151)`" points="813.32231,1277.4151 808.32231,1287.4151 818.32231,1287.4151" fill="#00FFFF" />
            <line :transform="`rotate(${windDirectionImst}, 813.32231, 1277.4151)`" x1="813.32231" y1="1296.4151" x2="813.32231" y2="1287.4151" stroke="#00FFFF" stroke-width="4" />
          </g>
          <!-- Pfeil Imst Ende-->

          <!-- Pfeil Innsbruck Anfang-->
          <g :transform="`translate(-10, 10)`">
            <polygon :transform="`rotate(${windDirectionInnsbruck}, 813.32231, 1277.4151)`" points="813.32231,1277.4151 808.32231,1287.4151 818.32231,1287.4151" fill="#00FFFF" />
            <line :transform="`rotate(${windDirectionInnsbruck}, 813.32231, 1277.4151)`" x1="813.32231" y1="1296.4151" x2="813.32231" y2="1287.4151" stroke="#00FFFF" stroke-width="4" />
          </g>
          <!-- Pfeil Innsbruck Ende-->

          <!-- Pfeil Innsbruck-Land Anfang-->
          <g :transform="`translate(-10, 100)`">
            <polygon :transform="`rotate(${windDirectionInnsbruckLand}, 813.32231, 1277.4151)`" points="813.32231,1277.4151 808.32231,1287.4151 818.32231,1287.4151" fill="#00FFFF" />
            <line :transform="`rotate(${windDirectionInnsbruckLand}, 813.32231, 1277.4151)`" x1="813.32231" y1="1296.4151" x2="813.32231" y2="1287.4151" stroke="#00FFFF" stroke-width="4" />
          </g>
          <!-- Pfeil Innsbruck-Land Ende-->

          <!-- Pfeil Schwaz Anfang-->
          <g :transform="`translate(130, 10)`">
            <polygon :transform="`rotate(${windDirectionSchwaz}, 813.32231, 1277.4151)`" points="813.32231,1277.4151 808.32231,1287.4151 818.32231,1287.4151" fill="#00FFFF" />
            <line :transform="`rotate(${windDirectionSchwaz}, 813.32231, 1277.4151)`" x1="813.32231" y1="1296.4151" x2="813.32231" y2="1287.4151" stroke="#00FFFF" stroke-width="4" />
          </g>
          <!-- Pfeil Schwaz Ende-->

          <!-- Pfeil Kufstein Anfang-->
          <g :transform="`translate(230, -110)`">
            <polygon :transform="`rotate(${windDirectionKufstein}, 813.32231, 1277.4151)`" points="813.32231,1277.4151 808.32231,1287.4151 818.32231,1287.4151" fill="#00FFFF" />
            <line :transform="`rotate(${windDirectionKufstein}, 813.32231, 1277.4151)`" x1="813.32231" y1="1296.4151" x2="813.32231" y2="1287.4151" stroke="#00FFFF" stroke-width="4" />
          </g>
          <!-- Pfeil Kufstein Ende-->

          <!-- Pfeil Kitzbuehel Anfang-->
          <g :transform="`translate(330, -50)`">
            <polygon :transform="`rotate(${windDirectionKitzbuehel}, 813.32231, 1277.4151)`" points="813.32231,1277.4151 808.32231,1287.4151 818.32231,1287.4151" fill="#00FFFF" />
            <line :transform="`rotate(${windDirectionKitzbuehel}, 813.32231, 1277.4151)`" x1="813.32231" y1="1296.4151" x2="813.32231" y2="1287.4151" stroke="#00FFFF" stroke-width="4" />
          </g>
          <!-- Pfeil Kitzbuehel Ende-->

          <!-- Pfeil Lienz Anfang-->
          <g :transform="`translate(380, 220)`">
            <polygon :transform="`rotate(${windDirectionLienz}, 813.32231, 1277.4151)`" points="813.32231,1277.4151 808.32231,1287.4151 818.32231,1287.4151" fill="#00FFFF" />
            <line :transform="`rotate(${windDirectionLienz}, 813.32231, 1277.4151)`" x1="813.32231" y1="1296.4151" x2="813.32231" y2="1287.4151" stroke="#00FFFF" stroke-width="4" />
          </g>
          <!-- Pfeil Lienz Ende-->

        </g>
      </g>

      <!-- Allgemeiner Kompass für ganz Tirol, wird nicht mehr benötigt -->
      <!--
      <g :transform="`translate(900, 500)`" id="wind-compass">
        <circle cx="0" cy="0" r="50" stroke="black" stroke-width="2" fill="none" />
        <text x="0" y="-35" text-anchor="middle" font-size="12" font-weight="bold">N</text>
        <text x="35" y="5" text-anchor="middle" font-size="12" font-weight="bold">E</text>
        <text x="0" y="45" text-anchor="middle" font-size="12" font-weight="bold">S</text>
        <text x="-35" y="5" text-anchor="middle" font-size="12" font-weight="bold">W</text>
        <polygon :transform="`rotate(${windDirection})`" points="0,-30 5,-20 -5,-20" fill="black" />
      </g>
      -->
    </svg>
  </div>

  <div class="text-center mt-5">
    <div
      v-for="(ort, index) in orte"
      :key="index"
      class="ort"
      @mouseover="showSensorCount(ort)"
      @mouseout="hideSensorCount"
    >
      {{ ort }}
    </div>

    <!-- Tooltip anzeigen -->
    <p v-if="showTooltip" class="tooltip">{{ tooltipText }}</p>
  </div>

  <!-- Winddaten anzeigen -->
  <div v-if="windSpeed" class="text-center mt-5">
    <p class="font-bold">Über ganz Tirol 💨</p>
    <p>Windgeschwindigkeit: {{ windSpeed }} m/s 🍃</p>
    <p>Windrichtung: {{ windDirection }}° 🧭</p>
  </div>
</template>

<style>
.tooltip {
  height: 30px; /* Feste Höhe damit sich nicht immer alles verschiebt wenn tooltip false */
}

svg g g path {
  cursor: pointer;
  fill: #cccccc;
  transition: fill 0.3s ease;
}

svg g g path:hover {
  fill: #aaaaaa;
}

svg path.active {
  fill: #ff0000;
}
</style>
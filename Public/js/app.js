// Selector interactivo de coordenadas en Nuevo Reporte
const pickerContainer = document.getElementById("picker-map");
if (pickerContainer && typeof L !== "undefined") {
  const latInput = document.getElementById("latitud");
  const lngInput = document.getElementById("longitud");
  const coordsLabel = document.getElementById("coords-label");

  const pickerMap = L.map("picker-map").setView([7.0653, -73.8547], 13);
  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "&copy; OpenStreetMap contributors",
  }).addTo(pickerMap);

  const marker = L.marker([7.0653, -73.8547], { draggable: true }).addTo(pickerMap);

  const actualizarCoords = (lat, lng) => {
    latInput.value = lat.toFixed(7);
    lngInput.value = lng.toFixed(7);
    if (coordsLabel) coordsLabel.textContent = `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
  };

  pickerMap.on("click", (e) => {
    marker.setLatLng(e.latlng);
    actualizarCoords(e.latlng.lat, e.latlng.lng);
  });

  marker.on("dragend", () => {
    const pos = marker.getLatLng();
    actualizarCoords(pos.lat, pos.lng);
  });

  const btnGeo = document.getElementById("btn-geolocate");
  if (btnGeo && "geolocation" in navigator) {
    btnGeo.addEventListener("click", () => {
      navigator.geolocation.getCurrentPosition((pos) => {
        const { latitude, longitude } = pos.coords;
        pickerMap.setView([latitude, longitude], 16);
        marker.setLatLng([latitude, longitude]);
        actualizarCoords(latitude, longitude);
      });
    });
  }


}


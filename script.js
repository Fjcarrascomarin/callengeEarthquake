  var xmlhttp = new XMLHttpRequest();
  var url = "data.php";

  xmlhttp.open("GET", url, true);
  xmlhttp.send();
  var map = L.map("map").setView([36.6338, -4.3994], 4);

  L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution:
      '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
  }).addTo(map);

  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const terremotos = JSON.parse(this.responseText);

      terremotos.forEach((element) => {
        const marker = L.marker([element["latitud"], element["longitud"]]).addTo(map);
        marker.bindPopup(
          "<b>" +
            element["fecha"] +
            " " +
            element["hora"] +
            "</b><br><a href='" +
            element["enlace"] +
            "' target='_blank'>" +
            element["ubicacion"] +
            " (" +
            element["magnitud"] +
            ")"
        );
      });
    }
  };

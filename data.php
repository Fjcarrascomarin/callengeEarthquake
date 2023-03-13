<?php
// Definir la URL del XML
$url_xml_terremotos = 'https://www.ign.es/ign/RssTools/sismologia.xml';

// Cargar el XML de la URL definida
$xml_terremotos = simplexml_load_file($url_xml_terremotos);

// Crear un array para almacenar los datos de los terremotos
$datos_terremotos = array();

// Recorrer los elementos "item" del XML
foreach ($xml_terremotos->channel->item as $item) {
    // Extraer los datos relevantes del elemento "title"
    $titulo_terremoto = (string) $item->title;
    preg_match('/-Info\.terremoto: (\d{2}\/\d{2}\/\d{4}) (\d{1,2}:\d{2}:\d{2})/', $titulo_terremoto, $matches);
    $fecha_terremoto = $matches[1];
    $hora_terremoto = $matches[2];

    // Extraer el enlace del elemento "link"
    $enlace_terremoto = (string) $item->link;

    // Extraer la descripción del elemento "description"
    $descripcion_terremoto = (string) $item->description;

    // Extraer la magnitud y la ubicación de la descripción
    preg_match('/Se ha producido un terremoto de magnitud ([\d\.]+) en ([^ ]+(?: [^ ]+)*) en la fecha (\d{2}\/\d{2}\/\d{4} \d{1,2}:\d{2}:\d{2}) en la siguiente localización: ([\d\.\-]+),([\d\.\-]+)/', $descripcion_terremoto, $matches);
    $magnitud_terremoto = $matches[1];
    $ubicacion_terremoto = $matches[2];
    $latitud_terremoto = $matches[4];
    $longitud_terremoto = $matches[5];

    // Añadir los datos al array de terremotos
    $datos_terremotos[] = array(
        'fecha' => $fecha_terremoto,
        'hora' => $hora_terremoto,
        'enlace' => $enlace_terremoto,
        'descripcion' => $descripcion_terremoto,
        'magnitud' => $magnitud_terremoto,
        'ubicacion' => $ubicacion_terremoto,
        'latitud' => $latitud_terremoto,
        'longitud' => $longitud_terremoto
    );
}

// Establecer el tipo de contenido como JSON y mostrar los datos de los terremotos en formato JSON
header('Content-Type: application/json');
echo json_encode($datos_terremotos);

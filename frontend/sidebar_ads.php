<?php

/* =========================================
   DETECTAR PÁGINA ACTUAL
========================================= */

$currentPage = basename($_SERVER['PHP_SELF'], ".php");


/* =========================================
   PLANES PUBLICITARIOS
========================================= */

$plans = [

    "basico" => [

        "duration" => 7,
        "price" => 40000,

        "pages" => [
            "dashboard"
        ],

        "views" => "50 - 100"
    ],

    "estandar" => [

        "duration" => 10,
        "price" => 100000,

        "pages" => [
            "dashboard",
            "perfil",
            "poemas"
        ],

        "views" => "100 - 200"
    ],

    "premium" => [

        "duration" => 11,
        "price" => 240000,

        "pages" => [
            "dashboard",
            "perfil",
            "poemas",
            "jugador",
            "comunidad"
        ],

        "views" => "250 - 500"
    ]

];


/* =========================================
   ANUNCIOS ACTIVOS
========================================= */

$ads = [

    [
        "image" => "./img/publicidad1-nueva.png",
        "link" => "#",
        "side" => "left",
        "plan" => "premium"
    ],

    [
        "image" => "./img/publicidad2.png",
        "link" => "#",
        "side" => "right",
        "plan" => "premium"
    ]

];


/* =========================================
   MOSTRAR ANUNCIOS
========================================= */

foreach ($ads as $ad) {

    $planData = $plans[$ad['plan']];

    /* Revisar si el anuncio puede salir
       en la página actual */

    if (in_array($currentPage, $planData['pages'])) {

        echo '

        <div class="' . $ad['side'] . '-global-ad">

            <a href="' . $ad['link'] . '">

                <img src="' . $ad['image'] . '" alt="Publicidad">

            </a>

        </div>

        ';
    }
}

?>
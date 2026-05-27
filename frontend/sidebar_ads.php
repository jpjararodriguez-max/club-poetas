<?php

/* =========================================
   DETECTAR PÁGINA ACTUAL
========================================= */

$currentPage = basename($_SERVER['PHP_SELF'], ".php");


/* =========================================
   PLANES PUBLICITARIOS
========================================= */

$plans = [

    "no_dinero" => [

        "duration" => 0,
        "price" => 0,

        "pages" => [
            ""
        ],

        "views" => "0 - 0"
    ],


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

        "duration" => 13,
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
        "plan" => "no_dinero"
    ],

    [
        "image" => "./img/publicidad2.png",
        "link" => "#",
        "side" => "right",
        "plan" => "no_dinero"
    ],

    
    [
        "image" => "./img/publicidadmercancia1.png",
        "link" => "#",
        "side" => "left",
        "plan" => "no_dinero"
    ],

    [
        "image" => "./img/publicidadmercancia2.png",
        "link" => "#",
        "side" => "right",
        "plan" => "no_dinero"
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

        <div class="' . $ad['side'] . '-global-ad ad-item ad-' . $ad['side'] . '">

            <a href="' . $ad['link'] . '">

                <img src="' . $ad['image'] . '" alt="Publicidad">

            </a>

        </div>

        ';
    }
}

?>

<script>

/* TOMAR TODOS LOS BANNERS */

const leftAds = document.querySelectorAll(".ad-left");
const rightAds = document.querySelectorAll(".ad-right");


/* MOSTRAR SOLO EL PRIMERO */

leftAds.forEach((ad, index) => {

    if (index !== 0) {
        ad.style.display = "none";
    }

});

rightAds.forEach((ad, index) => {

    if (index !== 0) {
        ad.style.display = "none";
    }

});


/* ROTACIÓN IZQUIERDA */

let leftIndex = 0;

setInterval(() => {

    leftAds[leftIndex].style.display = "none";

    leftIndex++;

    if (leftIndex >= leftAds.length) {
        leftIndex = 0;
    }

    leftAds[leftIndex].style.display = "block";

}, 10000);


/* ROTACIÓN DERECHA */

let rightIndex = 0;

setInterval(() => {

    rightAds[rightIndex].style.display = "none";

    rightIndex++;

    if (rightIndex >= rightAds.length) {
        rightIndex = 0;
    }

    rightAds[rightIndex].style.display = "block";

}, 10000);

</script>
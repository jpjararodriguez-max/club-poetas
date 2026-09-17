<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);

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
        "pages" => [],
        "views" => "0 - 0"
    ],

    "basico" => [
        "duration" => 4, 
        "price" => 40000,
        "pages" => ["dashboard"],
        "views" => "50 - 100"
    ],

    "estandar" => [
        "duration" => 9, 
        "price" => 100000,
        "pages" => ["dashboard", "perfil", "poemas"],
        "views" => "100 - 200"
    ],

    "premium" => [
        "duration" => 11, 
        "price" => 240000,
        "pages" => ["dashboard", "perfil", "poemas", "jugador", "comunidad"],
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
    $planKey = $ad['plan'] ?? 'no_dinero';
    $planData = $plans[$planKey] ?? $plans['no_dinero'];

    if (in_array($currentPage, $planData['pages'])) {
        $side = htmlspecialchars($ad['side'], ENT_QUOTES, 'UTF-8');
        $link = htmlspecialchars($ad['link'], ENT_QUOTES, 'UTF-8');
        $image = htmlspecialchars($ad['image'], ENT_QUOTES, 'UTF-8');

        echo '
        <div class="' . $side . '-global-ad ad-item ad-' . $side . '">
            <a href="' . $link . '">
                <img src="' . $image . '" alt="Publicidad">
            </a>
        </div>
        ';
    }
}
?>

<script>
document.addEventListener("DOMContentLoaded", () => {
    /* TOMAR TODOS LOS BANNERS */
    const leftAds = document.querySelectorAll(".ad-left");
    const rightAds = document.querySelectorAll(".ad-right");

    /* MOSTRAR SOLO EL PRIMERO (IZQUIERDA) */
    if (leftAds.length > 0) {
        leftAds.forEach((ad, index) => {
            ad.style.display = (index === 0) ? "block" : "none";
        });

        /* ROTACIÓN IZQUIERDA */
        if (leftAds.length > 1) {
            let leftIndex = 0;
            setInterval(() => {
                leftAds[leftIndex].style.display = "none";
                leftIndex = (leftIndex + 1) % leftAds.length;
                leftAds[leftIndex].style.display = "block";
            }, 11000);
        }
    }

    /* MOSTRAR SOLO EL PRIMERO (DERECHA) */
    if (rightAds.length > 0) {
        rightAds.forEach((ad, index) => {
            ad.style.display = (index === 0) ? "block" : "none";
        });

        /* ROTACIÓN DERECHA */
        if (rightAds.length > 1) {
            let rightIndex = 0;
            setInterval(() => {
                rightAds[rightIndex].style.display = "none";
                rightIndex = (rightIndex + 1) % rightAds.length;
                rightAds[rightIndex].style.display = "block";
            }, 11000);
        }
    }
});
</script>
<?php

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
            "buscar",
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
        "plan" => "basico"
    ]

];

?>


<?php foreach ($ads as $ad): ?>

<?php

    $planData = $plans[$ad['plan']];

?>

<div class="<?= $ad['side']; ?>-global-ad">

    <a href="<?= $ad['link']; ?>">

        <img src="<?= $ad['image']; ?>" alt="Publicidad">

    </a>

</div>

<?php endforeach; ?>
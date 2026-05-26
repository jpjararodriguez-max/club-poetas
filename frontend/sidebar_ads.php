<?php

$ads = [

    [
        "image" => "./img/publicidad1-nueva.png",
        "link" => "#",
        "side" => "left"
    ],

    [
        "image" => "./img/publicidad2.png",
        "link" => "#",
        "side" => "right"
    ]

];

?>

<?php foreach ($ads as $ad): ?>

    <div class="<?= $ad['side']; ?>-global-ad">

        <a href="<?= $ad['link']; ?>">

            <img src="<?= $ad['image']; ?>" alt="Publicidad">

        </a>

    </div>

<?php endforeach; ?>
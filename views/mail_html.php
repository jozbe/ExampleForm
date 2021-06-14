<?php
ob_start(); // Ez azért kell, hogy a HTML ne a HTTP-be íródjon, hanem egy bufferbe
?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <h1>Kedves Olvasó!</h1>
    <p>
        Egy ismerősöd meghívott, hogy csatlakozz te is <a href="jbence.hu">oldalunkhoz</a>.


    </p>

    <p>Üdvözlettel:<br>Józsa Bence Attila</p>
<?php
$MAIL_HTML = ob_get_clean(); // Ezzel a buffer tartalmát a változóba tesszük, és töröljük a buffert
?>
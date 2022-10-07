<?php
/*
ob_start();  //Que activa el tratamiento del buffer en php

set_time_limit(0);   //Indica al motor de php que el script nunca debe caducar a pesar de lo que dure.

$id=0;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli('localhost', 'MeseroAdmin', 'MeseroAdmin2022$', 'mesero_virtual') or die ('No se puede realizar la consulta');

for(;;)
{
$rs = $mysqli->query(' SELECT id, restaurante_id, cliente_id, valor, estado FROM pedido WHERE restaurante_id = 36 AND id > 57 ');
if(mysqli_num_rows($rs)>0)
{
while($fila=mysqli_fetch_array($rs,MYSQLI_ASSOC)) {
    $id=$fila['id'];
    echo '<div>\n';
echo '<span>' . $fila['id'] . ' ' . '</span>';
echo '<span>' . $fila['valor'] . '&gt;</span>';
echo '<span>' . $fila['estado'] . '</span>';
echo '</div>\n';
echo '<script>scrollTo(0,999999999);</script>\n';
ob_flush();
flush();

sleep(1);
}
}
}*/
ob_start();  //Que activa el tratamiento del buffer en php

//set_time_limit(0);   //Indica al motor de php que el script nunca debe caducar a pesar de lo que dure.

$id = 56;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli('localhost', 'MeseroAdmin', 'MeseroAdmin2022$', 'mesero_virtual');

//for (;;) {
    $rs = $mysqli->query(' SELECT id, restaurante_id, cliente_id, valor, estado FROM pedido WHERE restaurante_id = 36 AND id > ' . $id) or die ('no se puede realizar la consulta');
    $dato = mysqli_num_rows($rs);

    if (mysqli_num_rows($rs) > 0) {
        while ($fila = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
            $id = $fila['id'];
            echo '<script> console.log("holaaaaaaaaaaaaaaaaaaaa'.$fila['valor'].'"); </script>';
            sleep(1000);
        }
    }
//}
?>
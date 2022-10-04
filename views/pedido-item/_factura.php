<?php

use app\models\Grupo;
use app\models\Menu;

$grupos = Grupo::find()->all();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>

  <div id="factura-total" class="col-11">

    <div class="row my-3">
      <div class="col-10">
        <h1><?= $usuario->nombre; ?></h1>
        <p>Direcion : <?= $usuario->direccion; ?></p>
        Fecha : <?= date('Y-m-d H:i'); ?>

      </div>
      <div class="col-2">
        <!-- <img src="img/logo.png" /> -->
      </div>
    </div>
    <div class="row my-5">
      <table class="table table-borderless factura">
        <thead>
          <tr>
            <th>#.</th>
            <th style=" display:none; ">id.</th>
            <th>Cant.</th>
            <th>Precio</th>
          </tr>
        </thead>
        <tbody id="cuerpo">

        </tbody>
        <tfoot>
          <tr>
            <th></th>
            <th style=" display:none; "></th>
            <th>Total Factura</th>
            <th id="totalFactura">$0.00</th>
          </tr>
        </tfoot>
      </table>
    </div>
    <div class="cond row">
    </div>
  </div>

  <script type="text/javascript">
    const formatterDolar2 = new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD'
    }) //formato moneda Dolar

    var contador = 0;
    var tipoPlato = "Bebidas";
    var j = 0;

    $("#cuerpo").html("");

    var total = 0;

    <?php foreach ($grupos as $contador => $grupo) { ?>

      var tipoPlato = '<?= $grupo->nombre ?>';
      tipoPlato = tipoPlato.split(" ", 1);
      if (sessionStorage.getItem("pedido" + tipoPlato)) { //si existen datos del menu almacenados los carga en en formulario
        var pedido = sessionStorage.getItem("pedido" + tipoPlato);
        pedido = JSON.parse(pedido);
        var x = 0;
        <?php
        $menu = Menu::find()->where(['restaurante_id' => 36, 'grupo' => $grupo->id])->all();

        foreach ($menu as $key => $dato) { ?>
          if (pedido[x].cantidad > 0) {
            var tr = 
            '<tr>'+
            '<td>' + j + '</td>'+
            '<td style=" display:none; ">' + pedido[x].id + '</td>'+
            '<td>' + pedido[x].cantidad + '</td>'+
            '<td>' + formatterDolar2.format(pedido[x].totalU) + '</td>'+
            '<td>' + pedido[x].totalU + '</td>'+
            '</tr>';
            $("#cuerpo").append(tr);
            total+=Number(pedido[x].totalU);
            console.log("Total unitario: " + total);
            j++;
          }
          x++;
        <?php } ?>

        //calculoTotal();
      }
      <?php  if($contador == count($grupos)-1) { ?>
        document.getElementById("totalFactura").innerHTML = total;
        console.log("Total Factura: " + total);
      <?php }?>
      console.log("<?= $contador?> Total Factura: " + total);

    <?php } ?>

    function reload(){
      
     // $('#factura-total').load("_factura.php");
      location.reload();
    }

  </script>
  <style>
    .factura {
      table-layout: fixed;
    }

    .fact-info>div>h5 {
      font-weight: bold;
    }

    .factura>thead {
      border-top: solid 3px #000;
      border-bottom: 3px solid #000;
    }

    .factura>thead>tr>th:nth-child(2),
    .factura>tbod>tr>td:nth-child(2) {
      width: 300px;
    }

    .factura>thead>tr>th:nth-child(n+3) {
      text-align: right;
    }

    .factura>tbody>tr>td:nth-child(n+3) {
      text-align: right;
    }

    .factura>tfoot>tr>th,
    .factura>tfoot>tr>th:nth-child(n+3) {
      font-size: 24px;
      text-align: right;
    }

    .cond {
      border-top: solid 2px #000;
    }
  </style>

</body>

</html>
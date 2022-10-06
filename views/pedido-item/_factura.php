<?php

use app\models\Grupo;
use app\models\Menu;
use PhpParser\Node\Stmt\Label;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var app\models\Factura $menuFinal */

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

  <div class="main">
    <div class="container mt-3">
      <div class="card animate__animated animate__fadeIn">
        <div class="card-header">
          Fecha:
          <strong><?= date('Y-m-d H:i'); ?></strong>
        </div>
        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-auto">
              <h4 class="mb-2"><strong><?= $usuario->nombre; ?></strong></h4>

              <div>Direccion: <?= $usuario->direccion; ?></div>
              <div>Correo Electronico: <?= $usuario->email; ?></div>
              <div>Telefono: <?= $usuario->telefono; ?></div>
            </div>
          </div>
          <div class="table">
            <table class="table table-sm table-striped">
              <thead>
                <tr>
                  <th scope="col-auto" width="5%" class="center">#</th>
                  <th style=" display:none; ">id.</th>
                  <th scope="col-auto" class="d-none d-sm-table-cell" width="50%">Descripción</th>
                  <th scope="col-auto" width="5%" class="text-right">Cant.</th>
                  <th scope="col-auto" width="40%" class="text-right">Total</th>
                </tr>
              </thead>
              <tbody id="cuerpo">
              </tbody>
            </table>
          </div>
          <div class="row">
            <div class="col-lg-4 col-sm-5">
            </div>

            <div class="col-lg-4 col-sm-5 ml-auto">
              <table class="table table-sm table-clear">
                <tbody>
                  <tr>
                    <th></th>
                    <th style=" display:none; "></th>
                    <td class="left">
                      <strong>Total Factura</strong>
                    </td>
                    <td id="totalFactura" class="text-right bg-light">
                      <strong>$0.00</strong>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div>
              <div class="cliente-form">
                <?php if (isset($menuFinal)) { ?>

                  <?php $form = ActiveForm::begin([
                    'fieldConfig' => [
                      'errorOptions' => [
                        'encode' => false,
                        'class' => 'help-block',
                        'style' => 'color:red;',
                      ],
                    ],
                  ]); ?>

                  <?= $form->field($menuFinal, 'menu_id')->hiddenInput(['id' => 'menu_id'])->label(false) ?>

                  <?= $form->field($menuFinal, 'cantidad')->hiddenInput(['id' => 'cantidad'])->label(false) ?>

                  <?= $form->field($menuFinal, 'valor')->hiddenInput(['maxlength' => true, 'id' => 'valor'])->label(false) ?>

                  <div class="form-group">
                    <p></p>
                    <?= Html::submitButton('Pedir', ['class' => 'btn btn-success', 'style' => "float: right;", 'onclick' => 'borrarFactura();']) ?>
         
                  </div>

                  <?php ActiveForm::end(); ?>
                <?php } ?>

              </div>
              <?= Html::a('Menú', ['pedido-item/menu'], ["class" => "btn btn-success", 'role' => "button", 'style' => "float: left;"]) ?>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

  <script type="text/javascript">
    var tipos = [];

    const formatterDolar2 = new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD'
    }) //formato moneda Dolar

    var contador = 0;
    var tipoPlato = "Bebidas";
    var j = 0;

    $("#cuerpo").html("");

    var total = 0;

    var menu_id = "";
    var cantidad = "";
    var valor = "";
    <?php foreach ($grupos as $contador => $grupo) { ?>

      var tipoPlato = '<?= $grupo->nombre ?>';
      tipoPlato = tipoPlato.split(" ", 1);
      if (sessionStorage.getItem("pedido" + tipoPlato)) { //si existen datos del menu almacenados los carga en en formulario
        tipos.push(tipoPlato);
        var pedido = sessionStorage.getItem("pedido" + tipoPlato);
        pedido = JSON.parse(pedido);
        var x = 0;
        <?php
        $menu = Menu::find()->where(['restaurante_id' => 36, 'grupo' => $grupo->id])->all();

        foreach ($menu as $key => $dato) { ?>
          if (pedido[x].cantidad > 0) {
            menu_id += pedido[x].id + "-";
            cantidad += pedido[x].cantidad + "-";
            valor += pedido[x].totalU + "-";
            var tr =
              '<tr>' +
              '<td>' + j + '</td>' +
              '<td>' + pedido[x].descripcion + '</td>' +
              '<td style=" display:none; ">' + pedido[x].id + '</td>' +
              '<td>' + pedido[x].cantidad + '</td>' +
              '<td>' + formatterDolar2.format(pedido[x].totalU) + '</td>' +
              '<td style=" display:none; ">' + pedido[x].totalU + '</td>' +
              '</tr>';
            $("#cuerpo").append(tr);
            total += Number(pedido[x].totalU);
            console.log("Total unitario: " + total);
            j++;
          }
          x++;
        <?php } ?>

        //calculoTotal();
      }
      <?php if ($contador == count($grupos) - 1) { ?>
        <?php if (isset($menuFinal)) { ?>

          document.getElementById("menu_id").value = menu_id;
          document.getElementById("cantidad").value = cantidad;
          document.getElementById("valor").value = valor;
        <?php } ?>

        document.getElementById("totalFactura").innerHTML = formatterDolar2.format(total);
        console.log("Total Factura: " + total);
      <?php } ?>
      console.log("<?= $contador ?> Total Factura: " + total);

    <?php } ?>

    function borrarFactura() { 
    tipos.forEach(function(elemento, indice, array) {
    sessionStorage.removeItem("pedido" + elemento);
    })
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

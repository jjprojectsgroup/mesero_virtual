<?php

use app\models\Menu;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Menu $model */
/** @var yii\widgets\ActiveForm $form */
$grupo = ['Bebidas' => 'Bebidas', 'Entradas' => 'Entradas',  'Platos fuertes' => 'Platos fuertes', 'Postres' => 'Postres'];
$tipoPlato = Yii::$app->cache->get('tipoPlato');
$this->title = 'Menu '.$tipoPlato;

$mesaId = Yii::$app->cache->get('mesaId');


// $data está disponible aquí

?>

<form action="form.php" method="post" id="form">
  <div class="menu-form" ALIGN="center">
  <br/>
    <h1><?= Html::encode($this->title) ?></h1>
    <p></p>

    <div ALIGN="center" class="container">
    <div class="row justify-content-center">
    <div class=" col-auto">
    <table id="tablaMenu" class="table align-middle">
        <TR>
          <th style=" width:25%;" > Producto</th>
          <th style=" width:25%;"> Cantidad</th>
          <th style=" width:25%;"> Precio</th>
          <th  style=" width:25%;"> Total</th>
        </TR>
        <?php foreach ($model as $key => $dato) { ?>
          <TR>
            <td style=" width:25%;"><?php echo Html::encode($dato->nombre) ?></td>
            <td style=" width:25%;"><?php echo Html::input('NUMBER', null, 0, ['id' => 'cantidad' . $key, 'style' => 'width:80%', 'onblur' => 'calculoUnitario(' . $key . ')', 'min' => 0, 'onkeypress' => 'return validarClic(event)']); echo Html::label($dato->id,null,['id'=>'id' . $key, 'style'=>'display:none'])?></td>
            <td style=" width:25%;"><?= Html::label($dato->precio, null, ['id' => 'precioU' . $key]) ?></td>
            <td  style=" width:25%;"><?= Html::label('$0.00', null, ['id' => 'totalU' . $key]) ?><?= Html::label('0', null, ['id' => 'totalUAux' . $key, 'style' => 'display:none;']) ?></td>
          </TR>
        <?php } ?>

      </table>
</div>
</div>
    </div>

      
      <div>
        <p></p>
        <?= Html::a('Menú', ['pedido-item/menu'], ["class" => "btn btn-primary menuA", 'role'=>"button"]) ?>
        <?= Html::button('Guardar', ["class" => "btn btn-secondary menuA", 'role'=>"button", 'onclick'=>"guardarDatos()" ]) ?>
        <?= Html::button('Borrar', ["class" => "btn btn-danger menuA", 'role'=>"button", 'onclick'=>"borrarDatos()" ]) ?>
        <?= Html::a('Ordenar', ['pedido-item/generar-pedido'], ["class" => "btn btn-success menuA", 'role'=>"button"]) ?>
      </div>
   
  </div>
</form>
<script type="text/javascript">
  const tipoPlatoOrigen = "<?= $tipoPlato?>";
  var tipoPlatoSplit = tipoPlatoOrigen.split(" ", 1);
  var tipoPlato=tipoPlatoSplit[0];
  const formatterDolar = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD'
  }) //formato moneda Dolar

  const formatterPeso = new Intl.NumberFormat('es-CO', {
    style: 'currency',
    currency: 'COP',
    minimumFractionDigits: 0
  }) //formato moneda Peso

  function calculoUnitario(id) { //calcula el valor unitario de un producto
    var cantidad = document.getElementById("cantidad" + id).value;
    var precio = document.getElementById("precioU" + id).innerHTML;
    document.getElementById("totalU" + id).innerHTML = formatterDolar.format(cantidad * precio);
    document.getElementById("totalUAux" + id).innerHTML = cantidad * precio;
    calculoTotal();
  }

  function calculoTotal() { //calcula el valor total referrente a el menu
    var rowCount = $("#tablaMenu tr").length;
    var total = 0;
    for (var i = 0; i < rowCount-2; i++) {
      total += Number(document.getElementById("totalUAux" + i).innerHTML);
    }
    document.getElementById("totalMenu").innerHTML = formatterDolar.format(total);
  }

  function validarClic(e) { //impide la entrada por teclado en un input
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true; //Tecla de retroceso (para poder borrar)
    if (tecla==44) return true; //Coma ( En este caso para diferenciar los decimales )
    if (tecla==48) return true;
    if (tecla==49) return true;
    if (tecla==50) return true;
    if (tecla==51) return true;
    if (tecla==52) return true;
    if (tecla==53) return true;
    if (tecla==54) return true;
    if (tecla==55) return true;
    if (tecla==56) return true;
    if (tecla==57) return true;
    patron = /1/; //ver nota
    te = String.fromCharCode(tecla);
    return patron.test(te);
  }

  function guardarDatos(){ //guarda datos del menu en la sesion actual
    console.log("Guardar Datos");
    var i=0;
    var pedido1= [];
    <?php foreach ($model as $key => $dato) { ?>
     pedido1.push ({
        'id': document.getElementById("id"+i).innerHTML,
        'cantidad': document.getElementById("cantidad"+i).value,
        'totalU': document.getElementById("totalUAux"+i).innerHTML,
      });
      i++;
    <?php } ?>
    console.log("pedido : ",pedido1[0].id);
    sessionStorage.setItem("pedido"+tipoPlato, JSON.stringify(pedido1));
    sessionStorage.setItem("total"+tipoPlato, document.getElementById("totalMenu").innerHTML);

  }

  function borrarDatos(){ //borra datos del menu de la sesion actual
    console.log(tipoPlato);
    sessionStorage.removeItem("pedido"+tipoPlato);
    sessionStorage.removeItem("total"+tipoPlato);
    var x=0;
    <?php foreach ($model as $key => $dato) { ?>
      document.getElementById("cantidad"+x).value= 0;
      document.getElementById("totalU"+x).innerHTML= formatterDolar.format(0);
      document.getElementById("totalUAux"+x).innerHTML= 0;
      x++;
    <?php } ?>
    document.getElementById("totalMenu").innerHTML =formatterDolar.format(0);
  }

  if(sessionStorage.getItem("pedido"+tipoPlato)){  //si existen datos del menu almacenados los carga en en formulario
    var pedido = sessionStorage.getItem("pedido"+tipoPlato);
    pedido =JSON.parse(pedido);
    var x=0;
    <?php foreach ($model as $key => $dato) { ?>
      document.getElementById("id"+x).innerHTML = pedido[x].id;
      document.getElementById("cantidad"+x).value= pedido[x].cantidad;
      document.getElementById("totalU"+x).innerHTML= formatterDolar.format(pedido[x].totalU);
      document.getElementById("totalUAux"+x).innerHTML= pedido[x].totalU;
      x++;
    <?php } ?>
    document.getElementById("totalMenu").innerHTML = sessionStorage.getItem("total"+tipoPlato);

    //calculoTotal();
  }

</script>

<?php

use app\models\Menu;
use app\models\PedidoItem;
use app\models\Restaurante;
use app\models\SubGrupo;
use PhpParser\Node\Stmt\Label;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Menu $menu */
/** @var yii\widgets\ActiveForm $form */
/** @var app\models\PedidoItem $pedidoItem */

$tipoPlato = Yii::$app->cache->get('tipoPlato');
$this->title = 'Menu ' . $tipoPlato;

$mesaId = Yii::$app->cache->get('mesaId');

$nombreSubGrupo = SubGrupo::find()->where(['restaurante_id' => Yii::$app->cache->get('restauranteId')])->all();
$menuSubGupo = array();
foreach ($menu as $k => $item) {
  $subGrupo = $item->sub_grupo;
  unset($item->sub_grupo);
  $menuSubGupo[$subGrupo][] = $item;
}
$nombre = "otros";
$contadorItem = 0;
?>
<div class="pedido-item-create_pedido">
  <br>
  <h1 ALIGN="center"><?= Html::encode($this->title) ?></h1>
  <br>
  <div class="menu-form" ALIGN="center">
    <div ALIGN="center" class="container">
      <div class="row justify-content-center">
        <div class="col-auto">
          <table id="tablaMenu" class="table align-middle">
            <TR>
              <th style=" width:25%;"> Producto</th>
              <th style=" width:25%;"> Cantidad</th>
              <th style=" display:none; "> id</th>
              <th style=" width:25%;"> Precio</th>
              <th style=" width:25%;"> Total</th>
            </TR>
            <?php foreach ($menuSubGupo as $k => $items) { ?>

              <TR>
                <?php foreach ($nombreSubGrupo as $key => $item) {
                  if ($item->id == $k) {
                    $nombre = $item->nombre;
                    break;
                  } elseif ($key == count($nombreSubGrupo) - 1) {
                    $nombre = "otros";
                  }
                } ?>
                <th COLSPAN="4" style="text-align: center;">
                  <h3><?= Html::label(ucfirst($nombre)) ?></h3>
                </th>
              </TR>
              <?php foreach ($items as $key => $item) { ?>
              <?php if ($item->stock=='Agotado' || $item->estado=='Inactivo') {continue;} ?>

                <?php $form = ActiveForm::begin(); ?>
                <TR>
                  <td style=" width:25%;"><?= Html::label(ucfirst($item->nombre), null, ['id' => 'descripcion' . $contadorItem]) ?></td>
                  <td style=" width:25%;"><?= $form->field($pedidoItem, 'cantidad')->textInput(['type' => 'number', 'value' => 0, 'id' => 'cantidad' . $contadorItem, 'style' => 'width:80%', 'onblur' => 'calculoUnitario(' . $contadorItem . ');', 'min' => 0, 'oncontadorItempress' => 'return validarClic(event)'])->label(false) ?> </td>
                  <td style=" display:none;"><?= $form->field($pedidoItem, 'menu_id')->textInput(['value' => $item->id, 'id' => 'menu_id' . $contadorItem])->Label(false) ?> </td>
                  <td style=" width:25%;"><?= Html::label($item->precio, null, ['id' => 'precioU' . $contadorItem]) ?></td>
                  <td style=" width:25%;"><?= $form->field($pedidoItem, 'valor')->textInput(['value' => '0', 'id' => 'totalUAux' . $contadorItem, 'style' => 'display:none;'])->Label(false) ?><?= Html::label('$0.00', null, ['id' => 'totalU' . $contadorItem]) ?></td>
                </TR>
        </div>
        <?php ActiveForm::end();
                $contadorItem++; ?>
      <?php } ?>
    <?php  } ?>
    </table>
      </div>
    </div>
  </div>
  <div>
    <p></p>
    <?= Html::a('Menú', ['pedido-item/menu'], ["class" => "btn btn-primary menuA", 'role' => "button"]) ?>
    <?= Html::a('Pedir', ['pedido-item/facturar'], ["class" => "btn btn-success", 'role' => "button", 'onclick' => "guardarDatos()"]) ?>
    <?= Html::a('Eliminar Pedido', ['pedido-item/menu'], ["class" => "btn btn-danger menuA", 'role' => "button", 'onclick' => "borrarDatos()"]) ?>
    <?= Html::a('Facturar', ['pedido-item/facturar'], ["class" => "btn btn-primary menuA", 'role' => "button"]) ?>

  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <p></p>
  <br /><br /><br />
</div>

<script type="text/javascript">
  const tipoPlatoOrigen = "<?= $tipoPlato ?>";
  var tipoPlatoSplit = tipoPlatoOrigen.split(" ", 1);
  var tipoPlato = tipoPlatoSplit[0];
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
    document.getElementById("totalUAux" + id).value = cantidad * precio;
    // calculoTotal();
  }


  function validarClic(e) { //impide la entrada por teclado en un input
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8) return true; //Tecla de retroceso (para poder borrar)
    //if (tecla == 44) return true; //Coma ( En este caso para diferenciar los decimales )
    if (tecla == 48) return true;
    if (tecla == 49) return true;
    if (tecla == 50) return true;
    if (tecla == 51) return true;
    if (tecla == 52) return true;
    if (tecla == 53) return true;
    if (tecla == 54) return true;
    if (tecla == 55) return true;
    if (tecla == 56) return true;
    if (tecla == 57) return true;
    patron = /1/; //ver nota
    te = String.fromCharCode(tecla);
    return patron.test(te);
  }

  var contador = 0;

  function guardarDatos() { //guarda datos del menu en la sesion actual
    var i = 0;
    var pedido1 = [];
    // var precioPedido=0;
    <?php foreach ($menu as $key => $dato) { ?>
      console.log(i);
      pedido1.push({
        'id': document.getElementById("menu_id" + i).value,
        'descripcion': document.getElementById("descripcion" + i).innerHTML,
        'cantidad': document.getElementById("cantidad" + i).value,
        'totalU': document.getElementById("totalUAux" + i).value,
      });
      //  precioPedido+= Number(document.getElementById("totalUAux"+ i).value);
      i++;
    <?php } ?>
    sessionStorage.setItem("pedido" + tipoPlato, JSON.stringify(pedido1));
    /* var valorActual=sessionStorage.getItem("totalPedido");
     sessionStorage.setItem("totalPedido", valorActual!=null?valorActual:0 + precioPedido);
     console.log("totalPedido: " + valorActual);*/

    // reload();
  }

  function borrarDatos() { //borra datos del menu de la sesion actual
    sessionStorage.removeItem("pedido" + tipoPlato);
    var x = 0;
    <?php foreach ($menu as $key => $dato) { ?>
      document.getElementById("cantidad" + x).value = 0;
      document.getElementById("totalU" + x).innerHTML = formatterDolar.format(0);
      document.getElementById("totalUAux" + x).value = 0;
      x++;
    <?php } ?>
  }

  if (sessionStorage.getItem("pedido" + tipoPlato)) { //si existen datos del menu almacenados los carga en en formulario
    var pedido = sessionStorage.getItem("pedido" + tipoPlato);
    pedido = JSON.parse(pedido);
    var x = 0;
    <?php foreach ($menu as $key => $dato) { ?>
      document.getElementById("menu_id" + x).value = pedido[x].id;
      document.getElementById("cantidad" + x).value = pedido[x].cantidad;
      document.getElementById("totalU" + x).innerHTML = formatterDolar.format(pedido[x].totalU);
      document.getElementById("totalUAux" + x).value = pedido[x].totalU;
      x++;
    <?php } ?>

    //calculoTotal();
  }
</script>
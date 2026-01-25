<?php
use Tools\Hash;
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="description" content="Gestióndelcarritodecompras">
<title>CarritodeCompra-FoodHub</title>
<link rel="shortcut icon" href="<?=BASE_URL?>favicon.ico" type="image/x-icon">
<style>
*{
margin: 0;
padding: 0;
box-sizing: border-box;
}

body{
font-family: 'Courier New',monospace;
background:#0a0e27;
min-height: 100vh;
padding: 40px 20px;
}

body:: before{
content:'';
position: fixed;
width: 100%;
height: 100%;
background: radial-gradient(circle at 50% 50%,rgba(255,107,53,0.1)1px,transparent1px);
background-size: 40px 40px;
pointer-events: none;
}

.container{
max-width: 1400px;
margin: 0 auto;
background: rgba(18,24,48,0.95);
border-radius: 20px;
padding: 40px;
box-shadow: 0 50px rgba(255,107,53,0.3);
border: 2px solidrgba(255,107,53,0.2);
position: relative;
}

h1{
color:#ff6b35;
margin-bottom: 20px;
text-align: center;
font-size: 2.8em;
text-transform: uppercase;
letter-spacing: 4px;
text-shadow: 0 30px rgba(255,107,53,0.5);
}

.subtitle{
text-align: center;
color:#f7931e;
margin-bottom: 40px;
font-size: 1em;
letter-spacing: 2px;
}

.cart-table{
width: 100%;
border-collapse: separate;
border-spacing: 020px;
margin-bottom: 30px;
}

.cart-table thead th{
background: rgba(255,107,53,0.2);
color:#ff6b35;
padding: 20px15px;
text-align: left;
font-weight: 600;
text-transform: uppercase;
font-size: 0.85em;
letter-spacing: 2px;
border: 1pxsolidrgba(255,107,53,0.3);
}

.cart-table thead th: first-child{
border-radius: 10px0010px;
}

.cart-table thead th: last-child{
border-radius: 010px10px0;
}

.cart-table tbody tr{
background: rgba(10,14,39,0.7);
border: 2px solidrgba(255,107,53,0.2);
transition: all0.3s;
}

.cart-table tbody tr: hover{
transform: translateX(5px);
border-color:#ff6b35;
box-shadow: 05px30px rgba(255,107,53,0.3);
}

.cart-table tbody td{
padding: 25px15px;
border: none;
color:#aaa;
}

.cart-table tbody trtd: first-child{
border-radius: 10px0010px;
}

.cart-table tbody trtd: last-child{
border-radius: 010px10px0;
}

.product-name{
font-size: 1.2em;
color:#ff6b35;
font-weight: 700;
text-transform: uppercase;
letter-spacing: 1px;
}

.product-description{
color:#888;
font-size: 0.9em;
}

.product-weight{
color:#f7931e;
font-weight: 600;
}

.product-units{
background: linear-gradient(135deg,#ff6b350%,#f7931e100%);
color: white;
padding: 10px20px;
border-radius: 25px;
display: inline-block;
font-weight: 700;
box-shadow: 05px15px rgba(255,107,53,0.3);
}

.delete-form{
display: flex;
align-items: center;
gap: 15px;
}

.delete-form input[type="number"]{
width: 80px;
padding: 12px;
border: 2px solidrgba(255,107,53,0.3);
border-radius: 10px;
font-size: 14px;
text-align: center;
background: rgba(10,14,39,0.5);
color:#fff;
font-family: 'Courier New',monospace;
transition: all0.3s;
}

.delete-form input[type="number"]: focus{
outline: none;
border-color:#ff6b35;
box-shadow: 0015px rgba(255,107,53,0.4);
}

.delete-form button{
background: linear-gradient(135deg,#e74c3c0%,#c0392b100%);
color: white;
border: none;
padding: 12px25px;
border-radius: 10px;
cursor: pointer;
font-weight: 600;
transition: all0.3s;
text-transform: uppercase;
letter-spacing: 1px;
box-shadow: 05px15px rgba(231,76,60,0.3);
}

.delete-form button: hover{
transform: translateY(-2px);
box-shadow: 08px25px rgba(231,76,60,0.5);
}

.error-row{
background: rgba(231,76,60,0.2)!important;
border-color:#e74c3c!important;
}

.error-message{
color:#ff6b6b;
font-weight: 600;
text-align: center;
letter-spacing: 1px;
}

.actions{
display: flex;
justify-content: center;
margin-top: 40px;
}

.checkout-btn{
background: linear-gradient(135deg,#27ae600%,#2ecc71100%);
color: white;
text-decoration: none;
padding: 20px60px;
border-radius: 50px;
font-weight: 700;
font-size: 1.2em;
transition: all0.3s;
display: inline-block;
box-shadow: 08px30px rgba(46,204,113,0.4);
text-transform: uppercase;
letter-spacing: 3px;
}

.checkout-btn: hover{
transform: translateY(-3px)scale(1.05);
box-shadow: 012px40px rgba(46,204,113,0.6);
}

.empty-cart{
text-align: center;
padding: 100px20px;
color:#f7931e;
font-size: 1.5em;
letter-spacing: 2px;
}

@media(max-width: 768px){
.container{
padding: 20px;
}

h1{
font-size: 2em;
}

.cart-table{
font-size: 0.9em;
}

.cart-table thead{
display: none;
}

.cart-table tbody tr{
display: block;
margin-bottom: 20px;
border-radius: 10px;
}

.cart-table tbody td{
display: block;
text-align: right;
padding: 15px;
border-radius: 0!important;
}

.cart-table tbody td: before{
content: attr(data-label);
float: left;
font-weight: 600;
color:#ff6b35;
}
}
</style>
</head>
<body>

<div class="container">
<h1>Carrito de Compra</h1>
<div class="subtitle">Contenido de tu carrito</div>

<?php if(!empty($articulos)): ?>
<table class="cart-table">
<thead>
<tr>
<th>Producto</th>
<th>Descripción</th>
<th>Peso</th>
<th>Cantidad</th>
<th>Acciones</th>
</tr>
</thead>
<tbody>
<?php
$modelo = new \App\Models\Producto();

foreach($articulos as $item):
$producto=$modelo->buscarPorId($item->obtenerCodigoProd());

if($producto):?>
<tr>
<td data-label="Producto" class="product-name">
<?=htmlspecialchars($producto->obtenerTitulo())?>
</td>
<td data-label="Descripción" class="product-description">
<?=htmlspecialchars($producto->obtenerDetalles())?>
</td>
<td data-label="Peso" class="product-weight">
<?=$producto->obtenerMasa()?>kg
</td>
<td data-label="Cantidad">
<span class="product-units"><?=$item->obtenerUnidades()?>UDS</span>
</td>
<td data-label="Eliminar">
<form class="delete-form"
action=""
method="POST"
onsubmit="this.action='<?=BASE_URL?>productos/removeFromCart/<?php echo Hash::encode($item->obtenerCodigoProd());?>/'+this.unidades.value;return true;">

<input type="number"
name="unidades"
value="1"
min="1"
max="<?=$item->obtenerUnidades()?>"
title="Cantidad a eliminar">

<button type="submit">Quitar</button>
</form>
</td>
</tr>
<?php else: ?>
<tr class="error-row">
<td colspan="5" class="error-message">
Producto ID <?=htmlspecialchars($item->obtenerCodigoProd())?> no encontrado en inventario
</td>
</tr>
<?php endif;
endforeach; ?>
</tbody>
</table>

<div class="actions">
<a href="<?php echo BASE_URL; ?>pedidos/procesarCompra" class="checkout-btn">
Realizar Pedido
</a>
</div>
<?php else: ?>
<div class="empty-cart">
<p>Tu carrito está vacío</p>
</div>
<?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
</body>
</html>











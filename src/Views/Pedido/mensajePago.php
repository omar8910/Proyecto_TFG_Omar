<!-- Plantilla bonita para mostrar mensajes de pago -->
<style>
    .mensaje-pago-container {
        max-width: 500px;
        margin: 60px auto;
        padding: 30px 30px 20px 30px;
        background-color: #333;
        color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.18);
        text-align: center;
    }
    .mensaje-pago-container h2 {
        color: #ff9900;
        margin-bottom: 18px;
        font-size: 2em;
    }
    .mensaje-pago-container p {
        color: #ccc;
        font-size: 1.2em;
        margin-bottom: 25px;
    }
    .mensaje-pago-container a {
        display: inline-block;
        background: #28a745;
        color: #fff;
        padding: 12px 28px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        font-size: 1.1em;
        transition: background 0.2s;
        margin-top: 10px;
    }
    .mensaje-pago-container a:hover {
        background: #218838;
    }
    .mensaje-pago-container .icono {
        font-size: 3em;
        margin-bottom: 10px;
        color: #28a745;
    }
</style>

<div class="mensaje-pago-container">
    <div class="icono">&#x1F389;</div>
    <h2>¡Pago realizado con éxito!</h2>
    <p>Tu pedido ha sido registrado correctamente.<br>En breve recibirás un email con los detalles.</p>
    <a href="<?= BASE_URL ?>Pedido/misPedidos">Ver mis pedidos</a>
</div>

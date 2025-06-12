<!-- Plantilla bonita para mostrar mensaje de error/cancelación de pago -->
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
        color: #ff4c4c;
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
        background: #007bff;
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
        background: #0056b3;
    }
    .mensaje-pago-container .icono {
        font-size: 3em;
        margin-bottom: 10px;
        color: #ff4c4c;
    }
</style>

<div class="mensaje-pago-container">
    <div class="icono">&#x26A0;&#xFE0F;</div>
    <h2>Pago cancelado o error</h2>
    <p>El pago no se ha completado.<br>Puedes volver a intentarlo o revisar tu carrito.</p>
    <a href="<?= BASE_URL ?>Carrito/verCarrito">Volver al carrito</a>
</div>

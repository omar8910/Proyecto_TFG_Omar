<?php
namespace Controllers;
// Controlador para gestionar el pago con Stripe Checkout
// Este controlador crea una sesión de pago con Stripe y redirige al usuario a la página segura de Stripe.

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Services\PedidoServices;
use Repositories\PedidoRepository;
use Lib\Pages;

class StripeController {
    private $pedidoService;
    private $pages;

    public function __construct() {
        require_once __DIR__ . '/../../vendor/autoload.php';
        // Cargar variables de entorno (.env) para Stripe
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        $this->pedidoService = new PedidoServices(new PedidoRepository());
        $this->pages = new Pages();
    }

    // Crea la sesión de Stripe Checkout y redirige al usuario
    public function createSession() {
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
        if (!isset($_SESSION['carrito'])) {
            $this->pages->render('Pedido/mensajePagoError');
            return;
        }
        $carrito = $_SESSION['carrito'];
        $coste = $this->pedidoService->calcularTotal($carrito);
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Pedido en Tienda Omar',
                    ],
                    'unit_amount' => intval($coste * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => BASE_URL . 'Stripe/success',
            'cancel_url' => BASE_URL . 'Stripe/cancel',
        ]);
        header('Location: ' . $session->url);
        exit();
    }

    public function success() {
        if (!isset($_SESSION['inicioSesion']) || !isset($_SESSION['carrito']) || !isset($_SESSION['datos_envio'])) {
            $this->pages->render('Pedido/mensajePagoError');
            return;
        }
        $usuario = $_SESSION['inicioSesion'];
        $carrito = $_SESSION['carrito'];
        $datos_envio = $_SESSION['datos_envio'];
        $estado = "Pendiente a confirmar";
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $coste = $this->pedidoService->calcularTotal($carrito);
        $this->pedidoService->create($usuario->id, $datos_envio['provincia'], $datos_envio['localidad'], $datos_envio['direccion'], $coste, $estado, $fecha, $hora, $carrito);
        unset($_SESSION['carrito']);
        unset($_SESSION['datos_envio']);
        $this->pages->render('Pedido/mensajePago');
    }

    public function cancel() {
        $this->pages->render('Pedido/mensajePagoError');
    }
}

<?php

namespace Controllers;

use Services\PedidoServices;
use Services\ProductoServices;
use Repositories\PedidoRepository;
use Repositories\ProductoRepository;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

use Utils\Utils;
use Lib\Pages;

use Exception;



class PedidoController
{
    private Pages $pages;
    private PedidoServices $pedidoService;
    private ProductoServices $productoServices;
    private $mensajesError = [];

    public function __construct()
    {
        $this->pages = new Pages();
        $this->pedidoService = new PedidoServices(new PedidoRepository());
        $this->productoServices = new ProductoServices(new ProductoRepository());
    }

    // Método para ver el pedido
    public function verPedido() // mostrarPedido()
    {
        try {
            if (!isset($_SESSION['inicioSesion'])) {
                throw new Exception('Para realizar el pedido debes iniciar sesión.');
            }

            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = [];
            }

            if (count($_SESSION['carrito']) >= 1) {
                $this->pages->render('Pedido/CrearPedido');
            } else {
                throw new Exception('No puedes realizar un pedido sin productos en el carrito.');
            }
        } catch (Exception $e) {
            $this->mensajesError[] = $e->getMessage();
            if (!isset($_SESSION['inicioSesion'])) {
                $this->pages->render('Usuario/iniciarSesion', ['mensajesError' => $this->mensajesError]);
            } else {
                $this->pages->render('Carrito/verCarrito', ['mensajesError' => $this->mensajesError]);
            }
        }
    }

    // Método para ver todos los pedidos
    public function verTodosLosPedidos() // todosLosPedidos()
    {
        try {
            if (!isset($_SESSION['inicioSesion'])) {
                throw new Exception('Para ver todos los pedidos debes iniciar sesión como administrador.');
            } else {
                $usuario = $_SESSION['inicioSesion'];
                if ($usuario->rol === "administrador") {
                    $pedidos = $this->pedidoService->obtenerTodosPedidos();
                    $this->pages->render('Administrador/gestionarPedidos', ['pedidos' => $pedidos]);
                } else {
                    throw new Exception('No tienes permisos para ver los pedidos.');
                }
            }
        } catch (Exception $e) {
            $this->mensajesError[] = $e->getMessage();
            if (!isset($_SESSION['inicioSesion'])) {
                $this->pages->render('Usuario/iniciarSesion', ['mensajesError' => $this->mensajesError]);
            }

            if ($_SESSION['rol'] === 'usuario') {
                $this->pages->render('Carrito/verCarrito', ['mensajesError' => $this->mensajesError]);
            }
        }
    }

    // Método para ver los pedidos de un usuario en concreto.
    public function misPedidos() // misPedidos()
    {
        try {
            if (!isset($_SESSION['inicioSesion'])) {
                throw new Exception('Para ver tus pedidos debes iniciar sesión.');
            } else {
                $usuario = $_SESSION['inicioSesion'];
                $pedidos = $this->pedidoService->getByUsuario($usuario->id);
                $this->pages->render('Pedido/misPedidos', ['pedidos' => $pedidos]);
            }
        } catch (Exception $e) {
            $this->mensajesError[] = $e->getMessage();
            if (!isset($_SESSION['inicioSesion'])) {
                $this->pages->render('Usuario/iniciarSesion', ['mensajesError' => $this->mensajesError]);
            }
        }
    }

    // Método para validar el formulario de crear pedido
    public function ValidarFormularioPedido($provincia, $localidad, $direccion) // validarPedido()
    {
        $errores = [];

        try {
            if (empty($provincia) || strlen($provincia) < 4) {
                throw new Exception('La provincia no es válida, debe tener al menos 5 caracteres.');
            }

            if (empty($localidad) || strlen($localidad) < 4) {
                throw new Exception('La localidad no es válida, debe tener al menos 5 caracteres.');
            }

            if (empty($direccion) || strlen($direccion) < 4) {
                throw new Exception('La dirección no es válida, debe tener al menos 5 caracteres.');
            }
        } catch (Exception $e) {
            $errores[] = $e->getMessage();
        }

        return $errores;
    }

    // Método para crear un pedido

    public function crear() //crear()
    {
        try {
            if (!isset($_SESSION['inicioSesion'])) {
                throw new Exception('Para realizar un pedido debes iniciar sesión.');
            } elseif (!isset($_SESSION['carrito']) || count($_SESSION['carrito']) < 1) {
                throw new Exception('No puedes realizar un pedido sin productos en el carrito.');
            } else {
                $provincia = isset($_POST['provincia']) ? $_POST['provincia'] : false;
                $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : false;
                $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;
                $estado = "Pendiente a confirmar";
                $fecha = date('Y-m-d');
                $hora = date('H:i:s');

                $errores = $this->ValidarFormularioPedido($provincia, $localidad, $direccion);

                if (!empty($errores)) {
                    foreach ($errores as $error) {
                        $this->mensajesError[] = $error;
                    }
                    throw new Exception('Errores de validación en el formulario.');
                } else {
                    $usuario = $_SESSION['inicioSesion'];
                    $carrito = $_SESSION['carrito'];
                    $coste = $this->pedidoService->calcularTotal($carrito);
                    $resultado = $this->pedidoService->create($usuario->id, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora, $carrito);
                    if ($resultado != true) {
                        $this->mensajesError = $resultado;
                        $this->pages->render('Pedido/CrearPedido', ['mensajesError' => [$this->mensajesError[0]]]);
                    }
                    unset($_SESSION['carrito']);
                    header('Location:' . BASE_URL . 'Pedido/misPedidos');
                    exit();
                }
            }
        } catch (Exception $e) {
            $this->mensajesError[] = $e->getMessage();
            $this->pages->render('Pedido/CrearPedido', ['mensajesError' => $this->mensajesError]);
        }
    }

    // Metodo para eliminar un pedido
    public function delete($id) // eliminar($id)
    {
        $usuario = $_SESSION['inicioSesion'];


        if ($usuario->rol === 'administrador') {
            $this->pedidoService->delete($id);
            header('Location:' . BASE_URL . 'Administrador/gestionarPedidos');
        } else {
            $this->mensajesError[] = 'No tienes permisos para eliminar pedidos.';
            $this->pages->render('Pedido/misPedidos', ['mensajesError' => $this->mensajesError]);
        }
    }

    public function editar($id) //editar(id)
    {
        $pedidos = $this->pedidoService->obtenerTodosPedidos();
        $this->pages->render('Administrador/gestionarPedidos', ['pedidos' => $pedidos]);
    }

    public function validarPedidoActualizado($datos) // validarPedidoActualizado($data)
    {
        $errores = [];
        try {
            if (empty($datos['coste']) || !is_numeric($datos['coste'])) {
                $errores['coste'] = 'El coste es requerido y debe ser un número';
            }

            $estadosPermitidos = ['pendiente', 'confirmado'];
            if (empty($datos['estado']) || !in_array($datos['estado'], $estadosPermitidos)) {
                $errores['estado'] = 'El estado es requerido y debe ser "pendiente" o "confirmado"';
            }

            if (empty($datos['fecha']) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $datos['fecha'])) {
                $errores['fecha'] = 'La fecha es requerida y debe estar en el formato YYYY-MM-DD';
            }

            if (empty($datos['hora']) || !preg_match('/^\d{2}:\d{2}:\d{2}$/', $datos['hora'])) {
                $errores['hora'] = 'La hora es requerida y debe estar en el formato HH:MM:SS';
            }
        } catch (Exception $e) {
            $errores[] = $e->getMessage();
        }
        return $errores;
    }

    public function actualizar()
    {
        $usuario = $_SESSION['inicioSesion'];
        $pedido = $_POST["datos"];
        $id = $pedido['id'];
        $coste = $pedido['coste'];
        $estado = $pedido['estado'];
        $fecha = $pedido['fecha'];
        $hora = $pedido['hora'];
        $usuario_id = $pedido['usuario_id'];

        if ($usuario->rol === 'administrador') {
            $datos = $_POST['datos'];
            $errores = $this->validarPedidoActualizado($pedido);
            $pedidos = $this->pedidoService->obtenerTodosPedidos();

            if (!empty($errores)) {
                $this->pages->render('Administrador/gestionarPedidos', ['pedidos' => $pedidos, 'errores' => $errores]);
            } else {
                $this->pedidoService->update($id, $fecha, $hora, $coste, $estado, $usuario_id);
                $pedidos = $this->pedidoService->obtenerTodosPedidos();
                $this->pages->render('Administrador/gestionarPedidos', ['mensajes' => ['Pedido actualizado correctamente'], 'pedidos' => $pedidos]);
            }
        }
    }

    public function confirmarPedido($id)
    {
        $usuario = $_SESSION['inicioSesion'];
        if ($usuario->rol === 'administrador') {
            $this->pedidoService->updateEstado($id);
            // Renderizar la vista de pedidos   
            $this->enviarEmail($id);
            // header('Location:' . BASE_URL . 'Administrador/gestionarPedidos');
        } else {
            $this->mensajesError[] = 'No tienes permisos para confirmar pedidos.';
            $this->pages->render('Pedido/misPedidos', ['mensajesError' => $this->mensajesError]);
        }
    }

    public function enviarEmail($id)
    {
        // Import PHPMailer classes into the global namespace
        // require '../vendor/autoload.php';

        // Start output buffering
        ob_start();

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // Tell PHPMailer to use SMTP
            $mail->isSMTP();
            $mail->SMTPDebug = 0; // Change SMTP::DEBUG_SERVER to 0 to disable debugging
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->Username = 'omarqneiby@gmail.com';
            $mail->Password = 'yufqogxbcxeqyier';

            // Set who the message is to be sent from
            $mail->setFrom('omarqneiby@gmail.com', 'PC Componentes OMAR');
            // Set who the message is to be sent to
            $mail->addAddress($_SESSION['inicioSesion']->email, $_SESSION['inicioSesion']->nombre);
            $mail->Subject = '!Su pedido ha sido confirmado!';

            // Define the variables
            $nombre = $_SESSION['inicioSesion']->nombre;
            $id_pedido = $id;
            $productos = $this->pedidoService->getProductosPedido($id);
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');

            // Include the email template and store the output in a variable
            require_once __DIR__ . '/../Views/Pedido/email.php';
            $html = ob_get_contents();
            ob_end_clean();

            // Use the output as the HTML body of the email
            $mail->msgHTML($html, __DIR__);
            $mail->AltBody = 'This is a plain-text message body';

            // Attach an image file
            // $mail->addAttachment(__DIR__ . '/../images/phpmailer_mini.png');

            // Send the message
            if ($mail->send()) {
                header('Location:' . BASE_URL . 'Administrador/gestionarPedidos');
                exit; // Ensure the script stops after the header
            } else {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }
}

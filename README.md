
# 🖥️ Proyecto TFG - Franquicia PC Componentes (Omar Qneiby Al-Sarsour)

Este proyecto consiste en el desarrollo de una tienda online totalmente funcional especializada en productos informáticos, inspirada en el modelo de negocio de “PC Componentes”. El desarrollo se ha realizado como Trabajo de Fin de Grado del ciclo formativo de Desarrollo de Aplicaciones Web.

---

## 📌 Características principales

- 🛒 Catálogo de productos clasificados por categorías
- 🧾 Sistema de carrito de compra (con y sin sesión iniciada)
- 💳 Pasarela de pago con tarjeta bancaria integrada mediante **Stripe**
- 📦 Gestión completa de pedidos (usuarios y administradores)
- 🔐 Autenticación de usuarios con roles (cliente / administrador)
- 📧 Envío de correos automáticos al confirmar/cancelar pedidos
- 🌐 Arquitectura **MVC (Modelo-Vista-Controlador)** en PHP
- 🎨 Interfaz amigable y visualmente cuidada
- 🧪 Validación de formularios tanto en frontend como en backend
- 💾 Base de datos relacional en **MySQL**
- 🧩 Carga de configuraciones seguras desde `.env` (con `phpdotenv`)
- ✔️ Protección frente a inyecciones SQL (PDO)

---

## 🛠️ Tecnologías utilizadas

| Tecnología | Uso |
|------------|-----|
| **PHP** | Backend, lógica de negocio, MVC |
| **HTML5 & CSS3** | Estructura y estilos visuales |
| **MySQL** | Almacenamiento de datos |
| **Composer** | Gestión de dependencias |
| **PHPMailer** | Envío de correos electrónicos |
| **phpdotenv** | Carga de variables de entorno |
| **Stripe PHP SDK** | Integración de pagos |
| **Visual Studio Code** | Editor de desarrollo |
| **XAMPP** | Entorno local de pruebas |
| **Git & GitHub** | Control de versiones y publicación del código |

---

## 🗂️ Estructura del proyecto

```
proyecto/
│
├── public/              # Archivos públicos y punto de entrada (index.php)
├── config/              # Configuración general del proyecto
├── src/
│   ├── Controllers/     # Controladores PHP
│   ├── Models/          # Modelos para la base de datos
│   └── Lib/             # Librerías internas (BaseDatos, Router, Pages)
├── views/               # Plantillas PHP de interfaz
├── vendor/              # Librerías externas (Stripe, Dotenv, etc.)
├── .env                 # Variables de entorno (claves, credenciales)
├── composer.json        # Dependencias del proyecto
└── README.md            # Documentación del repositorio
```

---

## 🧪 Funcionalidades clave

### Usuarios
- Registro e inicio de sesión
- Edición de perfil
- Carrito persistente
- Visualización de pedidos
- Rol asignado (cliente o administrador)

### Administradores
- Gestión CRUD de productos, categorías, usuarios y pedidos
- Confirmación o cancelación de pedidos (con envío de email automático)
- Panel de administración con secciones dedicadas

### Seguridad y validación
- Hash de contraseñas (`password_hash`)
- Protección SQL mediante **consultas preparadas (PDO)**
- Filtro de acceso por roles
- Validaciones backend y cliente (HTML5)

---

## 💳 Pagos con Stripe

Se ha implementado un sistema de pago real con la pasarela **Stripe**:

- Checkout seguro
- Validación y confirmación de pago
- Sincronización automática con pedidos

> ⚠️ Las claves de Stripe están guardadas en `.env` y no se incluyen en este repositorio por seguridad.

---

## ⚙️ Instalación local (modo desarrollador)

1. Clona el repositorio:
   ```bash
   git clone https://github.com/omar8910/Proyecto_TFG_Omar.git
   ```

2. Inicia un servidor local (por ejemplo, con **XAMPP** o **Laragon**)

3. Crea una base de datos llamada `tiendaomar` e importa el archivo `.sql` disponible en el proyecto

4. Configura el archivo `.env` con tus credenciales:

   ```
   DB_HOST=localhost
   DB_NAME=tiendaomar
   DB_USER=root
   DB_PASS=
   STRIPE_SECRET_KEY=tu_clave_secreta
   STRIPE_PUBLIC_KEY=tu_clave_publica
   ```

5. Instala las dependencias:
   ```bash
   composer install
   ```

6. Accede a `http://localhost/proyecto/public/` desde tu navegador

---

## 📄 Documentación completa

El desarrollo completo del proyecto, incluyendo análisis, diseño, implementación, pruebas y manual de usuario se encuentra en el documento oficial:

📘 [Documentación PDF del Proyecto TFG](Documentacion%20Proyecto%20Omar%20Qneiby%20Al-Sarsour.pdf)

---

## 👨‍🎓 Autor

**Omar Qneiby Al-Sarsour**  
📘 I.E.S. Francisco Ayala - DAW (Desarrollo de Aplicaciones Web)  
📅 Curso 2024/2025


## ✅ Licencia

Este proyecto ha sido desarrollado con fines académicos como TFG.  


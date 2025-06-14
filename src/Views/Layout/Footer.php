<style>
    /* Estilos footer */
    footer {

        background-color: #333;
        color: white;
        padding: 20px 20px;
        box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.1);
        border-top: 1px solid #ffffff;
    }

    .footer-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        width: 100%;
        margin: 0 auto;
    }

    .footer-section {
        flex: 1 1 200px;
        margin: 20px;
    }

    .footer-logo {
        max-width: 150px;
        margin-bottom: 10px;
    }

    .footer-section h3 {
        margin-bottom: 15px;
        color: white;
    }

    .footer-section p,
    .footer-section ul,
    .footer-section a {
        color: #bbb;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
    }

    .footer-section ul li {
        margin-bottom: 10px;
    }

    .footer-section ul li a {
        color: #bbb;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-section ul li a:hover {
        color: white;
    }

    .footer-bottom {
        text-align: center;
        margin-top: 20px;
        border-top: 1px solid #444;
        padding-top: 20px;
    }

    .footer-bottom p {
        margin: 5px 0;
    }

    .footer-bottom a {
        color: #bbb;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-bottom a:hover {
        color: white;
    }

    /* Redes sociales */
    .social-link {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        color: #bbb;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .social-link img {
        width: 24px;
        height: 24px;
        margin-right: 10px;
    }

    .social-link:hover {
        color: white;
    }
</style>

<footer>
    <div class="footer-container">
        <!-- Logo and Description -->
        <div class="footer-section">
            <img src="https://cdn.pccomponentes.com/img/logos/logo-pccomponentes.png" alt="Logo" class="footer-logo">
            <p>En <strong>PcComponentes Omar</strong>, ofrecemos los mejores componentes para llevar tu experiencia de juego al siguiente nivel. Desde tarjetas gráficas hasta periféricos de alta calidad, tenemos todo lo que necesitas.</p>
        </div>

        <!-- Quick Links -->
        <div class="footer-section">
            <h3>Enlaces Rápidos</h3>
            <ul>
                <li><a href="<?= BASE_URL ?>">Inicio</a></li>
                <li><a href="<?= BASE_URL ?>">Productos</a></li>
                <li><a href="<?= BASE_URL ?>">Ofertas</a></li>
                <li><a href="<?= BASE_URL ?>">Contacto</a></li>
                <li><a href="<?= BASE_URL?>">FAQ</a></li>
            </ul>
        </div>

        <!-- Contact Information -->
        <div class="footer-section">
            <h3>Contacto</h3>
            <p><strong>Email:</strong> soporte@PcComponentesOmar.com</p>
            <p><strong>Teléfono:</strong> +34 123 456 789</p>
            <p><strong>Dirección:</strong> Calle Falsa 123, Ciudad Gaming, País</p>
        </div>

        <!-- Social Media Links -->
        <div class="footer-section">
            <h3>Síguenos</h3>
            <div>
                <a href="https://www.facebook.com/pccomponentes/?locale=es_ES" class="social-link" target="_blank">
                    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/facebook.svg" alt="Facebook" class="social-icon" style="width:24px;height:24px;vertical-align:middle;"> Facebook
                </a>
            </div>
            <div>
                <a href="https://x.com/pccomponentes?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor" class="social-link" target="_blank">
                    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/x.svg" alt="X (Twitter)" class="social-icon" style="width:24px;height:24px;vertical-align:middle;"> X (Twitter)
                </a>
            </div>
            <div>
                <a href="https://www.instagram.com/pccomponentes/?hl=es" class="social-link" target="_blank">
                    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/instagram.svg" alt="Instagram" class="social-icon" style="width:24px;height:24px;vertical-align:middle;"> Instagram
                </a>
            </div>
            <div>
                <a href="https://www.youtube.com/c/pccomponentes" class="social-link" target="_blank">
                    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/youtube.svg" alt="YouTube" class="social-icon" style="width:24px;height:24px;vertical-align:middle;"> YouTube
                </a>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <p>&copy; 2025 PcComponentes OMAR. Todos los derechos reservados.</p>
        <p><a href="<?=BASE_URL?>">Política de Privacidad</a> | <a href="<?=BASE_URL?>">Términos y Condiciones</a></p>
    </div>
</footer>
</body>

</html>
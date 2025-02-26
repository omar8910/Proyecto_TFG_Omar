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
            <p>En <strong>TuMarcaGaming</strong>, ofrecemos los mejores componentes para llevar tu experiencia de juego al siguiente nivel. Desde tarjetas gráficas hasta periféricos de alta calidad, tenemos todo lo que necesitas.</p>
        </div>

        <!-- Quick Links -->
        <div class="footer-section">
            <h3>Enlaces Rápidos</h3>
            <ul>
                <li><a href="/inicio">Inicio</a></li>
                <li><a href="/productos">Productos</a></li>
                <li><a href="/ofertas">Ofertas</a></li>
                <li><a href="/contacto">Contacto</a></li>
                <li><a href="/faq">FAQ</a></li>
            </ul>
        </div>

        <!-- Contact Information -->
        <div class="footer-section">
            <h3>Contacto</h3>
            <p><strong>Email:</strong> soporte@tumarcamaming.com</p>
            <p><strong>Teléfono:</strong> +34 123 456 789</p>
            <p><strong>Dirección:</strong> Calle Falsa 123, Ciudad Gaming, País</p>
        </div>

        <!-- Social Media Links -->
        <div class="footer-section">
            <h3>Síguenos</h3>
            <div>
                <a href="https://www.facebook.com/tumarcagaming" class="social-link"><img src="facebook-icon.png" alt="Facebook" class="social-icon"> Facebook</a>
            </div>
            <div>
                <a href="https://www.twitter.com/tumarcagaming" class="social-link"><img src="twitter-icon.png" alt="Twitter" class="social-icon"> Twitter</a>
            </div>
            <div>
                <a href="https://www.instagram.com/tumarcagaming" class="social-link"><img src="instagram-icon.png" alt="Instagram" class="social-icon"> Instagram</a>
            </div>
            <div>
                <a href="https://www.youtube.com/tumarcagaming" class="social-link"><img src="youtube-icon.png" alt="YouTube" class="social-icon"> YouTube</a>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <p>&copy; 2024 TuMarcaGaming. Todos los derechos reservados.</p>
        <p><a href="/politica-de-privacidad">Política de Privacidad</a> | <a href="/terminos-y-condiciones">Términos y Condiciones</a></p>
    </div>
</footer>
</body>

</html>
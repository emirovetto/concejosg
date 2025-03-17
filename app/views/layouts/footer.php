        </div>
    </main>
    
    <!-- Pie de página -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <!-- Información de contacto -->
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-4">Concejo Deliberante de San Genaro</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i> San Martín 1234, San Genaro, Santa Fe</p>
                    <p><i class="fas fa-phone me-2"></i> (03401) 123456</p>
                    <p><i class="fas fa-envelope me-2"></i> info@concejosangenaro.gob.ar</p>
                </div>
                
                <!-- Enlaces rápidos -->
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-4">Enlaces rápidos</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/sesiones" class="text-white text-decoration-none">Sesiones</a></li>
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/ordenanzas" class="text-white text-decoration-none">Ordenanzas</a></li>
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/concejales" class="text-white text-decoration-none">Concejales</a></li>
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/noticias" class="text-white text-decoration-none">Noticias</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/contacto" class="text-white text-decoration-none">Contacto</a></li>
                    </ul>
                </div>
                
                <!-- Redes sociales -->
                <div class="col-md-4">
                    <h5 class="mb-4">Síguenos</h5>
                    <div class="d-flex">
                        <a href="#" class="text-white me-3" target="_blank"><i class="fab fa-facebook-f fa-2x"></i></a>
                        <a href="#" class="text-white me-3" target="_blank"><i class="fab fa-twitter fa-2x"></i></a>
                        <a href="#" class="text-white me-3" target="_blank"><i class="fab fa-instagram fa-2x"></i></a>
                        <a href="#" class="text-white" target="_blank"><i class="fab fa-youtube fa-2x"></i></a>
                    </div>
                    <div class="mt-4">
                        <h5 class="mb-3">Boletín informativo</h5>
                        <form action="<?php echo SITE_URL; ?>/app/controllers/newsletter_controller.php" method="post">
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Tu correo electrónico" required>
                                <button class="btn btn-primary" type="submit">Suscribirse</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <!-- Copyright -->
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> Concejo Deliberante de San Genaro. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="<?php echo SITE_URL; ?>/?page=privacidad" class="text-white text-decoration-none me-3">Política de privacidad</a>
                    <a href="<?php echo SITE_URL; ?>/?page=terminos" class="text-white text-decoration-none">Términos de uso</a>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Scripts personalizados -->
    <script src="<?php echo SITE_URL; ?>/app/public/js/scripts.js"></script>
</body>
</html> 
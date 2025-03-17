<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="mb-4">Contacto</h1>
            
            <?php if (isset($success) && $success): ?>
                <div class="alert alert-success">
                    <h4 class="alert-heading"><i class="fas fa-check-circle me-2"></i> ¡Mensaje enviado!</h4>
                    <p>Su mensaje ha sido enviado correctamente. Nos pondremos en contacto con usted a la brevedad.</p>
                </div>
            <?php else: ?>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form method="post" action="<?php echo SITE_URL; ?>/?page=contacto" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre completo *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                                <div class="invalid-feedback">Por favor, ingrese su nombre.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">Por favor, ingrese un correo electrónico válido.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono">
                            </div>
                            
                            <div class="mb-3">
                                <label for="asunto" class="form-label">Asunto *</label>
                                <input type="text" class="form-control" id="asunto" name="asunto" required>
                                <div class="invalid-feedback">Por favor, ingrese el asunto.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="mensaje" class="form-label">Mensaje *</label>
                                <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required></textarea>
                                <div class="invalid-feedback">Por favor, ingrese su mensaje.</div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Enviar mensaje</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h4 class="card-title mb-4">Información de contacto</h4>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="contact-info">
                                <p><i class="fas fa-map-marker-alt me-2"></i> San Martín 1234, San Genaro, Santa Fe</p>
                                <p><i class="fas fa-phone me-2"></i> (03401) 123456</p>
                                <p><i class="fas fa-envelope me-2"></i> info@concejosangenaro.gob.ar</p>
                                <p><i class="fas fa-clock me-2"></i> Lunes a Viernes: 8:00 - 13:00</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26868.49091414598!2d-61.37!3d-32.37!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95b5fa3e4b7d3e45%3A0x8c5e6fa6a1e7c376!2sSan%20Genaro%2C%20Santa%20Fe!5e0!3m2!1ses!2sar!4v1625000000000!5m2!1ses!2sar" 
                                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
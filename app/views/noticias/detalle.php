<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <article class="news-detail">
                <h1 class="mb-3"><?php echo $noticia['titulo']; ?></h1>
                
                <div class="text-muted mb-4">
                    <i class="far fa-calendar-alt me-1"></i> <?php echo format_date($noticia['fecha_publicacion']); ?>
                </div>
            </article>
        </div>
    </div>
</div> 
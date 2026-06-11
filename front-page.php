<?php 
/**
 * Template Name : Accueil
 * 
 * @package  Nadb Portfolio
 */
?>

<?php get_header(); ?>

<main id="primary" class="site-main">
    <!-- HERO : affiche le contenu ajouté dans l'éditeur WordPress de la page d'accueil. -->
    <section class="hero">
        <?php the_content(); ?>
    </section>

 <section class="portfolio-grid">

<?php
$portfolio = new WP_Query([
    'post_type'      => 'portfolio',
    'posts_per_page' => 6,
]);

if ($portfolio->have_posts()) :
    while ($portfolio->have_posts()) : $portfolio->the_post();

        $photo = get_field('photo');
        $type  = get_field('type_du_projet');
        $date  = get_field('date');
?>

    <article class="portfolio-card">

        <?php if ($photo) : ?>
            <img 
                src="<?php echo esc_url($photo['url']); ?>" 
                alt="<?php echo esc_attr($photo['alt']); ?>"
                class="portfolio-card__image"
            >
        <?php endif; ?>

        <div class="portfolio-card__content">
            <h3><?php the_title(); ?></h3>

            <p>
                <?php echo wp_trim_words(get_the_content(), 25, '...'); ?>
            </p>

            <?php if ($type) : ?>
                <span><?php echo esc_html($type); ?></span>
            <?php endif; ?>

            <?php if ($date) : ?>
                <span><?php echo esc_html($date); ?></span>
            <?php endif; ?>
        </div>

    </article>

<?php
    endwhile;
    wp_reset_postdata();
endif;
?>

</section>

<?php get_footer(); ?>

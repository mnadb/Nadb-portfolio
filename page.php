<?php
/**
 * The template for displaying all single pages
 *
 * @package WordPress
 * @subpackage Nadb Portfolio
 * @since 1.0
 */
?>


<?php get_header(); ?>

<main id="primary" class="site-main">

    <?php if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();

            // La page Portfolio affiche les projets, les autres pages gardent leur contenu classique.
            $is_portfolio_page = is_page('portfolio');
            ?>

            <?php if ( $is_portfolio_page ) : ?>
                <section class="portfolio-section" aria-labelledby="portfolio-title">
                    <div class="portfolio-section__header">
                        <h1 id="portfolio-title"><?php the_title(); ?></h1>
                        <?php if ( get_the_content() ) : ?>
                            <div class="portfolio-section__intro">
                                <?php the_content(); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="portfolio-grid">
                        <?php
                        // Recupere les projets du type de contenu Portfolio cree dans WordPress.
                        $portfolio = new WP_Query([
                            'post_type'      => 'portfolio',
                            'posts_per_page' => 6,
                        ]);

                        if ( $portfolio->have_posts() ) :
                            while ( $portfolio->have_posts() ) :
                                $portfolio->the_post();

                                $photo = function_exists('get_field') ? get_field('photo') : null;
                                $type  = function_exists('get_field') ? get_field('type_du_projet') : '';
                                $date  = function_exists('get_field') ? get_field('date') : '';
                                ?>

                                <article class="portfolio-card">
                                    <a class="portfolio-card__link" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr('Voir le projet ' . get_the_title()); ?>">
                                        <?php if ( $photo ) : ?>
                                            <img
                                                src="<?php echo esc_url($photo['url']); ?>"
                                                alt="<?php echo esc_attr($photo['alt'] ?: get_the_title()); ?>"
                                                class="portfolio-card__image"
                                            >
                                        <?php elseif ( has_post_thumbnail() ) : ?>
                                            <?php the_post_thumbnail('large', ['class' => 'portfolio-card__image']); ?>
                                        <?php endif; ?>

                                        <div class="portfolio-card__content">
                                            <h2><?php the_title(); ?></h2>
                                            <p><?php echo esc_html(wp_trim_words(get_the_excerpt() ?: get_the_content(), 22, '...')); ?></p>

                                            <?php if ( $type || $date ) : ?>
                                                <div class="portfolio-card__meta">
                                                    <?php if ( $type ) : ?>
                                                        <span><?php echo esc_html($type); ?></span>
                                                    <?php endif; ?>

                                                    <?php if ( $date ) : ?>
                                                        <span><?php echo esc_html($date); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                </article>

                                <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            ?>
                            <p class="portfolio-empty">Aucun projet n'est disponible pour le moment.</p>
                        <?php endif; ?>
                    </div>

                    <div class="portfolio-actions">
                        <button class="cta-choix js-open-contact-popup" type="button">Me contacter</button>
                    </div>
                </section>
            <?php else : ?>
                <section class="page-content">
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </section>

                <?php if ( is_page(['a-propos', 'A propos', 'À propos', 'about']) ) : ?>
                    <?php
                    // Le slider utilise le champ ACF "technologies" s'il existe, sinon une liste par defaut.
                    $technologies = ['HTML', 'CSS', 'JavaScript', 'PHP', 'WordPress', 'ACF'];

                    // Associe chaque technologie a son image placee dans assets/images.
                    $technology_images = [
                        'html'       => 'html.png',
                        'html5'      => 'html.png',
                        'css'        => 'css3.png',
                        'css3'       => 'css3.png',
                        'javascript' => 'javascript_logo.png',
                        'js'         => 'javascript_logo.png',
                        'php'        => 'phplogo.jpeg',
                        'wordpress'  => 'wordpress.jpg',
                        'acf'        => 'acf.png',
                        'advancedcustomfields' => 'acf.png',
                        'html5etcss3' => 'HTML5-et-CSS3.png',
                    ];

                    if ( function_exists('get_field') ) {
                        $acf_technologies = get_field('technologies');

                        if ( is_string($acf_technologies) && $acf_technologies !== '' ) {
                            $technologies = array_map('trim', explode(',', $acf_technologies));
                        } elseif ( is_array($acf_technologies) && ! empty($acf_technologies) ) {
                            $technologies = array_map(
                                function ($technology) {
                                    if ( is_array($technology) ) {
                                        return $technology['nom'] ?? $technology['titre'] ?? $technology['technologie'] ?? reset($technology);
                                    }

                                    return $technology;
                                },
                                $acf_technologies
                            );
                        }
                    }

                    $technologies = array_filter($technologies);
                    ?>

                    <section class="about-technologies" aria-labelledby="about-technologies-title">
                        <div class="about-technologies__header">
                            <h2 id="about-technologies-title">Technologies</h2>
                        </div>

                        <div class="tech-slider" data-tech-slider>
                            <button class="tech-slider__button tech-slider__button--prev" type="button" aria-label="Technologie precedente">
                                &lt;
                            </button>

                            <div class="tech-slider__viewport" tabindex="0">
                                <div class="tech-slider__track">
                                    <?php foreach ( $technologies as $technology ) : ?>
                                        <?php
                                        // Normalise le nom pour retrouver l'image correspondante.
                                        $technology_key = sanitize_title($technology);
                                        $technology_key = str_replace('-', '', $technology_key);
                                        $technology_image = $technology_images[$technology_key] ?? '';
                                        ?>
                                        <article class="tech-slide">
                                            <?php if ( $technology_image ) : ?>
                                                <img
                                                    class="tech-slide__image"
                                                    src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/' . $technology_image); ?>"
                                                    alt="<?php echo esc_attr($technology); ?>"
                                                >
                                            <?php endif; ?>
                                            <span><?php echo esc_html($technology); ?></span>
                                        </article>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <button class="tech-slider__button tech-slider__button--next" type="button" aria-label="Technologie suivante">
                                &gt;
                            </button>
                        </div>
                    </section>
                <?php endif; ?>
            <?php endif; ?>

        <?php endwhile;
    endif; ?>

</main>
<?php get_footer(); ?>

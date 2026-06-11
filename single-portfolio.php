<?php
/**
 * Single Post Template
 * 
 * @package Nadb Portfolio
 */
?>

<?php get_header(); ?>

<main class="project-detail">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      
        <section class="project-hero">
            <h1><?php the_title(); ?></h1>

            <?php if (has_post_thumbnail()) : ?>
                <div class="project-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>
        </section>

        <?php if (get_the_content()) : ?>
            <section class="project-content">
                <?php the_content(); ?>
            </section>
        <?php endif; ?>

       
        <div class="project-actions">
            <button
                class="cta-choix js-open-contact-popup"
                type="button"
                data-reference="<?php echo esc_attr(get_the_title()); ?>"
            >
                Me contacter
            </button>

            <a class="back-link" href="<?php echo esc_url(home_url('/portfolio/')); ?>">
                Retour au portfolio
            </a>
        </div>

    <?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>

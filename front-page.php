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

</main>


<?php get_footer(); ?>

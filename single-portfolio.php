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
        <?php
        // Recupere les champs ACF du groupe "Details projet".
        $mission_context = '';
        $project_description = '';
        $project_screenshot = null;
        $developed_skills = '';
        $github_link = '';

        if (function_exists('get_field')) {
            $mission_context = get_field('contexte_de_la_mission');
            $project_description = get_field('description_du_projet');
            $project_screenshot = get_field('capture_decran');
            $developed_skills = get_field('competences_developpees');
            $github_link = get_field('github');
        }

        $has_project_details = $mission_context || $project_description || $project_screenshot || $developed_skills || $github_link;
        $portfolio_url = get_post_type_archive_link('portfolio') ?: home_url('/portfolio/');
        ?>

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

        <?php if ($has_project_details) : ?>
        <section class="project-details" aria-labelledby="project-details-title">
            <h2 id="project-details-title">Détails du projet</h2>

            <div class="project-details__grid">
                <?php if ($mission_context) : ?>
                    <article class="project-details__item">
                        <h3>Contexte de la mission</h3>
                        <div><?php echo wp_kses_post(wpautop($mission_context)); ?></div>
                    </article>
                <?php endif; ?>

                <?php if ($project_description) : ?>
                    <article class="project-details__item">
                        <h3>Description du projet</h3>
                        <div><?php echo wp_kses_post(wpautop($project_description)); ?></div>
                    </article>
                <?php endif; ?>

                <?php if ($developed_skills) : ?>
                    <article class="project-details__item">
                        <h3>Compétences développées</h3>
                        <div><?php echo wp_kses_post(wpautop($developed_skills)); ?></div>
                    </article>
                <?php endif; ?>
            </div>

            <?php if ($project_screenshot) : ?>
                <figure class="project-screenshot">
                    <?php
                    // Le champ image ACF peut retourner un tableau, un ID ou une URL selon son parametrage.
                    if (is_array($project_screenshot)) :
                        ?>
                        <img
                            src="<?php echo esc_url($project_screenshot['url'] ?? ''); ?>"
                            alt="<?php echo esc_attr(($project_screenshot['alt'] ?? '') ?: get_the_title()); ?>"
                        >
                    <?php elseif (is_numeric($project_screenshot)) : ?>
                        <?php echo wp_get_attachment_image($project_screenshot, 'large'); ?>
                    <?php else : ?>
                        <img src="<?php echo esc_url($project_screenshot); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                    <?php endif; ?>
                </figure>
            <?php endif; ?>

            <?php if ($github_link) : ?>
                <?php
                // Le champ lien ACF peut retourner un tableau ou directement une URL.
                $github_url = is_array($github_link) ? ($github_link['url'] ?? '') : $github_link;
                $github_label = is_array($github_link) ? (($github_link['title'] ?? '') ?: 'Voir le projet sur GitHub') : 'Voir le projet sur GitHub';
                $github_target = is_array($github_link) ? (($github_link['target'] ?? '') ?: '_blank') : '_blank';
                ?>

                <?php if ($github_url) : ?>
                    <a class="project-github" href="<?php echo esc_url($github_url); ?>" target="<?php echo esc_attr($github_target); ?>" rel="noopener">
                        <?php echo esc_html($github_label); ?>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
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

            <a class="back-link" href="<?php echo esc_url($portfolio_url); ?>">
                Retour au portfolio
            </a>
        </div>

    <?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>

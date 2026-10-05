<?php
/**
 * The template for displaying archive pages
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="container section-padding">
    <header class="archive-header text-center">
        <?php
        the_archive_title('<h1 class="page-title">', '</h1>');
        the_archive_description('<div class="archive-description">', '</div>');
        ?>
        <div class="gold-divider"></div>
    </header>

    <div class="posts-list-grid">
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('post-card-item'); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-card-thumb">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium_large'); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="post-card-body">
                        <h2 class="post-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <div class="post-excerpt"><?php the_excerpt(); ?></div>
                    </div>
                </article>
                <?php
            endwhile;
            the_posts_pagination();
        else :
            ?>
            <p><?php esc_html_e('No archived entries found.', 'kash-naturals'); ?></p>
            <?php
        endif;
        ?>
    </div>
</div>

<?php
get_footer();

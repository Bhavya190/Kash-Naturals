<?php
/**
 * The template for displaying single blog posts
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="container section-padding">
    <?php
    while (have_posts()) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('single-post-article'); ?>>
            <header class="entry-header text-center">
                <div class="post-meta">
                    <span class="post-category"><?php the_category(', '); ?></span>
                    <span class="post-date"><i class="fa-regular fa-calendar"></i> <?php echo get_the_date(); ?></span>
                </div>
                <h1 class="entry-title"><?php the_title(); ?></h1>
                <div class="gold-divider"></div>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="single-post-hero-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <div class="entry-content">
                <?php the_content(); ?>
            </div>

            <footer class="entry-footer">
                <div class="post-tags">
                    <?php the_tags('<span class="tag-title">Tags: </span>', ' ', ''); ?>
                </div>
            </footer>
        </article>

        <?php
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;

    endwhile;
    ?>
</div>

<?php
get_footer();

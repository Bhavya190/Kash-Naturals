<?php
/**
 * The main template file
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="container section-padding">
    <div class="page-header text-center">
        <h1 class="page-title"><?php single_post_title(); ?></h1>
        <div class="gold-divider"></div>
    </div>

    <div class="main-content-layout">
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
                            <div class="post-meta">
                                <span class="post-date"><i class="fa-regular fa-calendar"></i> <?php echo get_the_date(); ?></span>
                                <span class="post-author"><i class="fa-regular fa-user"></i> <?php the_author(); ?></span>
                            </div>
                            <h2 class="post-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <div class="post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="read-more-link">Read Journal Entry <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </article>
                    <?php
                endwhile;

                the_posts_pagination(array(
                    'prev_text' => __('&laquo; Previous', 'kash-naturals'),
                    'next_text' => __('Next &raquo;', 'kash-naturals'),
                ));
            else :
                ?>
                <p><?php esc_html_e('No posts found. Check back soon for chocolate recipes and cacao journal updates!', 'kash-naturals'); ?></p>
                <?php
            endif;
            ?>
        </div>
    </div>
</div>

<?php
get_footer();

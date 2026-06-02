<?php
// blog.php
require_once 'includes/functions.php';
$page_title = __('blog_page_title');
$page_description = __('blog_page_description');
include 'includes/head.php';
include 'includes/header.php';
?>

<main class="fix">
    <?php 
    $breadcrumb_title = __('breadcrumb_blog');
    include 'components/breadcrumb.php'; 
    ?>

    <!-- blog-area -->
    <section class="blog-area pt-120 pb-120">
        <div class="container">
            <div class="inner-blog-wrap">
                <div class="row justify-content-center">
                    <div class="col-71">
                        <div class="blog-post-wrap">
                            <div class="row">
                                <?php 
                                // Filtrage simple (à remplacer par requête BDD)
                                $display_posts = $blog_posts;
                                
                                if (isset($_GET['category'])) {
                                    $cat = $_GET['category'];
                                    $display_posts = array_filter($display_posts, fn($p) => getBlogField($p, 'category') === $cat);
                                }
                                
                                if (isset($_GET['tag'])) {
                                    $tag = strtolower($_GET['tag']);
                                    $display_posts = array_filter($display_posts, fn($p) =>
                                        str_contains(strtolower(getBlogField($p, 'category')), $tag) ||
                                        str_contains(strtolower(getBlogField($p, 'title')), $tag) ||
                                        str_contains(strtolower(getBlogField($p, 'excerpt')), $tag)
                                    );
                                }
                                
                                if (isset($_GET['search'])) {
                                    $search = strtolower($_GET['search']);
                                    $display_posts = array_filter($display_posts, fn($p) => 
                                        str_contains(strtolower(getBlogField($p, 'title')), $search) || 
                                        str_contains(strtolower(getBlogField($p, 'excerpt')), $search)
                                    );
                                }
                                
                                if (empty($display_posts)): 
                                ?>
                                <div class="col-12">
                                    <div class="alert alert-info"><?php echo __('blog_no_posts'); ?></div>
                                </div>
                                <?php 
                                else:
                                    foreach ($display_posts as $post):
                                        include 'components/blog-card.php';
                                    endforeach;
                                endif;
                                ?>
                            </div>
                            
                            <?php 
                            if (count($display_posts) > 6):
                                include 'components/pagination.php';
                            endif;
                            ?>
                        </div>
                    </div>
                    
                    <div class="col-29">
                        <?php include 'components/blog-sidebar.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
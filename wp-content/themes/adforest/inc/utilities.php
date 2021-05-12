<?php
/* 	Basic functions. */
/** * close all open xhtml tags at the end of the string
 * * @param string $html
 * @return string
 */
if (!function_exists('adforest_close_tags')) {

    function adforest_close_tags($html) {
        preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
        $openedtags = $result[1];   #put all closed tags into an array
        preg_match_all('#</([a-z]+)>#iU', $html, $result);
        $closedtags = $result[1];
        $len_opened = count($openedtags);

        if (count($closedtags) == $len_opened) {
            return $html;
        }
        $openedtags = array_reverse($openedtags);
        for ($i = 0; $i < $len_opened; $i++) {

            if (!in_array($openedtags[$i], $closedtags)) {
                $html .= '</' . $openedtags[$i] . '>';
            } else {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
        return $html;
    }

}

/* ------------------------------------------------ */
/* Comments */
/* ------------------------------------------------ */
if (!function_exists('adforest_comments_list')) :

    function adforest_comments_list($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        $img = '';
        if (get_avatar_url($comment, 44) != "") {
            $img = '<img class="pull-left hidden-xs img-circle" alt="' . esc_attr__('Avatar', 'adforest') . '" src="' . esc_url(get_avatar_url($comment, 44)) . '" />';
        }
        ?>

        <li class="comment" id="comment-<?php esc_attr(comment_ID());?>">
            <div class="comment-info">
                <?php echo "" . $img;?>
                <div class="author-desc">
                    <div class="author-title">
                        <strong><?php comment_author();?></strong>
                        <ul class="list-inline pull-right">
                            <li><a href="javascript:void(0);"><?php echo esc_html(get_comment_date()) . " " . esc_html(get_comment_time());?></a>
                            </li>
                            <?php
                            $myclass = ' active-color';
                            $reply_link = preg_replace('/comment-reply-link/', 'comment-reply-link ' . $myclass, get_comment_reply_link(array_merge($args, array('reply_text' => esc_attr__('Reply', 'adforest'), 'depth' => $depth, 'max_depth' => $args['max_depth']))), 1);
                            ?>
                            <?php if ($reply_link != "") {?>
                                <li><?php echo wp_kses($reply_link, adforest_required_tags());?>
                                <?php }?>
                            </li>
                        </ul>
                    </div>
                    <?php comment_text();?>
                </div>
            </div>
            <?php
            if ($args['has_children'] == "") {
                echo '</li>';
            }
            ?>
            <?php
        }

    endif;
    /* ------------------------------------------------ */
    /* Pagination */
    /* ------------------------------------------------ */
    if (!function_exists('adforest_pagination')) {

        function adforest_pagination($w_query = array()) {
            if (is_singular())
                return;

            global $wp_query;
            if (isset($w_query) && !empty($w_query)) {
                $wp_query = $w_query;
            }
            /** Stop execution if there's only 1 page */
            if ($wp_query->max_num_pages <= 1)
                return;

            $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
            $max = intval($wp_query->max_num_pages);

            /** 	Add current page to the array */
            if ($paged >= 1)
                $links[] = $paged;

            /** 	Add the pages around the current page to the array */
            if ($paged >= 3) {
                $links[] = $paged - 1;
                $links[] = $paged - 2;
            }

            if (( $paged + 2 ) <= $max) {
                $links[] = $paged + 2;
                $links[] = $paged + 1;
            }

            echo '<ul class="pagination pagination-large">' . "\n";

            if (get_previous_posts_link())
                printf('<li>%s</li>' . "\n", get_previous_posts_link());

            /** 	Link to first page, plus ellipses if necessary */
            if (!in_array(1, $links)) {
                $class = 1 == $paged ? ' class="active"' : '';

                printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

                if (!in_array(2, $links))
                    echo '<li><a href="javascript:void(0);">...</a></li>';
            }

            /** 	Link to current page, plus 2 pages in either direction if necessary */
            sort($links);
            foreach ((array) $links as $link) {
                $class = $paged == $link ? ' class="active"' : '';
                printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
            }

            /** 	Link to last page, plus ellipses if necessary */
            if (!in_array($max, $links)) {
                if (!in_array($max - 1, $links))
                    echo '<li><a href="javascript:void(0);">...</a></li>' . "\n";
                $class = $paged == $max ? ' class="active"' : '';
                printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
            }

            if (get_next_posts_link())
                printf('<li>%s</li>' . "\n", get_next_posts_link());
            echo '</ul>' . "\n";
        }

    }

    if (!function_exists('adforest_pagination_search')) {

        function adforest_pagination_search($wp_query) {
            if (is_singular())
            //return;

            /** Stop execution if there's only 1 page */
                if ($wp_query->max_num_pages <= 1)
                    return;

            if (get_query_var('paged')) {
                $paged = get_query_var('paged');
            } elseif (get_query_var('page')) {
                $paged = get_query_var('page');
            } else {
                $paged = 1;
            }

            $max = intval($wp_query->max_num_pages);
            /** 	Add current page to the array */
            if ($paged >= 1)
                $links[] = $paged;

            /** 	Add the pages around the current page to the array */
            if ($paged >= 3) {
                $links[] = $paged - 1;
                $links[] = $paged - 2;
            }

            if (( $paged + 2 ) <= $max) {
                $links[] = $paged + 2;
                $links[] = $paged + 1;
            }

            echo '<ul class="pagination pagination-lg">' . "\n";

            if (get_previous_posts_link())
                printf('<li>%s</li>' . "\n", get_previous_posts_link());

            /** 	Link to first page, plus ellipses if necessary */
            if (!in_array(1, $links)) {
                $class = 1 == $paged ? ' class="active"' : '';

                printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

                if (!in_array(2, $links))
                    echo '<li><a href="javascript:void(0);">...</a></li>';
            }
            /** 	Link to current page, plus 2 pages in either direction if necessary */
            sort($links);
            foreach ((array) $links as $link) {

                $class = $paged == $link ? ' class="active"' : '';
                printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
            }
            /** 	Link to last page, plus ellipses if necessary */
            if (!in_array($max, $links)) {
                if (!in_array($max - 1, $links))
                    echo '<li><a href="javascript:void(0);">...</a></li>' . "\n";
                $class = $paged == $max ? ' class="active"' : '';
                printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
            }

            if (get_next_posts_link_custom($wp_query))
                printf('<li>%s</li>' . "\n", get_next_posts_link_custom($wp_query));

            echo '</ul>' . "\n";
        }

    }

    if (!function_exists('adforest_comments_pagination')) {

        function adforest_comments_pagination($total_records, $current_page) {
            // Check if a records is set.
            if (!isset($total_records))
                return;
            if (!isset($current_page))
                return;
            $args = array(
                'base' => add_query_arg('page', '%#%'),
                'format' => '?page=%#%',
                'total' => $total_records,
                'current' => $current_page,
                'show_all' => false,
                'end_size' => 1,
                'mid_size' => 2,
                'prev_next' => true,
                'prev_text' => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                'next_text' => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                'type' => 'array');
            $pagination = paginate_links($args);
            $pagination_html = '';
            if (count((array) $pagination) > 0) {
                $pagination_html = '<ul class="pagination">';
                foreach ($pagination as $key => $page_link) {
                    $link = $page_link;
                    $class = '';
                    if (strpos($page_link, 'current') !== false) {
                        $link = '<a href="javascript:void(0);">' . $current_page . '</a>';
                        $class = 'active';
                    }
                    $pagination_html .= '<li class="' . $class . '">' . $link . '</li>';
                }
                $pagination_html .= '</ul>';
            }
            return $pagination_html;
        }

    }

    if (!function_exists('get_next_posts_link_custom')) {

        function get_next_posts_link_custom($wp_query, $label = null, $max_page = 0) {
            global $paged;


            if (!$max_page)
                $max_page = $wp_query->max_num_pages;

            if (!$paged)
                $paged = 1;

            $nextpage = intval($paged) + 1;

            if (null === $label)
                $label = __('Next Page &raquo;', 'adforest');

            if ($nextpage <= $max_page) {
                /**
                 * Filters the anchor tag attributes for the next posts page link.
                 *
                 * @since 2.7.0
                 *
                 * @param string $attributes Attributes for the anchor tag.
                 */
                $attr = apply_filters('next_posts_link_attributes', '');

                return '<a href="' . next_posts($max_page, false) . "\" $attr>" . preg_replace('/&([^#])(?![a-z]{1,8};)/i', '&#038;$1', $label) . '</a>';
            }
        }

    }
    /* Return Category ID */
    if (!function_exists('adforest_getCatID')) {

        function adforest_getCatID() {
            return esc_html(get_cat_id(single_cat_title("", false)));
        }

    }
    /* Breadcrumb */
    if (!function_exists('adforest_breadcrumb')) {

        function adforest_breadcrumb() {
            $string = '';
            global $adforest_theme;
            if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && is_shop()) {
                $string .= isset($adforest_theme['shop-number-page-title']) ? $adforest_theme['shop-number-page-title'] : __('Shop', 'adforest');
            } else if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && is_product()) {
                $string .= isset($adforest_theme['shop-single-page-title']) ? $adforest_theme['shop-single-page-title'] : __('Details', 'adforest');
            } else if (is_category()) {
                $string .= esc_html(get_cat_name(adforest_getCatID()));
            } else if (is_single()) {
                $string .= esc_html(get_the_title());
            } elseif (is_page()) {
                $string .= esc_html(get_the_title());
            } elseif (is_tag()) {
                $string .= esc_html(single_tag_title("", false));
            } elseif (is_search()) {
                $string .= esc_html(get_search_query());
            } elseif (is_404()) {
                $string .= esc_html__('Page not Found', 'adforest');
            } elseif (is_author()) {
                $string .= __('Author', 'adforest');
            } else if (is_tax()) {
                $string .= esc_html(single_cat_title("", false));
            } elseif (is_archive()) {
                $string .= esc_html__('Archive', 'adforest');
            } else if (is_home()) {
                $string = esc_html__('Latest Stories', 'adforest');
            }
            return $string;
        }

    }

    /* Get BreadCrumb Heading */
    if (!function_exists('adforest_bread_crumb_heading')) {

        function adforest_bread_crumb_heading() {
            $page_heading = '';
            global $adforest_theme;

            if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && is_shop()) {
                $page_heading = isset($adforest_theme['shop-number-page-title']) ? $adforest_theme['shop-number-page-title'] : __('Shop', 'adforest');
            } else if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && is_product()) {
                $page_heading = isset($adforest_theme['shop-single-page-title']) ? $adforest_theme['shop-single-page-title'] : __('Details', 'adforest');
            } else if (is_search()) {
                $string = esc_html__('entire web', 'adforest');
                if (get_search_query() != "") {
                    $string = get_search_query();
                }
                $page_heading = sprintf(esc_html__('Search Results for: %s', 'adforest'), esc_html($string));
            } else if (is_category()) {
                $page_heading = esc_html(single_cat_title("", false));
            } else if (is_tag()) {
                $page_heading = esc_html__('Tag: ', 'adforest') . esc_html(single_tag_title("", false));
            } else if (is_404()) {
                $page_heading = esc_html__('Page not found', 'adforest');
            } else if (is_author()) {
                $author_id = get_query_var('author');
                $author = get_user_by('ID', $author_id);
                $page_heading = $author->display_name;
            } else if (is_tax()) {
                $page_heading = esc_html(single_cat_title("", false));
            } else if (is_archive()) {
                $page_heading = __('Blog Archive', 'adforest');
            } else if (is_home()) {
                $page_heading = esc_html__('Latest Stories', 'adforest');
            } else if (is_singular('post')) {
                if (isset($adforest_theme['sb_blog_single_title']) && $adforest_theme['sb_blog_single_title'] != "") {
                    $page_heading = $adforest_theme['sb_blog_single_title'];
                } else {
                    $page_heading = __('Blog Detail', 'adforest');
                }
            } else if (is_singular('page')) {
                $page_heading = get_the_title();
            } else if (is_singular('ad_post')) {
                if (isset($adforest_theme['sb_single_ad_text']) && $adforest_theme['sb_single_ad_text'] != "")
                    $page_heading = $adforest_theme['sb_single_ad_text'];
                else
                    $page_heading = __('Ad Detail', 'adforest');
            }

            return $page_heading;
        }

    }

    /* Get and Set Post Views */
    if (!function_exists('adforest_getPostViews')) {

        function adforest_getPostViews($postID) {
            $postID = esc_html($postID);
            $count_key = 'sb_post_views_count';
            $count = get_post_meta($postID, $count_key, true);
            if ($count == '') {
                delete_post_meta($postID, $count_key);
                add_post_meta($postID, $count_key, '0');
                return "0";
            }
            return $count;
        }

    }

    if (!function_exists('adforest_setPostViews')) {

        function adforest_setPostViews($postID) {
            $postID = esc_html($postID);
            $count_key = 'sb_post_views_count';
            $count = get_post_meta($postID, $count_key, true);
            if ($count == '') {
                $count = 0;
                delete_post_meta($postID, $count_key);
                add_post_meta($postID, $count_key, '0');
            } else {
                $count++;
                update_post_meta($postID, $count_key, $count);
            }
        }

    }

    /* get post description as per need. */
    if (!function_exists('adforest_words_count')) {

        function adforest_words_count($contect = '', $limit = 180) {
            $string = '';
            $contents = strip_tags(strip_shortcodes($contect));
            $contents = adforest_removeURL($contents);
            $removeSpaces = str_replace(" ", "", $contents);
            $contents = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', html_entity_decode($contents, ENT_QUOTES));
            if (strlen($removeSpaces) > $limit) {
                return mb_substr(str_replace("&nbsp;", "", $contents), 0, $limit) . '...';
            } else {
                return str_replace("&nbsp;", "", $contents);
            }
        }

    }

    if (!function_exists('adforest_social_share')) {

        function adforest_social_share() {
            // check if plugin addtoany actiavted then load that otherwise builtin function
            if (in_array('add-to-any/add-to-any.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                return do_shortcode('[addtoany]');
            }
            // Get current page URL 
            $sbURL = esc_url(get_permalink());
            // Get current page title
            $sbTitle = str_replace(' ', '%20', esc_html(get_the_title()));
            // Get Post Thumbnail for pinterest
            $sbThumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(esc_html(get_the_ID())), 'sb-single-blog-featured');
            // Construct sharing URL without using any script
            $twitterURL = 'https://twitter.com/intent/tweet?text=' . $sbTitle . '&amp;url=' . $sbURL;
            $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u=' . $sbURL;
            $googleURL = 'https://plus.google.com/share?url=' . $sbURL;
            $bufferURL = 'https://bufferapp.com/add?url=' . $sbURL . '&amp;text=' . $sbTitle;
            // Based on popular demand added Pinterest too
            $pinterestURL = 'https://pinterest.com/pin/create/button/?url=' . $sbURL . '&amp;media=' . $sbThumbnail[0] . '&amp;description=' . $sbTitle;
            // Add sharing button at the end of page/page content
            return '<a href="' . esc_url($facebookURL) . '" class="btn btn-fb btn-md" target="_blank"><i class="fa fa-facebook"></i></a><a href="' . esc_url($twitterURL) . '" class="btn btn-twitter btn-md" target="_blank"><i class="fa fa-twitter"></i></a><a href="' . esc_url($googleURL) . '" class="btn btn-gplus btn-md" target="_blank"><i class="fa fa-google"></i></a>';
        }

    }

    if (!function_exists('adforest_required_attributes')) {

        function adforest_required_attributes() {
            return $default_attribs = array(
                'id' => array(),
                'src' => array(),
                'href' => array(),
                'target' => array(),
                'class' => array(),
                'title' => array(),
                'type' => array(),
                'style' => array(),
                'data' => array(),
                'role' => array(),
                'aria-haspopup' => array(),
                'aria-expanded' => array(),
                'data-toggle' => array(),
                'data-hover' => array(),
                'data-animations' => array(),
                'data-mce-id' => array(),
                'data-mce-style' => array(),
                'data-mce-bogus' => array(),
                'data-href' => array(),
                'data-tabs' => array(),
                'data-small-header' => array(),
                'data-adapt-container-width' => array(),
                'data-height' => array(),
                'data-hide-cover' => array(),
                'data-show-facepile' => array(),
            );
        }

    }

    if (!function_exists('adforest_required_tags')) {

        function adforest_required_tags() {
            return $allowed_tags = array(
                'div' => adforest_required_attributes(),
                'span' => adforest_required_attributes(),
                'p' => adforest_required_attributes(),
                'a' => array_merge(adforest_required_attributes(), array('href' => array(), 'target' => array('_blank', '_top'),)),
                'u' => adforest_required_attributes(),
                'br' => adforest_required_attributes(),
                'i' => adforest_required_attributes(),
                'q' => adforest_required_attributes(),
                'b' => adforest_required_attributes(),
                'ul' => adforest_required_attributes(),
                'ol' => adforest_required_attributes(),
                'li' => adforest_required_attributes(),
                'br' => adforest_required_attributes(),
                'hr' => adforest_required_attributes(),
                'strong' => adforest_required_attributes(),
                'blockquote' => adforest_required_attributes(),
                'del' => adforest_required_attributes(),
                'strike' => adforest_required_attributes(),
                'em' => adforest_required_attributes(),
                'code' => adforest_required_attributes(),
                'style' => adforest_required_attributes(),
                'script' => adforest_required_attributes(),
                'img' => adforest_required_attributes(),
            );
        }

    }
    /* pages links */
    paginate_comments_links();
    the_post_thumbnail();

    /* get feature image */
    if (!function_exists('adforest_get_feature_image')) {

        function adforest_get_feature_image($post_id, $image_size) {
            return wp_get_attachment_image_src(get_post_thumbnail_id(esc_html($post_id)), $image_size);
        }

    }

    /* Add Next Page Button in First Row */
    add_filter('mce_buttons', 'adforest_my_next_page_button', 1, 2); // 1st row

    /**
     * Add Next Page/Page Break Button
     * in WordPress Visual Editor
     */
    if (!function_exists('adforest_my_next_page_button')) {

        function adforest_my_next_page_button($buttons, $id) {
            /* only add this for content editor */
            if ('content' != $id)
                return $buttons;

            /* add next page after more tag button */
            array_splice($buttons, 13, 0, 'wp_page');
            return $buttons;
        }

    }
    /* search only within posts. */
    if (!function_exists('adforest_search_filter')) {

        function adforest_search_filter($query) {
            if ($query->is_author) {
                $query->set('post_type', array('ad_post'));
                $query->set('post_status', array('publish'));
            }
            return $query;
        }

    }

    if (!is_admin() && isset($_GET['type']) && $_GET['type'] == 'ads') {
        add_filter('pre_get_posts', 'adforest_search_filter');
    }

    /* get post format icon */
    if (!function_exists('adforest_post_format_icon')) {

        function adforest_post_format_icon($format = '') {
            if ($format == "") {
                return 'ion-ios-star';
            }
            $format_icons = array('audio' => 'ion-volume-medium', 'video' => 'ion-videocamera', 'image' => 'ion-images', 'quote' => 'ion-quote');
            return $format_icons[$format];
        }

    }

    /* get current page url */
    if (!function_exists('adforest_get_current_url')) {

        function adforest_get_current_url() {
            $site_url = site_url();
            $findme = 'https';
            if (strpos($site_url, $findme) !== false) {
                return $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            } else {
                return $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            }
        }

    }

    /* return numbers array */
    if (!function_exists('adforest_addNumbers')) {

        function adforest_addNumbers($r = 20) {
            $numArr = '';
            for ($i = 1; $i <= $r; $i++) {
                $numArr[$i] = $i;
            }
            return $numArr;
        }

    }

    /* check post format if exist */
    if (!function_exists('adforest_post_format_exist')) {

        function adforest_post_format_exist($format = '') {
            $formats = array('', 'image', 'audio', 'video', 'quote');
            if (in_array($format, $formats)) {
                return true;
            } else {
                return false;
            }
        }

    }

    if (!function_exists('adforest_get_cats')) {

        function adforest_get_cats($taxonomy = 'category', $parent_of = 0, $child_of = 0, $type = 'general') {
            global $adforest_theme;
            $search_popup_cat_disable = isset($adforest_theme['search_popup_cat_disable']) ? $adforest_theme['search_popup_cat_disable'] : false;
            $search_popup_loc_disable = isset($adforest_theme['search_popup_loc_disable']) ? $adforest_theme['search_popup_loc_disable'] : false;

            $show_all_terms = FALSE;
            if ($search_popup_cat_disable && $taxonomy == 'ad_cats') {
                $show_all_terms = TRUE;
            }
            if ($search_popup_loc_disable && $taxonomy == 'ad_country') {
                $show_all_terms = TRUE;
            }

            if ($type == 'post_ad') {
                $show_all_terms = FALSE;
            }

            $defaults = array(
                'taxonomy' => $taxonomy,
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => $show_all_terms,
                'exclude' => array(),
                'exclude_tree' => array(),
                'number' => '',
                'offset' => '',
                'fields' => 'all',
                'name' => '',
                'slug' => '',
                'hierarchical' => true,
                'search' => '',
                'name__like' => '',
                'description__like' => '',
                'pad_counts' => false,
                'get' => '',
                'child_of' => $child_of,
                'parent' => $parent_of,
                'childless' => false,
                'cache_domain' => 'core',
                'update_term_meta_cache' => true,
                'meta_query' => ''
            );
            $defaults = apply_filters('adforest_wpml_show_all_posts', $defaults); // for all lang texonomies
            if (taxonomy_exists($taxonomy)) {
                return get_terms($defaults);
            } else {
                return array();
            }
        }

    }

    /* Modifying search form */
    add_filter('get_search_form', 'adforest_search_form');
    if (!function_exists('adforest_search_form')) {

        function adforest_search_form($text) {
            $text = str_replace('<label>', '<div class="search-blog"><div class="input-group stylish-input-group">', $text);
            $text = str_replace('</label>', '<span class="input-group-addon"><button type="submit"> <span class="fa fa-search"></span> </button></span></div></div>', $text);
            $text = str_replace('<span class="screen-reader-text">Search for:</span>', '', $text);
            $text = str_replace('class="search-field"', 'class="form-control" id="serch"', $text);
            return $text;
        }

    }

    /* remove url from excerpt */
    if (!function_exists('adforest_removeURL')) {

        function adforest_removeURL($string) {
            return preg_replace("/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i", '', $string);
        }

    }

    /* Get param value of VC */
    if (!function_exists('adforest_get_param_vc')) {

        function adforest_get_param_vc($break, $string) {
            $arr = explode($break, $string);
            $res = explode(' ', $arr[1]);
            $r = explode('"', $res[0]);
            return $r[1];
        }

    }
    /* Hook in on activation */
    if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        add_action('init', 'adforest_woocommerce_image_dimensions', 1);
    }
    /**  Define image sizes */
    if (!function_exists('adforest_woocommerce_image_dimensions')) {

        function adforest_woocommerce_image_dimensions() {
            $catalog = array('width' => '358', 'height' => '269', 'crop' => 1,);
            $single = array('width' => '396', 'height' => '302', 'crop' => 1,);
            $thumbnail = array('width' => '100', 'height' => '100', 'crop' => 1,);
            /* Image sizes */
            update_option('shop_catalog_image_size', $catalog);   // Product category thumbs
            update_option('shop_single_image_size', $single);   // Single product image
            update_option('shop_thumbnail_image_size', $thumbnail);  // Image gallery thumbs
        }

    }

    /* getting social icon array */
    if (!function_exists('adforest_social_icons')) {

        function adforest_social_icons($social_network) {
            $social_icons = array(
                'Facebook' => 'fa fa-facebook',
                'Twitter' => 'fa fa-twitter ',
                'Linkedin' => 'fa fa-linkedin ',
                'Google' => 'fa fa-google',
                'YouTube' => 'fa fa-youtube-play',
                'Vimeo' => 'fa fa-vimeo ',
                'Pinterest' => 'fa fa-pinterest ',
                'Tumblr' => 'fa fa-tumblr ',
                'Instagram' => 'fa fa-instagram',
                'Reddit' => 'fa fa-reddit ',
                'Flickr' => 'fa fa-flickr ',
                'StumbleUpon' => 'fa fa-stumbleupon',
                'Delicious' => 'fa fa-delicious ',
                'dribble' => 'fa fa-dribbble ',
                'behance' => 'fa fa-behance',
                'DeviantART' => 'fa fa-deviantart',
            );
            return $social_icons[$social_network];
        }

    }

    add_filter('wp_list_categories', 'opportunies_cat_count_span');
    if (!function_exists('opportunies_cat_count_span')) {

        function opportunies_cat_count_span($links) {
            $links = str_replace('</a> (', '</a> <span class="pull-right">(', $links);
            $links = str_replace(')', ')</span>', $links);
            return $links;
        }

    }

    if (!function_exists('adforest_sample_admin_notice_activate')) {

        function adforest_sample_admin_notice_activate() {
            if (get_option('_sb_purchase_code') != "") {
                return;
            }
            ?>
            <div class="notice notice-error is-dismissible">
                <h4><?php echo __('Attention!', 'adforest');?></h4>
                <p><?php echo __('Please Verify your PURCHASE code in order to work this theme.', 'adforest');?></p>
                <p>
                    <?php echo __('Purchase Code:', 'adforest');?>
                    <input type="text" name="adforest_code" id="adforest_code" size="50" />
                    <input type="button" id="verify_it" value="Verify"/>
                </p>
            </div>
            <?php
        }

    }
    add_action('admin_notices', 'adforest_sample_admin_notice_activate');

    add_action('wp_ajax_verify_code', 'adforest_verify_code');
    if (!function_exists('adforest_verify_code')) {

        function adforest_verify_code() {
            $code = $_POST['code'];
            update_option( '_sb_purchase_code', $code ); echo('Looks good, now you can install required plugins.'); die;
            $my_theme = wp_get_theme();
            $theme_name = $my_theme->get('Name');
            $data = "?purchase_code=" . $code . "&id=" . get_option('admin_email') . '&url=' . get_option('siteurl') . '&theme_name=' . $theme_name;
            $url = esc_url("http://authenticate.scriptsbundle.com/adforest/verify_code.php") . $data;
            $response = wp_remote_get($url);
            $res = $response['body'];
            if ($res == 'verified') {
                update_option('_sb_purchase_code', $code);
                echo('Looks good, now you can install required plugins.');
            } else {
                echo('Invalid valid purchase code.');
            }
            die();
        }

    }

    if (!function_exists('adforest_make_link')) {

        function adforest_make_link($url, $text) {
            return wp_kses("<a href='" . esc_url($url) . "' target='_blank'>", adforest_required_tags()) . $text . wp_kses('</a>', adforest_required_tags());
        }

    }

    /* Translation */
    if (!function_exists('adforest_translate')) {

        function adforest_translate($index) {
            $strings = array(
                'variation_not_available' => __('This product is currently out of stock and unavailable.', 'adforest'),
                'adding_to_cart' => __('Adding...', 'adforest'),
                'add_to_cart' => __('add to cart', 'adforest'),
                'view_cart' => __('View Cart', 'adforest'),
                'cart_success_msg' => __('Product Added successfully.', 'adforest'),
                'cart_success' => __('Success', 'adforest'),
                'cart_error_msg' => __('Something went wrong, please try it again.', 'adforest'),
                'cart_error' => __('Error', 'adforest'),
                'email_error_msg' => __('Please add valid email.', 'adforest'),
                'mc_success_msg' => __('Thank you, we will get back to you.', 'adforest'),
                'mc_error_msg' => __('There is some error, please check your API-KEY and LIST-ID.', 'adforest'),
            );
            return $strings[$index];
        }

    }

    if (!function_exists('adforest_get_comments')) {

        function adforest_get_comments() {
            echo get_comments_number() . " " . __('comments', 'adforest');
        }

    }

    if (!function_exists('adforest_get_date')) {

        function adforest_get_date($PID) {
            echo get_the_date(get_option('date_format'), $PID);
        }

    }

    if (isset($_GET['post_status']) && $_GET['post_status'] == 'trash' && $_GET['post_type'] == '_sb_country') {
        add_action('admin_notices', 'adforest_notice_for_delete_country');
    }

    if (!function_exists('adforest_notice_for_delete_country')) {

        function adforest_notice_for_delete_country() {
            ?>
            <div class="notice notice-info">
                <strong><p><?php echo __('If you delete country permanently then all associated states and cities will be deleted with it.', 'adforest');?></p></strong>
            </div>	
            <?php
        }

    }

    if (isset($_GET['post_type'])) {
        if ($_GET['post_type'] == '_sb_country') {
            add_action('admin_notices', 'adforest_notice_for_add_country');
        }
    }

    if (!function_exists('adforest_notice_for_add_country')) {

        function adforest_notice_for_add_country() {
            ?>
            <div class="notice notice-info">
                <p><?php echo __('Must need to aad country NAME as google list like United Arab Emirates, check it', 'adforest');?>
                    <a href="https://developers.google.com/public-data/docs/canonical/countries_csv" target="_blank">
                        <strong><?php echo __('HERE', 'adforest');?></strong>
                    </a>
                </p>
            </div>	
            <?php
        }

    }

    if (!function_exists('adforest_redirect')) {

        function adforest_redirect($url = '') {
            return "<script> var red_url = decodeURI('{$url}'); window.location = red_url;console.log(red_url);</script>";
        }

    }

    add_action('init', 'adforest_StartSession', 1);
    if (!function_exists('adforest_StartSession')) {

        function adforest_StartSession() {
            /* if(!session_id()) { session_start(); } */
        }

    }

    /* Bad word filter */
    if (!function_exists('adforest_badwords_filter')) {

        function adforest_badwords_filter($words = array(), $string, $replacement) {
            foreach ($words as $word) {
                $string = preg_replace('/\b' . $word . '\b/i', $replacement, $string);
            }
            return $string;
        }

    }

    /* Post statuses */
    if (!function_exists('adforest_ad_statues')) {

        function adforest_ad_statues($index) {
            if ($index == "")
                $index = 'active';
            $sb_status = array('active' => __('Active', 'adforest'), 'expired' => __('Expired', 'adforest'), 'sold' => __('Sold', 'adforest'));
            return $sb_status[$index];
        }

    }

    /* Time Ago */
    if (!function_exists('adforest_timeago')) {

        function adforest_timeago($date) {

            adforest_set_date_timezone();
            $timestamp = strtotime($date);

            $strTime = array(__('second', 'adforest'), __('minute', 'adforest'), __('hour', 'adforest'), __('day', 'adforest'), __('month', 'adforest'), __('year', 'adforest'));
            $length = array("60", "60", "24", "30", "12", "10");

            //$currentTime = time();
            $currentTime = current_time('mysql', 1);
            //$currentTime = date('Y-m-d H:i:s');
            $currentTime = strtotime($currentTime);
            if ($currentTime >= $timestamp) {
                $diff = $currentTime - $timestamp;
                for ($i = 0; $diff >= $length[$i] && $i < count($length) - 1; $i++) {
                    $diff = $diff / $length[$i];
                }

                $diff = round($diff);
                return $diff . " " . $strTime[$i] . __('(s) ago', 'adforest');
            }
        }

    }

    /*
     * set timezone selected in theme options
     */

    if (!function_exists('adforest_set_date_timezone')) {

        function adforest_set_date_timezone() {
            global $adforest_theme;
            $time_zones_val = isset($adforest_theme['bid_timezone']) && $adforest_theme['bid_timezone'] != '' ? $adforest_theme['bid_timezone'] : 'Etc/UTC';
            if (function_exists('adforest_timezone_list') && isset($adforest_theme['bid_timezone']) && $adforest_theme['bid_timezone'] != '') {
                $time_zones_val = adforest_timezone_list('', $adforest_theme['bid_timezone']);
                if (!is_admin()) {
                    date_default_timezone_set($time_zones_val);
                }
            } else {
                $time_zones_val = 'Etc/UTC';
                date_default_timezone_set($time_zones_val);
            }
        }

    }
    /* Redirect */
    if (!function_exists('adforest_redirect_with_msg')) {

        function adforest_redirect_with_msg($url, $msg = '') {
            echo '
		<script type="text/javascript" src="' . trailingslashit(get_template_directory_uri()) . 'js/toastr.min.js"></script>
		<script type="text/javascript">
				toastr.error("' . $msg . '", "", {timeOut: 2500,"closeButton": true, "positionClass": "toast-top-right"});
				window.location	=	"' . $url . '";
			</script>';
            exit;
        }

    }

    /* Time difference n days */
    if (!function_exists('adforest_days_diff')) {

        function adforest_days_diff($now, $from) {
            $datediff = $now - $from;
            return floor($datediff / (60 * 60 * 24));
        }

    }

    /* Color of Ads */
    if (!function_exists('adforest_ads_status_color')) {

        function adforest_ads_status_color($status) {
            if ($status == "") {
                return;
            }
            $colors = array('active' => 'status_active', 'expired' => 'status_expired', 'sold' => 'status_sold');
            return $colors[$status];
        }

    }

    /* adforest search params */
    if (!function_exists('adforest_custom_remove_url_query')) {

        function adforest_custom_remove_url_query($key = '', $value = '') {
            $url = adforest_curPageURL();
            $param = "?" . $_SERVER['QUERY_STRING'];
            $url = preg_replace('/(?:&|(\?))' . $key . '=[^&]*(?(1)&|)?/i', "$1", $param);
            $url = rtrim($url, '?');
            $url = rtrim($url, '&');
            $final_url = ( $url != "" ) ? $url . "&$key=$value" : "?$key=$value";
            return $final_url;
        }

    }
    if (!function_exists('adforest_curPageURL')) {

        function adforest_curPageURL() {
            $pageURL = 'http';
            if (isset($_SERVER["HTTPS"]))
                if ($_SERVER["HTTPS"] == "on") {
                    $pageURL .= "s";
                }
            $pageURL .= "://";
            if ($_SERVER["SERVER_PORT"] != "80") {
                $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
            } else {
                $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
            }
            return $pageURL;
        }

    }

    if (!function_exists('adforest_validateDateFormat')) {

        function adforest_validateDateFormat($date, $format = 'Y-m-d') {
            $d = DateTime::createFromFormat($format, $date);
            // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
            return $d && $d->format($format) === $date;
        }

    }

    if (!function_exists('adforest_search_params')) {

        function adforest_search_params($index, $second = '', $third = '', $search_url = false) {
            global $adforest_theme;
            $param = $_SERVER['QUERY_STRING'];
            $res = '';
            //if (isset($param) && $index != 'cat_id' && $index != 'country_id') {
            if (isset($param)) {
                parse_str($_SERVER['QUERY_STRING'], $vars);
                foreach ($vars as $key => $val) {
                    if ($key == $index) {
                        continue;
                    }

                    if ($second != "") {
                        if ($key == $second) {
                            continue;
                        }
                    }
                    if ($third != "") {
                        if ($key == $third) {
                            continue;
                        }
                    }

                    if (isset($vars['custom']) && count($vars['custom']) > 0 && 'custom' == $key) {


                        if (is_array($val)) {
                            if (isset($val) && count($val) > 0) {
                                foreach ($val as $ckey => $cval) {
                                    $name = "custom[$ckey]";
                                    if ($name == $index) {
                                        continue;
                                    }
                                    if (isset($cval) && is_array($cval)) {
                                        foreach ($cval as $v) {
                                            $res .= '<input type="hidden" name="' . esc_attr($name) . '[]" value="' . esc_attr($v) . '" />';
                                        }
                                    } else {
                                        $res .= '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr($cval) . '" />';
                                    }
                                }
                            }
                        } else {

                            foreach ($vars['custom'] as $ckey => $cval) {
                                $name = "custom[$ckey]";
                                if ($name == $index) {
                                    continue;
                                }
                                $res .= '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr($cval) . '" />';
                            }
                        }
                    } else if (isset($vars['min_custom']) && count((array) $vars['min_custom']) > 0 && 'min_custom' == $key) {
                        foreach ($vars['min_custom'] as $ckey => $cval) {
                            $name = "min_custom[$ckey]";
                            if ($name == "min_" . $index) {
                                continue;
                            }
                            if ($name == $index) {
                                continue;
                            }
                            $res .= '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr($cval) . '" />';
                        }
                    } else if (isset($vars['max_custom']) && count((array) $vars['max_custom']) > 0 && 'max_custom' == $key) {
                        foreach ($vars['max_custom'] as $ckey => $cval) {
                            $name = "max_custom[$ckey]";
                            if ($name == "max_" . $index) {
                                continue;
                            }
                            if ($name == $second) {
                                continue;
                            }
                            $res .= '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr($cval) . '" />';
                        }
                    } else {
                        $res .= '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($val) . '" />';
                    }
                }
            } else if ($search_url) {
                $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
                $res = get_the_permalink($sb_search_page);
            }
            return $res;
        }

    }

    /* Get parents of custom taxonomy */
    if (!function_exists('adforest_get_taxonomy_parents')) {

        function adforest_get_taxonomy_parents($id, $taxonomy, $link = true, $separator = ' &raquo; ', $nicename = false, $visited = array()) {

            $chain = '';
            $parent = get_term($id, $taxonomy);
            if (is_wp_error($parent)) {
                echo "fail";
                return $parent;
            }

            if (!isset($parent) || empty($parent)) {
                return;
            }

            if ($nicename) {
                $name = $parent->slug;
            } else {
                $name = $parent->name;
            }

            if ($parent->parent && ($parent->parent != $parent->term_id) && !in_array($parent->parent, $visited)) {
                $visited[] = $parent->parent;
                $chain .= adforest_get_taxonomy_parents($parent->parent, $taxonomy, $link, $separator, $nicename, $visited);
            }

            if ($link) {
                $chain .= '<a href="' . esc_url(get_term_link((int) $parent->term_id, $taxonomy)) . '" title="' . esc_attr(sprintf(__("View all posts in %s", 'adforest'), $parent->name)) . '">' . $name . '</a>' . $separator;
            } else {
                $chain .= $separator . $name;
            }
            return $chain;
        }

    }

    if (!function_exists('adforest_display_cats')) {

        function adforest_display_cats($pid) {
            $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
            $cats_html = '';
            foreach ($post_categories as $c) {
                $cat = get_term($c);
                $cats_html .= '<span class="padding_cats"><a href="' . get_term_link($cat->term_id) . '">' . esc_html($cat->name) . '</a></span>';
            }
            return $cats_html;
        }

    }

    if (!function_exists('adforest_removeCPTCommentsFromWidget')) {

        function adforest_removeCPTCommentsFromWidget($example) {
            $ar = array('post_type' => 'post');
            return $ar;
        }

    }
    add_filter('widget_comments_args', 'adforest_removeCPTCommentsFromWidget');

    /* Allow Pending products to be viewed by listing/product owner */
    if (!function_exists('posts_for_current_author')) {

        function posts_for_current_author($query) {
            if (isset($_GET['post_type']) && $_GET['post_type'] == "ad_post" && isset($_GET['p'])) {
                $post_id = $_GET['p'];
                $post_author = get_post_field('post_author', $post_id);
                if (is_user_logged_in() && get_current_user_id() == $post_author) {
                    $query->set('post_status', array('publish', 'pending', 'draft'));
                    return $query;
                } else {
                    return $query;
                }
            } else {
                return $query;
            }
        }

    }
    add_filter('pre_get_posts', 'posts_for_current_author');

    if (!function_exists('adforest_get_all_countries')) {

        function adforest_get_all_countries() {

            $res = array();

            if (!is_admin()) {
                return $res;
            }

            $args = array(
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC',
                'post_type' => '_sb_country',
                'post_status' => 'publish',
            );
            $countries = get_posts($args);

            foreach ($countries as $country) {
                $stripped = trim(preg_replace('/\s+/', ' ', $country->post_excerpt));
                $res[$stripped] = $country->post_title;
            }
            return $res;
        }

    }

    if (!function_exists('adforest_adPrice')) {

        function adforest_adPrice($id = '', $class = 'negotiable') {
            if (get_post_meta($id, '_adforest_ad_price', true) == "" && get_post_meta($id, '_adforest_ad_price_type', true) == "on_call") {
                return __("Price On Call", 'adforest');
            }
            if (get_post_meta($id, '_adforest_ad_price', true) == "" && get_post_meta($id, '_adforest_ad_price_type', true) == "free") {
                return __("Free", 'adforest');
            }

            if (get_post_meta($id, '_adforest_ad_price', true) == "" || get_post_meta($id, '_adforest_ad_price_type', true) == "no_price") {
                return '';
            }

            $price = 0;
            global $adforest_theme;
            $thousands_sep = ",";
            if (isset($adforest_theme['sb_price_separator']) && $adforest_theme['sb_price_separator'] != "") {
                $thousands_sep = $adforest_theme['sb_price_separator'];
            }
            $decimals = 0;
            if (isset($adforest_theme['sb_price_decimals']) && $adforest_theme['sb_price_decimals'] != "") {
                $decimals = $adforest_theme['sb_price_decimals'];
            }
            $decimals_separator = ".";
            if (isset($adforest_theme['sb_price_decimals_separator']) && $adforest_theme['sb_price_decimals_separator'] != "") {
                $decimals_separator = $adforest_theme['sb_price_decimals_separator'];
            }
            $curreny = $adforest_theme['sb_currency'];
            if (get_post_meta($id, '_adforest_ad_currency', true) != "") {
                $curreny = get_post_meta($id, '_adforest_ad_currency', true);
            }

            if ($id != "") {
                if (is_numeric(get_post_meta($id, '_adforest_ad_price', true))) {
                    $price = number_format(get_post_meta($id, '_adforest_ad_price', true), $decimals, $decimals_separator, $thousands_sep);
                }

                $price = ( isset($price) && $price != "") ? $price : 0;

                if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right') {
                    $price = $price . $curreny;
                } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right_with_space') {
                    $price = $price . " " . $curreny;
                } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left') {
                    $price = $curreny . $price;
                } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left_with_space') {
                    $price = $curreny . " " . $price;
                } else {
                    $price = $curreny . $price;
                }
            }
            // Price type fixed or ...
            $price_type_html = '';
            if (get_post_meta($id, '_adforest_ad_price_type', true) != "" && isset($adforest_theme['allow_price_type']) && $adforest_theme['allow_price_type']) {
                $price_type = '';
                if (get_post_meta($id, '_adforest_ad_price_type', true) == 'Fixed') {
                    $price_type = __('Fixed', 'adforest');
                } else if (get_post_meta($id, '_adforest_ad_price_type', true) == 'Negotiable') {
                    $price_type = __('Negotiable', 'adforest');
                } else if (get_post_meta($id, '_adforest_ad_price_type', true) == 'auction') {
                    $price_type = __('Auction', 'adforest');
                } else {
                    $price_type = get_post_meta($id, '_adforest_ad_price_type', true);
                }
                $price_type_html = '<span class="' . esc_attr($class) . '">&nbsp(' . $price_type . ')</span>';
            }

            return $price . $price_type_html;
        }

    }

    if (!function_exists('adforest_get_static_form')) {

        function adforest_get_static_form($term_id = '', $post_id = '') {
            $html = '';
            $display_size = '';
            $price = '';
            $required = '';
            global $adforest_theme;
            $size_arr = explode('-', $adforest_theme['sb_upload_size']);
            $display_size = $size_arr[1];
            $actual_size = $size_arr[0];


            $_sb_video_links = get_user_meta(get_current_user_id(), '_sb_video_links', true);
            $_sb_allow_tags = get_user_meta(get_current_user_id(), '_sb_allow_tags', true);


            if (!apply_filters('adforest_directory_enabled', false)) {
                // Get Price Field , 
                $vals[] = array(
                    'type' => 'select',
                    'post_meta' => '_adforest_ad_type',
                    'is_show' => '_sb_default_cat_ad_type_show',
                    'is_req' => '_sb_default_cat_ad_type_required',
                    'main_title' => __('Type of Ad', 'adforest'),
                    'sub_title' => '',
                    'field_name' => 'buy_sell',
                    'field_id' => 'buy_sell',
                    'field_value' => '',
                    'field_req' => 1,
                    'cat_name' => 'ad_type',
                    'field_class' => ' category ',
                    'columns' => '12',
                    'data-parsley-type' => '',
                    'data-parsley-message' => __('This field is required.', 'adforest'),
                );
            }

            $currency_msg = $adforest_theme['sb_currency'] . " " . __('only', 'adforest');
            $currenies = adforest_get_cats('ad_currency', 0);
            if (count($currenies) > 0) {
                $currency_msg = '';
            }

            $sb_price_types_strings = array('Fixed' => __('Fixed', 'adforest'), 'Negotiable' => __('Negotiable', 'adforest'), 'on_call' => __('Price on call', 'adforest'), 'auction' => __('Auction', 'adforest'), 'free' => __('Free', 'adforest'), 'no_price' => __('No price', 'adforest'));

            $new_types_array = array();
            if (isset($adforest_theme['sb_price_types']) && count($adforest_theme['sb_price_types']) > 0) {
                $sb_price_types = $adforest_theme['sb_price_types'];
            } else if (isset($adforest_theme['sb_price_types']) && count($adforest_theme['sb_price_types']) == 0 && isset($adforest_theme['sb_price_types_more']) && $adforest_theme['sb_price_types_more'] == "") {
                $sb_price_types = array('Fixed', 'Negotiable', 'on_call', 'auction', 'free', 'no_price');
            } else {
                $sb_price_types = array();
            }

            $sb_price_types_html = '';
            foreach ($sb_price_types as $p_val) {
                $new_types_array[$p_val] = $sb_price_types_strings[$p_val];
            }
            if (isset($adforest_theme['sb_price_types_more']) && $adforest_theme['sb_price_types_more'] != "") {
                $sb_price_types_more_array = explode('|', $adforest_theme['sb_price_types_more']);
                foreach ($sb_price_types_more_array as $p_type_more) {
                    $new_types_array[str_replace(' ', '_', $p_type_more)] = $p_type_more;
                }
            }


            $vals[] = array(
                'type' => 'select_custom',
                'post_meta' => '_adforest_ad_price_type',
                'is_show' => '_sb_default_cat_price_type_show',
                'is_req' => '_sb_default_cat_price_type_required',
                'main_title' => __('Price Type', 'adforest'),
                'sub_title' => '',
                'field_name' => 'ad_price_type',
                'field_id' => 'ad_price_type',
                'field_value' => $new_types_array,
                'field_req' => $required,
                'cat_name' => '',
                'field_class' => ' category ',
                'columns' => '12',
                'data-parsley-type' => '',
                'data-parsley-message' => __('This field is required.', 'adforest'),
            );

            $currenies = adforest_get_cats('ad_currency', 0);
            if (isset($currenies) && count($currenies) > 0) {
                $vals[] = array(
                    'type' => 'select',
                    'post_meta' => '_adforest_ad_currency',
                    'is_show' => '_sb_default_cat_price_show',
                    'is_req' => '_sb_default_cat_price_required',
                    'main_title' => __('Currency', 'adforest'),
                    'sub_title' => '',
                    'field_name' => 'ad_currency',
                    'field_id' => 'ad_currency',
                    'field_value' => '',
                    'field_req' => $required,
                    'cat_name' => 'ad_currency',
                    'field_class' => ' category curreny_class',
                    'columns' => '12',
                    'data-parsley-type' => '',
                    'data-parsley-message' => __('This field is required.', 'adforest'),
                );
            }

            if (!apply_filters('adforest_directory_enabled', false)) {
                $vals[] = array(
                    'type' => 'textfield',
                    'post_meta' => '_adforest_ad_price',
                    'is_show' => '_sb_default_cat_price_show',
                    'is_req' => '_sb_default_cat_price_required',
                    'main_title' => __('Price', 'adforest'),
                    'sub_title' => $currency_msg,
                    'field_name' => 'ad_price',
                    'field_id' => 'ad_price',
                    'field_value' => $price,
                    'field_req' => $required,
                    'cat_name' => '',
                    'field_class' => '',
                    'columns' => '12',
                    'data-parsley-type' => 'digits',
                    'data-parsley-message' => __('Can\'t be empty and only integers allowed.', 'adforest'),
                );
            } else {
                $vals = apply_filters('adforest_directory_template_ad_post_price', $vals);
            }

            if (isset($_sb_video_links) && !empty($_sb_video_links) && $_sb_video_links == 'no') {
                
            } else {

                if ($required) {
                    $valid_text = __('This field is required and should be valid youtube video url.', 'adforest');
                } else {
                    $valid_text = __('Should be valid youtube video url.', 'adforest');
                }


                $vals[] = array(
                    'type' => 'textfield',
                    'post_meta' => '_adforest_ad_yvideo',
                    'is_show' => '_sb_default_cat_video_show',
                    'is_req' => '_sb_default_cat_video_required',
                    'main_title' => __('Youtube Video Link', 'adforest'),
                    'sub_title' => '',
                    'field_name' => 'ad_yvideo',
                    'field_id' => 'ad_yvideo',
                    'field_value' => '',
                    'field_req' => $required,
                    'cat_name' => '',
                    'field_class' => '',
                    'columns' => '12',
                    'data-parsley-type' => 'url',
                    'data-parsley-pattern' => '/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/',
                    'data-parsley-message' => $valid_text,
                );
            }

            if (!apply_filters('adforest_directory_enabled', false)) {
                $vals[] = array(
                    'type' => 'select',
                    'post_meta' => '_adforest_ad_condition',
                    'is_show' => '_sb_default_cat_condition_show',
                    'is_req' => '_sb_default_cat_condition_required',
                    'main_title' => __('Item Condition', 'adforest'),
                    'sub_title' => '',
                    'field_name' => 'condition',
                    'field_id' => 'condition',
                    'field_value' => '',
                    'field_req' => $required,
                    'cat_name' => 'ad_condition',
                    'field_class' => ' category ',
                    'columns' => '12',
                    'data-parsley-type' => '',
                    'data-parsley-message' => __('This field is required.', 'adforest'),
                );
                $vals[] = array(
                    'type' => 'select',
                    'post_meta' => '_adforest_ad_warranty',
                    'is_show' => '_sb_default_cat_warranty_show',
                    'is_req' => '_sb_default_cat_warranty_required',
                    'main_title' => __('Item Warranty', 'adforest'),
                    'sub_title' => '',
                    'field_name' => 'ad_warranty',
                    'field_id' => 'warranty',
                    'field_value' => '',
                    'field_req' => $required,
                    'cat_name' => 'ad_warranty',
                    'field_class' => ' category ',
                    'columns' => '12',
                    'data-parsley-type' => '',
                    'data-parsley-message' => __('This field is required.', 'adforest'),
                );
            }

            $vals[] = array(
                'type' => 'image',
                'post_meta' => '',
                'is_show' => '_sb_default_cat_image_show',
                'is_req' => '_sb_default_cat_image_required',
                'main_title' => __('Click the box below to ad photos!', 'adforest'),
                'sub_title' => __('upload only jpg, png and jpeg files with a max file size of ', 'adforest') . $display_size,
                'field_name' => 'dropzone',
                'field_id' => 'dropzone',
                'field_value' => '',
                'field_req' => $required,
                'cat_name' => '',
                'field_class' => ' dropzone ',
                'columns' => '12',
                'data-parsley-type' => '',
                'data-parsley-message' => __('This field is required.', 'adforest'),
            );

            if (isset($_sb_allow_tags) && !empty($_sb_allow_tags) && $_sb_allow_tags == 'no') {
                
            } else {
                $vals[] = array(
                    'type' => 'textfield',
                    'post_meta' => '',
                    'is_show' => '_sb_default_cat_tags_show',
                    'is_req' => '_sb_default_cat_tags_required',
                    'main_title' => __('Tags', 'adforest'),
                    'sub_title' => __('Comma(,) separated', 'adforest'),
                    'field_name' => 'tags',
                    'field_id' => 'tags',
                    'field_value' => '',
                    'field_req' => $required,
                    'cat_name' => 'ad_tags',
                    'field_class' => '',
                    'columns' => '12',
                    'data-parsley-type' => '',
                    'data-parsley-message' => __('This field is required.', 'adforest'),
                );
            }

            foreach ($vals as $val) {
                $type = $val['type'];
                $html .= adforest_return_input($type, $post_id, $term_id, $val);
            }

            return $html;
        }

    }

    if (!function_exists('adforest_html_bidding_system')) {

        function adforest_html_bidding_system($pid, $bid_style = 'style-1') {
            global $adforest_theme;


            if ($bid_style == 'style-2') {
                ?>

                <div class="col-lg-12 col-xs-12 col-xl-12 col-xs-12">
                    <div class="row">
                        <div class="ad-allbids">
                            <div class="heading-panel">
                                <div class="ad-detail-6-title">
                                    <?php echo esc_html($adforest_theme['sb_comments_section_title']);?>
                                </div>
                            </div>
                            <?php echo adforest_bidding_html($pid, 'style-2');?> 

                        </div>

                    </div>
                </div>

                <div class="col-lg-12 col-xs-12 col-sm-12 col-xs-12 bd-style" id="bids">
                    <div class="row">
                        <?php
                        $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true); // '2018-03-16 14:59:00';
                        if ($bid_end_date != "" && date('Y-m-d H:i:s') > $bid_end_date && isset($adforest_theme['bidding_timer']) && $adforest_theme['bidding_timer']) {
                            echo '<em>' . __('Bidding has been closed.', 'adforest') . '</em>';
                        } else {
                            ?>
                            <form role="form" id="sb_bid_ad" class="sb-form-wrap">
                                <div class="col-lg-2 col-md-2">
                                    <div class="row">
                                        <input name="bid_amount" placeholder="<?php echo __('Bid', 'adforest');?>" class="form-control" type="text" data-parsley-required="true" data-parsley-pattern="/^[0-9]+\.?[0-9]*$/" data-parsley-error-message="<?php echo __('only numbers allowed.', 'adforest');?>" autocomplete="off" maxlength="12"/>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8">
                                    <div class="row">  
                                        <input name="bid_comment" data-parsley-required="true" data-parsley-error-message="<?php echo __('This field is required.', 'adforest');?>" placeholder="<?php echo __('Comments...', 'adforest');?>" class="form-control" type="text" autocomplete="off">
                                        <small><em><?php echo esc_html($adforest_theme['sb_comments_section_note']);?></em></small>
                                    </div>
                                </div>  
                                <div class="col-lg-2 col-md-2">
                                    <div class="row">
                                        <button class="btn-bid-2 btn btn-theme form-group" type="submit"><?php echo __('Send', 'adforest');?></button>
                                        <input type="hidden" name="ad_id" value="<?php echo esc_attr($pid)?>" />
                                        <input type="hidden" id="sb-bidding-token" value="<?php echo wp_create_nonce('sb_bidding_secure');?>" />
                                    </div>
                                </div>
                            </form>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="list-style-1 margin-top-30">
                    <div class="panel with-nav-tabs panel-default">
                        <div class="panel-heading">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab2default" data-toggle="tab" aria-expanded="false">
                                        <?php echo esc_html($adforest_theme['sb_comments_section_title']);?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="panel-body" >
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="tab2default">
                                    <div class="bidding" style=" position: relative; overflow: hidden; max-height:325px;">
                                        <?php echo adforest_bidding_html($pid);?> 
                                    </div>
                                    <div class="chat-form ">
                                        <?php
                                        $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true); // '2018-03-16 14:59:00';
                                        if ($bid_end_date != "" && date('Y-m-d H:i:s') > $bid_end_date && isset($adforest_theme['bidding_timer']) && $adforest_theme['bidding_timer']) {
                                            echo '<em>' . __('Bidding has been closed.', 'adforest') . '</em>';
                                        } else {
                                            ?>
                                            <form role="form" id="sb_bid_ad" >

                                                <?php
                                                $col = 8;
                                                ?>
                                                <div class="col-md-2 margin-bottom-10">
                                                    <input name="bid_amount" placeholder="<?php echo __('Bid', 'adforest');?>" class="form-control" type="text" data-parsley-required="true" data-parsley-pattern="/^[0-9]+\.?[0-9]*$/" data-parsley-error-message="<?php echo __('only numbers allowed.', 'adforest');?>" autocomplete="off" maxlength="12"/>
                                                </div>
                                                <div class="col-md-<?php echo esc_attr($col);?> margin-bottom-10">   
                                                    <input name="bid_comment" data-parsley-required="true" data-parsley-error-message="<?php echo __('This field is required.', 'adforest');?>" placeholder="<?php echo __('Comments...', 'adforest');?>" class="form-control" type="text" autocomplete="off">
                                                    <small><em><?php echo esc_html($adforest_theme['sb_comments_section_note']);?></em></small>
                                                </div>   
                                                <div class="col-md-2">
                                                    <button class="btn btn-theme" type="submit"><?php echo __('Send', 'adforest');?></button>
                                                    <input type="hidden" name="ad_id" value="<?php echo esc_attr($pid)?>" />
                                                    <input type="hidden" id="sb-bidding-token" value="<?php echo wp_create_nonce('sb_bidding_secure');?>" />
                                                </div>
                                            </form>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }

    }

    if (!function_exists('adforest_get_feature_text')) {

        function adforest_get_feature_text($pid) {
            ?>
            <div role="alert" class="alert alert-info alert-dismissible <?php echo adforest_alert_type();?>">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&#10005;</span></button>
                <?php echo __('Mark as featured Ad,', 'adforest');?>
                <a href="javascript:void(0);" class="sb_anchor" data-btn-ok-label="<?php echo __('Yes', 'adforest');?>" data-btn-cancel-label="<?php echo __('No', 'adforest');?>" data-toggle="confirmation" data-singleton="true" data-title="<?php echo __('Are you sure?', 'adforest');?>" data-content="" id="sb_feature_ad" aaa_id="<?php echo esc_attr($pid);?>">
                    <?php echo __('Click Here.', 'adforest');?>
                </a>
            </div>
            <?php
        }

    }

    add_filter('register_post_type_args', 'adforest_register_post_type_args', 10, 2);
    if (!function_exists('adforest_register_post_type_args')) {

        function adforest_register_post_type_args($args, $post_type) {
            $adforest_theme_values = get_option('adforest_theme');
            if (isset($adforest_theme_values['sb_url_rewriting_enable']) && $adforest_theme_values['sb_url_rewriting_enable'] && isset($adforest_theme_values['sb_ad_slug']) && $adforest_theme_values['sb_ad_slug'] != "") {

                if ('ad_post' === $post_type) {
                    $old_slug = 'ad';
                    if (get_option('sb_ad_old_slug') != "") {
                        $old_slug = get_option('sb_ad_old_slug');
                    }
                    $args['rewrite']['slug'] = $adforest_theme_values['sb_ad_slug'];
                    update_option('sb_ad_old_slug', $adforest_theme_values['sb_ad_slug']);
                    if (($current_rules = get_option('rewrite_rules'))) {
                        foreach ($current_rules as $key => $val) {
                            if (strpos($key, $old_slug) !== false) {
                                add_rewrite_rule(str_ireplace($old_slug, $adforest_theme_values['sb_ad_slug'], $key), $val, 'top');
                            }
                        }
                        flush_rewrite_rules();
                    }
                }
            }

            return $args;
        }

    }

    if (!function_exists('adforest_change_taxonomies_slug')) {

        function adforest_change_taxonomies_slug($args, $taxonomy) {
            /* item category */
            $adforest_theme_values = get_option('adforest_theme');
            if (isset($adforest_theme_values['sb_url_rewriting_enable_cat']) && $adforest_theme_values['sb_url_rewriting_enable_cat'] && isset($adforest_theme_values['sb_cat_slug']) && $adforest_theme_values['sb_cat_slug'] != "") {
                if ('ad_cats' === $taxonomy) {
                    $args['rewrite']['slug'] = $adforest_theme_values['sb_cat_slug'];
                }
            }
            if (isset($adforest_theme_values['sb_url_rewriting_enable_location']) && $adforest_theme_values['sb_url_rewriting_enable_location'] && isset($adforest_theme_values['sb_ad_location_slug']) && $adforest_theme_values['sb_ad_location_slug'] != "") {
                if ('ad_country' === $taxonomy) {
                    $args['rewrite']['slug'] = $adforest_theme_values['sb_ad_location_slug'];
                }
            }
            if (isset($adforest_theme_values['sb_url_rewriting_enable_ad_tags']) && $adforest_theme_values['sb_url_rewriting_enable_ad_tags'] && isset($adforest_theme_values['sb_ad_tags_slug']) && $adforest_theme_values['sb_ad_tags_slug'] != "") {
                if ('ad_tags' === $taxonomy) {
                    $args['rewrite']['slug'] = $adforest_theme_values['sb_ad_tags_slug'];
                }
            }
            return $args;
        }

    }
    add_filter('register_taxonomy_args', 'adforest_change_taxonomies_slug', 10, 2);

    if (!function_exists('adforest_video_icon')) {

        function adforest_video_icon($is_grid2 = false, $class = 'play-video', $icon_class = 'fa fa-play-circle-o') {
            global $adforest_theme;

            $fet_cls = '';
            if ($is_grid2 && get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $fet_cls = 'video_position';
            }

            if (isset($adforest_theme['sb_video_icon']) && $adforest_theme['sb_video_icon'] && get_post_meta(get_the_ID(), '_adforest_ad_yvideo', true)) {
                return '<a href="' . get_post_meta(get_the_ID(), '_adforest_ad_yvideo', true) . '" class="' . esc_attr($class) . ' ' . esc_attr($fet_cls) . '"><i class="' . $icon_class . '"></i></a>';
            }
        }

    }

    if (!function_exists('adforest_randomString')) {

        function adforest_randomString($length = 50) {
            $str = "";
            $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
            $max = count($characters) - 1;
            for ($i = 0; $i < $length; $i++) {
                $rand = mt_rand(0, $max);
                $str .= $characters[$rand];
            }
            return $str;
        }

    }

    if (!function_exists('adforest_alert_type')) {

        function adforest_alert_type() {
            global $adforest_theme;
            $type = '';
            if (isset($adforest_theme['design_type']) && $adforest_theme['design_type'] == 'modern') {
                $type = 'alert-outline';
            }
            return $type;
        }

    }

    if (!function_exists('adforest_search_layout')) {

        function adforest_search_layout() {
            global $adforest_theme, $template;
            $widget_layout = 'sidebar';
            if (isset($adforest_theme['design_type']) && $adforest_theme['design_type'] == 'modern' && isset($adforest_theme['search_design']) && $adforest_theme['search_design'] == 'topbar') {
                $widget_layout = 'topbar';
            } else if (isset($adforest_theme['design_type']) && $adforest_theme['design_type'] == 'modern' && isset($adforest_theme['search_design']) && $adforest_theme['search_design'] == 'map') {
                $widget_layout = 'map';
            }

            $page_template = basename($template);
            if ($page_template == 'taxonomy-ad_cats.php' || $page_template == 'taxonomy-ad_country.php') {
                $widget_layout = 'sidebar';
            }


            return $widget_layout;
        }

    }

    if (!function_exists('adforest_widget_counter')) {

        function adforest_widget_counter($return = false) {
            global $adforest_theme;
            @$GLOBALS['widget_counter'] += 1;
            if ($GLOBALS['widget_counter'] == $adforest_theme['search_widget_limit']) {
                if ($return)
                    return '<a href="javascript:void(0);" class="adv-srch">' . __('Advance Search', 'adforest') . '</a>';
                else
                    echo '<a href="javascript:void(0);" class="adv-srch">' . __('Advance Search', 'adforest') . '</a>';
            }
        }

    }

    if (!function_exists('adforest_advance_search_container')) {

        function adforest_advance_search_container($return = false) {
            global $adforest_theme;
            if ($GLOBALS['widget_counter'] == $adforest_theme['search_widget_limit']) {
                if ($return)
                    return '<div class="hide_adv_search">';
                else
                    echo '<div class="hide_adv_search">';
            }
        }

    }

    if (!function_exists('adforest_advance_search_map_container_open')) {

        function adforest_advance_search_map_container_open($return = false) {
            global $adforest_theme;
            if (@$GLOBALS['widget_counter'] % 3 == 0) {
                if ($return)
                    return '<div class="seprator"><div class="row">';
                else
                    echo '<div class="seprator"><div class="row">';
            }
        }

    }

    if (!function_exists('adforest_advance_search_map_container_close')) {

        function adforest_advance_search_map_container_close($return = false) {
            global $adforest_theme;
            if ($GLOBALS['widget_counter'] % 3 == 0) {
                if ($return)
                    return '</div></div>';
                else
                    echo '</div></div>';
            }
        }

    }

    if (!function_exists('adforest_get_ad_images')) {

        function adforest_get_ad_images($pid) {
            global $adforest_theme;
            $re_order = get_post_meta($pid, '_sb_photo_arrangement_', true);
            if ($re_order != "" && isset($adforest_theme['design_type']) && $adforest_theme['design_type'] == 'modern') {
                return explode(',', $re_order);
            } else {
                global $wpdb;
                $query = "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND post_parent = '" . $pid . "'";
                $results = $wpdb->get_results($query, OBJECT);
                return $results;
                //return get_attached_media( 'image',$pid );
            }
        }

    }

    if (!function_exists('adforest_removeElementsByTagName')) {

        function adforest_removeElementsByTagName($tagName, $document) {
            $nodeList = $document->getElementsByTagName($tagName);
            for ($nodeIdx = $nodeList->length; --$nodeIdx >= 0;) {
                $node = $nodeList->item($nodeIdx);
                $node->parentNode->removeChild($node);
            }
        }

    }

    if (!function_exists('adforest_display_adLocation')) {

        function adforest_display_adLocation($pid) {
            global $adforest_theme;
            $ad_country = '';
            $type = '';
            $type = $adforest_theme['cat_and_location'];
            $ad_country = wp_get_object_terms($pid, array('ad_country'), array('orderby' => 'term_group'));
            $all_locations = array();
            foreach ($ad_country as $ad_count) {
                $country_ads = get_term($ad_count);
                $item = array(
                    'term_id' => $country_ads->term_id,
                    'location' => $country_ads->name
                );
                $all_locations[] = $item;
            }
            $location_html = '';
            if (count($all_locations) > 0) {
                $limit = count($all_locations) - 1;
                for ($i = $limit; $i >= 0; $i--) {
                    if ($type == 'search') {
                        $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
                        $location_html .= '<a href="' . get_the_permalink($sb_search_page) . '?country_id=' . $all_locations[$i]['term_id'] . '">' . esc_html($all_locations[$i]['location']) . '</a>, ';
                    } else {
                        $location_html .= '<a href="' . get_term_link($all_locations[$i]['term_id']) . '">' . esc_html($all_locations[$i]['location']) . '</a>, ';
                    }
                }
            }
            return rtrim($location_html, ', ');
        }

    }

    if (!function_exists('adforest_social_profiles')) {

        function adforest_social_profiles() {
            global $adforest_theme;
            if (isset($adforest_theme['sb_enable_social_links']) && $adforest_theme['sb_enable_social_links']) {
                $social_netwroks = array(
                    'facebook' => __('Facebook', 'adforest'),
                    'twitter' => __('Twitter', 'adforest'),
                    'linkedin' => __('Linkedin', 'adforest'),
                    'google' => __('Google', 'adforest')
                );
            } else {
                $social_netwroks = array();
            }
            return $social_netwroks;
        }

    }

    if (!function_exists('adforest_fetch_reviews_average')) {

        function adforest_fetch_reviews_average($listing_id) {
            $comments = '';
            $get_rating_avrage = '';
            $one_star = '';
            $two_star = '';
            $three_star = '';
            $four_star = '';
            $five_star = '';
            $star1 = $star2 = $star3 = $star4 = $star5 = 0;
            $args = array(
                'type__in' => array('ad_post_rating'),
                'parent' => 0, // only parents
                'post_id' => $listing_id, // use post_id, not post_ID
            );
            $comments = get_comments($args);
            if (count($comments) > 0) {

                $sum_of_rated = 0;
                $no_of_times_rated = 0;
                foreach ($comments as $comment) {
                    $rated = get_comment_meta($comment->comment_ID, 'review_stars', true);
                    if ($rated != "" && $rated > 0) {
                        $sum_of_rated += $rated;
                        $no_of_times_rated++;
                        //now rated percentage
                        if ($rated == 1) {
                            $star1++;
                        }
                        if ($rated == 2) {
                            $star2++;
                        }
                        if ($rated == 3) {
                            $star3++;
                        }
                        if ($rated == 4) {
                            $star4++;
                        }
                        if ($rated == 5) {
                            $star5++;
                        }
                    }
                }
                //loop end get avrage value
                $get_rating_avrage = round($sum_of_rated / $no_of_times_rated, 2);
                $get_rating_avrage1 = round($sum_of_rated / $no_of_times_rated, 1);
                $one_star = round(($star1 / $no_of_times_rated) * 100);
                $two_star = round(($star2 / $no_of_times_rated) * 100);
                $three_star = round(($star3 / $no_of_times_rated) * 100);
                $four_star = round(($star4 / $no_of_times_rated) * 100);
                $five_star = round(($star5 / $no_of_times_rated) * 100);

                $total_stars = explode(".", $get_rating_avrage1);

                $stars_html = '';
                $first_part = (isset($total_stars[0]) && $total_stars[0] > 0 && $total_stars[0] != "" ) ? $total_stars[0] : 0;
                $second_part = (isset($total_stars[1]) && $total_stars[1] > 0 && $total_stars[1] != "" ) ? $total_stars[1] : 0;
                for ($stars = 1; $stars <= 5; $stars++) {
                    if ($stars <= $first_part && $first_part > 0) {
                        $stars_html .= '<i class="fa fa-star color" aria-hidden="true"></i>';
                    } else if ($stars == $first_part + 1 && $second_part <= 5 && $second_part > 0) {
                        $stars_html .= '<i class="fa fa-star-half-o color" aria-hidden="true"></i>';
                    } else if ($stars == $first_part + 1 && $second_part > 5 && $second_part > 0) {
                        $stars_html .= '<i class="fa fa-star color" aria-hidden="true"></i>';
                    } else {
                        $stars_html .= '<i class="fa fa-star-o" aria-hidden="true"></i>';
                    }
                }
                if (strpos($get_rating_avrage, ".") !== false) {
                    $get_rating_avrage = $get_rating_avrage;
                } else {
                    $get_rating_avrage = $get_rating_avrage . '.0';
                }

                $array = array();
                $array['total_stars'] = $stars_html;
                $array['average'] = $get_rating_avrage;
                $array['rated_no_of_times'] = $no_of_times_rated;
                $array['ratings'] = array('1_star' => $one_star, '2_star' => $two_star, '3_star' => $three_star, '4_star' => $four_star, '5_star' => $five_star);
                return $array;
            }
        }

    }

    /* adforest Js Static Strings */
    if (!function_exists('adforest_static_strings')) {

        function adforest_static_strings() {
            $mapType = adforest_mapType();

            global $adforest_theme;

            $tags_limit_val = isset($adforest_theme['ad_post_tags_limit']) && !empty($adforest_theme['ad_post_tags_limit']) && $adforest_theme['ad_post_tags_limit'] > 0 ? $adforest_theme['ad_post_tags_limit'] : 10;
            $sb_upload_limit_admin = isset($adforest_theme['sb_upload_limit']) && !empty($adforest_theme['sb_upload_limit']) && $adforest_theme['sb_upload_limit'] > 0 ? $adforest_theme['sb_upload_limit'] : 0;

            $user_packages_images = get_user_meta(get_current_user_id(), '_sb_num_of_images', true);
            //$user_upload_max_images = isset($user_packages_images) && !empty($user_packages_images) ? $user_packages_images : $sb_upload_limit_admin;

            if (isset($user_packages_images) && $user_packages_images == '-1') {
                $user_upload_max_images = 'null';
            } elseif (isset($user_packages_images) && $user_packages_images > 0) {
                $user_upload_max_images = $user_packages_images;
            } else {
                $user_upload_max_images = $sb_upload_limit_admin;
            }



            wp_localize_script(
                    'adforest-custom', // name of js file
                    'get_strings', array(
                'one' => __('One Star', 'adforest'),
                'two' => __('Two Stars', 'adforest'),
                'three' => __('Three Stars', 'adforest'),
                'four' => __('Four Stars', 'adforest'),
                'five' => __('Five Stars', 'adforest'),
                'Sunday' => __('Sunday', 'adforest'),
                'Monday' => __('Monday', 'adforest'),
                'Tuesday' => __('Tuesday', 'adforest'),
                'Wednesday' => __('Wednesday', 'adforest'),
                'Thursday' => __('Thursday', 'adforest'),
                'Friday' => __('Friday', 'adforest'),
                'Saturday' => __('Saturday', 'adforest'),
                'Sun' => __('Sun', 'adforest'),
                'Mon' => __('Mon', 'adforest'),
                'Tue' => __('Tue', 'adforest'),
                'Wed' => __('Wed', 'adforest'),
                'Thu' => __('Thu', 'adforest'),
                'Fri' => __('Fri', 'adforest'),
                'Sat' => __('Sat', 'adforest'),
                'Su' => __('Su', 'adforest'),
                'Mo' => __('Mo', 'adforest'),
                'Tu' => __('Tu', 'adforest'),
                'We' => __('We', 'adforest'),
                'Th' => __('Th', 'adforest'),
                'Fr' => __('Fr', 'adforest'),
                'Sa' => __('Sa', 'adforest'),
                'January' => __('January', 'adforest'),
                'February' => __('February', 'adforest'),
                'March' => __('March', 'adforest'),
                'April' => __('April', 'adforest'),
                'May' => __('May', 'adforest'),
                'June' => __('June', 'adforest'),
                'July' => __('July', 'adforest'),
                'August' => __('August', 'adforest'),
                'September' => __('September', 'adforest'),
                'October' => __('October', 'adforest'),
                'November' => __('November', 'adforest'),
                'December' => __('December', 'adforest'),
                'Jan' => __('Jan', 'adforest'),
                'Feb' => __('Feb', 'adforest'),
                'Mar' => __('Mar', 'adforest'),
                'Apr' => __('Apr', 'adforest'),
                'May' => __('May', 'adforest'),
                'Jun' => __('Jun', 'adforest'),
                'Jul' => __('July', 'adforest'),
                'Aug' => __('Aug', 'adforest'),
                'Sep' => __('Sep', 'adforest'),
                'Oct' => __('Oct', 'adforest'),
                'Nov' => __('Nov', 'adforest'),
                'Dec' => __('Dec', 'adforest'),
                'Today' => __('Today', 'adforest'),
                'Clear' => __('Clear', 'adforest'),
                'Clear' => __('Clear', 'adforest'),
                'dateFormat' => __('dateFormat', 'adforest'),
                'timeFormat' => __('timeFormat', 'adforest'),
                'adforest_tags_limit' => __('Oops ! you have exceeded your tags limit.', 'adforest'),
                'adforest_location_error' => __('Oops ! Somethiing went wrong.Please verify your theme options locations.', 'adforest'),
                'adforest_tags_limit_val' => $tags_limit_val,
                'adforest_map_type' => $mapType,
                'whoops' => esc_html__('Whoops!', 'adforest'),
                'cat_pkg_error' => esc_html__('Whoops! you are not allowed to ad post in this category.Please buy another package.', 'adforest'),
                'max_upload_images' => sprintf(__('No more images please.you can only upload %d', ''), $user_upload_max_images),
                    )
            );
        }

        //$adforest_theme['sb_upload_limit']



        add_action('wp_enqueue_scripts', 'adforest_static_strings', 100);
    }

    if (!function_exists('adforest_determine_minMax_latLong')) {

        function adforest_determine_minMax_latLong($data_arr = array(), $check_db = true) {

            global $adforest_theme;

            /* $data_array = array("latitude" => '21212121212', "longitude" => '212121212121', "distance" => '100' ); */
            $data = array();
            $user_id = get_current_user_id();
            $success = false;
            $search_radius_type = isset($adforest_theme['search_radius_type']) ? $adforest_theme['search_radius_type'] : 'km';

            if (isset($data_arr) && !empty($data_arr)) {
                $nearby_data = $data_arr;
            } else if ($user_id && $check_db) {
                $nearby_data = get_user_meta($user_id, '_sb_user_nearby_data', true);
            }

            if (isset($nearby_data) && $nearby_data != "") {
                //array("latitude" => $latitude, "longitude" => $longitude, "distance" => $distance );
                $original_lat = $nearby_data['latitude'];
                $original_long = $nearby_data['longitude'];
                $distance = intval($nearby_data['distance']);

                if ($search_radius_type == 'mile' && $distance > 0) {
                    $distance = $distance * 1.609344;  // convert kilometer to miles 
                }

                $lat = $original_lat; //latitude
                $lon = $original_long; //longitude
                $distance = ($distance); //your distance in KM
                $R = 6371; //constant earth radius. You can add precision here if you wish

                $maxLat = $lat + rad2deg($distance / $R);
                $minLat = $lat - rad2deg($distance / $R);

                $maxLon = $lon + rad2deg(asin($distance / $R) / @abs(@cos(deg2rad($lat))));
                $minLon = $lon - rad2deg(asin($distance / $R) / @abs(@cos(deg2rad($lat))));

                $data['radius'] = $R;
                $data['distance'] = $distance;
                $data['lat']['original'] = $original_lat;
                $data['long']['original'] = $original_long;

                $data['lat']['min'] = $minLat;
                $data['lat']['max'] = $maxLat;

                $data['long']['min'] = $minLon;
                $data['long']['max'] = $maxLon;
            }


            return $data;
        }

    }

    if (!function_exists('adforest_getLatLong')) {

        function adforest_getLatLong($address = '') {
            global $adforest_theme;

            $gmap_api_key = isset($adforest_theme['gmap_api_key']) && !empty($adforest_theme['gmap_api_key']) ? $adforest_theme['gmap_api_key'] : '';
            $google_map_key_type = isset($adforest_theme['g-map-key-type']) && !empty($adforest_theme['g-map-key-type']) ? $adforest_theme['g-map-key-type'] : 'g_key_open';
            $gmap_restricted_api_key = isset($adforest_theme['gmap_restricted_api_key']) && !empty($adforest_theme['gmap_restricted_api_key']) ? $adforest_theme['gmap_restricted_api_key'] : '';

            if (isset($gmap_restricted_api_key) && !empty($gmap_restricted_api_key) && $google_map_key_type == 'g_key_restricted') {
                $gmap_api_key = $gmap_restricted_api_key;
            }

            if ($address) {
                $formattedAddr = str_replace(' ', '+', $address);
                $arrContextOptions = array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                    ),
                );
                //Send request and receive json data by address
                $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key=' . $gmap_api_key . '&address=' . $formattedAddr . '&sensor=false', false, stream_context_create($arrContextOptions));
                $output = json_decode($geocodeFromAddr);
                //Get latitude and longitute from json data
                if (isset($output->results[0]->geometry->location->lat) && isset($output->results[0]->geometry->location->lng)) {
                    $data['latitude'] = $output->results[0]->geometry->location->lat;
                    $data['longitude'] = $output->results[0]->geometry->location->lng;
                } else {
                    return array();
                }
                //Return latitude and longitude of the given address
                if (!empty($data)) {
                    return $data;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

    }

    if (!function_exists('adforest_detect_ie')) {

        function adforest_detect_ie() {
            $agent = $_SERVER["HTTP_USER_AGENT"];
            $ua = htmlentities($agent, ENT_QUOTES, 'UTF-8');
            if (preg_match('~MSIE|Internet Explorer~i', $ua) || (strpos($ua, 'Trident/7.0; rv:11.0') !== false)) {
                return true;
            } else if (preg_match('/Edge\/\d+/', $agent)) {
                return true;
            } else {
                return false;
            }
        }

    }

    if (!function_exists('adforest_timer_html')) {

        function adforest_timer_html($bid_end_date, $show_unit = true, $unit_style = 'style-1') {
            global $adforest_theme;
            if (isset($adforest_theme['bidding_timer']) && !$adforest_theme['bidding_timer'])
                return;
            if ($bid_end_date == "")
                return '';

            $days = $hours = $minutes = $seconds = '';
            if ($show_unit) {

                if ($unit_style == 'style-2') {
                    $days = '<div class="text">' . __('Days', 'adforest') . '</div>';
                    $hours = '<div class="text">' . __('Hours', 'adforest') . '</div>';
                    $minutes = '<div class="text">' . __('Min', 'adforest') . '</div>';
                    $seconds = '<div class="text">' . __('Sec', 'adforest') . '</div>';
                } else {
                    $days = '<div class="text">' . __('Days', 'adforest') . '</div>';
                    $hours = '<div class="text">' . __('Hours', 'adforest') . '</div>';
                    $minutes = '<div class="text">' . __('Minutes', 'adforest') . '</div>';
                    $seconds = '<div class="text">' . __('Seconds', 'adforest') . '</div>';
                }
            }

            $mt_rand = mt_rand();
            $html = '<div class="clock" data-rand="' . esc_attr($mt_rand) . '" data-date="' . $bid_end_date . '">
                                <div class="column-time clock-days"><div class="bidding_timer days-' . esc_attr($mt_rand) . '" id="days-' . esc_attr($mt_rand) . '"></div>' . $days . '</div>
                                <div class="column-time"><div class="bidding_timer hours-' . esc_attr($mt_rand) . '" id="hours-' . esc_attr($mt_rand) . '"></div>' . $hours . '</div>
                                <div class="column-time"><div class="bidding_timer minutes-' . esc_attr($mt_rand) . '" id="minutes-' . esc_attr($mt_rand) . '"></div>' . $minutes . '</div>
                                <div class="column-time"><div class="bidding_timer seconds-' . esc_attr($mt_rand) . '" id="seconds-' . esc_attr($mt_rand) . '"></div>' . $seconds . '</div>
                        </div>';

            return $html;
        }

    }

    if (!trait_exists('adforest_reuse_functions')) {

        trait adforest_reuse_functions {

            function adforect_widget_open($instance) {

                global $adforest_theme;
                if (isset($adforest_theme['search_design']) && $adforest_theme['search_design'] == 'sidebar') {
                    $open_widget = 0;
                    if (isset($instance['open_widget'])) {
                        $open_widget = $instance['open_widget'];
                    }

                    $open_selected = $close_selected = '';
                    if ($open_widget == '1')
                        $open_selected = 'selected="selected"';
                    else
                        $close_selected = 'selected="selected"';

                    $open_html = '<p>
		<label for="' . esc_attr($this->get_field_id('open_widget')) . '" >
		' . esc_html__('Widget behaviour:', 'adforest') . '
		</label> 
		<select  class="widefat" id="' . esc_attr($this->get_field_id('open_widget')) . '" name="' . esc_attr($this->get_field_name('open_widget')) . '">
			<option value="1"' . esc_attr($open_selected) . '>' . __('Open', 'adforest') . '</option>
			<option value="0"' . esc_attr($close_selected) . '>' . __('Close', 'adforest') . '</option>
		</select>
	</p>';
                    echo adforest_returnEcho($open_html);
                }
            }

        }

    }

    add_action('init', 'adforest_redirect_home');
    if (!function_exists('adforest_redirect_home')) {

        function adforest_redirect_home() {
            if (is_user_logged_in() && is_admin() && !( defined('DOING_AJAX') && DOING_AJAX )) {
                $user = wp_get_current_user();
                if (in_array('subscriber', $user->roles)) {
                    // user has subscriber role
                    wp_redirect(home_url());
                    exit;
                }
            }
        }

    }

    add_action('after_setup_theme', 'adforest_hide_adminbar');
    if (!function_exists('adforest_hide_adminbar')) {

        function adforest_hide_adminbar() {
            if (is_user_logged_in() && !is_admin() && !( defined('DOING_AJAX') && DOING_AJAX )) {
                $user = wp_get_current_user();
                if (in_array('subscriber', $user->roles)) {
                    show_admin_bar(false);
                }
            }
        }

    }

    if (!function_exists('adforest_title_limit')) {

        function adforest_title_limit($ad_title = '') {
            global $adforest_theme;
            if (isset($adforest_theme['sb_ad_title_limit_on']) && $adforest_theme['sb_ad_title_limit_on'] && isset($adforest_theme['sb_ad_title_limit']) && $adforest_theme['sb_ad_title_limit'] != "") {
                return adforest_words_count($ad_title, $adforest_theme['sb_ad_title_limit']);
            } else {
                return $ad_title;
            }
        }

    }

    if (!function_exists('adforest_ad_locations_limit')) {

        function adforest_ad_locations_limit($ad_location = '') {
            global $adforest_theme;
            if (isset($adforest_theme['sb_ad_location_limit_on']) && $adforest_theme['sb_ad_location_limit_on'] && isset($adforest_theme['sb_ad_location_limit']) && $adforest_theme['sb_ad_location_limit'] != "") {
                return adforest_words_count($ad_location, $adforest_theme['sb_ad_location_limit']);
            } else {
                return $ad_location;
            }
        }

    }

    /* Woocommerce Over Riding */
    if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) || class_exists('WooCommerce')) {
        add_filter('woocommerce_default_catalog_orderby', 'adforest_default_catalog_orderby');
        if (!function_exists('adforest_default_catalog_orderby')) {

            function adforest_default_catalog_orderby() {
                return 'date'; // Can also use title and price
            }

        }

        //Woocommerce Style Widget
        add_filter('get_product_search_form', 'adforest_custom_product_searchform');
        if (!function_exists('adforest_custom_product_searchform')) {

            function adforest_custom_product_searchform($form) {
                $form = '<form role="search" method="get" class="search-form" id="searchform" action="' . esc_url(home_url('/')) . '">
			<div class="search-blog">
				<div class="input-group stylish-input-group">
					<input class="form-control" placeholder="' . esc_html__('Search products...', 'adforest') . '" value="' . get_search_query() . '" name="s" type="search">
					<span class="input-group-addon"><button type="submit"> <span class="fa fa-search"></span> </button> </span>
				</div>
			</div>
			<input type="hidden" name="post_type" value="product" />
			<input class="search-submit" value="' . esc_html__('Search', 'adforest') . '" type="submit">
		</form>';
                return $form;
            }

        }


        add_action('woocommerce_after_shop_loop_item', 'mycode_remove_add_to_cart_buttons', 1);

        function mycode_remove_add_to_cart_buttons() {
            remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
        }

        if (!function_exists('adforest_fetch_product_images')) {

            function adforest_fetch_product_images($productId) {
                $product = wc_get_product($productId);
                $attachmentIds = $product->get_gallery_image_ids();
                $attachmentIds[] = $product->get_image_id();
                return $attachmentIds;
            }

        }
    }

    if (!function_exists('adforest_text')) {

        function adforest_text($get_text) {
            global $adforest_theme;
            if (isset($adforest_theme[$get_text]) && $adforest_theme[$get_text] != ""):
                return $adforest_theme[$get_text];
            else:
                return '';
            endif;
        }

    }

    if (!function_exists('adforest_mapType')) {

        function adforest_mapType() {
            global $adforest_theme;
            $mapType = 'google_map';
            if (isset($adforest_theme['map-setings-map-type']) && $adforest_theme['map-setings-map-type'] != '') {
                $mapType = $adforest_theme['map-setings-map-type'];
            }
            return $mapType;
        }

    }

    if (!function_exists('adforest_showPhone_to_users')) {

        function adforest_showPhone_to_users() {
            global $adforest_theme;

            $restrict_phone_show = ( isset($adforest_theme['restrict_phone_show']) ) ? $adforest_theme['restrict_phone_show'] : 'all';
            $is_show_phone = false;
            if ($restrict_phone_show == "login_only") {
                $is_show_phone = true;
                if (is_user_logged_in()) {
                    $is_show_phone = false;
                }
            }
            return $is_show_phone;
        }

    }

    if (!function_exists('adforest_returnEcho')) {

        function adforest_returnEcho($html = '') {
            return $html;
        }

    }

    if (!function_exists('adforest_get_grid_layout')) {

        function adforest_get_grid_layout() {
            global $adforest_theme;

            $search_ad_layout_for_sidebar = '';
            if (isset($adforest_theme['search_layout_types']) && $adforest_theme['search_layout_types'] == true) {
                if (isset($_GET['view-type']) && $_GET['view-type'] != "") {
                    if ($_GET['view-type'] == 'grid') {
                        $search_ad_layout_for_sidebar = $adforest_theme['search_layout_types_grid'];
                    }
                    if ($_GET['view-type'] == 'list') {
                        if (isset($adforest_theme['search_design']) && $adforest_theme['search_design'] == 'topbar') {
                            $search_ad_layout_for_sidebar = $adforest_theme['search_layout_types_list2'];
                        } else {
                            $search_ad_layout_for_sidebar = $adforest_theme['search_layout_types_list'];
                        }
                    }
                }
            }
            return $search_ad_layout_for_sidebar;
        }

    }

    if (!function_exists('adforest_get_adVideoID')) {

        function adforest_get_adVideoID($video_url = '') {
            $vid_arr = array();
            $ad_video = $video_url;
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $ad_video, $match);
            return $vID = (isset($match[1]) && $match[1] != "") ? $match[1] : '';
        }

    }

    if (!function_exists('adforest_get_CallAbleNumber')) {

        function adforest_get_CallAbleNumber($phone_number = '') {
            return preg_replace("/[^0-9+]/", "", $phone_number);
        }

    }

    if (!function_exists('adforest_owner_text_callback')) {

        function adforest_owner_text_callback($phone_number = '') {
            global $adforest_theme;
            $owner_deal_text = isset($adforest_theme['owner_deal_text']) && !empty($adforest_theme['owner_deal_text']) ? $adforest_theme['owner_deal_text'] : '';

            if (!empty($owner_deal_text)) {
                echo '<div class="adforest-owner-text">' . adforest_returnEcho($owner_deal_text) . '</div>';
            }
        }

        add_action('adforest_owner_text', 'adforest_owner_text_callback');
    }

    if (!function_exists('adforest_login_with_redirect_url_param')) {

        function adforest_login_with_redirect_url_param($redirect_url = '') {
            global $adforest_theme;
            $final_redi_url = '';
            $red_url = '';
            $sb_sign_in_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_in_page']);
            $login_page_url = isset($adforest_theme['sb_sign_in_page']) && !empty($adforest_theme['sb_sign_in_page']) ? get_the_permalink($sb_sign_in_page) : home_url('/');
            if ($redirect_url != '') {
                $query_url = parse_url($login_page_url, PHP_URL_QUERY);
                if ($query_url) {
                    $red_url = '&u=' . $redirect_url;
                } else {
                    $red_url = '?u=' . $redirect_url;
                }
            }
            $final_redi_url = $login_page_url . $red_url;
            $final_redi_url = apply_filters('adforest_page_lang_url', $final_redi_url);
            return $final_redi_url;
        }

    }
    if (!function_exists('adforest_set_url_param')) {

        function adforest_set_url_param($adforest_url = '', $key = '', $value = '') {

            if ($adforest_url != '') {
                $adforest_url = add_query_arg(array($key => $value), $adforest_url);
                $adforest_url = apply_filters('adforest_page_lang_url', $adforest_url);
            }
            return $adforest_url;
        }

    }

    if (!function_exists('adforest_verify_sms_gateway')) {

        function adforest_verify_sms_gateway() {
            global $adforest_theme;
            $gateway = '';
            if (isset($adforest_theme['sb_phone_verification']) && $adforest_theme['sb_phone_verification'] && in_array('wp-twilio-core/core.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                $gateway = 'twilio';
            } else if (isset($adforest_theme['sb_phone_verification']) && $adforest_theme['sb_phone_verification'] && in_array('wp-iletimerkezi-sms/core.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                $gateway = 'iletimerkezi-sms';
            }

            return $gateway;
        }

    }

    if (!function_exists('adforest_check_if_phoneVerified')) {

        function adforest_check_if_phoneVerified($user_id = 0) {
            global $adforest_theme;
            $verifed_phone_number = false;
            if (isset($adforest_theme['sb_phone_verification']) && $adforest_theme['sb_phone_verification']) {
                if (isset($adforest_theme['sb_new_user_sms_verified_can']) && $adforest_theme['sb_new_user_sms_verified_can'] == true) {
                    $user_id = ($user_id) ? $user_id : get_current_user_id();
                    if (get_user_meta($user_id, '_sb_is_ph_verified', true) != '1') {
                        //get_user_meta($user_id, '_sb_is_ph_verified', true);
                        $verifed_phone_number = true;
                    }
                }
            }
            return $verifed_phone_number;
        }

    }

    function adforest_human_time_diff($from, $to = '') {

        adforest_set_date_timezone();
        if (empty($to)) {
            //$to = current_time('mysql');
            $to = strtotime(date('Y-m-d H:i:s'));
        }

        $diff = (int) abs($to - $from);

        if ($diff < HOUR_IN_SECONDS) {
            $mins = round($diff / MINUTE_IN_SECONDS);
            if ($mins <= 1) {
                $mins = 1;
            }

            $since = sprintf(_n('%s min', '%s mins', $mins, 'adforest'), $mins);
        } elseif ($diff < DAY_IN_SECONDS && $diff >= HOUR_IN_SECONDS) {
            $hours = round($diff / HOUR_IN_SECONDS);
            if ($hours <= 1) {
                $hours = 1;
            }

            $since = sprintf(_n('%s hour', '%s hours', $hours, 'adforest'), $hours);
        } elseif ($diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS) {
            $days = round($diff / DAY_IN_SECONDS);
            if ($days <= 1) {
                $days = 1;
            }

            $since = sprintf(_n('%s day', '%s days', $days, 'adforest'), $days);
        } elseif ($diff < MONTH_IN_SECONDS && $diff >= WEEK_IN_SECONDS) {
            $weeks = round($diff / WEEK_IN_SECONDS);
            if ($weeks <= 1) {
                $weeks = 1;
            }

            $since = sprintf(_n('%s week', '%s weeks', $weeks, 'adforest'), $weeks);
        } elseif ($diff < YEAR_IN_SECONDS && $diff >= MONTH_IN_SECONDS) {
            $months = round($diff / MONTH_IN_SECONDS);
            if ($months <= 1) {
                $months = 1;
            }

            $since = sprintf(_n('%s month', '%s months', $months, 'adforest'), $months);
        } elseif ($diff >= YEAR_IN_SECONDS) {
            $years = round($diff / YEAR_IN_SECONDS);
            if ($years <= 1) {
                $years = 1;
            }

            $since = sprintf(_n('%s year', '%s years', $years, 'adforest'), $years);
        }

        return apply_filters('human_time_diff', $since, $diff, $from, $to);
    }

    /*
     *  Start Hooks section to ad post only for validated phone users
     */


    add_filter('adforest_ad_post_verified_id', 'adforest_ad_post_verified_id_callback', 10, 2);

    if (!function_exists('adforest_ad_post_verified_id_callback')) {

        function adforest_ad_post_verified_id_callback($page_id = '', $notification = 'no') {
            global $adforest_theme;
            if (is_user_logged_in()) {
                $enable_phone_verification = isset($adforest_theme['sb_phone_verification']) && $adforest_theme['sb_phone_verification'] ? True : FALSE;
                $ad_post_with_phone_verification = isset($adforest_theme['ad_post_restriction']) && $adforest_theme['ad_post_restriction'] == 'phn_verify' ? True : FALSE;
                $sb_profile_page = isset($adforest_theme['sb_profile_page']) && $adforest_theme['sb_profile_page'] != '' ? $adforest_theme['sb_profile_page'] : get_option('page_on_front');
                if ($enable_phone_verification && $ad_post_with_phone_verification) {
                    $user_id = get_current_user_id();
                    if (get_user_meta($user_id, '_sb_is_ph_verified', true) != '1') {
                        if ($notification == 'yes') {
                            $message_html = '<div role="alert" class="alert alert-info alert-dismissible">
                                                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">✕</span></button>
                                                ' . __("Please verify your phone number for ad Posting.", "adforest") . ' 
                                             </div>';
                            $page_id .= $message_html;
                        } else {
                            $page_id = $sb_profile_page;
                        }
                    }
                }
            }
            return $page_id;
        }

    }

    add_filter('adforest_ad_post_verified_link', 'adforest_ad_post_verified_link_callback', 10, 1);


    if (!function_exists('adforest_ad_post_verified_link_callback')) {

        function adforest_ad_post_verified_link_callback($page_url = '') {

            global $adforest_theme;
            if (is_user_logged_in()) {
                $enable_phone_verification = isset($adforest_theme['sb_phone_verification']) && $adforest_theme['sb_phone_verification'] ? True : FALSE;
                $ad_post_with_phone_verification = isset($adforest_theme['ad_post_restriction']) && $adforest_theme['ad_post_restriction'] == 'phn_verify' ? True : FALSE;
                if ($enable_phone_verification && $ad_post_with_phone_verification) {
                    $user_id = get_current_user_id();
                    if (get_user_meta($user_id, '_sb_is_ph_verified', true) != '1') {
                        $page_url = adforest_set_url_param(trailingslashit($page_url), 'type', 'phone_verification');
                    }
                }
            }
            return $page_url;
        }

    }

    add_action('adforest_validate_phone_verification', 'adforest_validate_phone_verification');

    function adforest_validate_phone_verification() {
        global $adforest_theme;
        $page_url = home_url('/');
        $sb_profile_page = isset($adforest_theme['sb_profile_page']) && $adforest_theme['sb_profile_page'] != '' ? $adforest_theme['sb_profile_page'] : get_option('page_on_front');
        $sb_profile_page = apply_filters('adforest_language_page_id', $sb_profile_page);
        if (is_user_logged_in()) {
            $enable_phone_verification = isset($adforest_theme['sb_phone_verification']) && $adforest_theme['sb_phone_verification'] ? True : FALSE;
            $ad_post_with_phone_verification = isset($adforest_theme['ad_post_restriction']) && $adforest_theme['ad_post_restriction'] == 'phn_verify' ? True : FALSE;
            if ($enable_phone_verification && $ad_post_with_phone_verification) {
                $user_id = get_current_user_id();
                if (get_user_meta($user_id, '_sb_is_ph_verified', true) != '1') {
                    $page_url = adforest_set_url_param(get_permalink($sb_profile_page), 'type', 'phone_verification');
                    echo adforest_redirect($page_url);
                }
            }
        }
    }

    /*
     * End Hooks section to ad post only for validated phone users
     */

    /*
     * Make Taxonomy hirerachy base.
     */


    add_filter('adforest_tax_hierarchy', 'adforest_tax_hierarchy_callback', 10, 2);

    function adforest_tax_hierarchy_callback($html, $tax_args = array()) {

        /*
         * 'taxonomy'=> 'ad_cats' // add the taxonomy slug
         * 'type' => 'html',  // can be html/array type
         * 'tag' => 'li',    //  can be li/option if type is html
         * 'parent_id' => 0, // parent id of the terms
         * 'q'=>  search query in case of ajax
         */

        extract($tax_args);
        $taxonomy = isset($taxonomy) && $taxonomy != '' ? $taxonomy : 'ad_cats';
        $type = isset($type) && $type != '' ? $type : 'html';
        $tag = isset($tag) && $tag != '' ? $tag : 'li';
        $vc = isset($vc) && $vc ? true : false;
        $parent_id = isset($parent_id) && $parent_id != '' ? $parent_id : 0;
        $args = array('hide_empty' => 0, 'hierarchical' => true, 'parent' => $parent_id);
        $args = isset($q) && $q != '' ? $args['name__like'] = $q : $args;



        $args = apply_filters('adforest_wpml_show_all_posts', $args);

        $terms = get_terms($taxonomy, $args);
        if (isset($terms) && !empty($terms) && is_array($terms) && sizeof($terms) > 0) {

            foreach ($terms as $term) {
                $ancestors = get_ancestors($term->term_id, $taxonomy);
                $depth_sign = '';
                for ($depth_loop = 1; $depth_loop <= count($ancestors); $depth_loop++) {
                    $depth_sign .= ' - ';
                }
                if ($type == 'html') {
                    $html .= '<' . $tag . ' value="' . $term->term_id . '">' . $depth_sign . $term->name . '</' . $tag . '>';
                } else {

                    if ($vc) {
                        $count = ($term->count);
                        //$html[] = array($term->term_id, wp_specialchars_decode($depth_sign . $term->name));
                        $html[$depth_sign . wp_specialchars_decode($term->name) . ' (' . urldecode_deep($term->slug) . ')' . ' (' . $count . ')'] = $term->term_id;
                    } else {
                        $html[] = array($term->term_id, wp_specialchars_decode($depth_sign . $term->name));
                    }
                }

                if ($term->parent == $parent_id) {
                    $args = array(
                        'type' => $type,
                        'taxonomy' => $taxonomy,
                        'tag' => $tag,
                        'parent_id' => $term->term_id,
                        'vc' => $vc,
                    );
                    $html = apply_filters('adforest_tax_hierarchy', $html, $args);
                }
            }
        }
        return $html;
    }
    
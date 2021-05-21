<?php
global $adforest_theme;
$pid = get_the_ID();
$poster_id = get_post_field('post_author', $pid);
$section_title = __('Rating & Reviews', 'adforest');
if (isset($adforest_theme['sb_ad_rating_title']) && $adforest_theme['sb_ad_rating_title'] != "") {
    $section_title = $adforest_theme['sb_ad_rating_title'];
}
$page = (get_query_var('page')) ? get_query_var('page') : 1;
$limit = $adforest_theme['sb_rating_max'];
$offset = ($page * $limit) - $limit;
$args = array(
    'type__in' => array('ad_post_rating'),
    'number' => $limit,
    'offset' => $offset,
    'parent' => 0, // parent only
    'post_id' => $pid, // use post_id, not post_ID
);

$comments = get_comments($args);
?>
<div class="col-lg-12 col-md-12 col-xs-12 col-md-12 col-sm-12" id="rating">
    <div class="row">
        <div class="ad-main-content">
            <?php
            if (count($comments) > 0) {
                $get_percentage = adforest_fetch_reviews_average($pid);
                ?>

                <div class="ad-bids-rating">
                    <div class="heading-panel">
                        <div class="ad-detail-6-title">
                            <?php
                            echo adforest_returnEcho($adforest_theme['sb_ad_rating_title']);
                            if (isset($get_percentage) && count($get_percentage['ratings']) > 0) {
                                echo ' <span>( ' . $get_percentage['average'] . ' )</span>';
                            }
                            ?>
                        </div>
                    </div>

                    <?php
                    if (count($comments) > 0) {
                        foreach ($comments as $comment) {
                            $commenter = get_userdata($comment->user_id);
                            if ($commenter) {
                                ?>
                                <div class="ad-review-wrap">
                                    <div class="ads-bids-client-area"> <img height="80" width="80" src="<?php echo adforest_get_user_dp($comment->user_id, 'adforest-user-profile');?>" alt="<?php echo esc_attr($commenter->display_name);?>" class="img-fluid">
                                        <span><?php echo get_comment_date('M j, Y', $comment->comment_ID);?></span>
                                    </div>
                                    <div class="ads-bids-nrating">
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= get_comment_meta($comment->comment_ID, 'review_stars', true))
                                                echo '<i class="fa fa-star color" aria-hidden="true"></i>';
                                            else
                                                echo '<i class="fa fa-star-o" aria-hidden="true"></i>';
                                        }
                                        ?>

                                        <a href="<?php echo adforest_set_url_param(get_author_posts_url($comment->user_id), 'type', 'ads');?>">
                                            <span class="ads-reviewer-name"><?php echo esc_html($commenter->display_name);?></span>
                                        </a>
                                        <p><?php echo esc_html($comment->comment_content);?></p>
                                        <?php
                                        if (isset($adforest_theme['adforest_listing_review_enable_emoji']) && $adforest_theme['adforest_listing_review_enable_emoji']) {
                                            $got_likes = '';
                                            $got_love = '';
                                            $got_wow = '';
                                            $got_angry = '';
                                            if (get_comment_meta($comment->comment_ID, 'review_like', true) != "") {
                                                $got_likes = get_comment_meta($comment->comment_ID, 'review_like', true);
                                            }
                                            if (get_comment_meta($comment->comment_ID, 'review_love', true) != "") {
                                                $got_love = get_comment_meta($comment->comment_ID, 'review_love', true);
                                            }
                                            if (get_comment_meta($comment->comment_ID, 'review_wow', true) != "") {
                                                $got_wow = get_comment_meta($comment->comment_ID, 'review_wow', true);
                                            }
                                            if (get_comment_meta($comment->comment_ID, 'review_angry', true) != "") {
                                                $got_angry = get_comment_meta($comment->comment_ID, 'review_angry', true);
                                            }
                                            ?>
                                            <div class="review-helpful"> 
                                                <div class="Like">
                                                    <div class="Emojis">
                                                        <div class="Emoji  Emoji-like"  data-reaction="1" data-cid="<?php echo esc_attr($comment->comment_ID);?>">
                                                            <div class="emoji-name"> <?php echo esc_html__('Like', 'adforest');?></div>
                                                            <div class="icon icon-like"></div>
                                                            <div class="emoji-count likes-<?php echo esc_attr($comment->comment_ID);?>"><?php echo esc_attr($got_likes);?></div>
                                                        </div>
                                                        <div class="Emoji Emoji-love" data-reaction="2" data-cid="<?php echo esc_attr($comment->comment_ID);?>">
                                                            <div class="emoji-name"> <?php echo esc_html__('Love', 'adforest');?></div>
                                                            <div class="icon icon-heartt" ></div>
                                                            <div class="emoji-count loves-<?php echo esc_attr($comment->comment_ID);?>"> <?php echo esc_attr($got_love);?> </div>
                                                        </div>

                                                        <div class="Emoji Emoji-wow" data-reaction="3" data-cid="<?php echo esc_attr($comment->comment_ID);?>">
                                                            <div class="emoji-name"> <?php echo esc_html__('Wow', 'adforest');?></div>
                                                            <div class="icon icon-wow" ></div>
                                                            <div class="emoji-count wows-<?php echo esc_attr($comment->comment_ID);?>"> <?php echo esc_attr($got_wow);?> </div>
                                                        </div>

                                                        <div class="Emoji Emoji-angry" data-reaction="4" data-cid="<?php echo esc_attr($comment->comment_ID);?>">
                                                            <div class="emoji-name"> <?php echo esc_html__('Angry', 'adforest');?></div>
                                                            <div class="icon icon-angry"></div>
                                                            <div class="emoji-count angrys-<?php echo esc_attr($comment->comment_ID);?>"> <?php echo esc_attr($got_angry);?> </div>
                                                        </div>
                                                        <img id="reaction-loader-<?php echo esc_attr($comment->comment_ID);?>" class="none" src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'images/adforest_loader.gif')?>" alt="<?php echo esc_html__('not found', 'adforest')?>">
                                                    </div>

                                                </div>

                                            </div>
                                            <?php
                                        }

                                        $args_reply = array(
                                            'type__in' => array('ad_post_rating'),
                                            'number' => 1,
                                            'parent' => $comment->comment_ID, // parent only
                                            'post_id' => $pid, // use post_id, not post_ID
                                        );
                                        $replies = get_comments($args_reply);
                                        if (count($replies) > 0) {
                                            foreach ($replies as $reply) {
                                                $ad_author = get_userdata($poster_id);
                                                if ($ad_author) {
                                                    ?>
                                                    <div class="sb-new-comment">
                                                        <div class="post-comments">

                                                            <p class="meta">
                                                                <a href="<?php echo adforest_set_url_param(get_author_posts_url($poster_id), 'type', 'ads');?>">
                                                                    <img height="50" width="50" src="<?php echo adforest_get_user_dp($comment->user_id, 'adforest-user-profile');?>" alt="<?php echo __('User image', 'adforest');?>" />
                                                                </a>
                                                                <a href="<?php echo adforest_set_url_param(get_author_posts_url($poster_id), 'type', 'ads');?>">
                                                                    <?php
                                                                    echo esc_html($ad_author->display_name);
                                                                    ?>
                                                                </a> 
                                                                <span class="reply-date"><?php echo get_comment_date('M j, Y', $reply->comment_ID);?></span>
                                                            </p>
                                                            <p>
                                                                <?php echo esc_html($reply->comment_content);?>
                                                            </p>
                                                        </div>

                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }

                                        if (get_post_meta($pid, '_adforest_ad_status_', true) == 'active' && get_current_user_id() == $poster_id) {
                                            ?>                            
                                            <div class="ads-bids-rply">
                                                <a href="javascript:void(0);" class="btn btn-theme reply_ad_rating"  data-comment_id="<?php echo adforest_returnEcho($comment->comment_ID);?>" data-commenter-name="<?php echo esc_attr($commenter->display_name);?>" data-toggle="modal" data-target=".reply_rating"><i class="fa fa-comments"></i><?php echo __('Reply', 'adforest');?></a> 
                                            </div>
                                            <?php
                                        }
                                        ?>

                                    </div>
                                </div>
                                <?php
                            }
                        }

                        $args_c = array(
                            'type__in' => array('ad_post_rating'),
                            'parent' => 0, // parent only
                            'post_id' => $pid, // use post_id, not post_ID
                        );
                        $total_comments = get_comments($args_c);
                        $pages = ( ceil(count($total_comments)) / $limit );
                        ?>

                        <?php echo adforest_comments_pagination($pages, $page);?>
                        <?php
                    }
                    ?>
                </div>
                    <?php
                }
                ?>
            <!-- comment -->

            <?php
            if (get_post_meta($pid, '_adforest_ad_status_', true) == 'active') {
                ?>                            
                <div class="ad-bids-rating">
                    <div class="heading-panel">
                        <div class="main-title text-left">
                <?php echo __('Post your rating', 'adforest');?>
                        </div>
                    </div>
                    <div class="row">
                        <form method="post" id="ad_rating_form">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <div dir="ltr">
                                        <input id="input-21b" name="rating" value="1" type="text"  data-show-clear="false" <?php if (is_rtl()) {?> dir="rtl"<?php }?>class="rating" data-min="0" data-max="5" data-step="1" data-size="xs" required title="required">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label><?php echo __('Comments', 'adforest');?>: <span class="required">*</span></label>
                                    <textarea cols="6" name="rating_comments" rows="6" placeholder="<?php echo __('Your comments...', 'adforest');?>" class="form-control" data-parsley-required="true" data-parsley-error-message="<?php echo __('This field is required.', 'adforest');?>"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <input type="hidden" id="sb-review-token" value="<?php echo wp_create_nonce('sb_review_secure') ;?>" />
                                <input class="btn btn-theme" value="<?php echo __('Submit Review', 'adforest');?>" type="submit">
                                <input type="hidden" value="<?php echo adforest_returnEcho($pid);?>" name="ad_id" />
                                <input type="hidden" value="<?php echo adforest_returnEcho($poster_id);?>" name="ad_owner" />
                            </div>
                        </form>
                    </div>
                </div> 
    <?php
    $flip_it = 'text-left';
    if (is_rtl()) {
        $flip_it = 'text-right';
    }
    ?>
                <div class="modal fade reply_rating" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="rating_reply_form">
                            <div class="modal-content <?php echo esc_attr($flip_it);?>">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&#10005;</span><span class="sr-only"></span></button>
                                    <div class="modal-title"><?php echo __('Reply to', 'adforest');?> <span id="reply_to_rating"></span></div>
                                </div>
                                <div class="modal-body <?php echo esc_attr($flip_it);?>">
                                    <div class="form-group  col-md-12 col-sm-12">
                                        <label></label>
                                        <textarea placeholder="<?php echo __('Write your reply...', 'adforest');?>" rows="3" class="form-control" name="reply_comments" data-parsley-required="true" data-parsley-error-message="<?php echo __('This field is required.', 'adforest');?>"></textarea>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-12 col-sm-12 margin-bottom-20 margin-top-20">
                                        <input type="hidden" id="parent_comment_id" value="0" name="parent_comment_id" />
                                        <input type="hidden" id="sb-review-reply-token" value="<?php echo wp_create_nonce('sb_review_reply_secure');?>" />
                                        <input type="hidden" value="<?php echo adforest_returnEcho($pid);?>" name="ad_id" />
                                        <input type="hidden" value="<?php echo adforest_returnEcho($poster_id);?>" name="ad_owner" />
                                        <input type="submit" class="btn btn-theme btn-block" value="<?php echo __('Submit', 'adforest');?>" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
    <?php
}
?>

        </div>
    </div>
</div>



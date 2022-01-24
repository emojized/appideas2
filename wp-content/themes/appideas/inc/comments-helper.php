<?php
if( ! function_exists( 'better_comments' ) ):
function better_comments($comment, $args, $depth) {
    ?>

    <div class="card comment" style="margin: auto;">
        <div class="card-body comment-block">

            <?php if ($comment->comment_approved == '0') : ?>
                <em><?php esc_html_e('Your comment is awaiting moderation.','5balloons_theme') ?></em>
                <br />
            <?php endif; ?>
            <span class="comment-by">
                <strong><?php echo get_comment_author() ?></strong>
                <span class="float-right">
			    	<span class="date float-right"><?php printf(/* translators: 1: date. */ esc_html__('%1$s' , '5balloons_theme'), get_comment_date() ) ?></span>
                </span>
            </span>
				
		   <p> <?php comment_text() ?></p>

        </div>
    </div>
	
	<br>

<?php
        }
endif;

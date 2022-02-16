<?php
/**
 * Single post partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


?>

<style>

.tag {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background-color: #e3e4f1;
  color: black;
  min-width: 1em;
  min-height: 1em;
  border-radius: 50px;
  vertical-align: middle;
  border: 1px solid #bebfda;
}

.card {
  width: 18rem;
  background-color: #f7f7fc!important;
  border-color: #e9ebf7;
}

/* unvisited link */
a:link {
  color: #848bbf;
}

/* visited link */
a:visited {
  color: #848bbf;
}

/* mouse over link */
a:hover {
  color: #848bbf;
  text-decoration: none;
}

/* selected link */
a:active {
  color: black;
  text-decoration: none;

  .buttonbright {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background-color: #f6f7fc;
  color: black;
  min-width: 1em;
/*  min-height: 1em; */
  height: 1.75em; 
  border-radius: 50px;
  vertical-align: middle;
  border: 1px solid #eaecf7;
}

.buttondark {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background-color: #c1c0df;
  color: black;
  min-width: 1em;
/*  min-height: 1em; */
  height: 1.75em; 
  border-radius: 50px;
  vertical-align: middle;
  border: 1px solid #8c92c3;
}


</style>


<?php




    // retrieve ratings
    $postid = get_the_ID();
    $oldrating = get_post_meta($postid, 'smp_rating_user', false);
    $ratingavg = get_post_meta($postid, 'smp_rating_avg', true);
    $ratingcount = intval(get_post_meta($postid, 'smp_rating_count', true));

    if (!empty($oldrating))
	{
        $oldrating = $oldrating[0];
	}

    if (empty($ratingavg)) {
        $ratingavg = 0;
    }

    if (empty($ratingcount)) {
        $ratingcount = 0;
    }

    // count number of ratings per rating category
    $ratingcountperrating = array_count_values($oldrating);

    $starfilledshow = '<span class="dashicons star-color-filled"></span>';
	$starhalfshow = '<span class="dashicons star-color-half"></span>';
    // $starfilledshow = '<span class="dashicons dashicons-star-filled star-color-filled"></span>';
    // $staremptyshow = '<span class="dashicons dashicons-star-empty star-color"></span>';
    $staremptyshow = '<span class="dashicons star-color-empty"></span>';

    echo '<div class="row">';
        echo '<div class="col">';

            echo '<div class="card" style="margin: auto;">';
            echo '<div class="card-body">';
                echo '<h5 class="card-title">Bewertungen</h5>';
                echo number_format($ratingavg, 1);

        if (is_null($ratingavg) or $ratingavg < 1)
        {
        echo ' ' .$staremptyshow .$staremptyshow .$staremptyshow .$staremptyshow;
        }

        elseif ($ratingavg >= 1 and $ratingavg < 1.25)
        {
        echo ' ' .$starfilledshow .$staremptyshow .$staremptyshow .$staremptyshow;
        }

        elseif ($ratingavg >= 1.25 and $ratingavg < 1.75)
        {
        echo ' ' .$starfilledshow .$starhalfshow .$staremptyshow .$staremptyshow;
        }

        elseif ($ratingavg >= 1.75 and $ratingavg < 2.25)
        {
        echo ' ' .$starfilledshow .$starfilledshow .$staremptyshow .$staremptyshow;
        }

        elseif ($ratingavg >= 2.25 and $ratingavg < 2.75)
        {
        echo ' ' .$starfilledshow .$starfilledshow .$starhalfshow .$staremptyshow;
        }

        elseif ($ratingavg >= 2.75 and $ratingavg < 3.25)
        {
        echo ' ' .$starfilledshow .$starfilledshow .$starfilledshow .$staremptyshow;
        }

        elseif ($ratingavg >= 3.25 and $ratingavg < 3.75)
        {
        echo ' ' .$starfilledshow .$starfilledshow .$starfilledshow .$starhalfshow;
        }

        elseif ($ratingavg >= 3.75)
        {
        echo ' ' .$starfilledshow .$starfilledshow .$starfilledshow .$starfilledshow;
        }

                echo '<span style="float:right;">';
                echo $ratingcount .' Bewertungen';
                echo '</span><br>';
        
                echo 'Sehr gut';
                echo '<span style="float:right;">';
                if(empty($ratingcountperrating[4])) {echo '0';} else {echo $ratingcountperrating[4];}
                echo ' ' .$starfilledshow .$starfilledshow .$starfilledshow .$starfilledshow;
                echo '</span>';
                echo '<br>';
                echo 'Befriedigend';
                echo '<span style="float:right;">';
                if(empty($ratingcountperrating[3])) {echo '0';} else {echo $ratingcountperrating[3];}
                echo ' ' .$starfilledshow .$starfilledshow .$starfilledshow .$staremptyshow;
                echo '</span>';
                echo '<br>';
                echo 'Mangelhaft';
                echo '<span style="float:right;">';
                if(empty($ratingcountperrating[2])) {echo '0';} else {echo $ratingcountperrating[2];}
                echo ' ' .$starfilledshow .$starfilledshow .$staremptyshow .$staremptyshow;
                echo '</span>';
                echo '<br>';
                echo 'Ungen&uuml;gend';
                echo '<span style="float:right;">';
                if(empty($ratingcountperrating[1])) {echo '0';} else {echo $ratingcountperrating[1];}
                echo ' ' .$starfilledshow .$staremptyshow .$staremptyshow .$staremptyshow;
                echo '</span>';
            echo '</div>';
            echo '<br>'; ?>

        </div>
        <br>

        <div class="card" style="margin: auto;">
            <div class="card-body">
                <h5 class="card-title">Projektverantwortlicher</h5>
                <p class="card-text">
                <?php
                
                // retrieve info about post author
                $postdata = get_post();
                $postauthor = $postdata->post_author; 
                $authorinfo = get_userdata($postauthor);

                echo $authorinfo->first_name .' ' .$authorinfo->last_name;
                echo '<br>';
                echo '<a href="mailto:' .$authorinfo->user_email .'">' .$authorinfo->user_email .'</a>';

                ?>
                </p>

            </div>
        </div>
        <br>


        <!--
        <div class="card" style="margin: auto;">
            <div class="card-body">
                <h5 class="card-title">Projektstatus</h5> -->

                <?php

                /*
	            if (isset($_POST['chosenstage']))
	            {
	            	$stage = intval($_POST['chosenstage']);
                }
                else
                {
	                $stage = NULL;
                }


                if ($stage < 0 or is_null($stage))
                {
                    $stage = 0;
                }


                echo $stage;

                echo '<form id="project" method="POST">';


                if ($stage = 0)
                {
                echo '<button id="chosenstage" name="chosenstage" type="submit" value="1"> Noch nicht gestartet </button>';
                }

                elseif ($stage = 1)
                {
                echo '<button id="chosenstage" name="chosenstage" type="submit" value="2"> In Planung </button>';
                }

                elseif ($stage = 2)
                {
                echo '<button id="chosenstage" name="chosenstage" type="submit" value="3"> In Bearbeitung </button>';
                }


                elseif ($stage = 3)
                {
                echo '<button id="chosenstage" name="chosenstage" type="submit" value="4"> In Testing </button>';
                }


                elseif ($stage = 4)
                {
                echo '<button id="chosenstage" name="chosenstage" type="submit" value="5"> In Review </button>';
                }

                elseif ($stage = 5)
                {
                echo '<button id="chosenstage" name="chosenstage" type="submit" value="0"> Fertig </button>';
                }
             
             echo '</form>';


             echo $stage;



             */
                ?>


          <!--  </div>
        </div>
        <br> -->



    </div>
 

    <div class="col">
        <div class="card" style="margin: auto;">

            <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">


                <div class="card-body">

        	        <header class="entry-header">

    	                <?php the_title( '<h5 class="entry-title card-title">', '</h5>' ); ?>

        	        </header><!-- .entry-header -->


                    <?php

                    // show tags
		            $categories = get_the_category();
		            $separator = ' ';
		            $outputtags = '';
		            if ( !empty( $categories ) ) {
  		            foreach( $categories as $category ) {
  		                  $outputtags .= '<div class="tag">&nbsp;&nbsp;'. esc_html( $category->name ) .'&nbsp;&nbsp;</div>' . $separator;
 		                 }

  		                echo '<font size="2">' .trim($outputtags, $separator) .'</font>';

		           	} ?>


                    <p class="card-text">
    	                <div class="entry-content">
	                    	<?php
	                    	the_content();
		                    understrap_link_pages();
	                    	?>
    	                </div><!-- .entry-content -->

                    </p>


	                <footer class="entry-footer">

	                <?php understrap_entry_footer(); ?>


                    <div class="entry-meta" align="right">

				        <?php echo get_the_date( 'd.m.Y' ); ?>

	    	        </div><!-- .entry-meta -->

	                </footer><!-- .entry-footer -->

                </div>



            </article><!-- #post-## -->

        </div>
        <br>


        <!-- Comment form -->
		<div class="card" style="margin: auto;">
            <div class="card-body">

	            <?php
                
                
                $defaults = array(
                    'fields' => apply_filters('comment_form_default_fields', $fields),
                    'title_reply' => '',
                    'label_submit' => __('   Senden   '),
                    'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><br /><textarea placeholder="Kommentar erfassen..." class="form-control" id="comment" name="comment" cols="45" rows="8" maxlength="1000" required="required" aria-required="true"></textarea></p>',
                    'class_submit' => 'buttondark',
                    
                    );

                comment_form($defaults);  // Render comments form.
                
                
                
                ?>

			</div>

		</div>


        <br>

    </div>


    <div class="col">

        <?php if (!empty(get_the_post_thumbnail( $post->ID, 'large' )))
            {
            echo '<div class="card" style="margin: auto;">';
                echo '<div class="card-body">';
                    echo get_the_post_thumbnail( $post->ID, 'large' );
                echo '</div>';
            echo '</div>';
        } ?>

        <br>

        <div>
            <div style="position: relative; left: 250px">
                <a href="<?php echo home_url(); ?>"><span class="bgroundback dashicons dashicons-no-alt"></span></a>
            </div>
        </div>

    </div>




    
</div>

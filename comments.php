<?php
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments">

	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
				$comments_number = get_comments_number();
				if ( 1 === $comments_number ) {
					/* translators: %s: post title */
					printf( _x( 'One thought on &ldquo;%s&rdquo;', 'comments title' ), get_the_title() );
				} else {
					printf(
						/* translators: 1: number of comments, 2: post title */
						_nx(
							'%1$s comentario en &ldquo;%2$s&rdquo;',
							'%1$s comentarios en &ldquo;%2$s&rdquo;',
							$comments_number,
							'comments title'
						),
						number_format_i18n( $comments_number ),
						get_the_title()
					);
				}
			?>
		</h3>

		<?php the_comments_navigation(); ?>

		<ol class="commentlist">
			<?php wp_list_comments( 'reply_text=<i class="fa fa-reply"></i> Responder&type=comment&callback=mytheme_comment' ); ?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.' ); ?></p>
	<?php endif; ?>

	<?php

		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );

		$fields =  array(

		  'author' =>
		    '<p class="comment-form-author"><label for="author">' . __( 'Name' ) . '</label> ' .
		    ( $req ? '<span class="required">*</span>' : '' ) .
		    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
		    '" size="30"' . $aria_req . ' /></p>',

		  'email' =>
		    '<p class="comment-form-email"><label for="email">' . __( 'Email' ) . '</label> ' .
		    ( $req ? '<span class="required">*</span>' : '' ) .
		    '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
		    '" size="30"' . $aria_req . ' /></p>',

		);

		$comments_args = array(
		  'id_form'           => 'commentform',
		  'class_form'        => 'comment-form',
		  'id_submit'         => 'submit',
		  'class_submit'      => 'submit',
		  'name_submit'       => 'submit',
		  'title_reply'       => 'Deje su opinión',
		  'title_reply_to'    => __( 'Leave a Reply to %s' ),
		  'cancel_reply_link' => __( 'Cancel Reply' ),
		  'label_submit'      => 'Publicar',
		  'format'            => 'xhtml',

		  'comment_field' =>  '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) .
		    '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
		    '</textarea></p>',

		  'must_log_in' => '<p class="must-log-in">' .
		    sprintf(
		      __( 'You must be <a href="%s">logged in</a> to post a comment.' ),
		      wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
		    ) . '</p>',

		  'logged_in_as' => '<p class="logged-in-as">' .
		    sprintf(
		    __( 'Identificado como %2$s. <a href="%3$s" title="Cerrar sesión">Cerrar sesión?</a>' ),
		      admin_url( 'profile.php' ),
		      $user_identity,
		      wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
		    ) . '</p>',

		  'comment_notes_before' => '<p class="comment-notes">' .
		    __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) .
		    '</p>',

		  'fields' => apply_filters( 'comment_form_default_fields', $fields ),
		);

		comment_form($comments_args);
	?>

</div><!-- .comments-area -->

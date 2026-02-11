<?php
/**
 * The footer of the theme
 *
 * @package webeez
 */

?>

				</div> <!-- #content-->

				<?php
				/**
				 * Functions hooked into webeez_footer_before action
				 */
				do_action( 'webeez_footer_before' );
				?>

				<footer id="colophon" class="site-footer">

					<?php
					/**
					 * Functions hooked in to webeez_footer action
					 */
					do_action( 'webeez_footer' );
					?>

				</footer> <!-- #colophon-->

				<?php
				/**
				 * Functions hooked into webeez_footer_after action
				 */
				do_action( 'webeez_footer_after' );
				?>

			</div> <!-- #page -->

			<?php wp_footer(); ?>

		</div> <!-- .site-wrapper -->

	</body>
</html>

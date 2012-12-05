<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage Cyon Theme
 */
?>
				<?php cyon_after_body_wrapper(); ?>
			</div>
		</div>

		<?php cyon_after_body(); ?>

		<!-- Footer -->
		<footer id="colophon" role="contentinfo">
			<div class="wrapper">
				<?php cyon_footer(); ?>
			</div>
		</footer>
		
		<?php cyon_after_footer(); ?>

	</div>

<?php wp_footer(); ?>
</body>
</html>
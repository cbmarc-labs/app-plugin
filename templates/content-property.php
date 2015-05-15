<?php
/**
 * The template for displaying property content within loops.
 *
 * Override this template by copying it to yourtheme/content-property.php
 *
 * @author 		marc
 * @package 	app/templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<li>

	<a href="<?php the_permalink(); ?>">

		<h3><?php the_title(); ?></h3>

	</a>

</li>

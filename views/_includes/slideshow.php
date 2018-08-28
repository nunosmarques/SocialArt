<div class="slideshow-container">
	<?php
	$d = 'views/_uploads/_slide';
	$dir = scandir( $d );
	$count = 1;
	foreach ( $dir as $val ) {
		$aux = explode( ".", $val, 2 );
		if ( preg_match( '(\D)', $aux[ 0 ] ) ) {
			if ( $count == 1 ) {
				echo '<div class="mySlides fade" style="display: block;">
							  <img src="' . $d . '/' . $aux[0] . '.' . $aux[1] . '" style="width:100%">
						  </div>';
			} else {
				echo '<div class="mySlides fade">
							  <img src="' . $d . '/' . $aux[0] . '.' . $aux[1] . '" style="width:100%">
						  </div>';
			}
			$count++;
		}
	}
	?>
</div>

<div class="sld-btn" style="text-align:center">
	<?php
	$count = 1;

	foreach ( $dir as $val ) {
		$aux = explode( ".", $val, 2 );
		if ( preg_match( '(\D)', $aux[ 0 ] ) ) {
			echo '<span class="dot" onclick="currentSlide(' . $count . ')"></span>';
			$count++;
		}
	}
	?>
</div>
<script src="views/_js/slideshow.js"></script>
<div class="main-page">
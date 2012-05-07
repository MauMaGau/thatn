<?php if( ! defined('BASEPATH') ) exit('No direct script access allowed');
/**
 * Thatn - Colour deciderer
 *
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>

	<base href="http://dtownsend.co.uk/dev/thatn/" />

	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap-responsive.css">

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

	<script type="text/javascript" src="assets/farbtastic/farbtastic.js"></script>
 	<link rel="stylesheet" href="assets/farbtastic/farbtastic.css" type="text/css" />

	<!--<script type="text/javascript" src="errthatn.js"></script>-->

	<style type="text/css">

		p.coloured			{font-weight: bold;}
		p.coloured.colour_4	{color:#<?php echo isset($colour_4)?$colour_4:'ffffff';?>}
		p.coloured.colour_2	{color:#<?php echo isset($colour_2)?$colour_2:'ffffff';?>}
		p.coloured.colour_1	{color:#<?php echo isset($colour_1)?$colour_1:'ffffff';?>}
		p.coloured.colour0	{color:#<?php echo isset($page_colour)?$page_colour:'ffffff';?>}
		p.coloured.colour1	{color:#<?php echo isset($colour1)?$colour1:'ffffff';?>}
		p.coloured.colour2	{color:#<?php echo isset($colour2)?$colour2:'ffffff';?>}
		p.coloured.colour4	{color:#<?php echo isset($colour4)?$colour4:'ffffff';?>}

		span.coloured			{display:block; width:100%; height:50px;}
		span.coloured.colour_4	{background-color:#<?php echo isset($colour_4)?$colour_4:'ffffff';?>}
		span.coloured.colour_2	{background-color:#<?php echo isset($colour_2)?$colour_2:'ffffff';?>}
		span.coloured.colour_1	{background-color:#<?php echo isset($colour_1)?$colour_1:'ffffff';?>}
		span.coloured.colour0	{background-color:#<?php echo isset($page_colour)? $page_colour:'ffffff';?>}
		span.coloured.colour1	{background-color:#<?php echo isset($colour1)? $colour1:'ffffff';?>}
		span.coloured.colour2	{background-color:#<?php echo isset($colour2)? $colour2:'ffffff';?>}
		span.coloured.colour4	{background-color:#<?php echo isset($colour4)? $colour4:'ffffff';?>}

		p.coloured.colour_sat_4	{color:#<?php echo isset($colour_sat_4)?$colour_sat_4:'ffffff';?>}
		p.coloured.colour_sat_2	{color:#<?php echo isset($colour_sat_2)?$colour_sat_2:'ffffff';?>}
		p.coloured.colour_sat_1	{color:#<?php echo isset($colour_sat_1)?$colour_sat_1:'ffffff';?>}
		p.coloured.colour_sat0	{color:#<?php echo isset($page_colour)?$page_colour:'ffffff';?>}
		p.coloured.colour_sat1	{color:#<?php echo isset($colour_sat1)?$colour_sat1:'ffffff';?>}
		p.coloured.colour_sat2	{color:#<?php echo isset($colour_sat2)?$colour_sat2:'ffffff';?>}
		p.coloured.colour_sat4	{color:#<?php echo isset($colour_sat4)?$colour_sat4:'ffffff';?>}

		span.coloured.colour_sat_4	{background-color:#<?php echo isset($colour_sat_4)?$colour_sat_4:'ffffff';?>}
		span.coloured.colour_sat_2	{background-color:#<?php echo isset($colour_sat_2)?$colour_sat_2:'ffffff';?>}
		span.coloured.colour_sat_1	{background-color:#<?php echo isset($colour_sat_1)?$colour_sat_1:'ffffff';?>}
		span.coloured.colour_sat0	{background-color:#<?php echo isset($page_colour)? $page_colour:'ffffff';?>}
		span.coloured.colour_sat1	{background-color:#<?php echo isset($colour_sat1)? $colour_sat1:'ffffff';?>}
		span.coloured.colour_sat2	{background-color:#<?php echo isset($colour_sat2)? $colour_sat2:'ffffff';?>}
		span.coloured.colour_sat4	{background-color:#<?php echo isset($colour_sat4)? $colour_sat4:'ffffff';?>}

		.secondary-colour{background-color:#<?php echo isset($secondary_colour)? $secondary_colour:'ffffff';?>}
		p.secondary-colour{background-color:#fff; color:#<?php echo isset($secondary_colour)? $secondary_colour:'ffffff';?>; padding:10px;}

		#btn-lighter,#btn-darker{padding-top:4px;}
		#btn-lighter .btn,#btn-darker .btn{padding-top:20px; padding-bottom:20px;}

	</style>

	<script type="text/javascript">

	$(document).ready(function() {
		$('#colorpicker1').hide();

		$('#colorpicker1').farbtastic('#main_colour');

		$('#main_colour').focusin(function(){
			$('#colorpicker1').show();

		});
		$('#main_colour').focusout(function(){
			$('#colorpicker1').hide();

		})

		/* Repetition is the key to learning....right? */

		$('#colorpicker2').hide();

		$('#colorpicker2').farbtastic('#secondary_colour');

		$('#secondary_colour').focusin(function(){
			$('#colorpicker2').show();
		});
		$('#secondary_colour').focusout(function(){
			$('#colorpicker2').hide();
		})

	});

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-10955279-6']);
	  _gaq.push(['_trackPageview']);
	  _gaq.push(['_trackPageLoadTime']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ga);
	  })();

	</script>

</head>
<body class='secondary-colour'>

<div class='container-fluid'>

	<?php if(!empty($display_errors)){
		echo '<ul class="unstyled alert alert-block alert-error"><h4 class="alert-heading">Error</h4>';
		foreach($display_errors as $error){
			echo "<li>$error</li>";
		}
		echo '</ul>';
	} ?>

	<div class='row-fluid'>
		<div class='well clearfix'>
			<section id='main-form' class='span6'>
				<?php echo form_open('',array('class'=>'form-inline clearfix')); ?>
					<!-- <fieldset class='span3 offset2'> -->
						<label for='main_colour'>
							Main colour
						</label>
						<div class='input-prepend'>
							<span class="add-on">#</span><input type='text' maxlength='6' value='<?php echo isset($original_colour)?$original_colour:'000'; ?>' id='main_colour' name='main_colour' placeholder="Main Colour" class='input-small'/>
						</div>
					<!-- </fieldset> -->
					<!-- <fieldset class='span3'> -->
						<label for='secondary_colour'>
							Background colour
						</label>
						<div class='input-prepend'>
							<span class="add-on">#</span><input type='text' value='<?php echo isset($secondary_colour)?$secondary_colour:'fff'; ?>' id='secondary_colour' name='secondary_colour' placeholder="Background" class='input-small'/>
						</div>
					<!-- </fieldset> -->
					<!-- <fieldset class='span2'> -->
						<input type='submit' id='main-submit' value='Go' class='btn'/>
						<span></span>
						<div id="colorpicker1"></div>
						<div id="colorpicker2"></div>
					<!-- </fieldset> -->
				</form>
			</section>
			<section class='span4 offset2'>
				<a href='https://github.com/MauMaGau/thatn' class='btn'>View Source</a>
				<a href='https://gist.github.com/2583140' class='btn'>Just the gist</a>
				<a href='http://dtownsend.co.uk' class='btn'>Made by me</a>
			</section>
	</div>

	<?php
		if(
			!empty($original_colour)
			&& !empty($colour_4)
		){
	?>

<h3 class='well'>Lightness <small></small></h3>
	<div class='row-fluid'>

		<?php $lighter_link = 'thatn/'.
			$original_colour.'/'.
			(($secondary_colour)?$secondary_colour:'0').'/'.
			($page-1);
			$disabled = ($page_colour ==='ffffff')?'disabled':'';
		?>
		<section class='span1' id='btn-lighter'>
			<a <?php if(empty($disabled)):?>href='<?php echo $lighter_link;?>'<?php endif;?> class='btn btn-primary <?php echo $disabled; ?>'>Lighter<br><i class='icon-arrow-left icon-white'></i></a>
		</section>

		<section id='lighter' class='span4'>
			<div class='row-fluid'>
				<p class='span4 coloured colour_4'>
					Much Lighter
					<span class='coloured colour_4'></span>
					<?php echo $colour_4; ?>
				</p>

				<p class='span4 coloured colour_2' >
					More Lighter
					<span class='coloured colour_2'></span>
					<?php echo $colour_2; ?>
				</p>

				<p class='span4 coloured colour_1' >
					Lighter
					<span class='coloured colour_1'></span>
					<?php echo $colour_1; ?>
				</p>
			</div>
		</section>

		<section id='input-colour' class='span2'>
			<div class='row-fluid'>
				<p class='span12 coloured colour0'>
					Main colour
					<span class='coloured colour0'></span>
					<?php echo $page_colour; ?>
				</p>
			</div>
		</section>

		<section id='darker' class='span4'>
			<div class='row-fluid'>
				<p class='span4 coloured colour1'>
					Darker
					<span class='coloured colour1'></span>
					<?php echo $colour1; ?>
				</p>
				<p class='span4 coloured colour2'>More Darker
					<span class='coloured colour2'></span>
				<?php echo $colour2; ?>
				</p>
				<p class='span4 coloured colour4'>Much Darker
					<span class='coloured colour4'></span>
					<?php echo $colour4; ?>
				</p>
			</div>
		</section>

		<?php $darker_link = 'thatn/'.
			$original_colour.'/'.
			(($secondary_colour)?$secondary_colour:'0').'/'.
			($page+1);
			$disabled = ($page_colour ==='000000')?'disabled':'';
		?>
		<section class='span1' id='btn-lighter'>
			<a <?php if(empty($disabled)):?>href='<?php echo $darker_link;?>'<?php endif;?> class='btn btn-primary <?php echo $disabled; ?> pull-right'>Darker<br><i class='icon-arrow-right icon-white'></i></a>
		</section>
	</div>

	<?php
		}
	?>

	<?php if( ! empty($colour_sat_1) ){ ?>
	<h3 class='well'>Saturation</h3>
	<div class='row-fluid'>
		<section id='whiter' class='span5'>
			<div class='row-fluid'>
				<p class='span4 coloured colour_sat_4'>
					Much Less saturated
					<span class='coloured colour_sat_4'></span>
					<?php echo $colour_sat_4; ?>
				</p>

				<p class='span4 coloured colour_sat_2' >
					A bit less saturated
					<span class='coloured colour_sat_2'></span>
					<?php echo $colour_sat_2; ?>
				</p>

				<p class='span4 coloured colour_sat_1' >
					Less saturated
					<span class='coloured colour_sat_1'></span>
					<?php echo $colour_sat_1; ?>
				</p>
			</div>
		</section>

		<section id='input-colour' class='span2'>
			<div class='row-fluid'>
				<p class='span12 coloured colour0'>
					Main colour
					<span class='coloured colour0'></span>
					<?php echo $page_colour; ?>
				</p>
			</div>
		</section>

		<section id='darker' class='span5'>
			<div class='row-fluid'>
				<p class='span4 coloured colour_sat1'>
					More saturated
					<span class='coloured colour_sat1'></span>
					<?php echo $colour_sat1; ?>
				</p>
				<p class='span4 coloured colour_sat2'>
					A bit more saturation
					<span class='coloured colour_sat2'></span>
					<?php echo $colour_sat2; ?>
				</p>
				<p class='span4 coloured colour_sat4'>
					Much more saturation
					<span class='coloured colour_sat4'></span>
					<?php echo $colour_sat4; ?>
				</p>
			</div>
		</section>
	</div>
	<?php } ?>

	<?php
		if(
			!empty($secondary_colour)
			&& empty($display_errors)
		){
	?>
	<h3 class='well'>
		Background: #<?php echo $secondary_colour; ?>
	</h3>
	<?php
		}
	?>


</div><!-- container -->

</body>
</html>
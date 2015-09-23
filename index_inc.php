<link rel="stylesheet" href="flexslider/flexslider.css" type="text/css" media="screen" />

<script src="bitrix/js/main/jquery/jquery-1.8.3.min.js"></script>
<!--
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
-->
<script defer src="flexslider/jquery.flexslider.js"></script>

<script>
// Can also be used with $(document).ready()
$(window).load(function() {
  $('.flexslider').flexslider({
    animation: "slide",
	controlNav: false
  });
});
</script>
<!-- Place somewhere in the <body> of your page -->
<div class="flexslider" style="width: 100%;">
	<ul class="slides">
		<li>
			<img src="images/kitchen_adventurer_cheesecake_brownie.jpg" />
		</li>
		<li>
			<img src="images/kitchen_adventurer_lemon.jpg" />
		</li>
		<li>
			<img src="images/kitchen_adventurer_donut.jpg" />
		</li>
		<li>
			<img src="images/kitchen_adventurer_caramel.jpg" />
		</li>
	</ul>
</div>
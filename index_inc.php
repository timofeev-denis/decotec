<!-- FlexSlider -->
<script defer src="js/jquery.flexslider-min.js"></script>

<script>
$(window).load(function() {
  $('.flexslider').flexslider({
    animation: "slide"
  });
});
</script>
<!-- Place either at the bottom in the <head> of your page or inside your CSS -->
<style type="text/css">
.flex-caption {
  width: 96%;
  padding: 2%;
  left: 0;
  bottom: 0;
  background: rgba(0,0,0,.5);
  color: #fff;
  text-shadow: 0 -1px 0 rgba(0,0,0,.3);
  font-size: 14px;
  line-height: 18px;
}
</style>
<!-- Place somewhere in the <body> of your page -->
<div class="flexslider">
  <ul class="slides">
    <li>
      <img src="slide1.jpg" />
      <p class="flex-caption">Adventurer Cheesecake Brownie</p>
    </li>
    <li>
      <img src="slide2.jpg" />
      <p class="flex-caption">Adventurer Lemon</p>
    </li>
    <li>
      <img src="slide3.jpg" />
      <p class="flex-caption">Adventurer Donut</p>
    </li>
    <li>
      <img src="slide4.jpg" />
      <p class="flex-caption">Adventurer Caramel</p>
    </li>
  </ul>
</div>
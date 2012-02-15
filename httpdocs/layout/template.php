<?php echo $this->loadLayout('header.php'); ?>

<header>
	<h1 class="mainHeading">xBoilerplate</h1>
	<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
	<?php
		echo $this->getMenu('top');
		echo $this->getMenu();
	?>
</header>
<section>
	<?php echo $this->loadPage(); ?>
	<h2>xBoilerplate</h2>
	xBoilerplate was built to kickstart the development of small dynamic webpages. It can also be used to design websites or web applications directly in css 3. xBoilerplate is inspired by HTML5 Boilerplate and lots of code is copied from HTML5 Boilerplate. The main difference is that xBoilerplate allows dynamic pages with PHP and includes dynamic libraries like lessphp.

	<h2>Getting Started</h2>
	To get you started as fast as possible, xBoilerplate uses Vagrant. The only thing you have to do to setup the project and have it running in Apache is to execute vagrant up. Sure, you have to install vagrant first.

	<h2>Documentation</h2>
	Should follow soon

	<h2>Changes</h2>
	For changes in the API please check the file changes.txt
</section>
<footer>
	&copy; xBoilerplate
</footer>

<?php echo $this->loadLayout('footer.php'); ?>

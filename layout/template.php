<?php echo $this->loadLayout('header.php'); ?>

<header>
	<?php
		echo $this->getMenu('top');
		echo $this->getMenu();
	?>
</header>
<section>
	<?php echo $this->loadPage(); ?>
</section>
<footer>
	<p id="copyright">&copy; Xodoa.com</p>
</footer>

<?php echo $this->loadLayout('footer.php'); ?>

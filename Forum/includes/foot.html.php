</div>
<footer>
	<?php if(userHasRole('Admin')): ?>
		<a class="button" href="/Admin/">Administration Area</a>
	<?php endif; ?>
	<br>
	The contents of this web page are copyright &copy; 2014&ndash;<?php echo date('Y'); ?> Aidan Dunn All Rights Reserved.
</footer>
<script src="/js/textarea_resizer.js" />
</body>
</html>
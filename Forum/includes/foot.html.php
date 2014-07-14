	</div>
	<footer>
		<?php if(userHasRole('Admin')): ?>
			<a class="button" href="/Forum/Admin/">Administration Area</a>
		<?php endif; ?>
		<br><br>
		The contents of this web page are copyright &copy; 2014&ndash;<?php echo date('Y'); ?> Aidan Dunn All Rights Reserved.
	</footer>
	<script src="/Forum/js/textarea_resizer.js" />
</body>
</html>
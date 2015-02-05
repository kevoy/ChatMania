<div id='footer'>
	<a id='footer-credits'>Copyright 2014 Chat Mania</a></br>
	<a class='footer-attr'>Chat Mania Script Developed by A.Thompson & J.Thompson</a></br>
	<a class='footer-attr'>Image Credits: </a><a class='footer-attr' href="http://www.visualpharm.com" rel='nofollow'> VisualPharm | </a><a class='footer-attr' href="http://www.aha-soft.com" rel='nofollow'>aha-soft | </a>
	<a class='footer-attr' href="http://www.iconka.com/" rel='nofollow'>iconka</a>
	<script src="prototype.js"></script>
	<script type='text/javascript'>
		function addCount(){
			new Ajax.Request(
				"stats.php?addcount=true",
				{
					method: 'get'
				}
				);
		}
		addCount();
	</script>
</div>
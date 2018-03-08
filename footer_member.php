  <footer class="page-footer dark">
    
    <div class="container">
      <div class="row">
	      
        <div class="col l6 s12">
          <h5 class="white-text">Suivez-nous</h5>
		  <ul>
		    <li class="social-icon"><a href="https://www.facebook.com/watchifyio"><i class="fa fa-facebook"></i></a></li>
		    <li class="social-icon"><a href="https://www.linkedin.com/"><i class="fa fa-linkedin"></i></a></li>
		    <li class="social-icon"><a href="https://twitter.com/"><i class="fa fa-twitter"></i></a></li>
		    <li class="social-icon"><a href="https://plus.google.com/"><i class="fa fa-google-plus"></i> </a></li>
		  </ul>
        </div> <!-- .col l6 s12 -->
        
        <div class="col l3 s12 right">
          <h5 class="white-text">Société</h5>
          <ul>
            <li><a class="white-text" href="#!">À propos</a></li>
            <li><a class="white-text" href="#!">Presse</a></li>
            <li><a class="white-text" href="#!">Aide</a></li>
            <li><a class="white-text" href="#!">Blog</a></li>
            <li><a class="white-text" href="#!">Opportunités</a></li>
            <li><a class="white-text" href="#!">CGU</a></li>
            <li><a class="white-text" href="#!">Confidentialité</a></li>
          </ul>
        </div> <!-- .col l3 s12 right -->
        
      </div> <!-- .row -->
    </div> <!-- .container -->
    
    <div class="footer-copyright">
      <div class="container">
      watchify, Inc. © <script>document.write(new Date().getFullYear())</script>
      </div>
    </div>
    
  </footer>

  <!--  Scripts-->
  <script src="https://www.watchify.io/js/jquery-ias.min.js"></script>
  <script src="https://www.watchify.io/js/jquery.validate.min.js"></script>
  <script src="https://www.watchify.io/js/additional-methods.min.js"></script>
  <script src="https://www.watchify.io/js/localization/messages_fr.min.js"></script>
  <script src="https://www.watchify.io/js/materialize.min.js"></script>
  
  <script src="https://www.watchify.io/js/init.js"></script>
  <script src="https://www.watchify.io/js/buttons-action.js"></script>
  <script src="https://www.watchify.io/js/validation-password.js"></script>
  <script src="https://www.watchify.io/js/validation-profile.js"></script>
  <script src="https://www.watchify.io/js/validation-add-youtuber.js"></script>
  
  <script type="text/javascript">
    var ias = jQuery.ias({
      container:  '#videos-content',
      item:       '.video-item',
      pagination: '#pagination',
      next:       '.next'
    });
    ias.extension(new IASSpinnerExtension({
        html: '<br><center><div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div></center>', // optionally
    }));
    
    ias.on('rendered', function(items) {
    var $items = $(items);

    $items.each(function() {
      $('.dropdown-button.menu-button', this).dropdown({
        constrain_width: false, // Does not change width of dropdown to that of the activator
        hover: true, // Activate on hover
        belowOrigin: false, // Displays dropdown below the button
      });
    });
})
  </script>
  
  <script type="text/javascript">
		$(document).ready(function() {
			$("#recherche").keyup(function() {
				var myID = <?php echo $myID; ?>;
				var recherche = $(this).val();
				var data = 'motclef=' + recherche + '&myID=' + myID;
				
				if (recherche.length >= 1) {

					$.ajax({
						type: 'GET',
						url: 'https://www.watchify.io/result.php',
						data: data,
						success: function (server_response) {
							$("#resultat").html(server_response).show();
						}
					});
					
				}
				
			});
		});
  </script>

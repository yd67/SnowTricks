var form =  document.getElementById('comment-form');
var formPosition = document.getElementById('form-emplacement');
var btnAnuller = document.getElementById('annuler-reponse')
var btn = document.querySelectorAll('.reply')

btnAnuller.style.visibility = 'hidden' ;

	btn.forEach(function(element) {
  		element.addEventListener('click', function() {

		var id = this.getAttribute('data-id') ;
		var comment = document.getElementById('comment-'+id);

        comment.after(form) ;
		document.querySelector('#comments_parent').value = id ;
		
		var divPosition = document.getElementById('annuler-position-'+id);
		divPosition.after(btnAnuller) ;
		btnAnuller.style.visibility = 'visible' ;
  		})
	})
    
	btnAnuller.addEventListener("click", myFunction);

	function myFunction() {
		document.querySelector('#comments_parent').value = null ;

		formPosition.after(form);
		btnAnuller.style.visibility = 'hidden' ;
	} 
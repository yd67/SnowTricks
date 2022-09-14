var btn = document.querySelectorAll('.reply')
	btn.forEach(function(element) {
  		element.addEventListener('click', function() {

		var id = this.getAttribute('data-id') ;
		var form =  document.getElementById('comment-form');
		var comment = document.getElementById('comment-'+id);

        comment.after(form) ;
		document.querySelector('#comments_parent').value = id ;
		
  		})
	})
let form = document.getElementById('comment-form');
let formPosition = document.getElementById('form-emplacement');
let btnAnuller = document.getElementById('annuler-reponse')
let btn = document.querySelectorAll('.reply')

btnAnuller.style.visibility = 'hidden';
btn.forEach(function (element) {
	element.addEventListener('click', function () {

		let id = this.getAttribute('data-id');
		let comment = document.getElementById('comment-' + id);

		comment.after(form);
		document.querySelector('#comments_parent').value = id;

		let divPosition = document.getElementById('annuler-position-' + id);
		divPosition.after(btnAnuller);
		btnAnuller.style.visibility = 'visible';
	})
})

btnAnuller.addEventListener("click", myFunction);

function myFunction() {
	document.querySelector('#comments_parent').value = null;

	formPosition.after(form);
	btnAnuller.style.visibility = 'hidden';
} 
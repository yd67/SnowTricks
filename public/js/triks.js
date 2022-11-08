const addFormToCollection = (e) => {
  const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

  const item = document.createElement('li');

  item.innerHTML = collectionHolder
    .dataset
    .prototype
    .replace(
      /__name__/g,
      collectionHolder.dataset.index
    );

  collectionHolder.appendChild(item);

  collectionHolder.dataset.index++;

  addTagFormDeleteLink(item);
};
document
  .querySelectorAll('.add_item_link')
  .forEach(btn => {
    btn.addEventListener("click", addFormToCollection)
  });

// #### remove 
const addTagFormDeleteLink = (item) => {
  const removeFormButton = document.createElement('button');
  removeFormButton.innerText = 'retirer';
  item.append(removeFormButton);

  removeFormButton.addEventListener('click', (e) => {
    e.preventDefault();
    // remove the li for the tag form
    item.remove();
  });
}
document
  .querySelectorAll('ul.video li')
  .forEach((tag) => {
    addTagFormDeleteLink(tag)
  })


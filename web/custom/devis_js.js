var $collectionHolder;

// setup an "add a expeience" link
var $addDevisProduitLink = jQuery('<a href="#" class="add_devisProduit_link"> + Ajouter un Produit</a>');
var $newLinkLi = jQuery('<li></li>').append($addDevisProduitLink);

jQuery(document).ready(function() {

    // Get the ul that holds the collection of expeiences
    $collectionHolder = jQuery('ul.devisProduits');
    // add a delete link to all of the existing tag form li elements
    $collectionHolder.find('li').each(function() {
        addTagFormDeleteLink(jQuery(this));
    });

    // add the "add a expeience" anchor and li to the expeiences ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    jQuery('.add_devisProduit_link').on('click', function(e) {

        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new expeience form (see next code block)
        addDevisProduitForm($collectionHolder, $newLinkLi);

    });

});
function addTagFormDeleteLink($tagFormLi) {
    var $removeFormA = jQuery('<a href="#" > - Effacer Cette DevisProduit</a>');
    $tagFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $tagFormLi.remove();
    });
}
function addDevisProduitForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');
    console.log(index);
    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your expeiences field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);
    console.log(newForm);
    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);


    var $newFormLi = jQuery('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
    addTagFormDeleteLink($newFormLi);
}



function removeNewInput(e) {
    let subcatInputsCount = document.getElementsByClassName('input-group-text').length - 1;
    if (subcatInputsCount === 1) {
        return false;
    }
    let target = e.target;
    let parent = findAncestor(target, 'form-group');
    parent.remove();
}
//TODO:Знести все к чортової бабушки та переписати без ГОВНОкоду
function addNewInput(e) {
    // let subcatInputsCount = document.getElementsByName('subcategory_title').length;
    let subcatInputsCount = document.getElementsByClassName('input-group-text').length - 1;
    if (subcatInputsCount === 10) return false;
    let whatToPaste = '<div class="form-group">' +
        '                <div class="input-group">' +
        '                    <div class="input-group-prepend">' +
        '                        <span class="input-group-text">Subcategory title</span>' +
        '                    </div>' +
        '                    <input placeholder="Leave it empty if you don\'t need it" name=\"subcategory_title['+ subcatInputsCount +']\" type="text" value="" maxlength="30" class="form-control">' +
        '                    <div class="input-group-append">' +
        '                        <button name="add_new_input" class="btn btn-outline-success" onclick="addNewInput(event)" type="button"><i class="fa fa-plus"></i></button>' +
        '                        <button name="remove_new_input" class="btn btn-outline-danger" onclick="removeNewInput(event)" type="button"><i class="fa fa-minus"></i></button>' +
        '                    </div>' +
        '                  </div>' +
        '               </div>';
    let target = e.target;
    let parent = findAncestor(target, 'form-group');
    // let parentClone = parent.cloneNode(true);
    parent.insertAdjacentHTML('afterEnd', whatToPaste);
    // parent.insertAdjacentElement('afterEnd', whatToPaste);

    //clear new input value and move focus on it
    /*let parentCloneInput = parentClone.getElementsByClassName('form-control')[0];
    parentCloneInput.className = 'form-control';
    parentCloneInput.value = '';
    parentCloneInput.name = 'subcategory_title[' + subcatInputsCount + ']';
    parentCloneInput.focus();*/
}
function findAncestor (el, cls) {
    while ((el = el.parentElement) && !el.classList.contains(cls));
    return el;
}

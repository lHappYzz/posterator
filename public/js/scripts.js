function removeNewInput(e) {
    let subcatInputsCount = document.getElementsByClassName('input-group-text').length - 1;
    if (subcatInputsCount === 1) {
        let whatToPaste = '<div id="noCategoriesInfo" class=" text-center alert alert-info">' +
            '                <h3>No subcategories</h3>' +
            '                <button name="add_new_input" class="btn btn-outline-success" onclick="addNewInput(event)" type="button"><i class="fa fa-plus"></i></button>' +
            '            </div>';
        let target = e.target;
        let parent = findAncestor(target, 'form-group');
        parent.insertAdjacentHTML('afterEnd', whatToPaste);
        parent.remove();
        return true;
    }
    let target = e.target;
    let parent = findAncestor(target, 'form-group');
    parent.remove();
}
function addNewInput(e) {
    let subcatInputsCount = document.getElementsByClassName('input-group-text').length - 1;
    let whatToPaste = '<div class="form-group">' +
        '                <div class="input-group">' +
        '                    <div class="input-group-prepend">' +
        '                        <span class="input-group-text">Subcategory title</span>' +
        '                    </div>' +
        '                    <input placeholder="Leave it empty if you don\'t need it" name=\"subcategory_title[new_input_'+ subcatInputsCount +'][0]\" type="text" value="" maxlength="30" class="form-control">' +
        '                    <div class="input-group-append">' +
        '                        <button name="add_new_input" class="btn btn-outline-success" onclick="addNewInput(event)" type="button"><i class="fa fa-plus"></i></button>' +
        '                        <button name="remove_new_input" class="btn btn-outline-danger" onclick="removeNewInput(event)" type="button"><i class="fa fa-minus"></i></button>' +
        '                    </div>' +
        '                  </div>' +
        '               </div>';
    if (subcatInputsCount === 10) return false;
    if (subcatInputsCount === 0) {
        let infoDiv = document.getElementById('noCategoriesInfo');
        let devWhithIdSubcategories = document.getElementById('subcategories');
        infoDiv.style.display = 'none';
        devWhithIdSubcategories.insertAdjacentHTML('afterBegin', whatToPaste);
        return true;
    }
    let target = e.target;
    let parent = findAncestor(target, 'form-group');
    parent.insertAdjacentHTML('afterEnd', whatToPaste);
}
function findAncestor (el, cls) {
    while ((el = el.parentElement) && !el.classList.contains(cls));
    return el;
}

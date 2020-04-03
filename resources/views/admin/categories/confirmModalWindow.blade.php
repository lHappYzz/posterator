<div class="modal fade" id="ModalCenter{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalCenterTitle">{{$modalTitle}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the category: "{{$category->title}}"</p>
            </div>
            <div class="modal-footer">
                <form method="post" action="{{ route('admin.category.destroy', ['category' => $category->id]) }}">
                    @csrf
                    @method('delete')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" value="delete" class="btn btn-outline-primary">Continue</button>
                </form>
            </div>
        </div>
    </div>
</div>

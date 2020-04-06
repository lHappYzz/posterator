<div class="modal fade" id="ModalCenter{{$model->id}}" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalCenterTitle">{{$modalTitle}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
{{--                <p>Are you sure you want to delete the category: "{{$model->title}}"</p>--}}
                <p>{{$message}}</p>
            </div>
            <div class="modal-footer">
                <form method="post" action="{{ $action }}">
                    @csrf
                    @method('delete')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" value="delete" class="btn btn-outline-primary">Continue</button>
                </form>
            </div>
        </div>
    </div>
</div>

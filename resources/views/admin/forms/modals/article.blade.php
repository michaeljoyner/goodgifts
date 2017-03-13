<div class="modal fade gg-modal" id="create-article-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Begin A New Article</h4>
            </div>
            <form action="/admin/articles" method="POST" class="modal-form gg-form form-horizontal">
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label for="title">Title: </label>
                        @if($errors->has('title'))
                        <span class="error-message">{{ $errors->first('title') }}</span>
                        @endif
                        <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                    </div>
                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description">Description: </label>
                        @if($errors->has('description'))
                        <span class="error-message">{{ $errors->first('description') }}</span>
                        @endif
                        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dd-btn btn-light dd-modal-cancel-btn" data-dismiss="modal">Cancel
                    </button>
                    <button type="submit" class="btn dd-btn dd-modal-confirm-btn">Post</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<form action="{{ $action }}" method="POST">
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-md-10">
            <div class="form-group">
                {!! Form::textarea('body', old('body'), ['class' => 'form-control', 'rows' => '8', 'placeholder'=> '']) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <button class="btn btn-primary btn-sm" type="submit" id="main-reply-button">Reply</button>
    </div>
</form>
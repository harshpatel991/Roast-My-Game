<form action="{{ $action }}" method="POST">
    {!! csrf_field() !!}

    <div class="form-group">

        <textarea class="form-control" name="body" rows="5"></textarea>
    </div>

    <div class="form-group">
        <button class="btn btn-light-blue btn-sm" type="submit">Reply</button>
    </div>
</form>
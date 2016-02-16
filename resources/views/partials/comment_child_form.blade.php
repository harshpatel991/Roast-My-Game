<form class="reply-form" action="' + $(this).data('url') + '" method="post">\
    {!! csrf_field() !!}\
    <div class="form-group">\
        <label for="body">Comment</label>\
        <textarea class="form-control" name="body" rows=5></textarea>\
    </div>\
    <div class="form-group">\
        <button class="btn btn-primary btn-sm" name="child-reply-button" type="submit">Reply</button>\
    </div>\
</form>
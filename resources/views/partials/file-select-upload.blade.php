<div class="form-group" id="form_group_{{ $platformName }}">
    <label for="link_platform_{{ $platformName }}" class="col-sm-2 control-label form-label">{{ \App\Game::$platformDropDown[$platformName] }}</label>

    {{--You can get with this--}}
    <div id="file_input_wrapper_{{ $platformName }}">
        <div class="col-sm-6">
            <input type="file" id="file_select_{{ $platformName }}" class="form-control" value="" autocomplete="off"/>
            <div id="file_name_display_{{ $platformName }}" class="form-control placeholder-dark" readonly="readonly" style="display:none;"></div>
            <input id="file_name_{{ $platformName }}" name="file_name_{{ $platformName }}" type="hidden" value="" autocomplete="off">
            <div id="error_message_{{ $platformName }}" class="help-block error-help-block"></div>
            <a href="javascript: void(0)" onclick="showLinkInput('{{ $platformName }}')" id="add-link-instead-{{ $platformName }}">or add an link instead</a>
        </div>
        <div class="col-sm-4">
            <a class="btn btn-default" id="upload_button_{{ $platformName }}" onclick="uploadFile('{{$game->slug}}', '{{ $platformName }}')">Upload</a>
            <a class="btn btn-danger" id="delete_button_{{ $platformName }}" onclick="deleteFile('{{$game->slug}}', '{{ $platformName }}')" style="display:none;">Remove</a>
        </div>
    </div>

    {{--Or you can get with this--}}
    <div id="link_input_wrapper_{{ $platformName }}" style="display:none;">
        <div class="col-sm-6">
            <input id="link_input_{{ $platformName }}" name="link_input_{{ $platformName }}" class="form-control" type="text" value="" autocomplete="off">
            <a href="javascript: void(0)" onclick="showFileInput('{{ $platformName }}')" id="add-file-instead-{{ $platformName }}">or upload a file instead</a>
        </div>
    </div>

</div>
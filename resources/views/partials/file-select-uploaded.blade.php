{{--<div class="form-group">--}}
    {{--<label for="link_platform_{{ $platformName }}" class="col-sm-2 control-label form-label">{{ $platformName }}</label>--}}

    {{--<div class="col-sm-4">--}}
        {{--<input type="file" id="file-select-{{ $platformName }}" name="file-select"/>--}}
    {{--</div>--}}

    {{--<a class="btn btn-default" id="upload-button" onclick="uploadFile('{{ $platformName }}')">Upload</a>--}}
    {{--<a class="btn btn-danger" id="upload-button" onclick="deleteFile('{{ $platformName }}')">Delete</a>--}}
{{--</div>--}}

{{--<script>--}}

    {{--function uploadFile(event) {--}}
        {{--var errorMessage = "";--}}
        {{--fileSelect = document.getElementById('file-select-{{ $platformName }}');--}}
        {{--this.innerHTML = 'Uploading...';--}}

        {{--var files = fileSelect.files;--}}
        {{--if (files.length == 0) {--}}
            {{--errorMessage = "Select a file";--}}
        {{--}--}}

        {{--var formData = new FormData();--}}
        {{--var file = files[0];--}}
        {{--formData.append('file', file, file.name);--}}

        {{--var xhr = new XMLHttpRequest();--}}
        {{--xhr.open('POST', '/save-file/{game_slug}/{version_slug}', true);--}}
        {{--xhr.onload = function () {--}}
            {{--if (xhr.status === 200) {--}}
                {{--// File(s) uploaded.--}}
                {{--uploadButton.innerHTML = 'Upload';--}}
            {{--} else {--}}
                {{--alert('An error occurred!');--}}
            {{--}--}}
        {{--};--}}
        {{--xhr.send(formData);--}}
    {{--}--}}
{{--</script>--}}
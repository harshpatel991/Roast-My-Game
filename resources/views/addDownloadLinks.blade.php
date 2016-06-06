@extends('app')

@section('page-title')Add Downloads - {{Config::get('app.name')}}@endsection

@section('navbar')
    @include('partials/fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="content-background">
                    @include('partials.display-input-error')
                    <h1 class="form-title" style="margin-bottom: 10px;">Add Downloads</h1>

                    <p class="small add-game-explanation">
                        <b>Accepted Types: </b>ZIP
                        <b>Max File Size: </b>20MB
                    </p>

                    {!! Form::open(array('url' => secure_url('/add-downloads/'.$game->slug), 'class'=>'form-horizontal', 'files'=>true, 'id'=>'add-downloads-form')) !!}

                        @foreach(\App\Game::$platforms as $platform)
                            @include('partials.file-select-upload', ['game' => $game, 'platformName' => $platform])
                        @endforeach

                        <div class="row">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button id="add-downloads" type="submit" class="btn btn-success">Save Downloads</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <div class="col-md-8 col-md-offset-2">
        @include('partials/footer')
    </div>
@endsection

@section('scripts')

    <script>
        function setLinkInputValue(platformName, value) {
            showLinkInput(platformName);
            var linkInput = $('#link_input_'+platformName);
            linkInput.val(value);
        }

        function setFileInputValue(platformName, value) {
            showFileInput(platformName);
            afterSuccessfulFileUpload($('#file_name_display_'+platformName), $('#file_name_'+platformName), $('#file_select_'+platformName), $('#upload_button_'+platformName), $('#delete_button_'+platformName), '', value);
        }

        function showLinkInput(platformName) {
            var fileInputWrapper = $('#file_input_wrapper_'+platformName);
            var linkInputWrapper = $('#link_input_wrapper_'+platformName);
            fileInputWrapper.hide();
            linkInputWrapper.show();
            reset(platformName);
        }

        function showFileInput(platformName) {
            var fileInputWrapper = $('#file_input_wrapper_'+platformName);
            var linkInputWrapper = $('#link_input_wrapper_'+platformName);
            fileInputWrapper.show();
            linkInputWrapper.hide();
            reset(platformName);
        }

        function uploadFile(gameSlug, platformName) {
            var fileSelect = $('#file_select_'+platformName);
            var fileNameDisplay = $('#file_name_display_'+platformName);
            var fileName = $('#file_name_'+platformName);
            var uploadButton = $('#upload_button_'+platformName);
            var deleteButton = $('#delete_button_'+platformName);

            reset(platformName);
            var files = fileSelect[0].files;

            if (files.length === 0) {
                showError(platformName, "Select a file");
                return;
            }

            uploadButton.text('Uploading...');

            var formData = new FormData();
            var file = files[0];
            formData.append('file', file);

            fileSelect.hide();
            fileNameDisplay.show();

            var xhr = new XMLHttpRequest();
            xhr.upload.onprogress = function(event) {
                var percentComplete = Math.round((event.loaded / event.total)*100);

                if (percentComplete == 100) {
                    fileNameDisplay.html('Processing');
                } else {
                    fileNameDisplay.html(percentComplete + '% Uploaded');
                }
            }

            xhr.open('POST', '/save-file/'+gameSlug+'/'+platformName, true);
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhr.setRequestHeader('X-Requested-With', "XMLHttpRequest"); //makes laravel know it was AJAX request

            xhr.onload = function () {
                if (xhr.status === 200) {
                    downloadLink = xhr.responseText;
                    afterSuccessfulFileUpload(fileNameDisplay, fileName, fileSelect, uploadButton, deleteButton, file.name, downloadLink);
                } else {
                    errors = JSON.parse(xhr.responseText).file;
                    reset(platformName);
                    showError(platformName, "Error: " + errors[0]);
                }
            };

            xhr.onerror = function() { //catch all for errors
                reset(platformName);
                showError(platformName, "Error");
            };
            xhr.send(formData);
        }

        function afterSuccessfulFileUpload(fileNameDisplay, fileName, fileSelect, uploadButton, deleteButton, fileNameValue, downloadLink) {
            fileNameDisplay.show();
            fileNameDisplay.html("Uploaded " + fileNameValue);
            fileName.val(downloadLink);
            fileSelect.hide();
            uploadButton.hide();
            deleteButton.show();
        }

        function deleteFile(gameSlug, platformName) {
            reset(platformName);
            //TODO:can send a delete request to server
        }

        function showError(platformName, errorMessageString) {
            var formGroup = $('#form_group_'+platformName);
            var errorMessage = $('#error_message_'+platformName);

            formGroup.addClass('has-error');
            errorMessage.text(errorMessageString);
        }

        function reset(platformName) {
            var formGroup = $('#form_group_'+platformName);
            var fileSelect = $('#file_select_'+platformName);
            var fileNameDisplay = $('#file_name_display_'+platformName);
            var fileName = $('#file_name_'+platformName);
            var linkInput = $('#link_input_'+platformName);
            var uploadButton = $('#upload_button_'+platformName);
            var deleteButton = $('#delete_button_'+platformName);
            var errorMessage = $('#error_message_'+platformName);

            formGroup.removeClass('has-error');
            fileNameDisplay.hide();
            fileNameDisplay.html("");
            fileName.val("");
            linkInput.val("");
            fileSelect.show();
            uploadButton.text('Upload');
            uploadButton.show();
            deleteButton.hide();
            errorMessage.text("");
        }

        {!! $oldDownloadValues !!}
    </script>

@endsection


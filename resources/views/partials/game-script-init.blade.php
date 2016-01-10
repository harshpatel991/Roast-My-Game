<script>
    tinymce.init({
        selector: '#description',
        menubar: '',
        toolbar: 'bold italic | link image | bullist numlist',
        plugins: [
            'advlist autolink link'
        ],
        statusbar: false,
        content_css: '/css/tinymce.css',
        skin: "custom",

        forced_root_block : false,
        force_p_newlines : false
    });
</script>
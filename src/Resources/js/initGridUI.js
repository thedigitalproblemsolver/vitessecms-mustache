var initGridUI = function() {
    var layoutEditor = $('#layout_editor');
    if( $.isFunction($.fn.gridEditor) && layoutEditor.length > 0) {
        layoutEditor.gridEditor({
            new_row_layouts: [[12], [6, 6], [9, 3],[3, 9],[3, 3, 3, 3]],
            content_types: ['summernote'],
            summernote: {
                config: {
                    callbacks: {
                        onInit: function() {
                            var element = this;
                        }
                    }
                }
            }
        });
        $('#layout_editor_fields a').on('click', function(e){
            e.preventDefault();
            $('.note-editable').append('{DATAFIELD;'+$(this).attr('id')+'}<br />');
        });
        $('#layout_editor_blocks a').on('click', function(e){
            e.preventDefault();
            $('.note-editable').append('{BLOCK;'+$(this).attr('id')+'}<br />');
        });
        $('#layout_editor_button_save').on('mouseover', function (e) {
            $('#html').val(layoutEditor.gridEditor('getHtml'));
        });
    }
};

inits.push(initGridUI);
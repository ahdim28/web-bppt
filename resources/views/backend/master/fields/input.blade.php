<script>
    $('#current_field').show();
    $('#field_category').change(function() {
        $('#current_field').hide();
        $(".class-div").remove();
        var id = $(this).val();
        if (id) {
            $.ajax({
                type : "GET",
                url : "/api/field?category_id=" + id,
                success : function(data) {
                    
                    if(data) {

                        if (data.field.length > 0) {
                            $.each(data.field, function(key, value) {

                                var append = ``;
                                if (value.type == 0 && value.classes == 0) {
                                    append += `
                                        <div class="form-group row class-div">
                                            <label class="col-form-label col-sm-2 text-sm-right">`+value.label+`</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control mb-1" name="field_`+value.name+`"
                                                    placeholder="Enter `+value.label+`...">
                                            </div>
                                        </div>`;
                                } else if (value.type == 0 && value.classes == 1) {
                                    append += `
                                        <div class="form-group row class-div">
                                            <label class="col-form-label col-sm-2 text-sm-right">`+value.label+`</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control mb-1" name="field_`+value.name+`" 
                                                    placeholder="Enter `+value.label+`...">
                                            </div>
                                        </div>`;
                                } else if (value.type == 0 && value.classes == 2) {
                                    append += `
                                        <div class="form-group row class-div">
                                            <label class="col-form-label col-sm-2 text-sm-right">`+value.label+`</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control mb-1 dates" name="field_`+value.name+`" 
                                                    placeholder="Enter `+value.label+`...">
                                            </div>
                                        </div>`;
                                } else if (value.type == 0 && value.classes == 3) {
                                    append += `
                                        <div class="form-group row class-div">
                                            <label class="col-form-label col-sm-2 text-sm-right">`+value.label+`</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control mb-1 times" name="field_`+value.name+`" 
                                                    placeholder="Enter `+value.label+`...">
                                            </div>
                                        </div>`;
                                } else if (value.type == 0 && value.classes == 4) {
                                    append += `
                                        <div class="form-group row class-div">
                                            <label class="col-form-label col-sm-2 text-sm-right">`+value.label+`</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control mb-1 datetimes" name="field_`+value.name+`" 
                                                    placeholder="Enter `+value.label+`...">
                                            </div>
                                        </div>`;
                                } else if (value.type == 1 && value.classes == 0) {
                                    append += `
                                        <div class="form-group row class-div">
                                            <label class="col-form-label col-sm-2 text-sm-right">`+value.label+`</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control mb-1" name="field_`+value.name+`" placeholder="Enter `+value.label+`..."></textarea>
                                            </div>
                                        </div>`;
                                } else if (value.type == 1 && value.classes == 1) {
                                    append += `
                                        <div class="form-group row class-div">
                                            <label class="col-form-label col-sm-2 text-sm-right">`+value.label+`</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control mb-1 editor" name="field_`+value.name+`" placeholder="Enter `+value.label+`..."></textarea>
                                            </div>
                                        </div>`;
                                }

                                $("#custom_field").append(append);

                            });

                        } else { 

                            $("#custom_field").empty();

                        }

                    } else {

                        $("#custom_field").empty();
                        
                    }

                    //date
                    $( ".dates" ).datepicker({
                        format: 'yyyy-mm-dd',
                        todayHighlight: true,
                    });
                    //time
                    $('.times').bootstrapMaterialDatePicker({
                        date: false,
                        shortTime: false,
                        format: 'HH:mm'
                    });
                    //datetime
                    $('.datetimes').bootstrapMaterialDatePicker({
                        date: true,
                        shortTime: false,
                        format: 'YYYY-MM-DD HH:mm'
                    });
                     //tiny
                     tinymce.init({
                        selector: '.editor',
                        height: 400,
                        min_height: 300,
                        max_height: 500,
                        plugins: 'image, link, media, wordcount, lists, code, table, preview',
                        toolbar: ['formatselect | bold italic strikethrough superscript subscript forecolor backcolor formatpainter | table link image media pageembed | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat code'],

                        path_absolute : "/",
                        file_picker_callback (callback, value, meta) {
                            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
                            let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight

                            tinymce.activeEditor.windowManager.openUrl({
                            url : '/file-manager/tinymce5',
                            title : 'File manager',
                            width : x * 0.8,
                            height : y * 0.8,
                            onMessage: (api, message) => {
                                callback(message.content, { text: message.text })
                            }
                            })
                        },
                        relative_urls : false,
                        remove_script_host : false,
                        convert_urls : true,
                    });
                },
            });
        };
    });
</script>
$( document ).ready(function() {
    //Cand documentul este pregatit(S a incarcat DOM-ul in memorie), 
    //seteaza optiune editorului SummerNote
    $('#summernote').summernote({ height: 200 });
    //Javascript pentru functionalitatea de invite
    $('.invite-span').click(function(){
    	$(this).hide();
    	$(this).next().show();
    	$(this).prev().slideDown('fast');
    });
    //Javascript pentru a prelua ID-ul evenimentul(localStorage este specific HTML5)
    var btnsToDisable = $('form').filter(function(){
        var event_id = $(this).children('input[name=event_id]').val();
        return localStorage.getItem('vote' + event_id) == event_id;
    });
    btnsToDisable.find('.btnUp, .btnDwn').attr('disabled', true);
    //Javascript pentru a functionalitatea de invite
    $('.send-event').submit(function(event) {
        var self = $(this);
        self.find('.invite-email').empty().attr('disabled', true);
        self.find('.invite-btn').attr('disabled', true);
        self.find('.message').slideDown('fast').html('<br><p class="text-info">Processing</p>');
        //Se preia inputul din forme
        var postForm = {
            'email'    : self.find('input[name=email]').val(),
            'event'    : self.find('input[name=event]').val(),
            'text'     : self.find('input[name=text]').val()
        };
        //Se face un ajax call cu datele din forma
        $.ajax({
            type      : 'POST',
            url       : 'invite.php',
            data      : postForm,
            dataType  : 'json',
            success   : function(data) {
                            if (!data.success) {
                                if (data.errors.empty) {
                                   self.find('.message').slideDown('fast').html('<br><p class="text-danger">' + data.errors.empty + '</p>');
								   self.find('.invite-email').attr('disabled', false).css('border-color', '#a94442');
                                   self.find('.invite-btn').attr('disabled', false);
                               } else if (data.errors.sentError) {
								   self.find('.message').slideDown('fast').html('<br><p class="text-danger">' + data.errors.empty + '</p>');
   							   	   self.find('.invite-email').attr('disabled', false).css('border-color', '#a94442');
							       self.find('.invite-btn').attr('disabled', false);
                               }
                            } else {
                                self.find('.message').slideDown('fast').html('<br><p class="text-success">' + data.sent + '</p>').delay(2000).slideUp('fast');
                                self.find('.invite-email').attr('disabled', false).css('border-color', '#3c763d').delay(2000).slideUp('fast');
                                self.find('.invite-span').show().next().hide().attr('disabled', false);
                            }
                        }
        });
        event.preventDefault();
    });
    //Javascript pentru functionalitatea de votat. 
    $('.btnUp, .btnDwn').click(function(e) {
        var button = $(this);
        buttonForm = button.parent();
        buttonForm.data('submittedBy', button);
    });

    $('.vote-event').submit(function(event) {
        var self = $(this);

        var submittedBy = self.data('submittedBy');
        if(submittedBy.hasClass('btnUp')) {
            var postForm = {
                'event_id'     : self.find('input[name=event_id]').val(),
                'btn_value'    : 'up'
            };
        }
        else if (submittedBy.hasClass('btnDwn')) {
            var postForm = {
                'event_id'     : self.find('input[name=event_id]').val(),
                'btn_value'    : 'down'
            };
        }

        $.ajax({
            type      : 'POST',
            url       : 'vote.php',
            data      : postForm,
            dataType  : 'json',
            success   : function(data) {
                            if (!data.success) {
                                if (data.errors.error) {
                                   alert(data.errors.error);
                                }
                            } else {
                                self.find('.btnUp , .btnDwn').attr('disabled', true);
                                localStorage.setItem('vote' + data.eventNum, data.eventNum);
                                self.find('.btnUp').html('<span class="glyphicon glyphicon-thumbs-up"></span> Like ' + data.upVote + '<span></span>');
                                self.find('.btnDwn').html('<span class="glyphicon glyphicon-thumbs-down"></span> Dislike ' + data.dwnVote + '<span></span>');
                            }
                        }
        });
        event.preventDefault();
    });
    //Javascriptul pentru a afisa poza in locul precizat(#picture-name)
    $('input[type=file]').change(function(e){
        var pictureName = $(this);
        $('#picture-name').html(e.target.files[0].name);
    });
    //Validare Client-Side pentru forme
    $('#process-form').submit(function(event) {
        var self = $(this);

        if ($('#title-input').val().length == 0) {
            $('#title-error').slideDown('fast').html('Campul nu poate fi gol.').delay(1500).slideUp('fast');
            return false;
        } else if ($('#image-input').val().length == 0) {
            $('#image-error').slideDown('fast').html('Campul nu poate fi gol.').delay(1500).slideUp('fast');
            return false;
        } else if ($('#select-input').length && !$('#select-input').val()) {
            $('#select-error').slideDown('fast').html('Campul nu poate fi gol.').delay(1500).slideUp('fast');
            return false;
        } else if ($('#summernote').summernote('isEmpty')) {
            $('#text-error').slideDown('fast').html('Campul nu poate fi gol.').delay(1500).slideUp('fast');
            return false;
        }
        //Se continuare scriptul in caz ca totul este OK. Se preia datele din forma si se atribuie obiectului formData, facem AJAX Call 
        var formData = new FormData(); 
        var title = self.find('input[name=title-input]').val();
        var image = self.find('input[name=image-input]')[0].files[0];
        var text = $('#summernote').summernote('code').trim();
        var action = self.find('input[name=action]').val();
        var action_type = self.find('input[name=action_type]').val();
        var action_id = self.find('input[name=action_id]').val();
        var category_id = self.find('select[name=category_id]').val();
        formData.append("image-input", image);
        formData.append("title", title);
        formData.append("text", text);
        formData.append("action", action);
        formData.append("action_type", action_type);
        formData.append("action_id", action_id);
        if (action == 'create' && action_type == 'event') {
            formData.append("category_id", category_id);
        }

        $.ajax({
            type        : 'POST',
            url         : 'process.php',
            data        : formData,
            cache       : false,
            processData : false,
            contentType : false,
            success     : function(data) {
                            var result = $.parseJSON(data);
                            if (!result.success) { 
                                if (result.error) {
                                    self.find('#response').slideDown('fast')
                                        .html('<p class="alert alert-danger col-md-offset-3 col-md-6">' + result.error + '</p>')
                                        .delay(1500).slideUp('fast');
                                }
                            } else {
                                self.find('#response').slideDown('fast')
                                    .html('<p class="alert alert-success col-md-offset-3 col-md-6">' + result.saved + '</p>')
                                    .delay(1500).slideUp('fast');
                                self.find('#process-submit').attr('disabled', true);
                                window.setTimeout(function() {
                                    window.location.href = 'index.php';
                                }, 2000);
                            }
                         }
        });
        event.preventDefault();
    });
    //Javascript pentru functionalitatea de delete
    $('.formDelete').submit(function(event) {
        var self = $(this);
        $('.modal').modal('hide');

        var postForm = {
            'action_type'  : self.find('input[name=sendName]').val(),
            'action_id'    : self.find('input[name=sendId]').val(),
            'action'       : 'delete'
        };

        $.ajax({
            type      : 'POST',
            url       : 'delete.php',
            data      : postForm,
            dataType  : 'json',
            success   : function(data) {
                            if (!data.success) {
                                if (data.error) {
                                    $('#response').slideDown('fast')
                                        .html('<p class="alert alert-danger col-md-offset-3 col-md-6">' + data.error + '</p>')
                                        .delay(1500).slideUp('fast');
                                }
                            } else {
                                window.scrollTo(0,0);
                                $('#response').slideDown('fast')
                                    .html('<p class="alert alert-success col-md-offset-3 col-md-6">' + data.deleted + '</p>')
                                    .delay(1500).slideUp('fast');
                                self.closest('.object-container').hide();
                            }
                        }
        });
        event.preventDefault();
    });
});

(function($) {
    $(document).ready(function(){
        
        $(document).foundation();
        
        $('#loginform-username').focus();
        
        $('#searchform-searchword').focus();
        
        $('#searchform-clearInput').click(function() {
            $('#searchform-searchword').val("");
        });
        
        $('.js_show').toggle();
        $('.js_hide').toggle();
        
        $('#language-selector').parent().clone().appendTo($('.top-bar .left'));
        
        $(document).keyup(function(e) {
            if(e.keyCode === 27) {
                $('.ul-nav-toggle').click();
            }
        });
        
        // ** Icon to minimize the nav **
        
        $('.sticky').append($('<i/>',{'class':'fi-eye ul-nav-toggle',text:' Menu'}));
        
        $('.ul-nav li').click(function() {
            if($(this).find('#language-selector').length === 0) {
                window.location = $(this).find('a').attr('href');
            }
        });
        
        $('.ul-nav-toggle').click(function() {
            var that = $(this);
            //that.toggleClass('fi-zoom-out fi-zoom-in');
            that.siblings('ul').toggleClass('ul-nav ul-nav-hide');
        }).click();
        
        
        $('#teacher-ac').on('autocompletefocus', function(e){
            e.preventDefault();
        });
        
        // ** Infofelder generieren **
        
        $('.infolabel').each(function() {
            $(this).append($('<i/>',{'class':'fi-info'}));
        });
        
        $('.infofeld').click(function(e) {
                e.preventDefault();
                $('.infobox').show();
                $('.infobox').children('p').html($(this).siblings('.infotext').html());
                $('.infobox').css('left', $(document).width()/2-200);
                $('.infobox').css('top', $(window).height()/4);
                e.stopPropagation();
                $(document).one('click',function() {
                    $('.infobox').hide();
                });
        });
        
        // ** JQuery UI Autocomplete Einstellungen **    
                
        $('input[id$="_display"]').on('autocompletefocus', function(e) {
            e.preventDefault();
        });
        $('input[id$="_teacher"]').on('autocompletefocus', function(e) {
            e.preventDefault();
        });
        $('#appointment_parent').on('autocompletefocus', function(e) {
            e.preventDefault();
        });
        
        $('#print-view-teacher').on('autocompletefocus', function(e) {
            e.preventDefault();
        });
        
        $('input[id$="_display"]').on('autocompleteselect', function(e, ui) {
            e.preventDefault();
            $(this).val(ui.item.label);
            $(this).nextAll('input').val(ui.item.value);
        });
        
        
        // ** Druckansicht Link und Autocompletes **
        
        $('#print-view-teacher').on('autocompleteselect', function( e, ui ) {
            e.preventDefault();
            $(this).val(ui.item.label);
            $(this).data('id',ui.item.value);
        });
        
        $('#print-view-button').click(function() {
            var date = $('#print-view-date').val();
            var id = $('#print-view-teacher').data('id');
            if(date !== '' && typeof date === 'string' && id !== '' && typeof id === 'string') {
                window.location.href = "index.php?r=appointment/overview&id=" + id + "&date=" + date;
            }
        });
        
        $('#print-view-all-button').click(function() {
            var date = $('#print-view-date').val();
            var empty = ($('#show-empty-plans').is(':checked') ? 1 : 0);
            if(date !== '' && typeof date === 'string') {
                window.location.href = "index.php?r=appointment/generatePlans&date=" + date + "&emptyPlans=" + empty;
            }
        });

       

    });
        
})(jQuery);
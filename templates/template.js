jQuery(document).ready(function($){
    $(window).resize(() => {
        if($(window).width() < 900) {
            $('.item').css({
                'width': '100%'
            })
        } else {
            $('.item').css({
                'width': 'calc(50% - 5px)'
            })
        }
    })

    $(document).ready(() => {
        $('.item').each(function() {
            if($(this).find('img').length) {
                $(this).find('img').prependTo($(this).find('.item_text'))
                $(this).find('.item_text').css('width', '100%')
            } else {
                $(this).find('.item_img').hide();
                $(this).find('.item_text').css('width', '100%')
            }
        })

        $('.item_container').masonry({
            itemSelector: '.item',
            horizontalOrder: true,
            gutter: 5
        });
    })
})
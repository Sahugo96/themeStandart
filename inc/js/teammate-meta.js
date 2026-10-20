jQuery(function ($) {
    'use strict';

    var frame;
    var linkFrame;

    // ---------- Медиазагрузчик для картинки члена команды ----------
    $('.teammate-choose-image').on('click', function (e) {
        e.preventDefault();

        var $button   = $(this);
        var $input    = $button.siblings('.teammate-image-id');
        var $img      = $button.siblings('img');
        var $remove   = $button.siblings('.teammate-remove-image');

        if (frame) {
            frame.open();
            return;
        }

        frame = wp.media.frames.teammateFrame = wp.media({
            title: 'Выберите изображение',
            button: { text: 'Использовать изображение' },
            multiple: false
        });

        frame.on('select', function () {
            var attachment = frame.state().get('selection').first().toJSON();

            $input.val(attachment.id || '');

            if (attachment.url) {
                if ($img.length) {
                    $img.attr('src', attachment.url).show();
                } else {
                    $('<img>')
                        .attr('src', attachment.url)
                        .css({ 'max-width': '200px', 'height': 'auto', 'margin-top': '8px', 'display': 'block' })
                        .insertAfter($button);
                }
                $remove.removeClass('hidden');
            }
        });

        frame.open();
    });

    $('.teammate-remove-image').on('click', function () {
        var $row = $(this).closest('td');
        $row.find('.teammate-image-id').val('');
        $row.find('img').remove();
        $(this).addClass('hidden');
    });

    // ---------- Медиазагрузчик для иконки SVG в строке ссылки ----------
    $(document).on('click', '.teammate-link-choose-icon', function (e) {
        e.preventDefault();

        var $button   = $(this);
        var $row      = $button.closest('.teammate-link-row');
        var $input    = $row.find('.teammate-link-icon-id');
        var $img      = $row.find('.teammate-link-icon-preview');
        var $remove   = $button.siblings('.teammate-link-remove-icon');

        if (linkFrame) {
            linkFrame.open();
            return;
        }

        linkFrame = wp.media.frames.teammateLinkFrame = wp.media({
            title: 'Выберите SVG иконку',
            button: { text: 'Использовать иконку' },
            multiple: false,
            library: { type: 'image' }
        });

        linkFrame.on('select', function () {
            var attachment = linkFrame.state().get('selection').first().toJSON();

            $input.val(attachment.id || '');

            if (attachment.url) {
                $img.attr('src', attachment.url).show();
                $remove.removeClass('hidden');
            }
        });

        linkFrame.open();
    });

    $(document).on('click', '.teammate-link-remove-icon', function (e) {
        e.preventDefault();

        var $button = $(this);
        var $row    = $button.closest('.teammate-link-row');

        $row.find('.teammate-link-icon-id').val('');
        $row.find('.teammate-link-icon-preview').attr('src', '').hide();
        $button.addClass('hidden');
    });

    // ---------- Репитер ссылок ----------
    var $repeater = $('.teammate-links-repeater');
    var $template = $('#teammate-links-template').html();
    var index     = $repeater.find('.teammate-link-row').length;

    $('.teammate-add-link').on('click', function (e) {
        e.preventDefault();
        var html = $template.replace(/__INDEX__/g, index);
        $repeater.append(html);
        index++;
    });

    $repeater.on('click', '.teammate-remove-link', function (e) {
        e.preventDefault();
        $(this).closest('.teammate-link-row').remove();
    });
});
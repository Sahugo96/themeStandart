jQuery(function ($) {
    'use strict';

    function bindRepeater(config) {
        var $repeater = $(config.repeater);
        var $template = $(config.template);
        var index = $repeater.find(config.row).length;

        $(document).on('click', config.add, function (e) {
            e.preventDefault();

            if (!$template.length || !$repeater.length) {
                return;
            }

            $repeater.append($template.html().replace(/__INDEX__/g, index));
            index++;
        });

        $repeater.on('click', config.remove, function (e) {
            e.preventDefault();
            $(this).closest(config.row).remove();
        });
    }

    bindRepeater({
        template: '#case-steps-template',
        repeater: '.case-steps-repeater',
        row: '.case-step-row',
        add: '.case-add-step',
        remove: '.case-remove-step'
    });

    bindRepeater({
        template: '#case-facts-template',
        repeater: '.case-facts-repeater',
        row: '.case-fact-row',
        add: '.case-add-fact',
        remove: '.case-remove-fact'
    });
});
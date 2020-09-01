/* This section of the code registers a new block, sets an icon and a category, and indicates what type of fields it'll include. */

wp.blocks.registerBlockType('lists-impay/sanctions-list', {
    title: 'Санкционный список',
    icon: 'format-aside',
    category: 'impay-lists',

    /* This configures how the content and color fields will work, and sets up the necessary elements */

    edit: function() {
        return React.createElement(
            "div",
            { id: 'impay_lists_sanctions_list' },
            wp.element.createElement(
                "h3",
                null,
                "Здесь будет вставлена таблица санкционного списка США"
            ),
        );
    },
    save: function() {
        return React.createElement(
            "div",
            { id: 'impay_lists_sanctions_list' },
        );
    }
})


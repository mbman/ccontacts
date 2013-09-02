window.HeaderView = Backbone.View.extend({

    initialize: function () {
    },

    render: function () {
        $(this.el).html(this.template());
        return this;
    },

    events: {
        "click #search": "search",
        "keypress #search-q": "onkeypress"
    },

    search: function (event) {
        var key = $('#search-q').val();
        event.preventDefault();
        console.log('search ' + key);
    },

    onkeypress: function (event) {
        if (event.keyCode == 13) {
            this.search(event);
        }
    },

    select: function(menuItem) {
        $('.nav li').removeClass('active');
        $('.' + menuItem).addClass('active');
    }

});
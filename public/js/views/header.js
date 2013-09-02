window.HeaderView = Backbone.View.extend({

    initialize: function () {
        this.searchResults = new ContactCollection();
        this.searchresultsView = new ContactListView({model: this.searchResults});
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
        $('#search-results').append(this.searchresultsView.render().el);
        this.searchResults.search(key);
        if (event != false) {
            event.preventDefault();
        }
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
window.SearchView = Backbone.View.extend({

    initialize: function () {
        this.searchResults = new ContactCollection();
        this.searchresultsView = new ContactListView({model: this.searchResults});
        this.searchResults.bind("reset", this.render, this);
    },

    render: function () {
        $(this.el).html(this.template({
                     query: this.searchResults.searchQuery,
                     resultsFound: this.searchResults.length,
                   }))
                  .append(this.searchresultsView.render().el);
        return this;
    },

    search: function(query) {
        this.searchResults.search(query);
    }

});
window.SearchView = Backbone.View.extend({

    initialize: function () {
        this.searchResults = new ContactCollection();
        this.searchResultsView = new ContactListView({model: this.searchResults});
        this.searchResults.bind("reset", this.renderResults, this);
    },

    render: function (query) {
        $(this.el).html(this.template({query: query}));
        $("#search-results", this.el).html(new LoaderView().render().el);
        this.searchResults.search(query);
        return this;
    },
    renderResults: function () {
        var self = this;
        $("[data-rel=results-found]", this.el).html(this.searchResults.length);
        $("#search-results", this.el).fadeOut("fast", function(){
            $(this).html(self.searchResultsView.el).show();
        });
    }

});
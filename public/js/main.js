window.Router = Backbone.Router.extend({

    routes: {
        "": "home",
        "contacts/new": "newContact",
        "contact/:id/edit": "editContact",
        "search/:query": "search"
    },

    initialize: function () {
        this.$content = $("#content");
        this.headerView = new HeaderView();
        $('.header').html(this.headerView.render().el);
    },

    home: function () {
        if (!this.homeView) {
            this.homeView = new HomeView();
        }
        this.$content.html(this.homeView.render().el);
        this.headerView.select('menu-home');
    },

    search: function (query) {
        if (!this.searchView) {
            this.searchView = new SearchView();
        }
        this.searchView.search(query);
        this.$content.html(this.searchView.render().el);
        this.headerView.select('menu-home');
    },

    newContact: function () {
        this.contactNewView = new ContactNewView({model: new Contact()});
        this.$content.html(this.contactNewView.render().el);
        this.headerView.select('menu-new');
    },

    editContact: function (id) {
        var contact = new Contact({id: id}), self = this;
        contact.fetch({
            success: function (data) {
                self.$content.html(new ContactEditView({model: data}).render().el);
                self.headerView.select('menu-home');
            }
        });
    }

});

templateLoader.load([
    "HomeView",
    "HeaderView",
    "AlertView",
    "SearchView",
    "ContactListItemView",
    "ContactNewView",
    "ContactEditView",
    "ContactFormView"
    ],
    function () {
        app = new Router();
        Backbone.history.start();
});
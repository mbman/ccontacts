window.Router = Backbone.Router.extend({

    title: "CContacts",

    routes: {
        "": "home",
        "contacts/new": "newContact",
        "contact/:id/edit": "editContact",
        "contact/:id": "viewContact",
        "search/:query": "search"
    },

    initialize: function () {
        this.$content = $("#content");
        this.headerView = new HeaderView();
        $('.header').html(this.headerView.render().el);
    },

    home: function () {
        this.homeView = new HomeView();
        this.$content.html(this.homeView.render().el);
        this.headerView.select('menu-home');
        this.setTitle("Home");
    },

    search: function (query) {
        this.searchView = new SearchView();
        this.$content.html(this.searchView.render(query).el);
        this.headerView.select('menu-home');
        this.setTitle("Search results");
    },

    newContact: function () {
        this.contactNewView = new ContactNewView({model: new Contact()});
        this.$content.html(this.contactNewView.render().el);
        this.headerView.select('menu-new');
        this.setTitle("Add contact");
    },

    editContact: function (id) {
        var contact = new Contact({id: id}), self = this;
        contact.fetch({
            success: function (data) {
                self.$content.html(new ContactEditView({model: data}).render().el);
                self.headerView.select('menu-home');
                self.setTitle("Edit contact #"+id);
            }
        });
    },

    viewContact: function (id) {
        var contact = new Contact({id: id}), self = this;
        contact.fetch({
            success: function (data) {
                self.$content.html(new ContactView({model: data}).render().el);
                self.headerView.select('menu-home');
                self.setTitle(data.fullName());
            }
        });
    },

    setTitle: function(title){
        document.title = title+" - "+this.title;
    }

});

templateLoader.load([
    "HomeView",
    "HeaderView",
    "AlertView",
    "LoaderView",
    "SearchView",
    "ContactView",
    "ContactListItemView",
    "ContactNewView",
    "ContactEditView",
    "ContactFormView",
    "ContactFormEmailItemView",
    "ContactFormPhoneItemView"
    ],
    function () {
        app = new Router();
        Backbone.history.start();
});
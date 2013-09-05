window.Router = Backbone.Router.extend({

    routes: {
        "": "home",
        "contacts/new": "newContact"
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

    newContact: function () {
        this.contactNewView = new ContactNewView({model: new Contact()});
        this.$content.html(this.contactNewView.render().el);
        this.headerView.select('menu-new');
    }

});

templateLoader.load(["HomeView", "HeaderView", "ContactListItemView", "ContactNewView", "ContactFormView"],
    function () {
        app = new Router();
        Backbone.history.start();
    });
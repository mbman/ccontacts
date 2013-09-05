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
            this.homeView.render();
        } else {
            this.homeView.delegateEvents();
        }
        this.$content.html(this.homeView.el);
        this.headerView.select('menu-home');
        this.headerView.search(false);
    },

    newContact: function () {
        this.$content.html(new ContactNewView({model: new Contact()}).render().el);
        this.headerView.select('menu-new');
    }

});

templateLoader.load(["HomeView", "HeaderView", "ContactListItemView", "ContactNewView", "ContactFormView"],
    function () {
        app = new Router();
        Backbone.history.start();
    });
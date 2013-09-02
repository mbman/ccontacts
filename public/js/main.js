window.Router = Backbone.Router.extend({

    routes: {
        "": "home",
        "contact/:id": "contactDetails"
    },

    initialize: function () {
        this.headerView = new HeaderView();
        $('.header').html(this.headerView.render().el);
    },

    home: function () {
        // Since the home view never changes, we instantiate it and render it only once
        if (!this.homeView) {
            this.homeView = new HomeView();
            this.homeView.render();
        } else {
            this.homeView.delegateEvents(); // delegate events when the view is recycled
        }
        $("#content").html(this.homeView.el);
        this.headerView.select('menu-home');
        this.headerView.search(false);
    }

});

templateLoader.load(["HomeView", "HeaderView", "ContactListItemView"],
    function () {
        app = new Router();
        Backbone.history.start();
    });
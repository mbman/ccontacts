window.HeaderView = Backbone.View.extend({

    render: function() {
        $(this.el).html(this.template());
        return this;
    },

    events: {
        "click #search": "search",
        "keypress #search-q": "onkeypress"
    },

    search: function(event) {
        if (event != false) {
            event.preventDefault();
        }
        window.location.hash = "search/"+$('#search-q').val();
    },

    onkeypress: function(event) {
        if (event.keyCode == 13) {
            this.search(event);
        }
    },

    select: function(menuItem) {
        $('.nav li').removeClass('active');
        $('.' + menuItem).addClass('active');
    },

    alert: function(contentHtml, className) {
        $(this.el).append(new AlertView({
            className: "container alert alert-dismissable alert-"+className,
            model: new Backbone.Model({
                html: contentHtml,
            }),
        }).render().el);
    }

});

window.AlertView = Backbone.View.extend({
    className: "container alert alert-dismissable alert-",

    render: function() {
        $(this.el).html(this.template(this.model.toJSON()));
        return this;
    },

});
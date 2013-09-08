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
        var $query = $('#search-q'),
            query =  $.trim($query.val()),
            $parent = $query.parent();
        if (!query.length) {
            $query.val("").focus();
            $parent.addClass("has-error");
            return false;
        }
        $parent.removeClass("has-error");
        window.location.hash = "search/"+query;
        return true;
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

window.LoaderView = Backbone.View.extend({
    className: "panel panel-info",

    render: function() {
        $(this.el).html(this.template());
        return this;
    },

});
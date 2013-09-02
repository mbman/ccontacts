window.ContactListView = Backbone.View.extend({

    initialize:function () {
        var self = this;
        this.model.bind("reset", this.render, this);
        this.model.bind("add", function (contact) {
            $(self.el).append(new ContactListItemView({model:contact}).render().el);
        });
    },

    render:function () {
        $(this.el).empty();
        _.each(this.model.models, function (contact) {
            $(this.el).append(new ContactListItemView({model:contact}).render().el);
        }, this);
        return this;
    }
});

window.ContactListItemView = Backbone.View.extend({

    tagName:"div",
    className:"col-md-6",

    initialize:function () {
        this.model.bind("change", this.render, this);
        this.model.bind("destroy", this.close, this);
    },

    render:function () {
        $(this.el).html(this.template(this.model.toJSON()));
        return this;
    }

});
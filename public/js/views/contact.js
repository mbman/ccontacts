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

window.ContactNewView = Backbone.View.extend({

    render: function () {
        $(this.el).html(this.template());
        $('#contact-form', this.el).html(new ContactFormView({model:this.model}).render().el);
        return this;
    }
});

window.ContactFormView = Backbone.View.extend({

    initialize:function () {
        this.model.bind("change", this.render, this);
    },

    render:function () {
        $(this.el).html(this.template(this.model.toJSON()));
        return this;
    },

    events: {
        "submit #contactform": "save"
    },

    save: function (event) {
        event.preventDefault();
        var formData = $("#contactform").serializeArray(),
            data = {};
        for (var key in formData) {
            data[formData[key].name] = formData[key].value;
        }
        this.model.save(data, {
            success: function (contact) {
                console.log(contact.toJSON());
            }
        })
    },

});

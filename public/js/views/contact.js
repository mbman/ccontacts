window.ContactListView = Backbone.View.extend({
    tagName: "ol",
    className: "contact-list list-group",

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

    className:"list-group-item clearfix",

    initialize:function () {
        this.model.bind("change", this.render, this);
        this.model.bind("destroy", this.close, this);
    },

    render:function () {
        $(this.el).html(this.template(this.model.toJSON(),{url:this.model.url()}));
        return this;
    }

});

var contactFormBaseView = {

    render: function () {
        $(this.el).html(this.template(this.model.toJSON()));
        $('#contact-form', this.el).html(new ContactFormView({model:this.model}).render().el);
        return this;
    }
};

window.ContactNewView = Backbone.View.extend(contactFormBaseView);
window.ContactEditView = Backbone.View.extend(contactFormBaseView);

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
            success: function (model) {
                app.navigate(model.url(), true);
            },
            error: function (model, response) {
                var $form = $("#contactform");
                _.each(response.responseJSON, function (errors, key) {
                    var $el = $("[data-el='"+key+"']", this);
                    $el.addClass("has-error")
                       .append(new ContactFormHelpView({model:errors}).render().el);
                }, $form);
            }
        });
    },

});


window.ContactFormHelpView = Backbone.View.extend({

    tagName: "span",
    className: "help-block pull-right",

    render:function () {
        $(this.el).html(_.values(this.model).join("<br>"));
        return this;
    },

});

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

window.ContactView = Backbone.View.extend({

    events: {
        "click .delete": "delete"
    },

    initialize:function () {
        this.model.bind("change", this.render, this);
    },

    render:function () {
        $(this.el).html(this.template(this.model.toJSON(),{url:this.model.url()}));
        return this;
    },

    delete: function(event){
        if (event != false) {
            event.preventDefault();
        }
        if (!confirm("Delete contact '"+this.model.fullName()+"'")) {
            return false;
        }
        app.headerView.alert("Well done, the contact <strong>"+this.model.fullName()+
                             "</strong> has been deleted!", "success");
        this.model.destroy();
        this.destroy();
    },

    destroy: function(){
        app.navigate("", true);
    }

});

window.ContactListItemView = window.ContactView.extend({

    tagName: "li",
    className:"list-group-item clearfix",

    destroy: function(){
        this.remove();
    }

});

window.ContactNewView = Backbone.View.extend({

    render: function () {
        $(this.el).html(this.template(this.model.toJSON()));
        $('#contact-form', this.el).html(new ContactFormView({model:this.model}).render().el);
        return this;
    }
});
window.ContactEditView = window.ContactNewView.extend();

window.ContactFormView = Backbone.View.extend({

    events: {
        "submit #contactform": "save",
        "click .add-email": "addEmail",
        "click .add-phone": "addPhone"
    },

    initialize:function () {
        this.model.bind("reset", this.render, this);
        this.emailListView = new ContactFormEmailListView({model: this.model.get("emails")});
    },

    render:function () {
        $(this.el).html(this.template(this.model.toJSON()));
        $(".contact-emails", this.el).html(this.emailListView.render().el).show();
        return this;
    },

    addEmail: function(event){
        event.preventDefault();
        this.model.emails().add(new ContactEmail());
    },

    addPhone: function(event){
        event.preventDefault();
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
                app.headerView.alert("Well done, the contact <strong>"+model.fullName()+
                                     "</strong> has been saved!", "success");
                app.navigate(model.url(), true);
            },
            error: function (model, response) {
                app.headerView.alert("<strong>Error</strong>, you did not fill out the form correctly."+
                                     " Please correct all of the errors marked red.", "danger");
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


window.ContactFormEmailListView = Backbone.View.extend({

    initialize:function () {
        var self = this;
        this.model.bind("reset", this.render, this);
        this.model.bind("add", function (email) {
            $(self.el).append(new ContactFormEmailItemView({model:email}).render().el);
        });
    },

    render:function () {
        $(this.el).empty();
        _.each(this.model.models, function (email) {
            $(this.el).append(new ContactFormEmailItemView({model:email}).render().el);
        }, this);
        return this;
    }

});

window.ContactFormEmailItemView = Backbone.View.extend({

    className: "form-group",

    initialize:function () {
        this.model.bind("change", this.render, this);
    },

    render:function () {
        $(this.el).html(this.template(this.model.toJSON()));
        return this;
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
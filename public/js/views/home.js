window.HomeView = Backbone.View.extend({

    initialize: function () {
        this.contacts = new ContactCollection();
        this.contactsListView = new ContactListView({model: this.contacts});
    },

    render:function () {
        $(this.el).html(this.template())
                  .append(this.contactsListView.render().el);
        this.contacts.search(false);
        return this;
    }

});
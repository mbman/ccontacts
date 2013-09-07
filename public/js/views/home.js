window.HomeView = Backbone.View.extend({

    initialize: function () {
        this.contacts = new ContactCollection();
        this.contactsListView = new ContactListView({model: this.contacts});
    },

    render:function () {
        $(this.el).html(this.template());
        var self = this, $container = $("#contacts", this.el);
        $container.html(new LoaderView().render().el);
        this.contacts.fetch({
            success: function () {
                $container.fadeOut("fast", function(){
                    $(this).html(self.contactsListView.el).show();
                });
            }
        });
        return this;
    },

});
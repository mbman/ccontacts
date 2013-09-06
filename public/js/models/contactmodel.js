window.Contact = Backbone.Model.extend({

    urlRoot:"contact",
    defaults: {
        firstName: "",
        lastName: "",
        company: "",
        job: "",
        address: "",
        zip: "",
        city: "",
        state: "",
        country: "",
        notes: "",
    },

    initialize:function () {
    }

});

window.ContactCollection = Backbone.Collection.extend({

    model: Contact,

    url:"contact",

    searchQuery: "",

    search:function (query) {
        var self = this;
        this.searchQuery = query;
        $.ajax({
            url:"contact"+(query ? "/search/" + query : ""),
            dataType:"json",
            success:function (data) {
                self.reset(data);
            }
        });
    }

});
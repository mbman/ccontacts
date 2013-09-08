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
        tags: "",
        notes: "",
    },

    fullName:function () {
        return this.get("firstName")+" "+this.get("lastName");
    }

});

window.ContactCollection = Backbone.Collection.extend({

    model: Contact,

    url:"contact",

    search:function (query) {
        var self = this;
        $.ajax({
            url:"contact"+(query ? "/search/" + query : ""),
            dataType:"json",
            success:function (data) {
                self.reset(data);
            }
        });
    }

});
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
        notes: ""
    },

    fullName: function () {
        return this.get("firstName")+" "+this.get("lastName");
    },

    getTags: function() {
        var tags = [];
        _.each(this.get("tags").split(","), function(tag){
          tag = $.trim(tag);
          tags.push(tag);
        });
        return tags;
    },

    getTagsLinks: function() {
        var tags = [];
        _.each(this.getTags(), function(tag){
          tags.push('<a href="#search/'+escape(tag)+'">'+_.escape(tag)+'</a>');
        });
        return tags;
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

window.ContactEmail = Backbone.Model.extend({

    defaults: {
        email: "",
    },

});

window.ContactEmailCollection = Backbone.Collection.extend({

    model: ContactEmail,

});

window.ContactPhone = Backbone.Model.extend({

    defaults: {
        phone: "",
    },

});

window.ContactPhoneCollection = Backbone.Collection.extend({

    model: ContactPhone,

});

Backbone.associate(Contact, {
  emails: { type: ContactEmailCollection, url: '/email' },
  phones: { type: ContactPhoneCollection, url: '/phone' }
});

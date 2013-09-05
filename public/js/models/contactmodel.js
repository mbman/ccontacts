window.Contact = Backbone.Model.extend({

    urlRoot:"contact",

    initialize:function () {
    }

});

window.ContactCollection = Backbone.Collection.extend({

    model: Contact,

    url:"contact",

    search:function (key) {
        var self = this;
        $.ajax({
            url:"contact"+(key ? "/search/" + key : ""),
            dataType:"json",
            success:function (data) {
                self.reset(data);
            }
        });
    }

});
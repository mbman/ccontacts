window.Contact = Backbone.Model.extend({

    urlRoot:"../contact",

    initialize:function () {
        this.reports = new ContactCollection();
        this.reports.url = '../contact/' + this.id;
    }

});

window.ContactCollection = Backbone.Collection.extend({

    model: Contact,

    url:"../contact",

    search:function (key) {
        var url = (key == '') ? '../contact' : "../contact/search/" + key;
        console.log('search: ' + key);
        var self = this;
        $.ajax({
            url:url,
            dataType:"json",
            success:function (data) {
                console.log("search success: " + data.length);
                self.reset(data);
            }
        });
    }

});
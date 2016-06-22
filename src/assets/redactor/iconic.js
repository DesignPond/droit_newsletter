(function($)
{
    $.Redactor.prototype.iconic = function()
    {
        return {
            init: function ()
            {
                var icons = {
                    'format': '<i class="fa fa-paragraph"></i>',
                    'lists': '<i class="fa fa-list"></i>',
                    'bold': '<i class="fa fa-bold"></i>',
                    'italic': '<i class="fa fa-italic"></i>',
                    'link': '<i class="fa fa-link"></i>',
                    'alignment': '<i class="fa fa-align-justify"></i>',
                    'image': '<i class="fa fa-image"></i>',
                    'file': '<i class="fa fa-file"></i>'
                };

                // 'format','bold','italic','|','lists','|','image','file','link','alignment'

                $.each(this.button.all(), $.proxy(function(i,s)
                {
                    var key = $(s).attr('rel');

                    if (typeof icons[key] !== 'undefined')
                    {
                        var icon = icons[key];
                        var button = this.button.get(key);
                        this.button.setIcon(button, icon);
                    }

                }, this));
            }
        };
    };
})(jQuery);
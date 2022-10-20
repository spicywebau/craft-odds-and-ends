/**
 * @author Spicy Web <plugins@spicyweb.com.au>
 * @author Josh Angell <josh@supercooldesign.co.uk>
 * @copyright Copyright (c) 2022, Spicy Web
 * @copyright Copyright (c) 2016, Supercool Ltd
 */

(function($){


if (typeof OddsAndEnds == 'undefined')
{
    OddsAndEnds = {}
}


/**
 * Make all links in instructions open in a new window - useful for fields
 * where only markdown is supported
 */
OddsAndEnds.TargetBlankInstructionLinks = Garnish.Base.extend(
{
    init: function()
    {
        this.addListener(Garnish.$win, 'load resize', 'apply');
    },

    apply: function()
    {
        Garnish.$bod.find('.instructions a').each(function()
        {
            $(this).attr('target', '_blank');
        });
    }
});


/**
 * Search elements like Tags - forked from `Craft.TagSelectInput`
 */
OddsAndEnds.ElementSearchInput = Craft.BaseElementSelectInput.extend(
{
    searchTimeout: null,
    searchMenu: null,
    limit: null,

    $container: null,
    $elementsContainer: null,
    $elements: null,
    $addElementContainer: null,
    $addElementInput: null,
    $spinner: null,

    _ignoreBlur: false,
    _initialized: false,

    init: function(settings)
    {
        this.base($.extend({}, settings));

        this.$addElementContainer = this.$container.children('.add');
        this.$addElementInput = this.$addElementContainer.children('.text');
        this.$spinner = this.$addElementInput.next();

        // No reason for this to be sortable if we're only allowing 1 selection
        if (this.settings.limit == 1)
        {
            this.settings.sortable = false;
        }

        // Ping this so the input hides on load if it needs to
        this.updateAddElementsBtn();

        // Bind listeners
        this.addListener(this.$addElementInput, 'textchange', $.proxy(function()
        {
            if (this.searchTimeout)
            {
                clearTimeout(this.searchTimeout);
            }

            this.searchTimeout = setTimeout($.proxy(this, 'searchForElements'), 500);
        }, this));

        this.addListener(this.$addElementInput, 'keypress', function(ev)
        {
            if (ev.keyCode == Garnish.RETURN_KEY)
            {
                ev.preventDefault();

                if (this.searchMenu)
                {
                    this.selectElement(this.searchMenu.$options[0]);
                }
            }
        });

        this.addListener(this.$addElementInput, 'focus', function()
        {
            if (this.searchMenu)
            {
                this.searchMenu.show();
            }
        });

        this.addListener(this.$addElementInput, 'blur', function()
        {
            if (this._ignoreBlur)
            {
                this._ignoreBlur = false;
                return;
            }

            setTimeout($.proxy(function()
            {
                if (this.searchMenu)
                {
                    this.searchMenu.hide();
                }
            }, this), 1);
        });

        this._initialized = true;
    },

    // No "add" button
    getAddElementsBtn: $.noop,

    getElements: function()
    {
        return this.$elementsContainer.find('.element');
    },

    // I’m hi-jacking these as they get fired when the limit is breached
    disableAddElementsBtn: function()
    {
        if (this.$addElementContainer && !this.$addElementContainer.hasClass('disabled'))
        {
            this.$addElementInput.prop('disabled', true);
            this.$addElementContainer
                    .velocity('fadeOut', { duration: Craft.BaseElementSelectInput.ADD_FX_DURATION })
                    .addClass('disabled');
        }
    },
    enableAddElementsBtn: function()
    {
        if (this.$addElementContainer && this.$addElementContainer.hasClass('disabled'))
        {
            this.$addElementInput.prop('disabled', false);
            this.$addElementContainer
                    .velocity('fadeIn', { display: 'inline-block', duration: Craft.BaseElementSelectInput.REMOVE_FX_DURATION })
                    .removeClass('disabled');
            this.$addElementInput.trigger('focus');
        }
    },

    searchForElements: function()
    {
        if (this.searchMenu)
        {
            this.killSearchMenu();
        }

        var val = this.$addElementInput.val();

        if (val)
        {
            this.$spinner.removeClass('hidden');

            var excludeIds = [];
            this.$elements.each(function()
            {
                var id = $(this).data('id');
                if (id)
                {
                    excludeIds.push(id);
                }
            });

            if (this.settings.sourceElementId)
            {
                excludeIds.push(this.settings.sourceElementId);
            }

            var data = {
                search:      this.$addElementInput.val(),
                sources:     this.settings.sources,
                elementType: this.settings.elementType,
                excludeIds:  excludeIds
            };

            Craft.postActionRequest('tools/tools/search-for-elements', data, $.proxy(function(response, textStatus)
            {
                this.$spinner.addClass('hidden');

                if (textStatus == 'success')
                {
                    var $menu = $('<div class="menu oddsandends-elementsearch__menu"/>').appendTo(Garnish.$bod);

                    // Loop each source defined in our settings and see if we got anything back from it
                    for (var i = 0; i < this.settings.sources.length; i++) {
                        var sourceKey = this.settings.sources[i];

                        if (response.elements.hasOwnProperty(sourceKey))
                        {
                            // Source name
                            $('<h6>'+response.elements[sourceKey][0].sourceName+'</h6>').appendTo($menu);
                            var $ul = $('<ul/>').appendTo($menu);

                            // Elements in that source
                            for (var n = 0; n < response.elements[sourceKey].length; n++)
                            {
                                var $li = $('<li/>').appendTo($ul),
                                        $a = $('<a />').appendTo($li).text(response.elements[sourceKey][n].title).data('id', response.elements[sourceKey][n].id).data('status', response.elements[sourceKey][n].status);
                                $('<span class="status '+response.elements[sourceKey][n].status+'"/>').prependTo($a);
                            }
                        }
                    }

                    // This is a bit grubby, but we’re just checking the contents of the $menu
                    // to see if there were no results returned
                    if ( $menu.children().length == 0 )
                    {
                        $('<p>'+Craft.t('tools', 'No results')+' &hellip;</p>').appendTo($menu);
                    }

                    // Highlight first match
                    $menu.find('a').first().addClass('hover');

                    this.searchMenu = new Garnish.Menu($menu, {
                        attachToElement: this.$addElementInput,
                        onOptionSelect: $.proxy(this, 'selectElement')
                    });

                    this.addListener($menu, 'mousedown', $.proxy(function()
                    {
                        this._ignoreBlur = true;
                    }, this));

                    this.searchMenu.show();
                }

            }, this));
        }
        else
        {
            this.$spinner.addClass('hidden');
        }
    },

    selectElement: function(option)
    {
        var $option = $(option),
            elementId = $option.data('id'),
            status = $option.data('status'),
            title = $option.text();

        if (this.settings.elementType == 'Entry' || this.settings.elementType == 'craft\\commerce\\elements\\Product')
        {
            var $element = $('<div class="element removable" data-id="'+elementId+'" data-editable/>').appendTo(this.$elementsContainer),
                $input = $('<input type="hidden" name="'+this.settings.name+'[]" value="'+elementId+'"/>').appendTo($element)

            $('<a class="delete icon" title="'+Craft.t('tools', 'Remove')+'"></a>').appendTo($element);
            $('<div class="label"><span class="status '+status+'"></span><span class="title">'+title+'</span></div>').appendTo($element);

            var margin = -($element.outerWidth()+10);
            this.$addElementInput.css('margin-'+Craft.left, margin+'px');

            var animateCss = {};
            animateCss['margin-'+Craft.left] = 0;
            this.$addElementInput.velocity(animateCss, 'fast');

            this.$elements = this.$elements.add($element);

            this.addElements($element);
        }
        else if (this.settings.elementType == 'Category')
        {
            var selectedCategoryIds = this.getSelectedElementIds();

            selectedCategoryIds.push(elementId);

            var data = {
                categoryIds:    selectedCategoryIds,
                locale:         this.settings.locale,
                id:             this.settings.id,
                name:           this.settings.name,
                limit:          this.settings.limit,
                selectionLabel: this.settings.selectionLabel
            };

            Craft.postActionRequest('categories/input-html', data, $.proxy(function(response, textStatus)
            {

                if (textStatus == 'success')
                {
                    var $newInput = $(response.html),
                            $newElementsContainer = $newInput.children('.elements');

                    this.$elementsContainer.replaceWith($newElementsContainer);
                    this.$elementsContainer = $newElementsContainer;
                    this.resetElements();

                    var $element = this.getElementById(elementId);
                    var margin = -($element.outerWidth()+10);
                    this.$addElementInput.css('margin-'+Craft.left, margin+'px');

                    var animateCss = {};
                    animateCss['margin-'+Craft.left] = 0;
                    this.$addElementInput.velocity(animateCss, 'fast');
                }
            }, this));
        }

        this.killSearchMenu();
        this.$addElementInput.val('');
        this.$addElementInput.focus();

    },

    removeElement: function($element)
    {

        if (this.settings.elementType == 'Entry' || this.settings.elementType == 'craft\\commerce\\elements\\Product')
        {
            this.removeElements($element);
            this.animateElementAway($element, function() {
                $element.remove();
            });
        }
        else if (this.settings.elementType == 'Category')
        {
            // Find any descendants this category might have
            var $allCategories = $element.add($element.parent().siblings('ul').find('.element'));

            // Remove our record of them all at once
            this.removeElements($allCategories);

            // Animate them away one at a time
            for (var i = 0; i < $allCategories.length; i++)
            {
                this._animateCategoryAway($allCategories, i);
            }
        }

    },

    killSearchMenu: function()
    {
        this.searchMenu.hide();
        this.searchMenu.destroy();
        this.searchMenu = null;
    },

    _animateCategoryAway: function($allCategories, i)
    {
        // Is this the last one?
        if (i == $allCategories.length - 1)
        {
            var callback = $.proxy(function()
            {
                var $li = $allCategories.first().parent().parent(),
                    $ul = $li.parent();

                if ($ul[0] == this.$elementsContainer[0] || $li.siblings().length)
                {
                    $li.remove();
                }
                else
                {
                    $ul.remove();
                }
            }, this);
        }
        else
        {
            callback = null;
        }

        var func = $.proxy(function() {
            this.animateElementAway($allCategories.eq(i), callback);
        }, this);

        if (i == 0)
        {
            func();
        }
        else
        {
            setTimeout(func, 100 * i);
        }
    }

});

})(jQuery);

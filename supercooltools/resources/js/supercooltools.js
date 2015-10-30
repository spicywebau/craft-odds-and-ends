/**
 * @author    Josh Angell <josh@supercooldesign.co.uk>
 * @copyright Copyright (c) 2015, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 * @since     1.0
 */

(function($){


if (typeof SupercoolTools == 'undefined')
{
	SupercoolTools = {}
}


/**
 * Search elements like Tags - forked from `Craft.TagSelectInput`
 */
SupercoolTools.ElementSearchInput = Craft.BaseElementSelectInput.extend(
{
	elementType: null,
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

		this.resetElements();

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
			console.log(this.$elements);
			this.$elements.each(function()
			{
				var id = $(this).data('id');
				console.log(id);

				if (id)
				{
					excludeIds.push(id);
				}
			});

			// for (var i = 0; i < this.$elements.length; i++)
			// {
			//
			// }

			if (this.settings.sourceElementId)
			{
				excludeIds.push(this.settings.sourceElementId);
			}

			console.log(excludeIds);

			var data = {
				search:      this.$addElementInput.val(),
				sources:     this.settings.sources,
				elementType: this.settings.elementType,
				excludeIds:  excludeIds
			};

			Craft.postActionRequest('supercoolTools/searchForElements', data, $.proxy(function(response, textStatus)
			{
				this.$spinner.addClass('hidden');

				if (textStatus == 'success')
				{
					var $menu = $('<div class="menu supercooltools-elementsearch__menu"/>').appendTo(Garnish.$bod);

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
						$('<p>'+Craft.t('No results')+' &hellip;</p>').appendTo($menu);
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
			id = $option.data('id'),
			status = $option.data('status'),
			title = $option.text();

		var $element = $('<div class="element removable" data-id="'+id+'" data-editable/>').appendTo(this.$elementsContainer),
			$input = $('<input type="hidden" name="'+this.settings.name+'[]" value="'+id+'"/>').appendTo($element)

		$('<a class="delete icon" title="'+Craft.t('Remove')+'"></a>').appendTo($element);
		$('<div class="label"><span class="status '+status+'"></span><span class="title">'+title+'</span></div>').appendTo($element);

		var margin = -($element.outerWidth()+10);
		this.$addElementInput.css('margin-'+Craft.left, margin+'px');

		var animateCss = {};
		animateCss['margin-'+Craft.left] = 0;
		this.$addElementInput.velocity(animateCss, 'fast');

		this.$elements = this.$elements.add($element);

		this.addElements($element);

		this.killSearchMenu();
		this.$addElementInput.val('');
		this.$addElementInput.focus();
	},

	killSearchMenu: function()
	{
		this.searchMenu.hide();
		this.searchMenu.destroy();
		this.searchMenu = null;
	}
});

})(jQuery);

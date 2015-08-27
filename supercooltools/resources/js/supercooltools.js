/**
 * @author    Josh Angell <josh@supercooldesign.co.uk>
 * @copyright Copyright (c) 2015, Supercool Ltd
 * @see       http://plugins.supercooldesign.co.uk
 * @since     1.0
 */

(function($){


if (typeof SuperCoolTools == 'undefined')
{
	SuperCoolTools = {}
}


/**
 * Entries with search input - forked from `Craft.TagSelectInput`
 */
SuperCoolTools.EntriesSearchInput = Craft.BaseElementSelectInput.extend(
{
	searchTimeout: null,
	searchMenu: null,
	limit: null,

	$container: null,
	$elementsContainer: null,
	$elements: null,
	$addEntryContainer: null,
	$addEntryInput: null,
	$spinner: null,

	_ignoreBlur: false,
	_initialized: false,

	init: function(settings)
	{
		this.base($.extend({}, settings));

		this.$addEntryContainer = this.$container.children('.add');
		this.$addEntryInput = this.$addEntryContainer.children('.text');
		this.$spinner = this.$addEntryInput.next();

		// No reason for this to be sortable if we're only allowing 1 selection
		if (this.settings.limit == 1)
		{
			this.settings.sortable = false;
		}

		// Ping this so the input hides on load if it needs to
		this.updateAddElementsBtn();

		// Bind listeners
		this.addListener(this.$addEntryInput, 'textchange', $.proxy(function()
		{
			if (this.searchTimeout)
			{
				clearTimeout(this.searchTimeout);
			}

			this.searchTimeout = setTimeout($.proxy(this, 'searchForEntries'), 500);
		}, this));

		this.addListener(this.$addEntryInput, 'keypress', function(ev)
		{
			if (ev.keyCode == Garnish.RETURN_KEY)
			{
				ev.preventDefault();

				if (this.searchMenu)
				{
					this.selectEntry(this.searchMenu.$options[0]);
				}
			}
		});

		this.addListener(this.$addEntryInput, 'focus', function()
		{
			if (this.searchMenu)
			{
				this.searchMenu.show();
			}
		});

		this.addListener(this.$addEntryInput, 'blur', function()
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

	// I’m hi-jacking these as they get fired when the limit is breached
	disableAddElementsBtn: function()
	{
		if (this.$addEntryContainer && !this.$addEntryContainer.hasClass('disabled'))
		{
			this.$addEntryInput.prop('disabled', true);
			this.$addEntryContainer
					.velocity('fadeOut', { duration: Craft.BaseElementSelectInput.ADD_FX_DURATION })
					.addClass('disabled');
		}
	},
	enableAddElementsBtn: function()
	{
		if (this.$addEntryContainer && this.$addEntryContainer.hasClass('disabled'))
		{
			this.$addEntryInput.prop('disabled', false);
			this.$addEntryContainer
					.velocity('fadeIn', { display: 'inline-block', duration: Craft.BaseElementSelectInput.REMOVE_FX_DURATION })
					.removeClass('disabled');
			this.$addEntryInput.trigger('focus');
		}
	},

	searchForEntries: function()
	{
		if (this.searchMenu)
		{
			this.killSearchMenu();
		}

		var val = this.$addEntryInput.val();

		if (val)
		{
			this.$spinner.removeClass('hidden');

			var excludeIds = [];

			for (var i = 0; i < this.$elements.length; i++)
			{
				var id = $(this.$elements[i]).data('id');

				if (id)
				{
					excludeIds.push(id);
				}
			}

			if (this.settings.sourceElementId)
			{
				excludeIds.push(this.settings.sourceElementId);
			}

			var data = {
				search:     this.$addEntryInput.val(),
				sources:    this.settings.sources,
				excludeIds: excludeIds
			};

			Craft.postActionRequest('superCoolTools/searchForEntries', data, $.proxy(function(response, textStatus)
			{
				this.$spinner.addClass('hidden');

				if (textStatus == 'success')
				{
					var $menu = $('<div class="menu supercooltools-entriessearch__menu"/>').appendTo(Garnish.$bod);

					// Loop each source defined in our settings and see if we got anything back from it
					for (var i = 0; i < this.settings.sources.length; i++) {
						var sourceKey = this.settings.sources[i];

						if (response.entries.hasOwnProperty(sourceKey))
						{
							// Section name
							$('<h6>'+response.entries[sourceKey][0].sectionName+'</h6>').appendTo($menu);
							var $ul = $('<ul/>').appendTo($menu);

							// Entries in that section
							for (var n = 0; n < response.entries[sourceKey].length; n++)
							{
								var $li = $('<li/>').appendTo($ul),
										$a = $('<a />').appendTo($li).text(response.entries[sourceKey][n].title).data('id', response.entries[sourceKey][n].id).data('status', response.entries[sourceKey][n].status);
								$('<span class="status '+response.entries[sourceKey][n].status+'"/>').prependTo($a);
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
						attachToElement: this.$addEntryInput,
						onOptionSelect: $.proxy(this, 'selectEntry')
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

	selectEntry: function(option)
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
		this.$addEntryInput.css('margin-'+Craft.left, margin+'px');

		var animateCss = {};
		animateCss['margin-'+Craft.left] = 0;
		this.$addEntryInput.velocity(animateCss, 'fast');

		this.$elements = this.$elements.add($element);

		this.addElements($element);

		this.killSearchMenu();
		this.$addEntryInput.val('');
		this.$addEntryInput.focus();
	},

	killSearchMenu: function()
	{
		this.searchMenu.hide();
		this.searchMenu.destroy();
		this.searchMenu = null;
	}
});

})(jQuery);

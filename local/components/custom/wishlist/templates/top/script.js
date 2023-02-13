(function (window) {

	if (!!window.Wishlist)
	{
		return;
	}

	window.Wishlist = function (params)
	{
		this.obWishlist = null;
		this.obAdminPanel = null;
		this.visual = params.VISUAL;
		this.ajax = params.AJAX;
		this.position = params.POSITION;

		BX.ready(BX.proxy(this.init, this));
	};

	window.Wishlist.prototype.init = function()
	{
		this.obWishlist = BX(this.visual.ID);
		if (BX.type.isElementNode(this.obWishlist))
		{
			BX.addCustomEvent(window, "OnWishlistChange", BX.proxy(this.reload, this));
			BX.bindDelegate(this.obWishlist, 'click', {tagName : 'a'}, BX.proxy(this.deleteWishlist, this));
		}
	};

	window.Wishlist.prototype.reload = function()
	{
		BX.showWait(this.obWishlist);
		BX.ajax.post(
			this.ajax.url,
			this.ajax.reload,
			BX.proxy(this.reloadResult, this)
		);
	};

	window.Wishlist.prototype.reloadResult = function(result)
	{
		var mode = 'block';
		BX.closeWait();
		this.obWishlist.innerHTML = result;
		if (BX.type.isNotEmptyString(result))
		{
			if (result.indexOf('<table') >= 0)
				mode = 'block';
		}
		BX.style(this.obWishlist, 'display', mode);
	};

	window.Wishlist.prototype.deleteWishlist = function()
	{
		var target = BX.proxy_context,
			itemID,
			url;

		if (!!target && target.hasAttribute('data-id'))
		{
			itemID = parseInt(target.getAttribute('data-id'), 10);
			if (!isNaN(itemID))
			{
				BX.showWait(this.obWishlist);
				url = this.ajax.url + this.ajax.templates.delete + itemID.toString();
				BX.ajax.loadJSON(
					url,
					this.ajax.params,
					BX.proxy(this.deleteWishlistResult, this)
				);
			}
		}
	};

	window.Wishlist.prototype.deleteWishlistResult = function(result)
	{
		var tbl,
			i,
			cnt,
			newCount;

		BX.closeWait();
		if (BX.type.isPlainObject(result))
		{
			if (BX.type.isNotEmptyString(result.STATUS) && result.STATUS === 'OK' && !!result.ID)
			{
				BX.onCustomEvent('onCatalogDeleteCompare', [result.ID]);

				tbl = this.obWishlist.querySelector('table[data-block="item-list"]');
				if (BX.type.isElementNode(tbl))
				{
					if (tbl.rows.length > 1)
					{
						for (i = 0; i < tbl.rows.length; i++)
						{
							if (
								tbl.rows[i].hasAttribute('data-row-id')
								&& tbl.rows[i].getAttribute('data-row-id') === ('row' + result.ID)
							)
							{
								tbl.deleteRow(i);
							}
						}
						if (BX.type.isNotEmptyString(result.COUNT) || BX.type.isNumber(result.COUNT))
						{
							newCount = parseInt(result.COUNT, 10);
							if (!isNaN(newCount))
							{
								cnt = this.obWishlist.querySelector('span[data-block="count"]');
								if (BX.type.isElementNode(cnt))
								{
									cnt.innerHTML = newCount.toString();
								}
								cnt = null;
								BX.style(this.obWishlist, 'display', (newCount > 0 ? 'block' : 'none'));
							}
						}
					}
					else
					{
						this.reload();
					}
				}
				tbl = null;
			}
		}
	};

	window.Wishlist.prototype.setVerticalAlign = function()
	{
		var topSize;
		if (BX.type.isElementNode(this.obWishlist) && BX.type.isElementNode(this.obAdminPanel))
		{
			topSize = parseInt(this.obAdminPanel.offsetHeight, 10);
			if (isNaN(topSize))
			{
				topSize = 0;
			}
			topSize +=5;
			BX.style(this.obWishlist, 'top', topSize.toString()+'px');
		}
	};

})(window);
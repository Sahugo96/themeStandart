	(function(){
		function stripHtml(s){
			var d = document.createElement('div');
			d.innerHTML = String(s || '');
			return (d.textContent || d.innerText || '').trim();
		}
		function initPostSelect() {
			document.querySelectorAll('.tolstenko-post-select-token-field').forEach(function(wrap) {
				if (wrap.dataset.initialized) return;
				wrap.dataset.initialized = '1';
				var input = wrap.querySelector('.tolstenko-post-select-input');
				var suggestions = wrap.querySelector('.tolstenko-post-select-suggestions');
				var tokensContainer = wrap.querySelector('.tolstenko-post-select-tokens');
				var name = wrap.dataset.name;
				var postType = wrap.dataset.postType || '';
				if (!input || !suggestions || !tokensContainer || !name) return;

				var allPosts = [];
				var isLoading = false;
				var isLoaded = false;

				try {
					if (wrap.hasAttribute('data-posts')) {
						var embedded = JSON.parse(wrap.getAttribute('data-posts') || '[]');
						if (Array.isArray(embedded)) {
							allPosts = embedded.map(function(p){
								return { id: parseInt(p.id, 10), title: stripHtml(p.title) || ('#' + p.id) };
							}).filter(function(p){ return p.id > 0; });
							suggestions.dataset.posts = JSON.stringify(allPosts);
							isLoaded = true;
						}
					}
				} catch (e) {}

				function loadAllPosts(cb) {
					if (isLoaded) { if (cb) cb(); return; }
					if (isLoading) return;
					isLoading = true;

					var existingIds = {};
					tokensContainer.querySelectorAll('.tolstenko-post-select-token').forEach(function(token) {
						var id = parseInt(token.dataset.id, 10);
						existingIds[id] = true;
						allPosts.push({
							id: id,
							title: stripHtml(token.querySelector('.tolstenko-post-select-token-label').textContent)
						});
					});

					if (!postType) {
						isLoaded = true;
						isLoading = false;
						suggestions.dataset.posts = JSON.stringify(allPosts);
						if (cb) cb();
						return;
					}

					var restRoot = (window.wpApiSettings && wpApiSettings.root) ? wpApiSettings.root : '/wp-json/';
					fetch(restRoot + 'wp/v2/' + postType + '?per_page=100&status=publish&_fields=id,title')
						.then(function(res) { return res.json(); })
						.then(function(data) {
							if (!Array.isArray(data)) data = [];
							data.forEach(function(post) {
								if (!existingIds[post.id]) {
									allPosts.push({ id: post.id, title: stripHtml(post.title && post.title.rendered) || ('#' + post.id) });
								}
							});
							allPosts.sort(function(a, b) { return a.title.localeCompare(b.title, 'ru'); });
							suggestions.dataset.posts = JSON.stringify(allPosts);
							isLoaded = true;
							isLoading = false;
							if (cb) cb();
						})
						.catch(function() {
							isLoaded = true;
							isLoading = false;
							suggestions.dataset.posts = JSON.stringify(allPosts);
							if (cb) cb();
						});
				}

				function getSelectedIds() {
					var ids = [];
					tokensContainer.querySelectorAll('.tolstenko-post-select-token').forEach(function(token) {
						ids.push(parseInt(token.dataset.id, 10));
					});
					return ids;
				}

				function showSuggestions(filter) {
					var posts = [];
					try { posts = JSON.parse(suggestions.dataset.posts || '[]'); } catch (e) { posts = []; }
					var selectedIds = getSelectedIds();
					var query = (filter || '').toLowerCase().trim();
					var filtered = posts.filter(function(p) {
						if (selectedIds.indexOf(p.id) !== -1) return false;
						if (query) return String(p.title || '').toLowerCase().indexOf(query) !== -1;
						return true;
					});

					if (filtered.length === 0) {
						suggestions.style.display = 'none';
						return;
					}

					suggestions.innerHTML = '';
					filtered.forEach(function(post) {
						var div = document.createElement('div');
						div.className = 'suggestion';
						div.textContent = post.title;
						div.dataset.id = post.id;
						div.addEventListener('mousedown', function(e) {
							e.preventDefault();
							addToken(post.id, post.title);
							input.value = '';
							showSuggestions('');
						});
						suggestions.appendChild(div);
					});
					suggestions.style.display = 'block';
				}

				function addToken(id, title) {
					var existing = tokensContainer.querySelector('.tolstenko-post-select-token[data-id="' + id + '"]');
					if (existing) return;
					var token = document.createElement('span');
					token.className = 'tolstenko-post-select-token';
					token.dataset.id = String(id);
					token.innerHTML = '<span class="tolstenko-post-select-token-label"></span>' +
						'<button type="button" class="tolstenko-post-select-token-remove" title="Удалить">×</button>' +
						'<input type="hidden" name="' + name + '[]" value="' + id + '">';
					token.querySelector('.tolstenko-post-select-token-label').textContent = title;
					tokensContainer.appendChild(token);
					token.querySelector('.tolstenko-post-select-token-remove').addEventListener('click', function() {
						token.remove();
						if (document.activeElement === input) showSuggestions(input.value);
					});
				}

				input.addEventListener('focus', function() {
					loadAllPosts(function(){ showSuggestions(input.value); });
				});
				input.addEventListener('input', function() {
					loadAllPosts(function(){ showSuggestions(input.value); });
				});
				input.addEventListener('blur', function() {
					setTimeout(function(){ suggestions.style.display = 'none'; }, 180);
				});
				document.addEventListener('click', function(e) {
					if (!wrap.contains(e.target)) suggestions.style.display = 'none';
				});
				tokensContainer.querySelectorAll('.tolstenko-post-select-token-remove').forEach(function(btn) {
					btn.addEventListener('click', function() {
						btn.closest('.tolstenko-post-select-token').remove();
						if (document.activeElement === input) showSuggestions(input.value);
					});
				});
			});
		}

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', initPostSelect);
		} else {
			initPostSelect();
		}
		if (window.MutationObserver) {
			new MutationObserver(function(){ initPostSelect(); }).observe(document.body, { childList: true, subtree: true });
		}
		window.tolstenkoInitPostSelect = initPostSelect;
	})();

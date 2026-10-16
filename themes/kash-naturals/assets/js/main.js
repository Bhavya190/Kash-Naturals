if (window.__kashScriptLoaded) {
    // Script already loaded once, prevent double initialization
} else {
    window.__kashScriptLoaded = true;
}

jQuery(document).ready(function ($) {
    'use strict';

    /* ==========================================================================
       1. GLOBAL PRODUCT CATALOG DATABASE (Dynamic from WooCommerce)
       ========================================================================== */
    const themeUri = (typeof kash_dynamic_data !== 'undefined' && kash_dynamic_data.theme_uri)
        ? kash_dynamic_data.theme_uri
        : ((typeof KASH_THEME_URI !== 'undefined') ? KASH_THEME_URI : '/wp-content/themes/kash-naturals');

    const PRODUCTS_DB = (typeof kash_dynamic_data !== 'undefined' && Array.isArray(kash_dynamic_data.products))
        ? kash_dynamic_data.products
        : [];

    /* ==========================================================================
       2. TOAST NOTIFICATION SYSTEM
       ========================================================================== */
    function showToast(message, type = 'success') {
        const icon = (type === 'success') ? 'fa-circle-check' : 'fa-circle-info';
        const $toast = $(`
            <div class="kash-toast ${type}">
                <i class="fa-solid ${icon}"></i>
                <span>${message}</span>
            </div>
        `);
        $('#kash-toast-container').append($toast);

        setTimeout(() => {
            $toast.addClass('show');
        }, 10);

        setTimeout(() => {
            $toast.removeClass('show');
            setTimeout(() => $toast.remove(), 300);
        }, 3200);
    }

    /* ==========================================================================
       3. LIVE INTERACTIVE SEARCH SYSTEM
       ========================================================================== */
    const $searchModal = $('#search-modal');
    const $searchField = $('#live-search-field');
    const $searchGrid = $('#search-results-grid');
    const $searchStatus = $('#search-status-label');
    const $searchClearBtn = $('#search-clear-btn');
    let currentSearchCat = 'all';

    // Open Search Modal
    $(document).on('click', '#search-modal-trigger, .search-trigger', function (e) {
        e.preventDefault();
        $searchModal.addClass('active');
        $('body').addClass('modal-open');
        setTimeout(() => $searchField.focus(), 150);
        renderSearchResults();
    });

    // Close Search Modal
    $('#close-search, .search-modal-overlay').on('click', function (e) {
        if (e.target === this || $(e.target).hasClass('close-modal-btn')) {
            $searchModal.removeClass('active');
            $('body').removeClass('modal-open');
        }
    });

    // Clear Search Input
    $searchClearBtn.on('click', function () {
        $searchField.val('').focus();
        $(this).hide();
        renderSearchResults();
    });

    // Filter Pills Handler
    $('#search-cat-pills').on('click', '.search-pill', function () {
        $('.search-pill').removeClass('active');
        $(this).addClass('active');
        currentSearchCat = $(this).data('cat');
        renderSearchResults();
    });

    // Realtime Input Event
    $searchField.on('input', function () {
        const query = $(this).val().trim();
        if (query.length > 0) {
            $searchClearBtn.show();
        } else {
            $searchClearBtn.hide();
        }
        renderSearchResults();
    });

    function renderSearchResults() {
        const query = $searchField.val().toLowerCase().trim();

        if (PRODUCTS_DB.length === 0) {
            $searchStatus.html('No products available in the store yet.');
            $searchGrid.html(`
                <div class="search-empty-state">
                    <i class="fa-solid fa-box-open"></i>
                    <p>No products available currently.</p>
                </div>
            `);
            return;
        }
        let matches = PRODUCTS_DB.filter(product => {
            const matchesCat = (currentSearchCat === 'all') || (product.category === currentSearchCat);
            const matchesQuery = !query || 
                product.name.toLowerCase().includes(query) || 
                product.desc.toLowerCase().includes(query) ||
                product.category_name.toLowerCase().includes(query);
            return matchesCat && matchesQuery;
        });

        $searchGrid.empty();

        if (matches.length === 0) {
            $searchStatus.html(`No products found for "<strong>${$searchField.val()}</strong>". Try 'paan', 'kunafa', 'dragees'...`);
            $searchGrid.html(`
                <div class="search-empty-state">
                    <i class="fa-solid fa-magnifying-glass-minus"></i>
                    <p>No matching items found.</p>
                </div>
            `);
            return;
        }

        if (query) {
            $searchStatus.html(`Found <strong>${matches.length}</strong> matching item(s) for "${query}"`);
        } else {
            $searchStatus.html(`Showing <strong>${matches.length}</strong> items in ${currentSearchCat === 'all' ? 'All Categories' : currentSearchCat.replace('-', ' ')}`);
        }

        matches.forEach(prod => {
            const isOos = (prod.in_stock === false || prod.stock_status === 'outofstock');
            const $item = $(`
                <div class="search-item-card ${isOos ? 'item-out-of-stock' : ''}">
                    <div class="search-item-img">
                        <img src="${prod.image}" alt="${prod.name}" />
                    </div>
                    <div class="search-item-info">
                        <span class="search-item-cat">${prod.category_name}</span>
                        <h4 class="search-item-title">${prod.name}</h4>
                        <div class="search-item-stars">★★★★★ (${prod.rating})</div>
                        <div class="search-item-price">₹${prod.price} <del>₹${prod.regular_price}</del></div>
                        ${isOos ? '<div style="color:#ef4444; font-size:11px; font-weight:700; margin-top:3px;"><i class="fa-solid fa-ban"></i> Out of Stock</div>' : ''}
                    </div>
                    ${isOos ? `
                        <button type="button" class="btn-search-add-cart disabled" disabled style="background:rgba(255,255,255,0.08); color:rgba(255,255,255,0.4); cursor:not-allowed;">
                            <i class="fa-solid fa-ban"></i> Sold Out
                        </button>
                    ` : `
                        <button type="button" class="btn-search-add-cart" data-id="${prod.id}">
                            <i class="fa-solid fa-cart-plus"></i> ADD
                        </button>
                    `}
                </div>
            `);

            if (!isOos) {
                $item.find('.btn-search-add-cart').on('click', function () {
                    addToCart(prod.id);
                    $searchModal.removeClass('active');
                    $('body').removeClass('modal-open');
                });
            }

            $searchGrid.append($item);
        });
    }


    /* ==========================================================================
       4. MY ACCOUNT SYSTEM (Auth + User Dashboard + Order History)
       ========================================================================== */
    const $accountModal = $('#account-modal');
    const $authView = $('#account-auth-view');
    const $dashView = $('#account-dashboard-view');

    // Default Sample Orders for Logged-In State
    const SAMPLE_ORDERS = [
        {
            id: '#KASH-8492',
            date: 'Oct 04, 2026',
            status: 'Delivered',
            status_class: 'status-delivered',
            total: 1299,
            items: 'Royal Connoisseur Treasure Box x 1'
        },
        {
            id: '#KASH-7103',
            date: 'Sep 28, 2026',
            status: 'Delivered',
            status_class: 'status-delivered',
            total: 499,
            items: 'Belgian Dark Almond Dragees x 1'
        }
    ];

    // Check Local Storage for User Session
    function getUserSession() {
        try {
            return JSON.parse(localStorage.getItem('kash_user'));
        } catch (e) {
            return null;
        }
    }

    function setUserSession(user) {
        localStorage.setItem('kash_user', JSON.stringify(user));
        updateHeaderUserUI();
    }

    function updateHeaderUserUI() {
        const user = getUserSession();
        if (user) {
            const initials = user.name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
            $('#header-account-icon').hide();
            $('#header-user-badge').text(initials).show();
            $('#account-modal-trigger').attr('title', `Logged in as ${user.name}`);
        } else {
            $('#header-account-icon').show();
            $('#header-user-badge').hide();
            $('#account-modal-trigger').attr('title', 'My Account');
        }
    }

    updateHeaderUserUI();

    // Open Account Modal
    $(document).on('click', '#account-modal-trigger, .account-trigger', function (e) {
        e.preventDefault();
        $accountModal.addClass('active');
        $('body').addClass('modal-open');
        renderAccountModal();
    });

    // Close Account Modal
    $('#close-account, .account-modal-overlay').on('click', function (e) {
        if (e.target === this || $(e.target).hasClass('close-modal-btn')) {
            $accountModal.removeClass('active');
            $('body').removeClass('modal-open');
        }
    });

    function renderAccountModal() {
        const user = getUserSession();
        if (user) {
            $authView.hide();
            $dashView.show();

            const initials = user.name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
            $('#user-avatar-initials').text(initials);
            $('#dash-user-name').text(user.name);
            $('#dash-user-email').text(user.email);

            $('#addr-display-name').text(user.name);

            // Render Orders List
            const orders = user.orders || SAMPLE_ORDERS;
            const $ordersWrap = $('#orders-list-wrap').empty();

            orders.forEach(order => {
                $ordersWrap.append(`
                    <div class="order-card-clean">
                        <div class="order-header-row">
                            <span class="order-id-tag">${order.id}</span>
                            <span class="order-status-badge ${order.status_class}"><i class="fa-solid fa-circle-check"></i> ${order.status}</span>
                        </div>
                        <div class="order-body-text">${order.items}</div>
                        <div class="order-footer-row">
                            <span class="order-date-text"><i class="fa-regular fa-calendar"></i> ${order.date}</span>
                            <span class="order-amount-text">₹${order.total}</span>
                        </div>
                    </div>
                `);
            });

            // Render Wishlist items
            const $wishlistGrid = $('#wishlist-grid').empty();
            let wishlist = [];
            try {
                wishlist = JSON.parse(localStorage.getItem('kash_wishlist') || '[]');
            } catch (e) {
                wishlist = [];
            }
            if (wishlist.length === 0) {
                $wishlistGrid.html(`
                    <div class="cart-empty-state text-center" style="grid-column: 1 / -1; padding: 30px;">
                        <i class="fa-regular fa-heart"></i>
                        <p>Your wishlist is currently empty.</p>
                        <a href="/shop" class="btn-shop-now-empty">EXPLORE PRODUCTS</a>
                    </div>
                `);
            } else {
                wishlist.forEach(item => {
                    const $wCard = $(`
                        <div class="wishlist-item-card">
                            <img src="${item.image}" alt="${item.name}" />
                            <div class="w-info">
                                <h4>${item.name}</h4>
                                <div class="w-price">₹${item.price}</div>
                            </div>
                            <button type="button" class="btn-w-add" data-id="${item.id}">
                                <i class="fa-solid fa-cart-plus"></i> Add
                            </button>
                        </div>
                    `);
                    $wCard.find('.btn-w-add').on('click', function() {
                        addToCart(item.id);
                        $accountModal.removeClass('active');
                        $('body').removeClass('modal-open');
                    });
                    $wishlistGrid.append($wCard);
                });
            }
            // Skip dummy items
            const wishlistItems = [];
            wishlistItems.forEach(item => {
                const $wCard = $(`
                    <div class="wishlist-item-card">
                        <img src="${item.image}" alt="${item.name}" />
                        <div class="w-info">
                            <h4>${item.name}</h4>
                            <div class="w-price">₹${item.price}</div>
                        </div>
                        <button type="button" class="btn-w-add" data-id="${item.id}">
                            <i class="fa-solid fa-cart-plus"></i> Add
                        </button>
                    </div>
                `);
                $wCard.find('.btn-w-add').on('click', function() {
                    addToCart(item.id);
                    $accountModal.removeClass('active');
                    $('body').removeClass('modal-open');
                });
                $wishlistGrid.append($wCard);
            });

        } else {
            $authView.show();
            $dashView.hide();
        }
    }

    // Auth Tabs Switch (Sign In vs Register)
    $('#tab-login-btn').on('click', function () {
        $('.auth-tab-btn').removeClass('active');
        $(this).addClass('active');
        $('#form-login').show();
        $('#form-register').hide();
    });

    $('#tab-register-btn').on('click', function () {
        $('.auth-tab-btn').removeClass('active');
        $(this).addClass('active');
        $('#form-login').hide();
        $('#form-register').show();
    });

    // Dashboard Tabs Switch
    $('.dash-tab-btn').on('click', function () {
        $('.dash-tab-btn').removeClass('active');
        $(this).addClass('active');
        const targetTab = $(this).data('dashtab');
        $('.dash-tab-content').hide();
        $(`#dashtab-${targetTab}`).show();
    });

    // Handle Login Submit
    $('#form-login').on('submit', function (e) {
        e.preventDefault();
        const email = $('#login-email').val();
        const user = {
            name: email.split('@')[0],
            email: email,
            orders: []
        };
        setUserSession(user);
        showToast('Successfully signed in!');
        renderAccountModal();
    });

// Quick demo login removed

    // Handle Register Submit
    $('#form-register').on('submit', function (e) {
        e.preventDefault();
        const name = $('#reg-name').val();
        const email = $('#reg-email').val();
        const user = {
            name: name,
            email: email,
            orders: []
        };
        setUserSession(user);
        showToast(`Welcome to Kash Royal Club, ${name}! Account created.`);
        renderAccountModal();
    });

    // Logout Handler
    $('#btn-logout').on('click', function () {
        localStorage.removeItem('kash_user');
        updateHeaderUserUI();
        showToast('You have been logged out.');
        renderAccountModal();
    });


    /* ==========================================================================
       5. SLIDE-OVER CART DRAWER & CART STATE SYSTEM
       ========================================================================== */
    const $cartDrawer = $('#cart-drawer');
    const $cartOverlay = $('#cart-drawer-overlay');
    let couponApplied = false;

    // Get Cart with Strict Dynamic WooCommerce Synchronization
    function getCart() {
        try {
            const data = localStorage.getItem('kash_cart');
            let cart = data ? JSON.parse(data) : [];

            // RULE 1: If there are NO products in the store (or store catalog is empty), cart MUST be completely empty.
            if (!PRODUCTS_DB || PRODUCTS_DB.length === 0) {
                if (cart.length > 0) {
                    localStorage.removeItem('kash_cart');
                }
                return [];
            }

            // RULE 2: Purge any cart items that no longer exist in the store catalog,
            // and dynamically refresh live price, stock status, and stock availability from WooCommerce.
            let validCart = [];
            let changed = false;

            cart.forEach(item => {
                const dbProduct = PRODUCTS_DB.find(p => p.id == item.id || (item.name && p.name.toLowerCase() === item.name.toLowerCase()));
                if (dbProduct) {
                    const isItemInStock = (dbProduct.in_stock !== false && dbProduct.stock_status !== 'outofstock');
                    validCart.push({
                        id: dbProduct.id,
                        name: dbProduct.name,
                        price: dbProduct.price,
                        image: dbProduct.image || item.image,
                        qty: item.qty > 0 ? item.qty : 1,
                        in_stock: isItemInStock,
                        stock_status: dbProduct.stock_status || (isItemInStock ? 'instock' : 'outofstock'),
                        stock_quantity: dbProduct.stock_quantity,
                        managing_stock: dbProduct.managing_stock,
                        backorders: dbProduct.backorders
                    });
                } else {
                    // Item was deleted or removed from WooCommerce -> purge it dynamically
                    changed = true;
                }
            });

            if (changed || validCart.length !== cart.length) {
                localStorage.setItem('kash_cart', JSON.stringify(validCart));
            }

            return validCart;
        } catch (e) {
            return [];
        }
    }

    function saveCart(cart) {
        localStorage.setItem('kash_cart', JSON.stringify(cart));
        updateCartCountBadge();
        renderCartDrawer();
    }

    // Sync with WooCommerce native cart session if active
    function syncWithWooCommerceCart() {
        if (typeof kash_dynamic_data !== 'undefined' && kash_dynamic_data.is_wc_active && kash_dynamic_data.ajax_url) {
            $.ajax({
                type: 'POST',
                url: kash_dynamic_data.ajax_url,
                data: { action: 'kash_get_cart' },
                dataType: 'json',
                success: function (res) {
                    if (res && res.success && res.data && Array.isArray(res.data.items)) {
                        const wcCart = res.data;
                        if (wcCart.items.length > 0) {
                            const syncedCart = wcCart.items.map(item => ({
                                id: item.id,
                                key: item.key,
                                name: item.name,
                                price: item.price,
                                image: item.image,
                                qty: item.qty,
                                in_stock: (item.in_stock !== false && item.stock_status !== 'outofstock'),
                                stock_status: item.stock_status,
                                stock_quantity: item.stock_quantity
                            }));
                            localStorage.setItem('kash_cart', JSON.stringify(syncedCart));
                            updateCartCountBadge();
                            renderCartDrawer();
                        } else if (PRODUCTS_DB.length > 0) {
                            // WC cart empty, ensure local cart reflects this if WC is the source of truth
                            const localCart = getCart();
                            if (localCart.length > 0 && localCart.some(i => i.key)) {
                                saveCart([]);
                            }
                        }
                    }
                }
            });
        }
    }
    window.syncWithWooCommerceCart = syncWithWooCommerceCart;

    function syncAddToCartWooCommerce(productId, quantity) {
        if (typeof kash_dynamic_data !== 'undefined' && kash_dynamic_data.is_wc_active && kash_dynamic_data.ajax_url) {
            $.ajax({
                type: 'POST',
                url: kash_dynamic_data.ajax_url,
                data: {
                    action: 'kash_add_to_cart',
                    product_id: productId,
                    quantity: quantity
                },
                dataType: 'json',
                success: function (res) {
                    if (res && !res.success && res.data && res.data.message) {
                        showToast(res.data.message, 'info');
                    }
                }
            });
        }
    }

    // Initial Cart Setup & Dynamic Catalog Verification
    const initialCart = getCart();
    updateCartCountBadge();
    syncWithWooCommerceCart();

    function updateCartCountBadge() {
        const cart = getCart();
        const totalCount = cart.reduce((sum, item) => sum + item.qty, 0);
        const $badge = $('#mini-cart-count');
        $badge.text(totalCount);

        if (totalCount > 0) {
            $badge.addClass('bounce');
            setTimeout(() => $badge.removeClass('bounce'), 400);
        }
    }

    // Global Add To Cart Function with Live Stock Checks
    window.addToCart = function (productId, quantity = 1) {
        let product = (PRODUCTS_DB && PRODUCTS_DB.length) ? PRODUCTS_DB.find(p => p.id == productId) : null;
        if (!product) {
            const $btn = $(`.add-to-cart-btn[data-product-id="${productId}"], .add-to-cart-btn[data-product_id="${productId}"]`).first();
            if ($btn.length && $btn.data('product-name')) {
                product = {
                    id: productId,
                    name: $btn.data('product-name') || 'Artisanal Specialty',
                    price: parseFloat($btn.data('product-price')) || 0,
                    image: $btn.data('product-img') || '',
                    in_stock: true,
                    stock_status: 'instock',
                    stock_quantity: null
                };
            }
        }

        if (!product) {
            if (!PRODUCTS_DB || PRODUCTS_DB.length === 0) {
                showToast('No products currently available in the shop.', 'info');
            } else {
                showToast('Product not found or currently unavailable.', 'info');
            }
            return;
        }

        // Live Stock Validation Check
        if (product.in_stock === false || product.stock_status === 'outofstock') {
            showToast(`Sorry, "${product.name}" is currently out of stock.`, 'info');
            return;
        }

        // Check remaining stock quantity if managed
        if (product.managing_stock && !product.backorders && typeof product.stock_quantity === 'number') {
            let currentCart = getCart();
            const existingItem = currentCart.find(i => i.id == productId);
            const currentQty = existingItem ? existingItem.qty : 0;
            if (currentQty + quantity > product.stock_quantity) {
                showToast(`Only ${product.stock_quantity} item(s) available in stock for "${product.name}".`, 'info');
                return;
            }
        }

        let cart = getCart();
        const existingIndex = cart.findIndex(item => item.id == productId);

        if (existingIndex > -1) {
            cart[existingIndex].qty += quantity;
        } else {
            cart.push({
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.image,
                qty: quantity,
                in_stock: true,
                stock_status: 'instock',
                stock_quantity: product.stock_quantity
            });
        }

        saveCart(cart);
        showToast(`Added "${product.name}" to your shopping bag!`);
        openCartDrawer();
        syncAddToCartWooCommerce(product.id, quantity);
    };

    // Global Click Listener for all "ADD TO CART" / "ORDER NOW" / "+" Buttons Across Site
    $(document).on('click', '.fav-btn-quick-add, .add-to-cart-btn, .btn-add-to-cart-outline, .btn-combo-add-cart, .btn-add-cart-exact, .combo-ref-btn, .btn-combo-shop-now', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const $btn = $(this);
        if ($btn.hasClass('disabled') || $btn.prop('disabled')) {
            showToast('This product is currently out of stock.', 'info');
            return;
        }
        
        let prodId = $btn.data('product-id') || $btn.attr('data-product-id');
        let prodName = $btn.data('product-name') || $btn.attr('data-product-name');

        if (!prodId && !prodName) {
            prodName = $btn.closest('.bestseller-card-exact, .shop-product-card-exact, .combo-card-exact, .combo-ref-card, .fav-card-item, .fav-card-inner').find('.bestseller-prod-title, .product-title-exact, .combo-card-title, .combo-ref-title, .fav-prod-title').text().trim();
        }

        let match = null;
        if (prodId) {
            match = PRODUCTS_DB.find(p => p.id == prodId);
        }
        if (!match && prodName) {
            match = PRODUCTS_DB.find(p => p.name.toLowerCase().includes(prodName.toLowerCase()) || prodName.toLowerCase().includes(p.name.toLowerCase()));
        }

        if (match) {
            addToCart(match.id, 1);
        } else {
            showToast('Product is currently unavailable or out of stock.', 'info');
        }
    });

    // Open/Close Cart Drawer
    function openCartDrawer() {
        renderCartDrawer();
        $cartDrawer.addClass('active');
        $cartOverlay.addClass('active');
        $('body').addClass('modal-open');
        syncWithWooCommerceCart();
    }

    function closeCartDrawer() {
        $cartDrawer.removeClass('active');
        $cartOverlay.removeClass('active');
        $('body').removeClass('modal-open');
    }

    $(document).on('click', '#mini-cart-toggle, .cart-drawer-trigger', function (e) {
        e.preventDefault();
        openCartDrawer();
    });

    $('#close-cart-drawer, #cart-drawer-overlay, #btn-close-cart-continue').on('click', function () {
        closeCartDrawer();
    });

    // Render Cart Items & Summary Totals with Dynamic Stock Indicators
    function renderCartDrawer() {
        const cart = getCart();
        const $list = $('#cart-drawer-items-list').empty();
        const totalCount = cart.reduce((sum, item) => sum + item.qty, 0);
        $('#cart-drawer-count-badge').text(`${totalCount} Items`);

        const shopUrl = (typeof kash_dynamic_data !== 'undefined' && kash_dynamic_data.shop_url) ? kash_dynamic_data.shop_url : '/shop';

        if (cart.length === 0) {
            $list.html(`
                <div class="cart-empty-state text-center">
                    <i class="fa-solid fa-basket-shopping"></i>
                    <p>Your shopping bag is currently empty.</p>
                    <a href="${shopUrl}" class="btn-shop-now-empty" id="btn-empty-shop">START SHOPPING</a>
                </div>
            `);
            $('#btn-empty-shop').on('click', function(e) {
                e.preventDefault();
                closeCartDrawer();
                window.location.href = $(this).attr('href');
            });

            $('#cart-drawer-stock-banner').remove();
            $('#btn-open-checkout')
                .removeClass('checkout-blocked')
                .prop('disabled', false)
                .html('PROCEED TO CHECKOUT <i class="fa-solid fa-lock"></i>');

            updateCartCalculations(0);
            return;
        }

        let subtotal = 0;
        let hasOutOfStock = false;

        cart.forEach((item, index) => {
            const isOutOfStock = (item.in_stock === false || item.stock_status === 'outofstock');
            if (isOutOfStock) {
                hasOutOfStock = true;
            }

            const itemTotal = item.price * item.qty;
            subtotal += itemTotal;

            const $cartItem = $(`
                <div class="cart-drawer-item ${isOutOfStock ? 'item-out-of-stock' : ''}">
                    <div class="cart-item-thumb-wrap">
                        <img src="${item.image}" alt="${item.name}" class="cart-item-thumb" />
                        ${isOutOfStock ? '<span class="cart-thumb-oos-overlay">OUT OF STOCK</span>' : ''}
                    </div>
                    <div class="cart-item-details">
                        ${isOutOfStock ? '<div class="cart-item-oos-badge"><i class="fa-solid fa-triangle-exclamation"></i> Unavailable (Out of Stock)</div>' : ''}
                        <h4 class="cart-item-title">${item.name}</h4>
                        <div class="cart-item-price">₹${item.price}</div>
                        <div class="cart-item-qty-row">
                            ${isOutOfStock ? `
                                <span class="cart-item-oos-note">Unavailable in stock. Remove item to checkout.</span>
                            ` : `
                                <div class="qty-stepper">
                                    <button type="button" class="btn-qty-minus" data-index="${index}">-</button>
                                    <span class="qty-val">${item.qty}</span>
                                    <button type="button" class="btn-qty-plus" data-index="${index}">+</button>
                                </div>
                            `}
                            <span class="cart-item-subtotal">₹${itemTotal}</span>
                        </div>
                    </div>
                    <button type="button" class="btn-remove-item" data-index="${index}" title="Remove Item">&times;</button>
                </div>
            `);

            $list.append($cartItem);
        });

        // Handle Out of Stock Warning Banner & Checkout Button Lock
        $('#cart-drawer-stock-banner').remove();
        const $checkoutBtn = $('#btn-open-checkout');

        if (hasOutOfStock) {
            const $banner = $(`
                <div class="cart-stock-warning-banner" id="cart-drawer-stock-banner">
                    <div>
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span><strong>Product Unavailable:</strong> Some items in your bag are currently out of stock. Remove them to proceed to checkout.</span>
                    </div>
                    <button type="button" class="btn-remove-oos-items" id="btn-remove-all-oos">Remove Unavailable</button>
                </div>
            `);
            $('.cart-summary-totals').before($banner);

            $checkoutBtn
                .addClass('checkout-blocked')
                .prop('disabled', true)
                .html('<i class="fa-solid fa-ban"></i> CANNOT CHECKOUT (REMOVE OUT OF STOCK ITEMS)');
        } else {
            $checkoutBtn
                .removeClass('checkout-blocked')
                .prop('disabled', false)
                .html('PROCEED TO CHECKOUT <i class="fa-solid fa-lock"></i>');
        }

        updateCartCalculations(subtotal);
    }

    function updateCartCalculations(subtotal) {
        // Free Shipping Progress Bar (Target ₹999)
        const targetFree = 999;
        const $shippingBarText = $('#shipping-bar-text');
        const $shippingFill = $('#shipping-progress-fill');

        if (subtotal >= targetFree) {
            $shippingBarText.html('🎉 Congratulations! You unlocked <strong>FREE Cold Shipping</strong>!');
            $shippingFill.css('width', '100%').addClass('complete');
        } else {
            const diff = targetFree - subtotal;
            const pct = Math.min(100, Math.round((subtotal / targetFree) * 100));
            $shippingBarText.html(`Add <strong>₹${diff}</strong> more to unlock <strong>FREE Shipping</strong>!`);
            $shippingFill.css('width', `${pct}%`).removeClass('complete');
        }

        // Coupon Discount
        let discount = 0;
        if (couponApplied && subtotal > 0) {
            discount = Math.round(subtotal * 0.10);
            $('#discount-summary-line').css('display', 'flex');
            $('#cart-discount-val').text(`-₹${discount}`);
        } else {
            $('#discount-summary-line').hide();
        }

        const shippingFee = (subtotal >= targetFree || subtotal === 0) ? 0 : 49;
        $('#cart-shipping-val').text(shippingFee === 0 ? 'FREE' : '₹49');

        const finalTotal = Math.max(0, subtotal - discount + shippingFee);

        $('#cart-subtotal-val').text(`₹${subtotal}`);
        $('#cart-total-val').text(`₹${finalTotal}`);
    }

    // Remove All Out-of-Stock Items Action
    $(document).on('click', '#btn-remove-all-oos', function (e) {
        e.preventDefault();
        let cart = getCart();
        const validItems = cart.filter(item => item.in_stock !== false && item.stock_status !== 'outofstock');
        saveCart(validItems);
        showToast('Removed unavailable items from your bag.');

        if (typeof kash_dynamic_data !== 'undefined' && kash_dynamic_data.ajax_url) {
            $.post(kash_dynamic_data.ajax_url, { action: 'kash_remove_out_of_stock' });
        }
    });

    // Quantity Stepper Handlers with Stock Limit Checking
    $(document).off('click', '.btn-qty-plus').on('click', '.btn-qty-plus', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const index = $(this).data('index');
        let cart = getCart();
        if (cart[index]) {
            const item = cart[index];
            const product = PRODUCTS_DB.find(p => p.id == item.id);
            if (product && product.managing_stock && !product.backorders && typeof product.stock_quantity === 'number') {
                if (item.qty + 1 > product.stock_quantity) {
                    showToast(`Only ${product.stock_quantity} item(s) left in stock.`, 'info');
                    return;
                }
            }

            cart[index].qty = parseInt(cart[index].qty, 10) + 1;
            saveCart(cart);

            if (typeof kash_dynamic_data !== 'undefined' && kash_dynamic_data.ajax_url) {
                $.post(kash_dynamic_data.ajax_url, {
                    action: 'kash_update_cart_qty',
                    product_id: item.id,
                    item_key: item.key || '',
                    quantity: cart[index].qty
                });
            }
        }
    });

    $(document).off('click', '.btn-qty-minus').on('click', '.btn-qty-minus', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const index = $(this).data('index');
        let cart = getCart();
        if (cart[index]) {
            const item = cart[index];
            if (cart[index].qty > 1) {
                cart[index].qty = parseInt(cart[index].qty, 10) - 1;
                saveCart(cart);
                if (typeof kash_dynamic_data !== 'undefined' && kash_dynamic_data.ajax_url) {
                    $.post(kash_dynamic_data.ajax_url, {
                        action: 'kash_update_cart_qty',
                        product_id: item.id,
                        item_key: item.key || '',
                        quantity: cart[index].qty
                    });
                }
            } else {
                const removedName = cart[index].name;
                cart.splice(index, 1);
                saveCart(cart);
                showToast(`Removed "${removedName}" from bag.`);
                if (typeof kash_dynamic_data !== 'undefined' && kash_dynamic_data.ajax_url) {
                    $.post(kash_dynamic_data.ajax_url, {
                        action: 'kash_remove_cart_item',
                        product_id: item.id,
                        item_key: item.key || ''
                    });
                }
            }
        }
    });

    $(document).off('click', '.btn-remove-item').on('click', '.btn-remove-item', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const index = $(this).data('index');
        let cart = getCart();
        if (cart[index]) {
            const item = cart[index];
            const removedName = item.name;
            cart.splice(index, 1);
            saveCart(cart);
            showToast(`Removed "${removedName}" from bag.`);

            if (typeof kash_dynamic_data !== 'undefined' && kash_dynamic_data.ajax_url) {
                $.post(kash_dynamic_data.ajax_url, {
                    action: 'kash_remove_cart_item',
                    product_id: item.id,
                    item_key: item.key || ''
                });
            }
        }
    });

    // Apply Coupon Code KASH10
    $('#btn-apply-coupon').on('click', function () {
        const code = $('#coupon-code-input').val().trim().toUpperCase();
        if (code === 'KASH10') {
            couponApplied = true;
            $('#coupon-applied-tag').show();
            showToast('Promo code KASH10 applied! 10% discount added.');
            renderCartDrawer();
        } else {
            showToast('Invalid promo code! Try "KASH10"', 'info');
        }
    });

    $('#btn-remove-coupon').on('click', function () {
        couponApplied = false;
        $('#coupon-applied-tag').hide();
        $('#coupon-code-input').val('');
        showToast('Promo code removed.');
        renderCartDrawer();
    });


    /* ==========================================================================
       6. CHECKOUT MODAL & ORDER CONFIRMATION
       ========================================================================== */
    const $checkoutModal = $('#checkout-modal');
    const $successModal = $('#order-success-modal');

    $('#btn-open-checkout').on('click', function (e) {
        e.preventDefault();
        const cart = getCart();
        if (cart.length === 0) {
            showToast('Your cart is empty! Add items first.', 'info');
            return;
        }

        const hasOos = cart.some(item => item.in_stock === false || item.stock_status === 'outofstock');
        if (hasOos) {
            showToast('Please remove out of stock items before proceeding.', 'info');
            return;
        }

        // If WooCommerce is active, proceed directly to WooCommerce Checkout
        if (typeof kash_dynamic_data !== 'undefined' && kash_dynamic_data.is_wc_active && kash_dynamic_data.checkout_url) {
            window.location.href = kash_dynamic_data.checkout_url;
            return;
        }

        closeCartDrawer();
        renderCheckoutSummary();
        $checkoutModal.addClass('active');
        $('body').addClass('modal-open');
    });

    $('#close-checkout, .checkout-modal-overlay').on('click', function (e) {
        if (e.target === this || $(e.target).hasClass('close-modal-btn')) {
            $checkoutModal.removeClass('active');
            $('body').removeClass('modal-open');
        }
    });

    function renderCheckoutSummary() {
        const cart = getCart();
        const $miniList = $('#checkout-items-mini').empty();
        let subtotal = 0;

        cart.forEach(item => {
            const itemTot = item.price * item.qty;
            subtotal += itemTot;
            $miniList.append(`
                <div class="mini-item-row">
                    <span>${item.name} <strong>x${item.qty}</strong></span>
                    <span>₹${itemTot}</span>
                </div>
            `);
        });

        let discount = couponApplied ? Math.round(subtotal * 0.10) : 0;
        const shippingFee = (subtotal >= 999) ? 0 : 49;
        const total = subtotal - discount + shippingFee;

        $('#chk-subtotal').text(`₹${subtotal}`);
        if (discount > 0) {
            $('#chk-discount-row').css('display', 'flex');
            $('#chk-discount').text(`-₹${discount}`);
        } else {
            $('#chk-discount-row').hide();
        }
        $('#chk-shipping').text(shippingFee === 0 ? 'FREE' : '₹49');
        $('#chk-total').text(`₹${total}`);
    }

    // Payment Option Select Radio Styling
    $('.payment-option').on('click', function () {
        $('.payment-option').removeClass('active');
        $(this).addClass('active');
        $(this).find('input[type="radio"]').prop('checked', true);
    });

    // Place Order Form Submit
    $('#checkout-form').on('submit', function (e) {
        e.preventDefault();

        const cart = getCart();
        const orderId = '#KASH-' + Math.floor(1000 + Math.random() * 9000);
        const total = $('#chk-total').text();
        const userName = $('#chk-name').val() || 'Valued Customer';

        // Add to Order History in User Session
        let user = getUserSession() || { name: userName, email: 'customer@kashnaturals.com', orders: [] };
        if (!user.orders) user.orders = [];

        user.orders.unshift({
            id: orderId,
            date: new Date().toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' }),
            status: 'Confirmed',
            status_class: 'status-delivered',
            total: parseInt(total.replace(/[^\d]/g, '')),
            items: cart.map(i => `${i.name} x ${i.qty}`).join(', ')
        });

        setUserSession(user);

        // Clear Cart
        saveCart([]);

        // Close Checkout Modal & Open Success Celebration Popup
        $checkoutModal.removeClass('active');
        $('#success-order-id').text(orderId);
        $('#success-order-total').text(total);

        $successModal.addClass('active');
    });

    // Success Popup Close
    $('#btn-success-done, .order-success-overlay').on('click', function (e) {
        if (e.target === this || $(e.target).hasClass('btn-success-done')) {
            $successModal.removeClass('active');
            $('body').removeClass('modal-open');
        }
    });

    // ESC Key Global Listener for Modals
    $(document).keyup(function (e) {
        if (e.key === 'Escape') {
            $('.search-modal-overlay, .account-modal-overlay, .cart-drawer-overlay, .cart-drawer-panel, .checkout-modal-overlay, .order-success-overlay').removeClass('active');
            $('body').removeClass('modal-open');
        }
    });

    // Sticky Header Scroll Shadow
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 50) {
            $('.site-header').addClass('scrolled');
        } else {
            $('.site-header').removeClass('scrolled');
        }
    });

    // Mobile Menu Trigger
    $('#mobile-menu-trigger').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $('#site-navigation').toggleClass('active-mobile');
        $(this).find('i').toggleClass('fa-bars fa-xmark');
    });

    // Mobile Submenu Dropdown Toggle
    $(document).on('click', '.nav-dropdown-item > a', function (e) {
        if ($(window).width() <= 992) {
            e.preventDefault();
            $(this).parent('.nav-dropdown-item').toggleClass('open');
        }
    });

    // Close Mobile Menu on Outside Click
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#masthead').length) {
            $('#site-navigation').removeClass('active-mobile');
            $('#mobile-menu-trigger').find('i').removeClass('fa-xmark').addClass('fa-bars');
        }
    });

    /* ==========================================================================
       CUSTOMER FAVORITES CAROUSEL SLIDER CONTROLS (Auto-Next + Bottom Dots)
       ========================================================================== */
    const $favTrack = $('#favCarouselTrack');
    const $favViewport = $('#favCarouselViewport');
    const $favOuter = $('.fav-carousel-outer');
    const $favPagination = $('#favCarouselPagination');
    const $favPrevBtn = $('#favCarouselPrev');
    const $favNextBtn = $('#favCarouselNext');

    if ($favTrack.length) {
        let currentIndex = 0;
        let autoSlideTimer = null;
        const AUTO_INTERVAL = 2500; // 2.5s per slide

        function getCardStepWidth() {
            const $cards = $favTrack.find('.fav-card-item');
            if ($cards.length < 2) return $cards.outerWidth() || 280;
            const firstLeft = $cards.eq(0).position().left;
            const secondLeft = $cards.eq(1).position().left;
            const step = Math.round(secondLeft - firstLeft);
            return step > 0 ? step : Math.round($cards.eq(0).outerWidth() + 20);
        }

        function getMaxScroll() {
            const scrollW = $favTrack[0].scrollWidth;
            const viewW = $favViewport.innerWidth() || $favTrack.parent().innerWidth();
            return Math.max(0, scrollW - viewW);
        }

        function getTotalSteps() {
            const stepWidth = getCardStepWidth();
            const maxScroll = getMaxScroll();
            if (stepWidth <= 0 || maxScroll <= 0) return 1;
            return Math.ceil(maxScroll / stepWidth) + 1;
        }

        function buildPagination() {
            if (!$favPagination.length) return;
            const total = getTotalSteps();
            $favPagination.empty();
            for (let i = 0; i < total; i++) {
                const $dot = $('<button>', {
                    type: 'button',
                    class: 'fav-dot' + (i === currentIndex ? ' active' : ''),
                    'aria-label': 'Slide ' + (i + 1),
                    'data-index': i
                });
                $favPagination.append($dot);
            }
        }

        function goToStep(index) {
            const total = getTotalSteps();
            if (total <= 0) return;

            // Cycle index smoothly
            currentIndex = ((index % total) + total) % total;

            const stepWidth = getCardStepWidth();
            const maxScroll = getMaxScroll();
            let targetScroll = currentIndex * stepWidth;
            if (targetScroll > maxScroll) {
                targetScroll = maxScroll;
            }

            $favTrack.css('transform', `translateX(-${targetScroll}px)`);

            // Update active pagination dot
            $favPagination.find('.fav-dot')
                .removeClass('active')
                .eq(currentIndex)
                .addClass('active');
        }

        function nextSlide() {
            goToStep(currentIndex + 1);
        }

        function prevSlide() {
            goToStep(currentIndex - 1);
        }

        function startAutoSlide() {
            stopAutoSlide();
            autoSlideTimer = setInterval(function () {
                nextSlide();
            }, AUTO_INTERVAL);
        }

        function stopAutoSlide() {
            if (autoSlideTimer) {
                clearInterval(autoSlideTimer);
                autoSlideTimer = null;
            }
        }

        function resetAutoSlide() {
            stopAutoSlide();
            startAutoSlide();
        }

        // Initialize Pagination & Position
        buildPagination();
        goToStep(0);
        startAutoSlide();

        // Pagination Dot Click
        $favPagination.on('click', '.fav-dot', function (e) {
            e.preventDefault();
            const idx = parseInt($(this).data('index'), 10);
            if (!isNaN(idx)) {
                goToStep(idx);
                resetAutoSlide();
            }
        });

        // Side Buttons (Preserved for when unhidden)
        $favNextBtn.on('click', function (e) {
            e.preventDefault();
            nextSlide();
            resetAutoSlide();
        });

        $favPrevBtn.on('click', function (e) {
            e.preventDefault();
            prevSlide();
            resetAutoSlide();
        });

        // Pause on Hover (Outer container + Pagination)
        $favOuter.add($favPagination).on('mouseenter', function () {
            stopAutoSlide();
        }).on('mouseleave', function () {
            startAutoSlide();
        });

        // Pause when tab is inactive / hidden
        document.addEventListener('visibilitychange', function () {
            if (document.hidden) {
                stopAutoSlide();
            } else {
                startAutoSlide();
            }
        });

        // Touch Swipe Support
        let touchStartX = 0;
        let touchStartY = 0;
        let isSwiping = false;

        $favViewport.on('touchstart', function (e) {
            const touch = e.originalEvent.touches[0];
            touchStartX = touch.clientX;
            touchStartY = touch.clientY;
            isSwiping = true;
            stopAutoSlide();
        });

        $favViewport.on('touchend', function (e) {
            if (!isSwiping) return;
            isSwiping = false;
            const touch = e.originalEvent.changedTouches[0];
            const diffX = touch.clientX - touchStartX;
            const diffY = touch.clientY - touchStartY;

            if (Math.abs(diffX) > 40 && Math.abs(diffX) > Math.abs(diffY)) {
                if (diffX < 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
            startAutoSlide();
        });

        // Responsive Resize Handler
        let resizeTimeout;
        $(window).on('resize', function () {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function () {
                const prevTotal = $favPagination.find('.fav-dot').length;
                const newTotal = getTotalSteps();
                if (prevTotal !== newTotal) {
                    buildPagination();
                }
                goToStep(currentIndex);
            }, 150);
        });
    }

    /* ==========================================================================
       HEADER NAVIGATION ACTIVE STATE CONTROLLER
       ========================================================================== */
    function syncActiveNav() {
        const path = window.location.pathname.toLowerCase().replace(/\/+$/, '');
        const search = window.location.search.toLowerCase();
        const $topNavItems = $('.main-navigation .nav-menu-list > li');

        $topNavItems.removeClass('current-menu-item active current_page_item current-menu-ancestor current-menu-parent');

        function setActiveByDirectLink(matcher) {
            $topNavItems.filter(function () {
                const href = $(this).children('a').attr('href') || '';
                return matcher(href.toLowerCase());
            }).first().addClass('current-menu-item active');
        }

        if (path.indexOf('combos') !== -1 || path.indexOf('combo') !== -1) {
            setActiveByDirectLink(function (href) { return href.indexOf('combo') !== -1; });
        } else if (path.indexOf('about') !== -1) {
            setActiveByDirectLink(function (href) { return href.indexOf('about') !== -1; });
        } else if (path.indexOf('contact') !== -1) {
            setActiveByDirectLink(function (href) { return href.indexOf('contact') !== -1; });
        } else if (path.indexOf('shop') !== -1 || path.indexOf('product') !== -1 || search.indexOf('product=') !== -1) {
            setActiveByDirectLink(function (href) { return href.indexOf('shop') !== -1; });
        } else if (!path || path === '' || path === '/index' || path === '/index.php' || path === window.location.origin.toLowerCase()) {
            $topNavItems.first().addClass('current-menu-item active');
        }
    }

    syncActiveNav();

    // Update active underline immediately on click
    $('.main-navigation .nav-menu-list > li > a').on('click', function () {
        const $li = $(this).parent('li');
        $('.main-navigation .nav-menu-list > li').removeClass('current-menu-item active current_page_item current-menu-ancestor current-menu-parent');
        $li.addClass('current-menu-item active');
    });

    // Submenu links click (e.g. Gift Combos inside dropdown)
    $('.main-navigation .header-dropdown-menu a').on('click', function () {
        const href = ($(this).attr('href') || '').toLowerCase();
        const $topNavItems = $('.main-navigation .nav-menu-list > li');
        $topNavItems.removeClass('current-menu-item active current_page_item current-menu-ancestor current-menu-parent');
        if (href.indexOf('combo') !== -1) {
            $topNavItems.filter(function () {
                return ($(this).children('a').attr('href') || '').toLowerCase().indexOf('combo') !== -1;
            }).first().addClass('current-menu-item active');
        } else {
            $topNavItems.filter(function () {
                return ($(this).children('a').attr('href') || '').toLowerCase().indexOf('shop') !== -1;
            }).first().addClass('current-menu-item active');
        }
    });
});

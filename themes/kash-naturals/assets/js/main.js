if (window.__kashScriptLoaded) {
    // Script already loaded once, prevent double initialization
} else {
    window.__kashScriptLoaded = true;
}

jQuery(document).ready(function ($) {
    'use strict';

    /* ==========================================================================
       1. GLOBAL PRODUCT CATALOG DATABASE (16 Artisan Items)
       ========================================================================== */
    const themeUri = (typeof KASH_THEME_URI !== 'undefined') ? KASH_THEME_URI : '/wp-content/themes/kash-naturals';
    
    const PRODUCTS_DB = [
        {
            id: 1,
            name: 'Royal Calcutta Paan Mukhwas',
            category: 'mouth-fresheners',
            category_name: 'Mouth Fresheners',
            price: 299,
            regular_price: 399,
            image: themeUri + '/assets/images/product-calcutta-pan.jpg',
            badge: 'Bestseller',
            rating: 5.0,
            desc: 'Traditional betel leaf mukhwas with silver cardamom & sweet gulkand.'
        },
        {
            id: 2,
            name: 'Shahi Royal Mukhwas Blend',
            category: 'mouth-fresheners',
            category_name: 'Mouth Fresheners',
            price: 349,
            regular_price: 449,
            image: themeUri + '/assets/images/product-royal-mukhwas.jpg',
            badge: 'Heritage',
            rating: 4.9,
            desc: 'Royal digestive mix of roasted seeds, dry fruits, and aromatic spices.'
        },
        {
            id: 3,
            name: 'Kash Sweet Saunf Digestif',
            category: 'mouth-fresheners',
            category_name: 'Mouth Fresheners',
            price: 249,
            regular_price: 329,
            image: themeUri + '/assets/images/product-sweet-saunf.jpg',
            badge: '100% Natural',
            rating: 4.8,
            desc: 'Crisp candied aniseeds blended with menthol and silver pearls.'
        },
        {
            id: 4,
            name: 'Silver Coated Elaichi Paan',
            category: 'mouth-fresheners',
            category_name: 'Mouth Fresheners',
            price: 399,
            regular_price: 499,
            image: themeUri + '/assets/images/jar-calcutta-pan.jpg',
            badge: 'Luxury Paan',
            rating: 5.0,
            desc: 'Premium silver leaf wrapped cardamom and dry paan infusion.'
        },
        {
            id: 5,
            name: 'Belgian Dark Almond Dragees',
            category: 'chocolate-dragees',
            category_name: 'Chocolate Dragees',
            price: 499,
            regular_price: 649,
            image: themeUri + '/assets/images/chocolate-dragees.jpg',
            badge: 'Bestseller',
            rating: 5.0,
            desc: 'Slow-roasted almonds enrobed in 70% dark Belgian cocoa.'
        },
        {
            id: 6,
            name: 'Milk Chocolate Hazelnut Dragees',
            category: 'chocolate-dragees',
            category_name: 'Chocolate Dragees',
            price: 549,
            regular_price: 699,
            image: themeUri + '/assets/images/jar-royal-mukhwas.jpg',
            badge: 'Artisanal',
            rating: 4.9,
            desc: 'Whole Turkish hazelnuts dipped in smooth creamy milk chocolate.'
        },
        {
            id: 7,
            name: 'Cranberry Dark Chocolate Bites',
            category: 'chocolate-dragees',
            category_name: 'Chocolate Dragees',
            price: 479,
            regular_price: 599,
            image: themeUri + '/assets/images/jar-sweet-saunf.jpg',
            badge: 'New Arrival',
            rating: 4.8,
            desc: 'Tangy dried cranberries coated in rich dark chocolate.'
        },
        {
            id: 8,
            name: 'Gold Dusted Cashew Dragees',
            category: 'chocolate-dragees',
            category_name: 'Chocolate Dragees',
            price: 599,
            regular_price: 749,
            image: themeUri + '/assets/images/mouth-fresheners.jpg',
            badge: 'Festive Special',
            rating: 5.0,
            desc: 'Jumbo cashews wrapped in milk chocolate with gold shimmer.'
        },
        {
            id: 9,
            name: 'Pistachio Kunafa Bar (100g)',
            category: 'kunafa-bars',
            category_name: 'Kunafa Bars',
            price: 599,
            regular_price: 749,
            image: themeUri + '/assets/images/kunafa-bars.jpg',
            badge: 'Signature',
            rating: 5.0,
            desc: 'Crispy kataifi pastry & roasted pistachio cream wrapped in chocolate.'
        },
        {
            id: 10,
            name: 'Baklava Kunafa Milk Bar (100g)',
            category: 'kunafa-bars',
            category_name: 'Kunafa Bars',
            price: 549,
            regular_price: 699,
            image: themeUri + '/assets/images/gift-combos.jpg',
            badge: 'Middle Eastern',
            rating: 4.9,
            desc: 'Traditional Middle Eastern baklava crunch with milk chocolate.'
        },
        {
            id: 11,
            name: '70% Dark Kunafa Crunch Bar',
            category: 'kunafa-bars',
            category_name: 'Kunafa Bars',
            price: 649,
            regular_price: 799,
            image: themeUri + '/assets/images/combo-celebration.jpg',
            badge: 'Dark Special',
            rating: 4.9,
            desc: 'Rich dark cocoa paired with crispy roasted pistachio kunafa.'
        },
        {
            id: 12,
            name: 'Kunafa Trio Gift Bar Pack',
            category: 'kunafa-bars',
            category_name: 'Kunafa Bars',
            price: 899,
            regular_price: 1099,
            image: themeUri + '/assets/images/combo-premium.jpg',
            badge: 'Value Pack',
            rating: 5.0,
            desc: 'Set of 3 mini kunafa bars: Pistachio, Hazelnut & Almond Crunch.'
        },
        {
            id: 13,
            name: 'Freshness & Digestive Duo Pack',
            category: 'gift-combos',
            category_name: 'Gift Combos',
            price: 499,
            regular_price: 599,
            image: themeUri + '/assets/images/combo-freshness.jpg',
            badge: 'Popular',
            rating: 4.9,
            desc: 'Royal Paan Mukhwas (250g) + Shahi Sweet Saunf (250g) Gift Box.'
        },
        {
            id: 14,
            name: 'Family Festive Celebration Pack',
            category: 'gift-combos',
            category_name: 'Gift Combos',
            price: 899,
            regular_price: 1199,
            image: themeUri + '/assets/images/combo-family.jpg',
            badge: 'Best Value',
            rating: 5.0,
            desc: 'Assortment of 4 signature jars of mukhwas and dragees.'
        },
        {
            id: 15,
            name: 'Royal Connoisseur Treasure Box',
            category: 'gift-combos',
            category_name: 'Gift Combos',
            price: 1299,
            regular_price: 1799,
            image: themeUri + '/assets/images/combo-premium.jpg',
            badge: 'Luxury Edition',
            rating: 5.0,
            desc: 'Flagship luxury hamper with kunafa bars, dragees & silver paan.'
        },
        {
            id: 16,
            name: 'Artisanal Celebration Hamper',
            category: 'gift-combos',
            category_name: 'Gift Combos',
            price: 1599,
            regular_price: 2000,
            image: themeUri + '/assets/images/combo-celebration.jpg',
            badge: 'Gift Favorite',
            rating: 4.8,
            desc: 'Roasted hazelnut dragees, paan mukhwas & pistachio kunafa bar.'
        }
    ];

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
            const $item = $(`
                <div class="search-item-card">
                    <div class="search-item-img">
                        <img src="${prod.image}" alt="${prod.name}" />
                    </div>
                    <div class="search-item-info">
                        <span class="search-item-cat">${prod.category_name}</span>
                        <h4 class="search-item-title">${prod.name}</h4>
                        <div class="search-item-stars">★★★★★ (${prod.rating})</div>
                        <div class="search-item-price">₹${prod.price} <del>₹${prod.regular_price}</del></div>
                    </div>
                    <button type="button" class="btn-search-add-cart" data-id="${prod.id}">
                        <i class="fa-solid fa-cart-plus"></i> ADD
                    </button>
                </div>
            `);

            $item.find('.btn-search-add-cart').on('click', function () {
                addToCart(prod.id);
                $searchModal.removeClass('active');
                $('body').removeClass('modal-open');
            });

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
            const wishlistItems = PRODUCTS_DB.slice(0, 3);
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
            name: 'Bhavya Sharma',
            email: email,
            orders: SAMPLE_ORDERS
        };
        setUserSession(user);
        showToast('Successfully signed in as Bhavya Sharma!');
        renderAccountModal();
    });

    // 1-Click Quick Demo Login Button
    $('#btn-quick-demo').on('click', function () {
        const user = {
            name: 'Bhavya Sharma',
            email: 'bhavya@kashnaturals.com',
            orders: SAMPLE_ORDERS
        };
        setUserSession(user);
        showToast('Welcome Bhavya! Signed in via 1-Click Demo Login.');
        renderAccountModal();
    });

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

    // Get Cart from LocalStorage
    function getCart() {
        try {
            const data = localStorage.getItem('kash_cart');
            return data ? JSON.parse(data) : [];
        } catch (e) {
            return [];
        }
    }

    function saveCart(cart) {
        localStorage.setItem('kash_cart', JSON.stringify(cart));
        updateCartCountBadge();
        renderCartDrawer();
    }

    // Initial Cart Setup (Add 2 default items if empty on first visit for instant rich experience)
    if (!localStorage.getItem('kash_cart')) {
        const initialCart = [
            { id: 1, name: 'Royal Calcutta Paan Mukhwas', price: 299, image: themeUri + '/assets/images/product-calcutta-pan.jpg', qty: 1 },
            { id: 5, name: 'Belgian Dark Almond Dragees', price: 499, image: themeUri + '/assets/images/chocolate-dragees.jpg', qty: 1 }
        ];
        saveCart(initialCart);
    } else {
        updateCartCountBadge();
    }

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

    // Global Add To Cart Function
    window.addToCart = function (productId, quantity = 1) {
        const product = PRODUCTS_DB.find(p => p.id == productId);
        if (!product) return;

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
                qty: quantity
            });
        }

        saveCart(cart);
        showToast(`Added "${product.name}" to your shopping bag!`);
        openCartDrawer();
    };

    // Global Click Listener for all "ADD TO CART" / "ORDER NOW" / "+" Buttons Across Site
    $(document).on('click', '.fav-btn-quick-add, .add-to-cart-btn, .btn-add-to-cart-outline, .btn-combo-add-cart, .btn-add-cart-exact, .combo-ref-btn, .btn-combo-shop-now', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const $btn = $(this);
        
        let prodId = $btn.data('product-id') || $btn.attr('data-product-id');
        let prodName = $btn.data('product-name') || $btn.attr('data-product-name');
        let prodPrice = $btn.data('product-price') || $btn.attr('data-product-price');
        let prodImg = $btn.data('product-img') || $btn.attr('data-product-img');

        if (!prodName) {
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
            addToCart(match.id);
        } else if (prodName) {
            const numericPrice = prodPrice ? parseInt(String(prodPrice).replace(/[^\d]/g, '')) || 299 : 299;
            let cart = getCart();
            const existingIndex = cart.findIndex(item => item.name.toLowerCase() === prodName.toLowerCase());

            if (existingIndex > -1) {
                cart[existingIndex].qty += 1;
            } else {
                cart.push({
                    id: Date.now(),
                    name: prodName,
                    price: numericPrice,
                    image: prodImg || (themeUri + '/assets/images/product-royal-mukhwas.jpg'),
                    qty: 1
                });
            }
            saveCart(cart);
            showToast(`Added "${prodName}" to your shopping bag!`);
            openCartDrawer();
        } else {
            addToCart(1);
        }
    });

    // Open/Close Cart Drawer
    function openCartDrawer() {
        renderCartDrawer();
        $cartDrawer.addClass('active');
        $cartOverlay.addClass('active');
        $('body').addClass('modal-open');
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

    // Render Cart Items & Summary Totals
    function renderCartDrawer() {
        const cart = getCart();
        const $list = $('#cart-drawer-items-list').empty();
        const totalCount = cart.reduce((sum, item) => sum + item.qty, 0);
        $('#cart-drawer-count-badge').text(`${totalCount} Items`);

        if (cart.length === 0) {
            $list.html(`
                <div class="cart-empty-state text-center">
                    <i class="fa-solid fa-basket-shopping"></i>
                    <p>Your shopping bag is currently empty.</p>
                    <a href="/shop" class="btn-shop-now-empty" id="btn-empty-shop">START SHOPPING</a>
                </div>
            `);
            $('#btn-empty-shop').on('click', function(e) {
                e.preventDefault();
                closeCartDrawer();
                window.location.href = '/shop';
            });
            updateCartCalculations(0);
            return;
        }

        let subtotal = 0;

        cart.forEach((item, index) => {
            const itemTotal = item.price * item.qty;
            subtotal += itemTotal;

            const $cartItem = $(`
                <div class="cart-drawer-item">
                    <img src="${item.image}" alt="${item.name}" class="cart-item-thumb" />
                    <div class="cart-item-details">
                        <h4 class="cart-item-title">${item.name}</h4>
                        <div class="cart-item-price">₹${item.price}</div>
                        <div class="cart-item-qty-row">
                            <div class="qty-stepper">
                                <button type="button" class="btn-qty-minus" data-index="${index}">-</button>
                                <span class="qty-val">${item.qty}</span>
                                <button type="button" class="btn-qty-plus" data-index="${index}">+</button>
                            </div>
                            <span class="cart-item-subtotal">₹${itemTotal}</span>
                        </div>
                    </div>
                    <button type="button" class="btn-remove-item" data-index="${index}" title="Remove Item">&times;</button>
                </div>
            `);

            $list.append($cartItem);
        });

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

    // Quantity Stepper Handlers
    $(document).off('click', '.btn-qty-plus').on('click', '.btn-qty-plus', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const index = $(this).data('index');
        let cart = getCart();
        if (cart[index]) {
            cart[index].qty = parseInt(cart[index].qty, 10) + 1;
            saveCart(cart);
        }
    });

    $(document).off('click', '.btn-qty-minus').on('click', '.btn-qty-minus', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const index = $(this).data('index');
        let cart = getCart();
        if (cart[index]) {
            if (cart[index].qty > 1) {
                cart[index].qty = parseInt(cart[index].qty, 10) - 1;
            } else {
                cart.splice(index, 1);
            }
            saveCart(cart);
        }
    });

    $(document).off('click', '.btn-remove-item').on('click', '.btn-remove-item', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const index = $(this).data('index');
        let cart = getCart();
        if (cart[index]) {
            const removedName = cart[index].name;
            cart.splice(index, 1);
            saveCart(cart);
            showToast(`Removed "${removedName}" from bag.`);
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

    $('#btn-open-checkout').on('click', function () {
        const cart = getCart();
        if (cart.length === 0) {
            showToast('Your cart is empty! Add items first.', 'info');
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
       CUSTOMER FAVORITES CAROUSEL SLIDER CONTROLS
       ========================================================================== */
    const $favTrack = $('#favCarouselTrack');
    const $favPrevBtn = $('#favCarouselPrev');
    const $favNextBtn = $('#favCarouselNext');

    if ($favTrack.length) {
        let currentScrollPos = 0;

        function getCardStepWidth() {
            const $firstCard = $favTrack.find('.fav-card-item').first();
            if (!$firstCard.length) return 300;
            const cardWidth = $firstCard.outerWidth();
            const gap = 24;
            return cardWidth + gap;
        }

        $favNextBtn.on('click', function () {
            const stepWidth = getCardStepWidth();
            const maxScroll = Math.max(0, $favTrack[0].scrollWidth - $favTrack.parent().outerWidth());
            
            // If already at or near the end, loop back to start
            if (Math.abs(currentScrollPos - maxScroll) < 10) {
                currentScrollPos = 0;
            } else {
                currentScrollPos += stepWidth;
                if (currentScrollPos > maxScroll - 15) {
                    currentScrollPos = maxScroll; // Clamp to exact end so last card is 100% fully visible
                }
            }
            $favTrack.css('transform', `translateX(-${currentScrollPos}px)`);
        });

        $favPrevBtn.on('click', function () {
            const stepWidth = getCardStepWidth();
            const maxScroll = Math.max(0, $favTrack[0].scrollWidth - $favTrack.parent().outerWidth());

            // If already at start, loop to the maxScroll end
            if (currentScrollPos <= 10) {
                currentScrollPos = maxScroll;
            } else {
                currentScrollPos -= stepWidth;
                if (currentScrollPos < 0) {
                    currentScrollPos = 0;
                }
            }
            $favTrack.css('transform', `translateX(-${currentScrollPos}px)`);
        });
    }
});

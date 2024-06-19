<div>
    <ul class="list-unstyled link-container">
        <div class="fw-semibold mb-1 link-header">My Profile</div>
        <li class="list-group-item link-child mb-1 ps-3">
            <a href="<?= route("profile") ?>" class="tag-link <?= $_SERVER['PATH_INFO']
            === '/profile' ? "active" : "" ?>">Profile</a>
        </li>
        <li class="list-group-item link-child mb-1 ps-3 ">
            <a href="<?= route("address") ?>" class="tag-link <?= $_SERVER['PATH_INFO']
            === '/address' ? "active" : "" ?>">Address Book</a>
        </li>
    </ul>
    <ul class="list-unstyled">
        <div class="fw-semibold mb-1 link-header">My Orders</div>
        <li class="list-group-item link-child mb-1 ps-3 ">
            <a href="<?= route("orders") ?>" class="tag-link <?= $_SERVER['PATH_INFO']
            === '/orders' ? "active" :
                "" ?>">Orders</a>
        </li>
        <li class="list-group-item link-child mb-1 ps-3 ">
            <a href="<?= route("cart") ?>" class="tag-link <?= $_SERVER['PATH_INFO']
            === '/cart' ? "active" :
                "" ?>">Cart</a>
        </li>
        <li class="list-group-item link-child mb-1 ps-3 ">
            <a href="<?= route("wishlist") ?>" class="tag-link <?= $_SERVER['PATH_INFO']
            === '/wishlist' ? "active" : "" ?>">Wishlist</a>
        </li>
    </ul>
</div>
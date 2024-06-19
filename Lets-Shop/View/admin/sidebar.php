<?php
$route = substr($_SERVER['PHP_SELF'], strripos($_SERVER['PHP_SELF'], '/') + 1);
?>

<div class="col-2 d-flex flex-column justify-content-between left-side p-0 sidebar-container">
    <div>
        <div class="icon-container py-3 d-flex flex-column justify-content-center align-items-center">
            <div class="fs-2 text-center text-white">HERE IS FUCKING LOGO</div>
            <div class="fs-4 logo">Lets Shop</div>
        </div>
        <div class="links-container text-center">
            <div class="d-flex justify-content-center align-items-start flex-column px-3 pt-3 mt-2">
                <div class="d-flex justify-content-start align-items-center">
                    <span class="link material-symbols-outlined">bar_chart_4_bars</span>
                    <span class="link ms-2 fs-5 fw-semibold ">Dashboard</span>
                </div>
                <div class="d-flex justify-content-center align-items-start flex-column ms-2 w-100">
                    <a href="<?= route('admin/product') ?>"
                       class="w-100 text-decoration-none d-flex justify-content-start align-items-center px-2 py-1 mb-1 mt-3 link-container <?= $route === 'product' ? 'active' : '' ?>">
                        <span class="sub-link material-symbols-outlined link">inventory_2</span>
                        <span class="sub-link ms-2 fw-semibold">Product</span>
                    </a>
                    <a href="<?= route('admin/stock') ?>"
                       class="w-100 text-decoration-none d-flex justify-content-start align-items-center px-2 py-1 my-1 link-container <?= $route === 'stock' ? 'active' : '' ?>">
                        <span class="sub-link material-symbols-outlined">ballot</span>
                        <span class="sub-link ms-2 fw-semibold">Stock</span>
                    </a>
                    <a href="<?= route('admin/category') ?>"
                       class="w-100 text-decoration-none d-flex justify-content-start align-items-center px-2 py-1 my-1 link-container <?= $route === 'category' ? 'active' : '' ?>">
                        <span class="sub-link material-symbols-outlined">dataset</span>
                        <span class="sub-link ms-2 fw-semibold">Category</span>
                    </a>
                    <a href="<?= route('admin/discount') ?>"
                       class="w-100 text-decoration-none d-flex justify-content-start align-items-center px-2 py-1 my-1 link-container <?= $route === 'discount' ? 'active' : '' ?>">
                        <span class="sub-link material-symbols-outlined">sell</span>
                        <span class="sub-link ms-2 fw-semibold">Discount</span>
                    </a>
                    <a href="<?= route('admin/location') ?>"
                       class="w-100 text-decoration-none d-flex justify-content-start align-items-center px-2 py-1 my-1 link-container <?= $route === 'location' ? 'active' : '' ?>">
                        <span class="sub-link material-symbols-outlined">location_on</span>
                        <span class="sub-link ms-2 fw-semibold">Location</span>
                    </a>
                </div>
            </div>
            <a href="<?= route('admin/order') ?>"
               class="text-decoration-none d-flex justify-content-start align-items-center px-3 py-2 my-2 link-container <?= $route === 'order' ? 'active' : '' ?>">
                <span class="link material-symbols-outlined">package</span>
                <span class="link ms-2 fs-5 fw-semibold ">Orders</span>
            </a>
            <a href="<?= route('logout') ?>"
               class="text-decoration-none d-flex justify-content-start align-items-center px-3 py-2 my-2 link-container <?= $route === 'staff' ? 'active' : '' ?>">

                <span class="link ms-2 fs-5 fw-semibold ">Logout</span>
            </a>
        </div>
    </div>

</div>

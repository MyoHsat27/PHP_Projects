<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class=" d-flex justify-content-between align-items-center container">
    <a class="navbar-brand" href="#">Navbar</a>
    <ul class="navbar-nav mr-auto d-flex flex-row">
      <li class="nav-item mx-2 active">
        <a class="nav-link" href="<?= route('') ?>">Home</a>
      </li>
      <li class="nav-item mx-2 active">
        <a class="nav-link" href="<?= route('about') ?>">About</a>
      </li>
      <li class="nav-item mx-2 active">
        <a class="nav-link" href="<?= route('list') ?>">List</a>
      </li>
      <li class="nav-item mx-2 active">
        <a class="nav-link" href="<?= route('inventory') ?>">Inventory</a>
      </li>
    </ul>
  </div>
</nav>

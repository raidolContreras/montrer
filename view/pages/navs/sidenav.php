<!-- Start Sidebar Menu Area -->
<nav class="sidebar-menu">
    <ul class="list-group flex-column d-inline-block first-menu" data-simplebar>
        <?php 
        	$active = (!isset($_GET['pagina']) || $_GET['pagina'] == 'inicio') ? 'active' : '';
        ?>
        <li class="list-group-item main-grid <?php echo $active; ?>">
            <a href="inicio" class="icon">
                <img src="assets/img/svg/element.svg" alt="element">
            </a>
        </li>

        <?php 
        	$active = (isset($_GET['pagina']) && ($_GET['pagina'] == 'registers' || $_GET['pagina'] == 'register')) ? 'active' : '';
        ?>
        <li class="list-group-item main-grid <?php echo $active; ?>">
            <a href="registers" class="icon">
                <img src="assets/img/svg/profile-2user.svg" alt="calendar">
            </a>
        </li>
    </ul>
</nav>
<!-- End Sidebar Menu Area -->

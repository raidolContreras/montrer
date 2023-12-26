<!-- Start Sidebar Menu Area -->
<nav class="sidebar-menu">
    <ul class="list-group flex-column d-inline-block first-menu" data-simplebar>
        <?php 
            // Verifica si 'pagina' no está seteado o es igual a 'inicio'
            $activeInicio = (!isset($_GET['pagina']) || $_GET['pagina'] == 'inicio') ? 'active' : '';
        ?>
        <li class="list-group-item main-grid <?php echo $activeInicio; ?>">
            <a href="inicio" class="icon">
                <img src="assets/img/svg/element.svg" alt="element">
            </a>
        </li>

        <?php 
            // Verifica si 'pagina' está seteado y es igual a 'registers' o 'register'
            $activeRegisters = (isset($_GET['pagina']) && ($_GET['pagina'] == 'registers' || $_GET['pagina'] == 'register')) ? 'active' : '';
        ?>
        <li class="list-group-item main-grid <?php echo $activeRegisters; ?>">
            <a href="registers" class="icon">
                <img src="assets/img/svg/profile-2user.svg" alt="calendar">
            </a>
        </li>
        

        <?php 
            // Verifica si 'pagina' está seteado y es igual a 'registers' o 'register'
            $activeAreas = (isset($_GET['pagina']) && ($_GET['pagina'] == 'registerArea' || $_GET['pagina'] == 'areas')) ? 'active' : '';
        ?>
        <li class="list-group-item main-grid <?php echo $activeAreas; ?>">
            <a href="areas" class="icon">
                <img src="assets/img/svg/area.svg" alt="calendar">
            </a>
        </li>
    </ul>
</nav>
<!-- End Sidebar Menu Area -->

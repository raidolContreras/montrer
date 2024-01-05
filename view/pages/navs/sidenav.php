<!-- Start Sidebar Menu Area -->
<nav class="sidebar-menu">
    <ul class="list-group flex-column d-inline-block first-menu" data-simplebar>
        <?php 
            // Verifica si 'pagina' no está seteado o es igual a 'inicio'
            $activeInicio = (!isset($_GET['pagina']) || $_GET['pagina'] == 'inicio') ? 'active' : '';
        ?>
        <li class="list-group-item main-grid <?php echo $activeInicio; ?>">
            <a href="inicio" class="icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Inicio">
                <img src="assets/img/svg/element.svg" alt="element">
            </a>
        </li>

        <?php 
            // Verifica si 'pagina' está seteado y es igual a 'registers' o 'register'
            $activeRegisters = (isset($_GET['pagina']) && ($_GET['pagina'] == 'registers' || $_GET['pagina'] == 'register')) ? 'active' : '';
        ?>
        <li class="list-group-item main-grid <?php echo $activeRegisters; ?>">
            <a href="registers" class="icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Registros de usuarios">
                <img src="assets/img/svg/profile-2user.svg" alt="calendar">
            </a>
        </li>
        
        <?php 
            // Verifica si 'pagina' está seteado y es igual a 'registers' o 'register'
            $activeAreas = (isset($_GET['pagina']) && ($_GET['pagina'] == 'registerArea' || $_GET['pagina'] == 'areas')) ? 'active' : '';
        ?>
        <li class="list-group-item main-grid <?php echo $activeAreas; ?>">
            <a href="areas" class="icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Departamentos">
                <img src="assets/img/svg/area.svg" alt="calendar">
            </a>
        </li>

        <!-- <?php 
            // Verifica si 'pagina' está seteado y es igual a 'registers' o 'register'
            $activeCompany = (isset($_GET['pagina']) && ($_GET['pagina'] == 'company' || $_GET['pagina'] == 'registerCompany')) ? 'active' : '';
        ?>
        <li class="list-group-item main-grid <?php echo $activeCompany; ?>">
            <a href="company" class="icon">
                <img src="assets/img/svg/company.svg" alt="calendar">
            </a>
        </li> -->

        <?php 
            // Verifica si 'pagina' está seteado y es igual a 'registers' o 'register'
            $activeExercise = (isset($_GET['pagina']) && ($_GET['pagina'] == 'exercise' || $_GET['pagina'] == 'registerExercise')) ? 'active' : '';
        ?>
        <li class="list-group-item main-grid <?php echo $activeExercise; ?>">
            <a href="exercise" class="icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Ejercicios">
                <img src="assets/img/svg/exercise.svg" alt="calendar">
            </a>
        </li>

        <?php 
            // Verifica si 'pagina' está seteado y es igual a 'registers' o 'register'
            $activeExercise = (isset($_GET['pagina']) && ($_GET['pagina'] == 'budgets' || $_GET['pagina'] == 'registerBudgets')) ? 'active' : '';
        ?>
        <li class="list-group-item main-grid <?php echo $activeExercise; ?>">
            <a href="budgets" class="icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Asignación de presupuestos">
                <img src="assets/img/svg/budget.svg" alt="calendar">
            </a>
        </li>
    </ul>
</nav>
<!-- End Sidebar Menu Area -->

<script>
    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip()
    })
</script>

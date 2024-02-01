<!-- Start Sidebar Menu Area -->
<nav class="sidebar-menu">
    <ul class="list-group flex-column d-inline-block first-menu" data-simplebar>
        <?php 
            // Verifica si 'pagina' no está seteado o es igual a 'inicio'
            $activeInicio = (!isset($_GET['pagina']) || $_GET['pagina'] == 'inicio') ? 'active' : '';
        ?>
        <li class="list-group-item main-grid <?php echo $activeInicio; ?>">
            <a href="inicio" class="icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Tablero" onclick="confirmExit(event, 'inicio')">
                <img src="assets/img/svg/element.svg" alt="element">
            </a>
        </li>

        <?php if ($_SESSION['level'] == 1): ?>
            
            <?php 
                // Verifica si 'pagina' está seteado y es igual a 'registers' o 'register'
                $activeRegisters = (isset($_GET['pagina']) && ($_GET['pagina'] == 'registers' || $_GET['pagina'] == 'register' || $_GET['pagina'] == 'editRegister')) ? 'active' : '';
            ?>
            <li class="list-group-item main-grid <?php echo $activeRegisters; ?>">
                <a href="registers" class="icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Usuarios" onclick="confirmExit(event, 'registers')">
                    <img src="assets/img/svg/profile-2user.svg" alt="calendar">
                </a>
            </li>
            
            <?php 
                // Verifica si 'pagina' está seteado y es igual a 'registers' o 'register'
                $activeAreas = (isset($_GET['pagina']) && ($_GET['pagina'] == 'registerArea' || $_GET['pagina'] == 'areas' || $_GET['pagina'] == 'editArea')) ? 'active' : '';
            ?>
            <li class="list-group-item main-grid <?php echo $activeAreas; ?>">
                <a href="areas" class="icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Departamentos" onclick="confirmExit(event, 'areas')">
                    <img src="assets/img/svg/area.svg" alt="calendar">
                </a>
            </li>

            <?php 
                // Verifica si 'pagina' está seteado y es igual a 'registers' o 'register'
                $activeExercise = (isset($_GET['pagina']) && ($_GET['pagina'] == 'exercise' || $_GET['pagina'] == 'registerExercise' || $_GET['pagina'] == 'editExercise')) ? 'active' : '';
            ?>
            <li class="list-group-item main-grid <?php echo $activeExercise; ?>">
                <a href="exercise" class="icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Ejercicios" onclick="confirmExit(event, 'exercise')">
                    <img src="assets/img/svg/exercise.svg" alt="calendar">
                </a>
            </li>

            <?php 
                // Verifica si 'pagina' está seteado y es igual a 'registers' o 'register'
                $activeBudget = (isset($_GET['pagina']) && ($_GET['pagina'] == 'budgets' || $_GET['pagina'] == 'registerBudgets' || $_GET['pagina'] == 'editBudgets')) ? 'active' : '';
            ?>
            <li class="list-group-item main-grid <?php echo $activeBudget; ?>">
                <a href="budgets" class="icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Asignación de presupuestos" onclick="confirmExit(event, 'budgets')">
                    <img src="assets/img/svg/budget.svg" alt="calendar">
                </a>
            </li>
        
        <?php endif ?>
        
        <?php 
            // Verifica si 'pagina' está seteado y es igual a 'registers' o 'register'
            $activeProvider = (isset($_GET['pagina']) && ($_GET['pagina'] == 'provider' || $_GET['pagina'] == 'registerProvider' || $_GET['pagina'] == 'editProvider')) ? 'active' : '';
        ?>
        <li class="list-group-item main-grid <?php echo $activeProvider; ?>">
            <a href="provider" class="icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Proveedores" onclick="confirmExit(event, 'provider')">
                <img src="assets/img/svg/provider.svg" alt="calendar">
            </a>
        </li>
        
        <?php 
            // Verifica si 'pagina' está seteado y es igual a 'registers' o 'register'
            $activeRequest = (isset($_GET['pagina']) && ($_GET['pagina'] == 'requestBudget' || $_GET['pagina'] == 'registerRequestBudget')) ? 'active' : '';
        ?>
        <li class="list-group-item main-grid <?php echo $activeRequest; ?>">
            <a href="requestBudget" class="icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Solicitudes de presupuestos" onclick="confirmExit(event, 'requestBudget')">
                <img src="assets/img/svg/request.svg" alt="calendar">
            </a>
        </li>
        <?php 
            // Verifica si 'pagina' está seteado y es igual a 'registers' o 'register'
            $activeRequest = (isset($_GET['pagina']) && ($_GET['pagina'] == 'solicitudSendBudget')) ? 'active' : '';
        ?>
        <li class="list-group-item main-grid <?php echo $activeRequest; ?>">
            <a href="solicitudSendBudget" class="icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Justificar de presupuestos" onclick="confirmExit(event, 'requestBudget')">
                <img src="assets/img/svg/request.svg" alt="calendar">
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
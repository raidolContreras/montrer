<!-- Start Sidebar Menu Area -->
<nav class="sidebar-menu">
    <ul class="list-group flex-column d-inline-block first-menu" data-simplebar>
        <?php 
            // Verifica si 'pagina' no está seteado o es igual a 'inicio'
            $activeInicio = (!isset($_GET['pagina']) || $_GET['pagina'] == 'inicio') ? 'active' : '';
        ?>
        <li class="list-group-item main-grid <?php echo $activeInicio; ?>">
            <a href="inicio" class="icon sidenav" data-bs-toggle="tooltip" data-bs-placement="right" title="Tablero" onclick="confirmExit(event, 'inicio')">
                <img src="assets/img/svg/element.svg" alt="element">
            </a>
        </li>

        <?php if ($level == 1 || $level == 0): ?>
            
            <?php
                $activeRegisters = (isset($_GET['pagina']) && ($_GET['pagina'] == 'registers' || $_GET['pagina'] == 'register' || $_GET['pagina'] == 'editRegister')) ? 'active' : '';
            ?>
            <li class="list-group-item main-grid <?php echo $activeRegisters; ?>">
                <a href="registers" class="icon sidenav" data-bs-toggle="tooltip" data-bs-placement="right" title="Usuarios" onclick="confirmExit(event, 'registers')">
                    <img src="assets/img/svg/registers.svg" width='25px' alt="calendar">
                </a>
            </li>
<!--             
            <?php
                // $activeCompany = (isset($_GET['pagina']) && ($_GET['pagina'] == 'registerCompany' || $_GET['pagina'] == 'company' || $_GET['pagina'] == 'editCompany')) ? 'active' : '';
            ?>
            <li class="list-group-item main-grid <?php // echo $activeCompany; ?>">
                <a href="company" class="icon sidenav" data-bs-toggle="tooltip" data-bs-placement="right" title="Empresas" onclick="confirmExit(event, 'company')">
                <img src="assets/img/svg/company.svg" width='25px' alt="business">
                </a>
            </li> -->
            
            <?php
                $activeAreas = (isset($_GET['pagina']) && ($_GET['pagina'] == 'registerArea' || $_GET['pagina'] == 'areas' || $_GET['pagina'] == 'editArea')) ? 'active' : '';
            ?>
            <li class="list-group-item main-grid <?php echo $activeAreas; ?>">
                <a href="areas" class="icon sidenav" data-bs-toggle="tooltip" data-bs-placement="right" title="Departamentos" onclick="confirmExit(event, 'areas')">
                <img src="assets/img/svg/areas.svg" width='25px' alt="areas">
                </a>
            </li>

            <?php
                $activeAreas = (isset($_GET['pagina']) && ($_GET['pagina'] == 'registerCuenta' || $_GET['pagina'] == 'cuentas' || $_GET['pagina'] == 'editCuenta')) ? 'active' : '';
            ?>
            <li class="list-group-item main-grid <?php echo $activeAreas; ?>">
                <a href="cuentas" class="icon sidenav" data-bs-toggle="tooltip" data-bs-placement="right" title="Cuentas" onclick="confirmExit(event, 'cuentas')">
                <img src="assets/img/svg/accounts.svg" width='25px' alt="cuentas">
                </a>
            </li>

            <?php
                $activeAreas = (isset($_GET['pagina']) && ($_GET['pagina'] == 'registerPartidas' || $_GET['pagina'] == 'partidas' || $_GET['pagina'] == 'editPartidas')) ? 'active' : '';
            ?>
            <li class="list-group-item main-grid <?php echo $activeAreas; ?>">
                <a href="partidas" class="icon sidenav" data-bs-toggle="tooltip" data-bs-placement="right" title="Partidas" onclick="confirmExit(event, 'cuentas')">
                <img src="assets/img/svg/partidas.svg" width='25px' alt="partidas">
                </a>
            </li>

            <?php
                $activeExercise = (isset($_GET['pagina']) && ($_GET['pagina'] == 'exercise' || $_GET['pagina'] == 'registerExercise' || $_GET['pagina'] == 'editExercise')) ? 'active' : '';
            ?>
            <li class="list-group-item main-grid <?php echo $activeExercise; ?>">
                <a href="exercise" class="icon sidenav" data-bs-toggle="tooltip" data-bs-placement="right" title="Ejercicios" onclick="confirmExit(event, 'exercise')">
                    <img src="assets/img/svg/exercises.svg" width='25px' alt="exercise">
                </a>
            </li>

            <?php
                $activeBudget = (isset($_GET['pagina']) && ($_GET['pagina'] == 'budgets' || $_GET['pagina'] == 'registerBudgets' || $_GET['pagina'] == 'editBudgets')) ? 'active' : '';
            ?>
            <li class="list-group-item main-grid <?php echo $activeBudget; ?>">
                <a href="budgets" class="icon sidenav" data-bs-toggle="tooltip" data-bs-placement="right" title="Asignación de presupuestos" onclick="confirmExit(event, 'budgets')">
                    <img src="assets/img/svg/budgets.svg" width='25px' alt="budget">
                </a>
            </li>
        
        <?php endif ?>
        
        <?php
            $activeProvider = (isset($_GET['pagina']) && ($_GET['pagina'] == 'provider' || $_GET['pagina'] == 'registerProvider' || $_GET['pagina'] == 'editProvider')) ? 'active' : '';
        ?>
        <li class="list-group-item main-grid <?php echo $activeProvider; ?>">
            <a href="provider" class="icon sidenav" data-bs-toggle="tooltip" data-bs-placement="right" title="Proveedores" onclick="confirmExit(event, 'provider')">
                <img src="assets/img/svg/providers.svg" width='25px' alt="provider">
            </a>
        </li>
        
        <?php
            $activeRequest = (isset($_GET['pagina']) && ($_GET['pagina'] == 'requestBudget' || $_GET['pagina'] == 'registerRequestBudget')) ? 'active' : '';
        ?>
        <li class="list-group-item main-grid <?php echo $activeRequest; ?>">
            <a href="requestBudget" class="icon sidenav" data-bs-toggle="tooltip" data-bs-placement="right" title="Solicitudes de presupuestos" onclick="confirmExit(event, 'requestBudget')">
                <img src="assets/img/svg/justifyRequest.svg" width='25px' alt="requestBudget">
            </a>
        </li>
    </ul>
</nav>
<!-- End Sidebar Menu Area -->

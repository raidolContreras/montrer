$(document).ready(function () {
    getAreas();
});

function getAreas() {
    var idUser = $('input[name="user"]').val();
    // Realiza la solicitud AJAX para obtener las áreas
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/countArea.php',
        data: {idUser: idUser},
        dataType: 'json', // Asegúrate de indicar que esperas un objeto JSON
        success: function (response) {
            var comp = parseFloat(response.comp).toLocaleString('es-MX', {
                style: 'currency',
                currency: 'MXN'
            });

            var nocomp = parseFloat(response.nocomp).toLocaleString('es-MX', {
                style: 'currency',
                currency: 'MXN'
            });

            $('.comp').text(comp);

            $('.nocomp').text(nocomp);

            $('.budget-message-compr').text('Presupuesto comprobado en el ' + response.name + '.');
            $('.budget-message-no-compr').text('Presupuesto sin comprobar en el ' + response.name + '.');

            // Convertir la cadena JSON de las áreas en un objeto JavaScript
            var areasObj = JSON.parse(response.areas);
            var budgetsObj = JSON.parse(response.budgets);
            
            // Iterar sobre las claves y valores del objeto de áreas
            Object.keys(areasObj).forEach(function(key) {
                var areaName = areasObj[key];

                // Obtener el presupuesto para esta área
                var budget = '$0.00';
                var budgetMessage = 'Sin presupuesto asignado en el ejercicio';
                if (!isNaN(parseFloat(budgetsObj[key]))) {
                    budgetMessage = 'Presupuesto asignado en el ejercicio ' + response.name;
                    budget = parseFloat(budgetsObj[key]).toLocaleString('es-MX', {
                        style: 'currency',
                        currency: 'MXN'
                    });
                }

                // Construir el HTML para la nueva área
                var areaHtml = `
                    <div class="col-lg-4 col-md-6">
                        <a href="requestBudget" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Presupuesto total del departamento ${areaName}">
                            <div class="single-features">
                                <div class="row align-items-center">
                                    <div class="col-xl-12">
                                        <div class="single-click-content">
                                            <span class="features-title depto-titles">${areaName}</span>
                                            <h3 class="deptos">${budget}</h3>
                                            <p class="deptos-message">${budgetMessage}.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

					<div class="col-lg-4 col-md-6">
						<a href="budgets" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Presupuesto utilizado del departamento ${areaName}">
						<div class="single-features">
							<div class="row align-items-center">
								<div class="col-xl-12">
									<div class="single-click-content">
										<span class="features-title">Presupuesto utilizado</span>
										<h3 class="total-use-${areaName}"></h3>
										<p class="budget-message-uses"></p>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>

					<div class="col-lg-4 col-md-6">
						<a href="exercise" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Presupuesto restante del departamento ${areaName}">
						<div class="single-features">
							<div class="row align-items-center">
								<div class="col-xl-12">
									<div class="single-click-content">
										<span class="features-title">Presupuesto restante</span>
										<h3 class="rest-${areaName}"></h3>
										<p class="budget-message-rest"></p>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>
                `;

                // Agregar el HTML al div con la clase dashboard
                $('.dashboard').append(areaHtml);
            });

        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}

function usedBudgets(idArea) {
    $.ajax({
        type: 'POST',
            url: 'controller/ajax/countAreaId.php',
        data: {idArea: idArea},
        dataType: 'json', // Asegúrate de indicar que esperas un objeto JSON
    });
}
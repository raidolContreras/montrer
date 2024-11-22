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
            
            var comp = formatNumber(response.comp);
            var nocomp = formatNumber(response.nocomp);

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
                    
                    budget = formatNumber(budgetsObj[key]);

                }
                usedBudgets(key, budgetsObj[key], response.name);

                // Construir el HTML para la nueva área
                
            //     <div class="col-lg-3 col-md-6">
            //     <a href="requestBudget" data-bs-toggle="tooltip" data-bs-placement="top" title="Presupuesto total del departamento ${areaName}">
            //         <div class="single-features">
            //             <div class="row align-items-center">
            //                 <div class="col-xl-12">
            //                     <div class="single-click-content">
            //                         <span class="features-title depto-titles">${areaName}</span>
            //                         <h3 class="deptos">${budget}</h3>
            //                         <p class="deptos-message">${budgetMessage}.</p>
            //                     </div>
            //                 </div>
            //             </div>
            //         </div>
            //     </a>
            // </div>
                var areaHtml = `

					<div class="col-lg-4 col-md-6">
						<a href="requestBudget" data-bs-toggle="tooltip" data-bs-placement="top" title="Presupuesto solicitado del departamento ${areaName}">
						<div class="single-features">
							<div class="row align-items-center">
								<div class="col-xl-12">
									<div class="single-click-content">
										<span class="features-title">Presupuesto solicitado del departamento: ${areaName}</span>
										<h3 class="total-use-${areaName}"></h3>
										<p class="budget-message-uses-${areaName}"></p>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>

					<div class="col-lg-4 col-md-6">
						<a href="requestBudget" data-bs-toggle="tooltip" data-bs-placement="top" title="Presupuesto Comprobado del departamento ${areaName}">
						<div class="single-features">
							<div class="row align-items-center">
								<div class="col-xl-12">
									<div class="single-click-content">
										<span class="features-title">Presupuesto comprobado</span>
										<h3 class="total-comp-${areaName}"></h3>
										<p class="budget-message-comp-${areaName}"></p>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>

					<div class="col-lg-4 col-md-6">
						<a href="requestBudget" data-bs-toggle="tooltip" data-bs-placement="top" title="Presupuesto sin comprobar del departamento ${areaName}">
						<div class="single-features">
							<div class="row align-items-center">
								<div class="col-xl-12">
									<div class="single-click-content">
										<span class="features-title">Presupuesto sin comprobar</span>
										<h3 class="rest-${areaName}"></h3>
										<p class="budget-message-rest-${areaName}"></p>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>
                `;

                // Agregar el HTML al div con la clase dashboard
                $('.dashboard').append(areaHtml);// Inicializa los tooltips para los nuevos elementos dinámicos
                $('[data-bs-toggle="tooltip"]').tooltip();
                
            });

        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}

function usedBudgets(idArea, budgetActive, exercise) {
    $.ajax({
        type: 'POST',
            url: 'controller/ajax/countAreaId.php',
        data: {idArea: idArea},
        dataType: 'json', // Asegúrate de indicar que esperas un objeto JSON
        success: function (response) {

            var budgetTotal = response.comp - response.compActive;

            var used = formatNumber(response.comp);
            var compActive = formatNumber(response.compActive);
            
            if (!isNaN(parseFloat(budgetTotal))) {
                budgetTotal = formatNumber(budgetTotal);
            } else {
                budgetTotal = '$0.00';
            }
            
            budgetUsedMessage = 'Presupuesto solicitado en el ejercicio ' + exercise;
            budgetCompMessage = 'Presupuesto comprobado en el ejercicio ' + exercise;
            budgetRestMessage = 'Presupuesto sin comprobar en el ejercicio ' + exercise;
            $('.total-use-'+ response.nameArea).append(used);
            $('.total-comp-'+ response.nameArea).append(compActive);
            // $('.rest-'+ response.nameArea).append(budgetTotal);
            $('.rest-'+ response.nameArea).append(budgetTotal);
            $('.budget-message-uses-'+ response.nameArea).append(budgetUsedMessage);
            $('.budget-message-comp-'+ response.nameArea).append(budgetCompMessage);
            $('.budget-message-rest-'+ response.nameArea).append(budgetRestMessage);
        }
    });
    
}

function formatNumber(number) {
    var numberFormatted = parseFloat(number).toLocaleString('es-MX', {
        style: 'currency',
        currency: 'MXN'
    });
    return numberFormatted;
}

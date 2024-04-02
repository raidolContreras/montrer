$(document).ready(function () {

	$("input[name='metodoDePago']").change(function(){
        // Si el radio button seleccionado es 'cheque', habilita el input
        if($("#cheque").is(":checked")) {
            $("#chequeNombre").removeAttr("disabled");
        } else {
            // Si se selecciona cualquier otro método de pago, deshabilita el input
            $("#chequeNombre").attr("disabled", true);
        }
    });

	var level = $("input[name='level']").val();
	var user = $("input[name='user']").val();

	verificacion(user);
	
	moment.locale('es');
	$('#requests').DataTable({
		// tus otras opciones de configuración aquí...
		initComplete: function(settings, json) {
			// Esto inicializa los tooltips después de que DataTables ha terminado de cargar los datos por primera vez
			$('[data-bs-toggle="tooltip"]').tooltip();
		},
		drawCallback: function(settings) {
			// Esto reinicializa los tooltips cada vez que DataTables redibuja la tabla (ej., paginación)
			$('[data-bs-toggle="tooltip"]').tooltip();
		},
		ajax: {
			type: 'POST',
			url: 'controller/ajax/getRequests.php', // Ajusta la URL según tu estructura
			dataSrc: '',
			data: {
				user: user
			}
		},
		columns: [
			{
				data: 'folio',
			},
			{
				data: 'nameArea',
			},
			{
				data: null,
				render: function (data, type, row) {
					if (type === 'display' || type === 'filter') {
						var dataAmount;
						var color;
			
						if (data.approvedAmount != null) {
							dataAmount = data.approvedAmount;
							color = 'green';
						} else {
							dataAmount = data.requestedAmount;
							color = 'orange';
						}
			
						// Formatear como pesos
						var formattedBudget = parseFloat(dataAmount).toLocaleString('es-MX', {
							style: 'currency',
							currency: 'MXN'
						});
			
						// Construir el HTML con el texto y el color
						var html = '<span style="color: ' + color + ';">' + formattedBudget + '</span>';
						return html;
					}
					return data;
				}
			},			
			{
				data: null,
				render: function (data) {
					return data.firstname + ' ' + data.lastname;
				}
			},
			{
				data: 'description'
			},
			{
				data: 'requestDate',
				render: function (data, type, row) {
					return moment(data).format('DD-MMM-YYYY hh:mm A');
				}
			},
			{
				data: null,
				render: function (data) {
					if (data.pagado == 1) {
                        return '<span style="color: green;">Pagado</span>';
                    } else {
						if (level == 1 && data.idUsers != user){
							return `<button class="btn btn-success pendiente-button" onClick="marcarPago(${data.idRequest}, ${data.idUsers})">Marcar como pagado</button>`;
						}
                        return '<span style="color: red;">No Pagado</span>';
                    }
				}
			},
			{
				data: null,
				render: function (data) {
					return renderActionButtons(data.idRequest, data.status, data.idUsers, user, level, data.idBudget, data.pagado);
				}
			}
		],
		responsive: true,
		autoWidth: false,
		dom: 'Bfrtip', // Define la estructura del DOM para incluir botones
		buttons: [
			{
				extend: 'excelHtml5',
				text: 'Exportar a Excel',
				title: 'Presupuestos', // Título personalizado para el archivo Excel
				exportOptions: {
					columns: ':not(:last-child)' // Exportar todas las columnas excepto la última
				}
			},
			{
				extend: 'pdfHtml5',
				text: 'Exportar a PDF',
				title: 'Presupuestos',
				titleAttr: 'PDF',
				customize: function(doc) {
			
					// Añadir el logo en la parte superior
					doc.content.splice(1, 0, {
						image: logo64(), // Imagen en Base64
						width: 100, // Ancho del logo
						alignment: 'center' // Alineación del logo
					});
			
					// Eliminar cabeceras y pies de página por defecto
					delete doc['header']; // Eliminar la cabecera si existe
					delete doc['footer']; // Eliminar el pie de página si existe
			
					// Personalizaciones adicionales aquí
				},
				orientation: 'landscape', // Orientación del PDF
				pageSize: 'A4', // Tamaño de la página
				exportOptions: {
					columns: ':not(:last-child)' // Exportar todas las columnas excepto la última
				}
			},			
			{
				extend: 'print',
				text: 'Imprimir',
				title: '',
				customize: function(win) {
					// Añadir el logo
					$(win.document.body).prepend(
						'<img src="assets/img/logo.png" style="position:absolute; top:10px; left:10px; height:50px;" />'
					);
					$(win.document.body).prepend(
						'<h1 style="text-align: center; font-size: 8pt; padding-top: 10px;">Presupuestos</h1>'
					);

					$(win.document.body).css('font-size', '8pt');
					$(win.document.body).css('margin', '10mm');
			
					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
			
					$(win.document.body).find('table').each(function(index, elem) {
						$(elem).width('100%');
					});

					var css = '@page { size: landscape; }',
						head = win.document.head || win.document.getElementsByTagName('head')[0],
						style = win.document.createElement('style');
			
					style.type = 'text/css';
					style.media = 'print';
			
					if (style.styleSheet){
						style.styleSheet.cssText = css;
					} else {
						style.appendChild(win.document.createTextNode(css));
					}
			
					head.appendChild(style);
				}
			},
			
		],
		language: {
			"paginate": {
				"first": "<<",
				"last": ">>",
				"next": ">",
				"previous": "<"
			},
			"search": "Buscar:",
			"lengthMenu": "Ver _MENU_ resultados",
			"loadingRecords": "Cargando...",
			"info": "Mostrando _START_ de _END_ en _TOTAL_ resultados",
			"infoEmpty": "Mostrando 0 resultados",
			"emptyTable":	  "Ningún dato disponible en esta tabla"
		}
	});

});

// Manejar el clic del botón de edición
$('#requests').on('click', '.edit-button', function() {
	var idRequest = $(this).data('id');
	sendForm('editRequest', idRequest);
});

function sendForm(action, idRequest) {
	// Crear un formulario oculto y agregar el idRequest como un campo oculto
	var form = $('<form action="' + action + '" method="post"></form>');
	form.append('<input type="hidden" name="register" value="' + idRequest + '">');

	// Adjuntar el formulario al cuerpo del documento y enviarlo
	$('body').append(form);
	form.submit();
}

showModalAndSetData('deleteModal', 'deleteRequestName', 'confirmDeleteRequest', 'delete', 'Presupuesto eliminado con éxito', 'eliminar');
showModalAndSetData('enableModal', 'enableRequestName', 'confirmEnableRequest', 'enable', 'Presupuesto aceptado con éxito', 'aceptar');
showModalAndSetData('denegateModal', 'denegateRequestName', 'confirmDenegateRequest', 'denegate', 'Presupuesto rechazado', 'rechazar');

function showModalAndSetData(modalId, nameId, confirmButtonId, actionType, successMessage, errorMessage) {
	$('#requests').on('click', `.${actionType}-button`, function () {
		var idRequest = $(this).data('id');
		var RequestName = $(this).closest('tr').find('td:eq(1)').text();
		
		$(`#${nameId}`).text(RequestName);
		$(`#${confirmButtonId}`).data('id', idRequest);
		
		if(modalId == 'enableModal'){
			var idBudget = $(this).data('budget');
			$("input[name='budget']").val(idBudget);
			$.ajax({
				type: 'POST',
				url: 'controller/ajax/getRequest.php',
				data: { idRequest: idRequest },
				dataType: 'json',
				success: function (response) {
					$("input[name='approvedAmount']").val(response.requestedAmount);
					$("input[name='area']").val(response.idArea);
					$.ajax({
						type: 'POST',
						url: 'controller/ajax/getAuthorizedAmount.php',
						data: { areaId: response.idArea },
						dataType: 'json',
						success: function (response) {
							updateMaxRequestedAmount(response);
						},
						error: function (error) {
							console.log('Error en la solicitud AJAX:', error);
						}
					});
				},
				error: function (error) {
					console.log('Error en la solicitud AJAX:', error);
				}
			});
		}

		$(`#${modalId}`).modal('show');
	});

	$(`#${confirmButtonId}`).off('click').on('click', function () {
		var idRequest = $(this).data('id');
		var user = $("input[name='user']").val();
		if(modalId == 'enableModal'){
			var approvedAmount = $('input[name="approvedAmount"]').val();
			var maxBudget = $('input[name="maxBudget"]').val();
			var idBudget = $('input[name="budget"]').val();
			var idArea = $('input[name="area"]').val();
			if(parseFloat(maxBudget) >= parseFloat(approvedAmount)){
				$.ajax({
					type: 'POST',
					url: 'controller/ajax/ajax.form.php',
					data: {
						enableRequest: idRequest,
						approvedAmount: approvedAmount,
						idArea: idArea,
						idBudget: idBudget,
						idAdmin: user
					},
					success: function (response) {
						handleResponse(response, successMessage, errorMessage);
					},
					complete: function () {
						idRequest = 0;
						$(`#${modalId}`).modal('hide');
					}
				});
			} else {
				console.log(maxBudget);
				console.log(approvedAmount);

				showAlertBootstrap('¡Atención!', 'La cantidad por aprobar no debe de superar el monto disponible mensual.');
			}
		} else if(modalId == 'denegateModal') {
			$.ajax({
				type: 'POST',
				url: 'controller/ajax/ajax.form.php',
				data: { 
					denegateRequest: idRequest,
					idAdmin: user
				},
				success: function (response) {
					handleResponse(response, successMessage, errorMessage);
				},
				complete: function () {
					idRequest = 0;
					$(`#${modalId}`).modal('hide');
				}
			});
		} else {
			$.ajax({
				type: 'POST',
				url: 'controller/ajax/ajax.form.php',
				data: { [`${actionType}Request`]: idRequest },
				success: function (response) {
					handleResponse(response, successMessage, errorMessage);
				},
				complete: function () {
					idRequest = 0;
					$(`#${modalId}`).modal('hide');
				}
			});
		}
	});
}

function handleResponse(response, successMessage, errorMessage) {
	if (response === 'ok') {
		showAlertBootstrap4('Operación realizada', successMessage);
	} else {
		showAlertBootstrap('!Atención¡', `No se pudo ${errorMessage.toLowerCase()} el Presupuesto`);
	}
}

function renderActionButtons(idRequest, status, userRequest, user, level, idBudget, pagado) {

	if (status == 0 && userRequest == user){
		return `
			<div class="container">
				<div class="row btn-group" role="group" style="justify-content: center;">
					<button class="btn btn-primary edit-button col-2" data-id="${idRequest}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
						<i class="ri-edit-line"></i>
					</button>
					<button class="btn btn-danger delete-button col-2" data-id="${idRequest}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
						<i class="ri-delete-bin-6-line"></i>
					</button>
				</div>
			</div>
		`;
	} else if (status == 0 && level == 1 && userRequest != user) {
		return `
			<div class="container">
				<div class="row btn-group" role="group" style="justify-content: center;">
					<button class="btn btn-success enable-button col-2" data-id="${idRequest}" data-budget="${idBudget}" data-bs-toggle="tooltip" data-bs-placement="top" title="Aceptar">
						<i class="ri-check-line"></i>
					</button>
					<button class="btn btn-danger denegate-button col-2" data-id="${idRequest}" data-bs-toggle="tooltip" data-bs-placement="top" title="Rechazar">
						<i class="ri-close-line"></i>
					</button>
				</div>
			</div>
		`;
	} else if (status == 1) {
		html = `
			<div class="container">
		`;
		if(userRequest == user){
			if (pagado == 1) {
				html += `
				<div class="row btn-group" role="group" style="justify-content: center;">
					<button class="btn btn-success check-budget-button col-2" onclick="modalComprobar(${idRequest})" data-bs-toggle="tooltip" data-bs-placement="top" title="Comprobar presupuesto">
						<i class="ri-refund-2-line"></i>
					</button>
				</div>`;
			} else {
				html += `
				<div class="row btn-group" role="group" style="justify-content: center;">
					<button class="btn btn-warning btn-block pendiente-button col-2">
						Pendiente de pago
					</button>
				</div>`;
			}
		} else {
			html += `
			<div class="row btn-group" role="group" style="justify-content: center;">
				<button class="btn btn-warning btn-block pendiente-button col-2" data-id="${idRequest}">
					Pendiente de comprobación
				</button>
			</div>`;
		}
		return html + `
			</div>
		`;
	} else if (status == 2) {
		if (level == 1 && userRequest != user){

			$('.botones-modal').html(`
				<a class="btn btn-danger" data-bs-dismiss="modal">Cancelar</a>
				<button type="button" class="btn btn-warning denegar">Denegar</button>
				<button type="button" class="btn btn-success aceptar">Aceptar</button>
			`);
			$('.comment').html(`
				<div class="col-12">
					<label for="comentario" class="form-label">Realizar comentario</label>
					<input type="text" class="form-control" id="comentario">
				</div>
			`);

			return `
                <div class="container">
                    <div class="row btn-group" role="group" style="justify-content: center;">
                        <button class="btn btn-success ver-button col-2" onclick="verComprobacion(${idRequest})" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver envio">
                            <i class="ri-eye-line"></i>
                        </button>
                    </div>
                </div>
            `;
		}
		return `
			<div class="row btn-group" role="group" style="justify-content: center;">
				<button class="btn btn-warning btn-block pendiente-button col-2" onclick="pendienteAprovacion(${idRequest})">
					Pendiente de aprobación
				</button>
			</div>
		`;
	} else if (status == 4) {
		html = `
			<div class="container">
		`;
		if(userRequest == user){
			html += `
				<div class="row btn-group" role="group" style="justify-content: center;">
					<button class="btn btn-danger check-budget-button col-2" onclick="modalComprobar(${idRequest})" data-bs-toggle="tooltip" data-bs-placement="top" title="Comprobante rechazado, por favor vuelva a enviarlo.">
						<i class="ri-refund-2-line"></i>
					</button>
				</div>
			`;
		} else {
			html += `
				<button class="btn btn-warning btn-block pendiente-button col-2" data-id="${idRequest}">
					Pendiente de comprobación
				</button>
			`;
		}
		return html + `
			</div>
		`;
	} else if (status == 5) {
		$('.botones-modal').html('<button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>');
		
		$('.comment').html(`
			<div class="col-12">
				<label for="comentario" class="form-label">Comentarios</label>
				<input type="text" class="form-control" id="comentario" readonly>
			</div>
		`);

		return `
			<div class="container">
				<div class="row btn-group" role="group" style="justify-content: center;">
					<button class="btn btn-success ver-button col-2" onclick="verComprobacion(${idRequest})" data-bs-toggle="tooltip" data-bs-placement="top" title="Comprobante aceptado, verifique el envío.">
						<i class="ri-check-line"></i>
					</button>
				</div>
			</div>
		`;

	} else {
		return `
			<div class="container">
				<div class="row btn-group" role="group" style="justify-content: center;">
					Rechazado
				</div>
			</div>
		`;
	}
}

function updateMaxRequestedAmount(datos) {
		// Obtén el mes actual
		var today = new Date();
		var currentMonth = today.getMonth() + 1; // Los meses en JavaScript van de 0 a 11, por lo que sumamos 1.
	
		// Filtra los datos hasta el mes actual
		var datosHastaMesActual = datos.filter(function (dato) {
			return dato.month <= currentMonth;
		});
	
		// Suma los valores de budget_month hasta el mes actual
		var sumaBudgetMonth = datosHastaMesActual.reduce(function (total, dato) {
			var budgetMonth = parseFloat(dato.budget_month);
			var budgetUsed = parseFloat(dato.budget_used);
			
			// Verificar si los valores son números válidos
			if (!isNaN(budgetMonth) && !isNaN(budgetUsed)) {
				return total + (budgetMonth - budgetUsed);
			} else {
				return total; // No agregar nada si alguno de los valores no es un número válido
			}
		}, 0);

		// Obtiene el idBudget del primer elemento del array (puedes ajustar esto según tus necesidades)
		var idBudget = datos[0].idBudget;

		let formattedSum = sumaBudgetMonth.toLocaleString('es-MX', {
			style: 'currency',
			currency: 'MXN',
			minimumFractionDigits: 2,
			maximumFractionDigits: 2,
		});
		
		if(datos[0].approvedAmount !== 0){
			
			$("input[name='budget']").val(idBudget);
			$("input[name='maxBudget']").val(sumaBudgetMonth.toFixed(2));
			$('#requestedAmount').val(sumaBudgetMonth.toFixed(2));
			$('.requestMax').text('La suma de los presupuestos hasta el mes actual es: ' + formattedSum);

		} else {
			$('#requestedAmount').prop('disabled', true);
			$('.requestMax').text('No se puede solicitar un nuevo presupuesto porque no se ha justificado uno anterior.');
		}
}

function modalComprobar(idRequest) {

    $.ajax({
        type: 'POST',
        url: 'controller/ajax/ajax.form.php',
        data: { searchRequest: idRequest },
        dataType: 'json',
        success: function (response) {
			
			var registerValue = $('#register-value').data('register');

            getArea(registerValue);
            $('#fechaSolicitud').val(response.responseDate.split(' ')[0]);
            $("input[name='importeSolicitado']").val(response.approvedAmount);
            $("input[name='titularCuenta']").val(response.representative_name);
            $("input[name='entidadBancaria']").val(response.bank_name);
            $("input[name='conceptoPago']").val(response.description);

            // Usa writtenNumber para convertir el monto aprobado a palabras.
            var amountInWords = numeroALetra(response.approvedAmount);
			
            $("input[name='importeLetra']").val(amountInWords);

            $("select[name='provider']").val(response.idProvider);
            $("input[name='request']").val(idRequest);
            $('#comprobarModal').modal('show');
        }
    });
}

function numeroALetra(numero) {
    var unidades = ['', 'un', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
    var especiales = ['diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve'];
    var decenas = ['','diez','veinte','treinta','cuarenta','cincuenta','sesenta','setenta','ochenta','noventa'];
    var centenas = ['','ciento','doscientos','trescientos','cuatrocientos','quinientos','seiscientos','setecientos','ochocientos','novecientos'];

    var texto = '';

    var entero = Math.floor(numero);
    var decimal = Math.round((numero - entero) * 100);

    if (entero === 0) {
        texto = 'cero';
    } else {
        // Parte entera
        if (entero >= 1000000) {
            texto += numeroALetra(Math.floor(entero / 1000000)) + ' millón ';
            entero %= 1000000;
        }

        if (entero >= 1000) {
            texto += numeroALetra(Math.floor(entero / 1000)) + ' mil ';
            entero %= 1000;
        }

        if (entero >= 100) {
            texto += centenas[Math.floor(entero / 100)] + ' ';
            entero %= 100;
        }

        if (entero >= 20) {
            texto += decenas[Math.floor(entero / 10)] + ' ';
            entero %= 10;
        }

        if (entero >= 10) {
            texto += especiales[entero - 10];
            decimal = 0; // No hay centavos si el número es un número especial
        } else if (entero > 0) {
            texto += unidades[entero];
        }
    }

    // Centavos
    if (decimal > 0) {
        texto += (entero > 0 ? ' ' : '') + (decimal === 1 ? 'pesos con un centavo' : 'pesos con ' + numeroALetra(decimal) + ' centavos');
    } else if (entero > 0) {
    }

    return texto.trim();
}

function getArea(registerValue) {
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/getAreasManager.php',
        data: {user: registerValue},
        dataType: 'json',
        success: function (response) {
            $('select[name="area"]').val(response.nameArea);

            fillAreaSelect('area', response);

        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}

function fillAreaSelect(select, datas) {
    var selectOption = $('#' + select);

    selectOption.empty();
    datas.forEach(function (data) {
        var option = $('<option>').val(data[0]).text(data[1]);
        selectOption.append(option);
    });
}

function verificacion(idUser) {
	$.ajax({
        type: 'POST',
        url: 'controller/ajax/ajax.form.php',
        data: {verificacion: idUser},
        dataType: 'json',
        success: function (response) {
			if (response == false) {
				$('.solicitud').html(`
					<h3>Solicitudes de presupuesto</h3>
					<a class="btn btn-primary denegate" disabled>Nueva solicitud</a>
				`)
			} else {
				$.ajax({
					type: 'POST',
					url: 'controller/ajax/ajax.form.php',
					data: {verificacion2: idUser},
					dataType: 'json',
					success: function (response) {
						response.forEach(function(item) {
							var responseDate = new Date(item.responseDate);
							var today = new Date();
				
							var timeDifference = today.getTime() - responseDate.getTime();
							var daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
				
							console.log("Días transcurridos desde la respuesta:", daysDifference);
							// Formatear como pesos
							var formattedBudget = parseFloat(item.approvedAmount).toLocaleString('es-MX', {
								style: 'currency',
								currency: 'MXN'
							});
				
							if (daysDifference >= 8) {
				
								showAlertBootstrap('¡Atención!', `Deseamos informarle que su préstamo anterior, valuado en ${formattedBudget}, lleva más de 8 días sin ser comprobado. Le instamos a que lo revise lo antes posible antes de realizar cualquier otra solicitud de presupuesto. Es crucial mantener un seguimiento oportuno de sus transacciones financieras para garantizar una gestión eficiente de los recursos. <br><br>Por favor, tenga en cuenta que su cuenta no puede solicitar más presupuestos hasta que compruebe los que ya tiene vencidos.`);
								
								$('.solicitud').html(`
									<h3>Solicitudes de presupuesto</h3>
									<a class="btn btn-primary denegate" disabled>Nueva solicitud</a>
								`)
							} else if( daysDifference > 1 ) {
								showAlertBootstrap('¡Atención!', `Queremos informarle que su préstamo anterior, valuado en ${formattedBudget}, lleva ${daysDifference} días sin ser comprobado. Le instamos a que lo revise lo antes posible antes de realizar cualquier otra solicitud de presupuesto. Es crucial mantener un seguimiento oportuno de sus transacciones financieras para garantizar una gestión eficiente de los recursos. <br><br>Por favor, tenga en cuenta que una vez enviado, debe esperar a que nuestro equipo administrativo lo revise.`);
							}
						});
					},
					error: function (error) {
						console.log('Error en la solicitud AJAX:', error);
					}
				});
				
			}
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}


function marcarPago(idRequest, idUser) {

    $('#marcarModal').modal('show');
	var html =  `
		<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
		<button type="button" class="btn btn-success" onclick="marcarAjax(${idRequest},${idUser})">Aceptar</button>
	`;

	$('.marcar-footer').html(html);

};

function marcarAjax(idRequest, idUser) {
	$.ajax({
		type: 'POST',
		url: 'controller/ajax/ajax.form.php',
		data: {marcarPago: idRequest, idUser: idUser},
		dataSrc: '',
		success: function (response) {
			if(response == 'ok'){
				$('#requests').DataTable().ajax.reload();
				$('#marcarModal').modal('hide');
			}
		}
	});
}

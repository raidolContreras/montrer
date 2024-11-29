$(document).ready(function () {
    let $comment = document.getElementById("requestedAmount");
    let timeout;

    $comment.addEventListener('keydown', () => {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            requestedAmount = $('#requestedAmount').val();
            var inputValue = requestedAmount.replace(/[^0-9.]/g, ''); // Eliminar todo excepto números y punto decimal
            var numero = parseFloat(inputValue);
            if (!isNaN(numero)) {
                var textoEnLetras = numeroALetra(numero, true);
                $('#importeLetra').val(textoEnLetras);
            } else {
                $('#importeLetra').val('');
            }
            clearTimeout(timeout);
        }, 500);
    });

    $("input[name='metodoDePago']").change(function () {
        if ($("#cheque").is(":checked")) {
            $("#chequeNombre").removeAttr("disabled");
        } else {
            $("#chequeNombre").attr("disabled", true);
        }
    });

    var level = $("input[name='level']").val();
    var user = $("input[name='user']").val();

    verificacion(user);

    moment.locale('es');
    $('#requests').DataTable({
        initComplete: function (settings, json) {
            $('[data-toggle="tooltip"]').tooltip();
        },
        drawCallback: function (settings) {
            $('[data-toggle="tooltip"]').tooltip();
        },
        ajax: {
            type: 'POST',
            url: 'controller/ajax/getRequests.php',
            dataSrc: '',
            data: {
                user: user
            }
        },
        columns: [
            { data: 'folio' },
            { data: 'nameArea' },
            {
                data: null,
                render: function (data, type) {
                    var dataAmount, color;

                    if (data.approvedAmount != null) {
                        dataAmount = data.approvedAmount;
                        color = 'green';
                    } else {
                        dataAmount = data.requestedAmount;
                        color = 'orange';
                    }

                    var formattedBudget = parseFloat(dataAmount).toLocaleString('es-MX', {
                        style: 'currency',
                        currency: 'MXN'
                    });

                    var html = '<span style="color: ' + color + ';">' + formattedBudget + '</span>';
                    return html;
                }
            },
            {
                data: null,
                render: function (data) {
                    return data.firstname + ' ' + data.lastname;
                }
            },
            { data: 'concepto_pago' },
            {
                data: 'requestDate',
                render: function (data) {
                    return moment(data).format('DD-MMM-YYYY hh:mm A');
                }
            },
            { data: 'exerciseName' },
			{
				data: null,
				render: function (data) {
                    if (data.pagado == 0) {
						return 'Pendiente de pago';
					} else {
						return 'Pagado';
					}
                }
			},
            {
                data: null,
                render: function (data) {
                    return renderActionButtons(data.idRequest, data.status, data.idUsers, user, level, data.idBudget, data.pagado, data.paymentDate, data.complete);
                }
            }
        ],
        responsive: true,
        autoWidth: false,
        dom: "<'row'<'col-sm-6'B><'col-sm-6 text-end'f>>" + // Botones y búsqueda
             "<'row'<'col-sm-12't>>" +
             "<'row'<'col-sm-6'i><'col-sm-6'p>>" + // Información y paginación
             "<'row'<'col-sm-12'<'d-flex justify-content-between align-items-center'l>>>" + // Personalización del DOM
             "<'row'<'col-sm-12'<'mt-3'G>>>", // Donde G se reemplaza por el formulario
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Exportar a Excel',
                title: 'Presupuestos',
            },
            {
                extend: 'pdfHtml5',
                text: 'Exportar a PDF',
                title: 'Presupuestos',
                titleAttr: 'PDF',
                customize: function (doc) {
                    doc.content.splice(1, 0, {
                        image: logo64(),
                        width: 100,
                        alignment: 'center'
                    });
                    delete doc['header'];
                    delete doc['footer'];
                },
                orientation: 'landscape',
                pageSize: 'A4'
            },
            {
                extend: 'print',
                text: 'Imprimir',
                customize: function (win) {
                    $(win.document.body).prepend(
                        '<img src="assets/img/logo.png" style="position:absolute; top:10px; left:10px; height:50px;" />' +
                        '<h1 style="text-align: center; font-size: 8pt; padding-top: 10px;">Presupuestos</h1>'
                    );
                    $(win.document.body).css('font-size', '8pt');
                    $(win.document.body).css('margin', '10mm');
                    $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                    $(win.document.body).find('table').each(function (index, elem) {
                        $(elem).width('100%');
                    });
                    var css = '@page { size: landscape; }',
                        head = win.document.head || win.document.getElementsByTagName('head')[0],
                        style = win.document.createElement('style');

                    style.type = 'text/css';
                    style.media = 'print';

                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild(win.document.createTextNode(css));
                    }

                    head.appendChild(style);
                }
            }
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
            "emptyTable": "Ningún dato disponible en esta tabla"
        }
    });
    if (level == 1){
        // Anexar el formulario después del botón de exportar
        $('#requests_wrapper').find('.text-end').after(`
            <center>
            <form class="row p-3 align-items-center" id="GenReport">
                <div class="col-md-3 d-flex align-items-center">
                    <label for="startDate" class="form-label me-2 mb-0 small">Inicio:</label>
                    <input type="date" id="startDate" name="startDate" class="form-input">
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <label for="endDate" class="form-label me-2 mb-0 small">Fin:</label>
                    <input type="date" id="endDate" name="endDate" class="form-input">
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <button class="btn-report" type="submit">
                        <i class="bi bi-file-earmark-bar-graph"></i> Generar reporte
                    </button>
                </div>
            </form>
            </center>
        `);
    }
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
							updateMaxRequestedAmount(response, idRequest);
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
				// console.log('Max: '+maxBudget);
				// console.log(approvedAmount);
				$(`#${modalId}`).modal('hide');
				var idBudget = $('input[name="budget"]').val();
				showAlertBootstrap6('¡Atención!', 'La cantidad por aprobar no debe de superar el monto disponible mensual.', idRequest, idBudget);
			}
		} else if(modalId == 'denegateModal') {

			var comentRechazo = $('#comentRechazo').val();
			$.ajax({
				type: 'POST',
				url: 'controller/ajax/ajax.form.php',
				data: { 
					comentRechazo: comentRechazo,
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

function closeModal() {	
	$('#alertModal').modal('hide');
	$('#enableModal').modal('show');
}

function showAlertBootstrap6(title, message, idRequest, idBudget) {
	$('#modalLabel').text(title);
	$('.modal-body-extra').html(message);
		modalFooter.html(`
		<button class="btn btn-success enable-button col-2" data-id="${idRequest}" data-budget="${idBudget}" data-bs-toggle="tooltip" data-bs-placement="top" onclick="closeModal()">
			Aceptar
		</button>
		`);
	$('#alertModal').modal('show');
}


function handleResponse(response, successMessage, errorMessage) {
	if (response === 'ok') {
		showAlertBootstrap4('Operación realizada', successMessage);
	} else {
		showAlertBootstrap('!Atención¡', `No se pudo ${errorMessage.toLowerCase()} el Presupuesto`);
	}
}


function updateMaxRequestedAmount(datos, idRequest) {
	let requestedAmount = 0;
    const fecha = new Date();
    const mesActual = fecha.getMonth();
    if (!datos) {
        // Si authorizedAmount es falso (undefined, null, 0, '', false), deshabilita el campo de entrada y reinicia los valores
        $('#requestedAmount').prop('disabled', true);
        $('#requestedAmount').val('');
        $('.requestMax').text('En el presente ejercicio, no se ha asignado un presupuesto para el departamento correspondiente');
    } else {
            
        $.ajax({
            type: 'POST',
                url: 'controller/ajax/countAreaId.php',
            data: {idArea: datos[0].idArea },
            dataType: 'json', // Asegúrate de indicar que esperas un objeto JSON
            success: function (response) {

                var totalBudgetPendient = 0;
                var totalBudget = 0;
                var totalBudgetUsed = 0;

                $.ajax({
                    type: 'POST',
                    url: 'controller/ajax/getAmountPendient.php',
                    data: { areaId: datos[0].idArea },
                    dataType: 'json',
                    success: function (result) {
                        // for (var i = 0; i < result.length; i++) {
                        //     // Obtenemos la cantidad de cada objeto y la sumamos al total
                        //     totalBudgetPendient += parseFloat(result[i].requestedAmount);
                        // }
                        for (var i = 0; i < result.length; i++) {
                            // Obtenemos la cantidad de cada objeto y la sumamos al total
							if(result[i].idRequest === idRequest){
                                requestedAmount = parseFloat(result[i].requestedAmount);
                            }
                        }
						
                        for (var i = 0; i < mesActual; i++) {
                            totalBudgetUsed += datos[i].budget_used;
                            totalBudget += datos[i].budget_month;
                        }
                        
                        // Mostramos la suma total
                        // totalAmountBudget = response.total - response.comp - totalBudgetPendient;
						
                        totalBudget = (totalBudget - totalBudgetUsed) - response.comp;

                        formattedSum = totalBudget.toLocaleString('es-MX', {
                            style: 'currency',
                            currency: 'MXN',
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });

                        // Aquí puedes colocar el código que depende de totalAmountBudget
                        var idBudget = datos[0].idBudget;
                        if(datos[0].approvedAmount !== 0){
                            $("input[name='budget']").val(idBudget);
							
                            $("input[name='maxBudget']").val(totalBudget.toFixed(2));
                            // $("input[name='maxBudget']").val(totalAmountBudget.toFixed(2));
                            // $('#requestedAmount').val(totalAmountBudget.toFixed(2));
                            $('.requestMax').text('Presupuesto maximo a solicitar es de: ' + formattedSum);

							$('#approvedAmount').val(requestedAmount);
                        } else {
                            $('#requestedAmount').prop('disabled', true);
                            $('.requestMax').text('No se puede solicitar un nuevo presupuesto porque no se ha justificado uno anterior.');
                        }
                        
                    },
                    error: function (error) {
                        console.log('Error en la solicitud AJAX:', error);
                    }
                });

            }
        });
    }
}

function modalComprobar(idRequest, status) {

    $.ajax({
        type: 'POST',
        url: 'controller/ajax/ajax.form.php',
        data: { searchRequest: idRequest },
        dataType: 'json',
        success: function (response) {
			
			var registerValue = $('#register-value').data('register');
			
			documentRequest(idRequest);
            getArea(registerValue);
            $('#fechaSolicitud').val(response.responseDate.split(' ')[0]);
            $("input[name='importeSolicitado']").val(response.approvedAmount);
            $("input[name='titularCuenta']").val(response.representative_name);
            $("input[name='entidadBancaria']").val(response.bank_name);
            $("input[name='conceptoPago']").val(response.concepto_pago);

            // // Usa writtenNumber para convertir el monto aprobado a palabras.
            // var amountInWords = numeroALetra(response.approvedAmount, true);
			
            $("input[name='importeLetra']").val(response.importe_letra);

            $("select[name='provider2']").val(response.idProvider);
            $("input[name='request']").val(idRequest);
			if(status == true){
				$('.comentartio').html(`
					<label for="comentario" class="form-label">Comentario</label>
					<input type="text" class="form-control comentario-error" id="comentario" name="comentario" disabled>
				`);
				$('#comentario').val(response.comentarios);
			}
            $('#comprobarModal').modal('show');
        }
    });
}

function numeroALetra(numero, status) {
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
            texto += numeroALetra(Math.floor(entero / 1000000), false) + ' millón ';
            entero %= 1000000;
        }

        if (entero >= 1000) {
            texto += numeroALetra(Math.floor(entero / 1000), false) + ' mil ';
            entero %= 1000;
        }

        if (entero >= 100) {
            texto += centenas[Math.floor(entero / 100)] + ' ';
            entero %= 100;
        }

        if (entero >= 20) {
			if (entero > 20 && entero < 30 && status == true) {
				texto += 'veinti';
			} else if (entero != 30 && entero != 40 && entero != 50 && entero != 60 && entero != 70 && entero != 80 && entero != 90 && status == true) {
				texto += decenas[Math.floor(entero / 10)] + ' ';
				texto += 'y ';
			}else if (status == true) {
				texto += decenas[Math.floor(entero / 10)] + '';
				texto += '';
			} else {
				texto += decenas[Math.floor(entero / 10)] + ' ';
			}
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
        texto += (entero > 0 ? ' ' : '') + (decimal === 1 ? 'pesos con un centavo' : 'pesos con ' + numeroALetra(decimal, false) + ' centavos');
    } else {
		if (status == true) {	
			texto += ' pesos'; 
		}
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
            $('select[name="area2"]').val(response.nameArea);

            fillAreaSelect('area2', response);

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
				
				var level = $('#level').val();
				if (level != 0) {
					$('.solicitud').html(`
						<h3>Solicitudes de presupuesto</h3>
						<a class="btn btn-primary denegate" disabled>Nueva solicitud</a>
					`);
				} else {
					$('.solicitud').html(`
						<h3>Solicitudes de presupuesto</h3>
					`)
				}
			} else {
				$.ajax({
					type: 'POST',
					url: 'controller/ajax/ajax.form.php',
					data: {verificacion2: idUser},
					dataType: 'json',
					success: function (response) {
						response.forEach(function(item) {
							if (item.pagado != 0){
								var responseDate = new Date(item.responseDate);
								var today = new Date();
					
								var timeDifference = today.getTime() - responseDate.getTime();
								var daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
					
								// console.log("Días transcurridos desde la respuesta:", daysDifference);
								// Formatear como pesos
								var formattedBudget = parseFloat(item.approvedAmount).toLocaleString('es-MX', {
									style: 'currency',
									currency: 'MXN'
								});
					
								if (daysDifference >= 8) {
									showAlertBootstrap('¡Atención!', `Le informamos que tiene un acumulado en solicitudes de pago por un total de: ${formattedBudget}, y la fecha de vencimiento a expirado hace ${daysDifference} días. No podrá realizar una nueva solicitud hasta que haya comprobado los pendientes de forma correcta. <br><br>Tenga en cuenta que, una vez enviada la comprobación, debe esperar a que sea revisado y en su caso validado por el área correspondiente.`);
									
									var level = $('#level').val();
									if (level != 0) {
										$('.solicitud').html(`
											<h3>Solicitudes de presupuesto</h3>
											<a class="btn btn-primary denegate" disabled>Nueva solicitud</a>
										`);
									} else {
										$('.solicitud').html(`
											<h3>Solicitudes de presupuesto</h3>
										`)
									}
								} else if( daysDifference > 1 ) {
									showAlertBootstrap('¡Atención!', `Queremos informarle que su préstamo anterior, valuado en ${formattedBudget}, lleva ${daysDifference} días sin ser comprobado. Le instamos a que lo revise lo antes posible antes de realizar cualquier otra solicitud de presupuesto. Es crucial mantener un seguimiento oportuno de sus transacciones financieras para garantizar una gestión eficiente de los recursos. <br><br>Por favor, tenga en cuenta que una vez enviado, debe esperar a que nuestro equipo administrativo lo revise.`);
								}
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

function changePaymentDateModal(idRequest, paymentDate) {
    $('#modalChangePaymentDate').modal('show');
	$('#paymentDate').val(paymentDate);
	var html =  `
		<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
		<button type="button" class="btn btn-success" onclick="changePaymentDate(${idRequest})">Aceptar</button>
	`;

	$('.marcar-footer').html(html);
}

function changePaymentDate(idRequest) {
	
	var paymentDate = $('#paymentDate').val();

	$.ajax({
        type: 'POST',
        url: 'controller/ajax/ajax.form.php',
        data: {changePaymentDate: idRequest, paymentDate: paymentDate},
        dataSrc: '',
        success: function (response) {
            if(response == 'ok'){
                $('#requests').DataTable().ajax.reload();
                $('#modalChangePaymentDate').modal('hide');
            }
        }
    });
	
}

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

function renderActionButtons(idRequest, status, userRequest, user, level, idBudget, pagado, paymentDate, complete) {
    switch (status) {
        case 0:
            if (userRequest == user) {
                
            //     <button class="btn btn-primary edit-button col-2" data-id="${idRequest}" data-toggle="tooltip" data-placement="top" title="Editar">
            //     <i class="ri-edit-line"></i>
            // </button>
                return `
                    <div class="container">
                        <div class="btn-group" role="group" style="justify-content: center;">
                            <button class="btn btn-danger delete-button col-2" data-id="${idRequest}" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                <i class="ri-delete-bin-6-line"></i>
                            </button>
                            <button class="btn btn-success pendiente-button" data-bs-toggle="modal" data-bs-target="#verComprovacion" onclick="verComprobacion(${idRequest}, false)" data-toggle="tooltip" data-placement="top" title="Ver comprobante">
                                <i class="ri-file-paper-fill"></i>
                            </button>
                        </div>
                    </div>
                `;
            } else if (level == 1 && userRequest != user) {
				if (complete == 1) {
					return `
                    <div class="container">
						<div class="btn-group" role="group" style="justify-content: center;">
							<button class="btn btn-success enable-button col-2" data-id="${idRequest}" data-budget="${idBudget}" data-toggle="tooltip" data-placement="top" title="Aceptar">
								<i class="ri-check-line"></i>
							</button>
							<button class="btn btn-danger denegate-button col-2" data-id="${idRequest}" data-toggle="tooltip" data-placement="top" title="Rechazar">
								<i class="ri-close-line"></i>
							</button>
                            <button class="btn btn-success pendiente-button" data-bs-toggle="modal" data-bs-target="#verComprovacion" onclick="verComprobacion(${idRequest}, false)" data-toggle="tooltip" data-placement="top" title="Ver comprobante">
                                <i class="ri-file-paper-fill"></i>
                            </button>
						</div>
                    </div>
					`;
				} else {
					return `
                    <div class="container">
                        <div class="btn-group" role="group" style="justify-content: center;">
                            <button class="btn btn-success complete-button col-2" onclick="completeRequest(${idRequest})" data-toggle="tooltip" data-placement="top" title="Completar registro">
                                <i class="ri-file-edit-fill"></i>
                            </button>
                        </div>
                    </div>
                    `;
				}
            } else {
                return '';
            }
        case 1:
            if (userRequest == user) {
                if (pagado == 0) {
                    return `
                        <div class="container">
                            <div class="row" style="justify-content: center;">
                                Presupuesto aprobado
								<button class="btn btn-success pendiente-button" data-bs-toggle="modal" data-bs-target="#verComprovacion" onclick="verComprobacion(${idRequest}, false)" data-toggle="tooltip" data-placement="top" title="Ver comprobante">
									<i class="ri-file-paper-fill"></i>
								</button>
                            </div>
                        </div>
                    `;
                } else if (pagado == 1) {
                    return `
                        <div class="container">
                            <div class="btn-group" style="justify-content: center;">
                                <button class="btn btn-info pendiente-button" onclick="modalComprobar(${idRequest}, false)" data-toggle="tooltip" data-placement="top" title="Enviar comprobante">
                                    <i class="ri-file-add-line"></i>
                                </button>
								<button class="btn btn-success pendiente-button" data-bs-toggle="modal" data-bs-target="#verComprovacion" onclick="verComprobacion(${idRequest}, false)" data-toggle="tooltip" data-placement="top" title="Ver comprobante">
									<i class="ri-file-paper-fill"></i>
								</button>
                            </div>
                        </div>
                    `;
                }
            } else if (level == 1 && pagado == 0 && userRequest != user) {
                return `
					<div class="container">
						<div class="btn-group" role="group" style="justify-content: center;">
							<button class="btn btn-success pendiente-button" data-toggle="tooltip" data-placement="top" title="Marcar como pagado" onclick="marcarPago(${idRequest}, ${userRequest})">
								<i class="ri-money-dollar-circle-line"></i>
							</button>
                            <button class="btn btn-primary change-date-button col-2" data-id="${idRequest}" data-toggle="tooltip" data-placement="top" title="Cambiar fecha del pago" onclick="changePaymentDateModal(${idRequest}, '${paymentDate}')">
                                <i class="ri-calendar-event-line"></i>
                            </button>
                            <button class="btn btn-success pendiente-button" data-bs-toggle="modal" data-bs-target="#verComprovacion" onclick="verComprobacion(${idRequest}, false)" data-toggle="tooltip" data-placement="top" title="Ver comprobante">
                                <i class="ri-file-paper-fill"></i>
                            </button>
						</div>
					</div>
                `;
            } else if (userRequest != user && pagado == 1) {
                return `
                    <div class="container">
                        <div class="row" style="justify-content: center;">
                            Esperando comprobante
                            <button class="btn btn-success pendiente-button" data-bs-toggle="modal" data-bs-target="#verComprovacion" onclick="verComprobacion(${idRequest}, false)" data-toggle="tooltip" data-placement="top" title="Ver comprobante">
                                <i class="ri-file-paper-fill"></i>
                            </button>
                        </div>
                    </div>
                `;
            } else {
				return '';
			}
            break;
        case 2:
            if (userRequest != user && level == 1) {
                return `
                    <div class="container">
                        <div class="row" style="justify-content: center;">
                            <button class="btn btn-success pendiente-button" data-bs-toggle="modal" data-bs-target="#verComprovacion" onclick="verComprobacion(${idRequest}, true)" data-toggle="tooltip" data-placement="top" title="Ver comprobante">
                                <i class="ri-file-paper-fill"></i>
                            </button>
                        </div>
                    </div>
                `;
            } else {
                return `
                    <div class="container">
                        <div class="row" style="justify-content: center;">
                            Esperando respuesta
                            <button class="btn btn-success pendiente-button" data-bs-toggle="modal" data-bs-target="#verComprovacion" onclick="verComprobacion(${idRequest}, false)" data-toggle="tooltip" data-placement="top" title="Ver comprobante">
                                <i class="ri-file-paper-fill"></i>
                            </button>
                        </div>
                    </div>
                `;
            }
            break;
        case 3:
            return `
                <div class="container">
                    <div class="btn-group" style="justify-content: center;">
                        <button class="btn btn-danger pendiente-button" onclick="verRespuesta(${idRequest}, false)">
                            Rechazado
                        </button>
						<button class="btn btn-success pendiente-button" data-bs-toggle="modal" data-bs-target="#verComprovacion" onclick="verComprobacion(${idRequest}, false)" data-toggle="tooltip" data-placement="top" title="Ver comprobante">
							<i class="ri-file-paper-fill"></i>
						</button>
                    </div>
                </div>
            `;
        case 4:
            if (userRequest != user && level == 1) {
                return `
                    <div class="container">
                        <div class="row" style="justify-content: center;">
                            Esperando comprobante
                            <button class="btn btn-success pendiente-button" data-bs-toggle="modal" data-bs-target="#verComprovacion" onclick="verComprobacion(${idRequest}, false)" data-toggle="tooltip" data-placement="top" title="Ver comprobante">
                                <i class="ri-file-paper-fill"></i>
                            </button>
                        </div>
                    </div>
                `;
            } else {
                return `
                    <div class="container">
                        <div class="btn-group" style="justify-content: center;">
                            <button class="btn btn-danger pendiente-button" onclick="modalComprobar(${idRequest}, true)">
                                Enviar comprobante
                            </button>
                            <button class="btn btn-success pendiente-button" data-bs-toggle="modal" data-bs-target="#verComprovacion" onclick="verComprobacion(${idRequest}, false)" data-toggle="tooltip" data-placement="top" title="Ver comprobante">
                                <i class="ri-file-paper-fill"></i>
                            </button>
                        </div>
                    </div>
                `;
            }
            break;
        case 5:
            return `
                <div class="container">
                    <div class="row" style="justify-content: center;">
						Finalizado
						<button class="btn btn-success pendiente-button mx-2" data-bs-toggle="modal" data-bs-target="#verComprovacion" onclick="verComprobacion(${idRequest}, false)" data-toggle="tooltip" data-placement="top" title="Ver comprobante">
							<i class="ri-file-paper-fill"></i>
						</button>
                    </div>
                </div>
            `;
        default:
            return '';
    }
}

function verRespuesta(idRequest) {
	$.ajax({
        type: 'POST',
        url: 'controller/ajax/ajax.form.php',
        data: {verRespuesta: idRequest},
		dataType: 'json',
        success: function (response) {
			$('#respuestaModal').modal('show');
			var comentarios = (response.comentarios != null) ? response.comentarios : '';
			$('.comentartioRespuesta').html(comentarios);
        }
    });
}

function documentRequest(idRequest) {
	$.ajax({
		type: 'POST',
		url: 'controller/ajax/ajax.form.php', // URL actualizada si es necesario
		data: { getDocumentsTemp: idRequest },
		success: function(response) {
			var documentos = JSON.parse(response);
			$('#listaDocumentos').empty(); // Limpiar la lista actual

			if(documentos.length > 0) {

				documentos.forEach(function(documento) {
					var extension = documento.split('.').pop().toLowerCase();
					var colorClass = '';
					var iconClass = '';
					switch(extension) {
						case 'pdf':
							colorClass = 'doc-pdf';
							iconClass = 'ri-file-pdf-line';
							numPDF ++;
							break;
						case 'xml':
							colorClass = 'doc-image';
							iconClass = 'ri-image-line';
							numXML++;
							break;
						default:
							colorClass = 'doc-other';
							iconClass = 'ri-pages-line';
							break;
					}
				
					$('#listaDocumentos').append(`
						<li class="list-group-item d-flex flex-column align-items-center justify-content-center p-3">
							<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger deleteButton" onclick="deleteDocument('${documento}', ${idRequest})">
								&times;
								<span class="visually-hidden">unread messages</span>
							</span>
							<div>
								<a href="view/documents/requestTemp/${idRequest}/${documento}" download target="_blank" class="mt-2 text-wrap">
									<div class="document-icon ${colorClass}">
										<i class="${iconClass}"></i>
									</div>
								</a>
							</div>
							${documento}
						</li>
					`);
				});
				
			} else {
				$('#listaDocumentos').append(`<li class="list-group-item">No hay documentos asignados.</li>`);
			}

		},
		error: function() {
			$('#listaDocumentos').append(`<li class="list-group-item">Error al buscar documentos.</li>`);
		}
	});

}

function deleteDocument(document, idRequest) {
    // Confirmar si el usuario desea eliminar el documento
    var confirmDelete = confirm("¿Estás seguro de que deseas eliminar este documento?");
    
    // Si el usuario confirma la eliminación
    if (confirmDelete) {
        $.ajax({
            type: 'POST',
            url: 'controller/ajax/deleteDocument.php',
            data: { document: document, idRequest: idRequest },
            dataType: 'json',
            success: function (response) {
				
				var extension = document.split('.').pop().toLowerCase();
                
				switch(extension) {
					case 'pdf':
						numPDF--;
						break;
					case 'xml':
						numXML--;
						break;
				}

				documentRequest(idRequest);
                
            },
            error: function (error) {
                console.log('Error en la solicitud AJAX:', error);
            }
        });
    }
}

$(document).ready(function () {
    $('#GenReport').on('submit', function (e) {
        e.preventDefault();

        // Obtener las fechas
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();

        // Validar las fechas
        if (!startDate || !endDate) {
            alert("Por favor, selecciona ambas fechas.");
            return;
        }

        // Obtener el valor del campo de búsqueda (context)
        const contextField = $('input[type="search"].form-control.form-control-sm[aria-controls="requests"]');
        const context = contextField.val().trim(); // Remover espacios al inicio y al final

        // Crear el objeto de datos
        let data = { startDate, endDate };
        if (context !== "") {
            data.context = context; // Solo incluir si no está vacío
        }

        // Enviar la solicitud AJAX
        $.ajax({
            url: 'controller/ajax/reportRequests.php',
            type: 'POST',
            data: data,
            xhrFields: {
                responseType: 'blob' // Especifica que el servidor devolverá un archivo
            },
            success: function (response, status, xhr) {
                // Crear un enlace para descargar el archivo
                const filename = xhr.getResponseHeader('Content-Disposition')
                    .split('filename=')[1]
                    .replace(/"/g, '');

                const blob = new Blob([response], { type: xhr.getResponseHeader('Content-Type') });
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = filename;
                link.click();
            },
            error: function () {
                alert("Ocurrió un error al generar el reporte.");
            }
        });
    });
});
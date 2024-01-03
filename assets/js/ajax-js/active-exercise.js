$(document).ready(function () {
		$.ajax({
            url: 'controller/ajax/activeExercise.php',
            dataSrc: '',
			success: function (response) {

                if (response === 'false') {
                    
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 1100,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                        }
                    });

                    Toast.fire({
			          icon: 'error',
					  title: 'No se ha activado ningun ejercicio'
					});

                    setTimeout(() => {
                        window.location.href = 'exercise';
                      }, 1000);

                }
			},
			error: function (error) {
				console.log("Error en la solicitud Ajax:", error);
			}
		});
});
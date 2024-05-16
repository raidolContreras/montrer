<?php
// Verificar si se recibió el nombre del documento a eliminar
if (isset($_POST['document'])) {
    // Directorio donde se encuentran los documentos
    $directory = '../../view/documents/requestTemp/'.$_POST['idRequest'].'/';

    // Nombre del documento a eliminar
    $document = $_POST['document'];
    $idRequest = $_POST['idRequest'];

    // Ruta completa del documento
    $filePath = $directory . $document;

    // Verificar si el archivo existe
    if (file_exists($filePath)) {
        // Intentar eliminar el documento
        if (unlink($filePath)) {
            // El documento se eliminó correctamente
            echo json_encode(array('success' => true));
        } else {
            // No se pudo eliminar el documento
            echo json_encode(array('success' => false, 'message' => 'No se pudo eliminar el documento.'));
        }
    } else {
        // El documento no existe
        echo json_encode(array('success' => false, 'message' => 'El documento no existe.'));
    }
} else {
    // No se recibió el nombre del documento
    echo json_encode(array('success' => false, 'message' => 'No se recibió el nombre del documento.'));
}

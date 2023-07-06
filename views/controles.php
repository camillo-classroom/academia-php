<?php
    function input($id, $texto, $valor, $somenteLeitura, $tipo) {

        if (!$tipo) {
            $tipo = "text";
        }

        echo '<div class="mb-3">
            <label for="' . $id . '" class="form-label">' . $texto . '</label>
            <input type="'.$tipo.'" ' . ($somenteLeitura ? "readonly" : "") .' class="form-control" id="' . $id . '" name="' . $id . '" value="' . $valor . '">
        </div>';
}
?>